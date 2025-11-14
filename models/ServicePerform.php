<?php

namespace app\models;

use gearguard\phpmvc\UserModel;

class ServicePerform extends UserModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;
    public int $id;
    public int $vehicle_id = 0;
    public int $service_id = 0;
    public int $mechanic_id = 0;
    public string $begin_timestamp;
    public string $end_timestamp;
    public int $duration = 0;
    public string $notes = 0;


    public function tableName(): string
    {
        return 'gg_vehicle_service_take';
    }

    public function attributes(): array
    {
        return ['service_type', 'service_date', 'service_time', 'service_location', 'duration', 'notes'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }
    public function rules(): array
    {
        return [
            'vehicle_id' => [self::RULE_REQUIRED],
            'service_id' => [self::RULE_REQUIRED],
            'mechanic_id' => [self::RULE_REQUIRED],
            'begin_timestamp' => [self::RULE_REQUIRED],
            'end_timestamp' => [self::RULE_REQUIRED],
            'duration' => [self::RULE_REQUIRED],
            'notes' => [self::RULE_REQUIRED],
        ];
    }
    public function labels(): array
    {
        return [
            'vehicle_id' => 'Vehicle ID',
            'service_id' => 'Service ID',
            'mechanic_id' => 'Mechanic ID',
            'begin_timestamp' => 'Begin Timestamp',
            'end_timestamp' => 'End Timestamp',
            'duration' => 'Duration',
            'notes' => 'Notes'
        ];
    }

    public function getDisplayName(): string
    {
        return $this->vehicle_id . ' - ' . $this->service_id . ' - ' . $this->mechanic_id;
    }

    public function getServiceType(): string
    {
        return $this->service_id;
    }

    public function getServiceDate(): string
    {
        return $this->begin_timestamp;
    }

    public function getServiceTime(): string
    {
        return $this->end_timestamp;
    }

    public function getServiceLocation(): string
    {
        return $this->notes;
    }
}
