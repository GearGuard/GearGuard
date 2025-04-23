<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\db\DbModel;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\UserModel;

class Vehicle extends UserModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    public int $id = 0;
    public string $vin = '';
    public int $model_id = 0;
    public string $year_manufactured = '';
    public string $license_plate_no = '';
    public int $class_id = 0;
    public int $engine_capacity_id = 0;
    public int $fuel_type_id = 0;
    public int $bodytype_id = 0;
    public string $insurance_no = '';
    public string $engine_no = '';
    public int $current_user_id = 0;
    public int $status_id = self::STATUS_INACTIVE;
    public int $vehicle_type_id = 0;

    public function tableName(): string
    {
        return 'gg_vehicle';
    }

    public function attributes(): array
    {
        return [
            'vin',
            'model_id',
            'year_manufactured',
            'license_plate_no',
            'class_id',
            'engine_capacity_id',
            'fuel_type_id',
            'bodytype_id',
            'insurance_no',
            'engine_no',
            'current_user_id',
            'status_id',
            'vehicle_type_id'
        ];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function getDisplayName(): string
    {
        return $this->license_plate_no;
    }

    public function rules(): array
    {
        return [
            'vin' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'model_id' => [self::RULE_REQUIRED],
            'year_manufactured' => [self::RULE_REQUIRED],
            'license_plate_no' => [self::RULE_REQUIRED],
            'class_id' => [self::RULE_REQUIRED],
            'engine_capacity_id' => [self::RULE_REQUIRED],
            'fuel_type_id' => [self::RULE_REQUIRED],
            'bodytype_id' => [self::RULE_REQUIRED],
            'insurance_no' => [self::RULE_REQUIRED],
            'engine_no' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'status_id' => [self::RULE_REQUIRED],
            'vehicle_type_id' => [self::RULE_REQUIRED],
        ];
    }

    public static function initialize(array $data): self
    {
        $vehicle = new self();
        foreach ($data as $key => $value) {
            if (property_exists($vehicle, $key)) {
                // Always assign a string to string fields, never null
                if (is_null($value)) {
                    if (gettype($vehicle->$key) === 'string') {
                        $vehicle->$key = '';
                    } elseif (gettype($vehicle->$key) === 'int') {
                        $vehicle->$key = 0;
                    }
                } else {
                    $vehicle->$key = $value;
                }
            }
        }
        return $vehicle;
    }

    public static function findByOwner($userId)
    {
        $tableName = (new self())->tableName();
        $stmt = Application::$app->db->prepare("
            SELECT v.* FROM {$tableName} v
            INNER JOIN gg_user_owner uo ON v.id = uo.vehicle_id
            WHERE uo.user_id = :userId AND v.status_id = :status_id
        ");
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':status_id', self::STATUS_ACTIVE);
        $stmt->execute();

        $vehicles = [];
        while ($vehicleData = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $vehicle = new self();
            foreach ($vehicleData as $key => $value) {
                if (property_exists($vehicle, $key)) {
                    $vehicle->{$key} = $value;
                }
            }
            $vehicles[] = $vehicle;
        }

        return $vehicles;
    }
}
