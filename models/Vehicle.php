<?php

namespace app\models;

use gearguard\phpmvc\db\DbModel;

class Vehicle extends DbModel
{

    public function tableName(): string
    {
        return 'gg_vehicle';
    }

    public function attributes(): array
    {
        return ['vin', 'model_id', 'year_manufactured', 'license_plate_no', 'class_id', 'engine_capacity_id', 'fuel_type_id', 'bodytype_id', 'insurance_no', 'engine_no', 'current_user_id', 'status_id'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'vin' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'model_id' => [self::RULE_REQUIRED],
            'license_plate_no' => [self::RULE_REQUIRED],
            'class_id' => [self::RULE_REQUIRED],
            'engine_capacity_id' => [self::RULE_REQUIRED],
            'fuel_type_id' => [self::RULE_REQUIRED],
            'bodytype_id' => [self::RULE_REQUIRED],
            'engine_no' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'status_id' => [self::RULE_REQUIRED],
            ];
    }
}