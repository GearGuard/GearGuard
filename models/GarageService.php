<?php

namespace app\models;

use Couchbase\InvalidStateException;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Model;
use gearguard\phpmvc\DbModel;
use gearguard\phpmvc\UserModel;

class GarageService extends UserModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    public int $id;
    public string $type = '';
    public int $price = 0;
    public int $duration = 0;
    public string $description = '';
    public int $garage_id = 0;
    private string $garage_name = '';
    public int $status_id = self::STATUS_INACTIVE;

    public static function initialize(string $type, int $price, int $duration, string $description): GarageService
    {
        $object = new GarageService();

        $object->type = $type;
        $object->price = $price;
        $object->duration = $duration;
        $object->description = $description;
        $object->garage_id = Application::$app->session->get('user');
        $object->status_id = self::STATUS_ACTIVE;

        return $object;
    }

    public function tableName(): string
    {
        return 'gg_garage_service';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'type' => [self::RULE_REQUIRED],
            'price' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 0]],
            'duration' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 0]],
            'description' => [self::RULE_REQUIRED],
            'garage_id' => [self::RULE_REQUIRED],
            'status_id' => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return ['type', 'price', 'duration', 'description', 'garage_id', 'status_id'];
    }

    public function labels(): array
    {
        return [
            'type' => 'Service Type',
            'price' => 'Price',
            'duration' => 'Duration',
            'description' => 'Description',
            'garage_id' => 'Garage ID',
            'status_id' => 'Status ID',
        ];
    }
    public function getDisplayName(): string
    {
        return $this->type;
    }

    public function getGarageName(): string
    {
        if ($this->garage_id === 0) {
            throw new InvalidStateException('Garage ID is not set');
        }

        if ($this->garage_name !== '') {
            return $this->garage_name;
        }

        $sql = "SELECT name FROM gg_garage WHERE id = :id LIMIT 1";
        $statement = self::prepare($sql);
        $statement->bindValue(':id', $this->garage_id);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            throw new InvalidStateException('Garage not found');
        } else {
            $garage_name = $result[0]['name'];
        }

        return $garage_name;
    }
}
