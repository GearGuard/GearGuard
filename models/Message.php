<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\db\DbModel;

class Message extends DbModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    public int $id;
    public int $fuid;
    public int $tuid;
    public string $message;
    public string $timestamp;
    public int $status_id = self::STATUS_INACTIVE;

    public function tableName(): string
    {
        return 'gg_messages';
    }

    public function attributes(): array
    {
        return ['fuid', 'tuid', 'message', 'timestamp', 'status_id'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'fuid' => [self::RULE_REQUIRED],
            'tuid' => [self::RULE_REQUIRED],
            'message' => [self::RULE_REQUIRED],
            'status_id' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'fuid' => 'From User ID',
            'tuid' => 'To User ID',
            'message' => 'Message',
            'timestamp' => 'Timestamp',
            'status_id' => 'Status ID'
        ];
    }

    public static function sendMessage(int $toUserId, string $message, int $fromUserId = -1): bool
    {
        if ($fromUserId == -1) {
            $fromUserId = Application::$app->user->id ?: Application::$app->session->get('user');
        }

        $messageModel = new self();
        $messageModel->fuid = $fromUserId;
        $messageModel->tuid = $toUserId;
        $messageModel->message = $message;
        $messageModel->timestamp = date('Y-m-d H:i:s');

        if ($messageModel->validate()) {
            $messageModel->save();
            Notification::sendNotification($toUserId, 'You have a new message!', 'New Message');
            return true;
        }
        else return false;
    }

    public static function getMessages(int $userId): array
    {
        $sql = "SELECT * FROM gearguard.gg_messages WHERE tuid = :userId OR fuid = :userId";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
}