<?php

namespace app\models;

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
    public int $status_id = self::STATUS_INACTIVE;


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
        $this->status_id = self::STATUS_INACTIVE;
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
}
