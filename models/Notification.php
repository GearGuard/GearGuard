<?php

namespace app\models;

use app\utilities\JWTGenerator;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\db\DbModel;

class Notification extends DbModel
{

    public const STATUS_UNREAD = 1;
    public const STATUS_READ = 2;
    public const STATUS_DELETED = 3;

    public int $id;
    public int $user_id;
    public string $timestamp;
    public string $description;
    public int $status_id;

    private $secretKey = 'Abracadabra@Hogwarts1959';

    public function tableName(): string
    {
        return 'gg_notification';
    }

    public function attributes(): array
    {
        return ['user_id', 'timestamp', 'description', 'status_id'];
    }

    public function labels(): array
    {
        return [
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
            'description' => 'Description',
            'status_id' => 'Status ID'
        ];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED],
            'timestamp' => [self::RULE_REQUIRED],
            'description' => [self::RULE_REQUIRED],
            'status_id' => [self::RULE_REQUIRED],
        ];
    }

    public static function sendNotification(int $userId, string $description, string $title = 'New Notification')
    {
        $notification = new Notification();
        $notification->user_id = $userId;
        $notification->description = $description;
        $notification->timestamp = date('Y-m-d H:i:s');
        $notification->status_id = self::STATUS_UNREAD;

        $notification->validate();
        if ($notification->save()) {
            $socket = stream_socket_client('tcp://127.0.0.1:8081' . JWTGenerator::generateJWT(JWTGenerator::generatePayloadForJWT(0, 3600), 'Abracadabra@Hogwarts1959'), $errno, $errstr);
            if (!$socket) {
                echo "Error: $errstr ($errno)\n";
            } else {
                fwrite($socket, json_encode([
                    'uid' => $userId,
                    'description' => $description,
                    'timestamp' => $notification->timestamp,
                    'title' => $title,
                ]));
                fclose($socket);
            }
        }
    }

    public static function receiveNotification(int $userId): array
    {
        $sql = "SELECT * FROM gearguard.gg_notification WHERE user_id = :user_id AND status_id = :status_id";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':status_id', self::STATUS_UNREAD);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, Notification::class);
    }

    public static function readNotification(int $notificationId, int $userId): bool
    {
        $sql = "UPDATE gearguard.gg_notification SET status_id = :status_id WHERE id = :id AND user_id = :user_id";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':status_id', self::STATUS_READ);
        $statement->bindValue(':id', $notificationId);
        $statement->bindValue(':user_id', $userId);
        return $statement->execute();
    }
}