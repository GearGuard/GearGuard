<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\Model;

class Vehicle extends Model
{
    public const STATUS_ACTIVE = 2; // Based on your gg_status table where 'active' has id 2
    public const STATUS_INACTIVE = 1; // Based on your gg_status table where 'Inactive' has id 1
    public const STATUS_DELETED = 3; // Based on your gg_status table where 'deleted' has id 3

    public ?int $id = null;
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
    public ?int $current_user_id = null;
    public int $status_id = self::STATUS_ACTIVE;
    public int $vehicle_type_id = 0;

    // For form use only
    public string $model = '';

    public function tableName(): string
    {
        return 'gg_vehicle';
    }

    public function primaryKey(): string
    {
        return 'id';
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

    public function labels(): array
    {
        return [
            'vin' => 'VIN',
            'model_id' => 'Model',
            'year_manufactured' => 'Year Manufactured',
            'license_plate_no' => 'License Plate Number',
            'class_id' => 'Vehicle Class',
            'engine_capacity_id' => 'Engine Capacity',
            'fuel_type_id' => 'Fuel Type',
            'bodytype_id' => 'Body Type',
            'insurance_no' => 'Insurance Number',
            'engine_no' => 'Engine Number',
            'current_user_id' => 'Current User',
            'status_id' => 'Status',
            'vehicle_type_id' => 'Vehicle Type',
            'model' => 'Model'
        ];
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
            'engine_no' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'status_id' => [self::RULE_REQUIRED],
            'vehicle_type_id' => [self::RULE_REQUIRED],
            'model' => [self::RULE_REQUIRED]
        ];
    }

    public function save(): bool
    {
        try {
            $db = Application::$app->db;

            // Begin transaction
            $db->beginTransaction();

            // Insert vehicle
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn($attr) => ":$attr", $attributes);

            $statement = $db->prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");

            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }

            $result = $statement->execute();

            if ($result) {
                // Get the last insert ID
                $this->id = (int)$db->getPdo()->lastInsertId();

                // Commit transaction
                $db->commit();
                return true;
            }

            $db->rollBack();
            return false;
        } catch (\Exception $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            return false;
        }
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
