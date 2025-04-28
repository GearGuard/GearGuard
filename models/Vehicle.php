<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\db\DbModel;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\Model;

class Vehicle extends DbModel
{
    public const STATUS_ACTIVE = 2; 
    public const STATUS_INACTIVE = 1; 
    public const STATUS_DELETED = 3; 

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
            'model_id' => 'Vehicle Model',
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
            'vehicle_type_id' => [self::RULE_REQUIRED]
        ];
    }

    public function save()
    {
        if (Application::$app->user instanceof User) {
            $result = parent::save();
            $this->id = Application::$app->db->pdo->lastInsertId();
            $sql = "INSERT INTO gg_user_owner (user_id, vehicle_id, ownership_status_id, registration_date) VALUES (:userId, :vehicleId, 1, NOW())";
            $statement = Application::$app->db->prepare($sql);
            $statement->bindValue(':userId', Application::$app->session->get('user'));
            $statement->bindValue(':vehicleId', $this->id);
            $statement->execute();
            return $result;
        }

        throw new NotFoundException();
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

    public function isOwnedByUser($userId): bool
    {
        $stmt = Application::$app->db->prepare("
            SELECT COUNT(*) FROM gg_user_owner 
            WHERE vehicle_id = :vehicleId AND user_id = :userId
        ");
        $stmt->bindValue(':vehicleId', $this->id);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        return (bool)$stmt->fetchColumn();
    }

    public function getVehiclesByOwner($userId): array
    {
        $stmt = Application::$app->db->prepare("
            SELECT v.* FROM gg_vehicle v
            INNER JOIN gg_user_owner uo ON v.id = uo.vehicle_id
            WHERE uo.user_id = :userId AND v.status_id = :status_id
        ");
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':status_id', self::STATUS_ACTIVE);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
   

    public static function getAllVehicleModelsWithIDs() {
        $sql = "SELECT gvm.id, gvm.model FROM gearguard.gg_vehicle_model gvm order by gvm.id";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public static function getAllVehicleFuelTypesWithID() {
        $sql = "SELECT gft.id, gft.fueltype FROM gearguard.gg_vehicle_fueltype gft order by gft.id";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public static function getAllVehicleTypesWithID() {
        $sql = "SELECT gvt.id, gvt.type FROM gearguard.gg_vehicle_type gvt order by gvt.id";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public static function getAllVehicleBodyTypesWithID() {
        $sql = "SELECT gvt.id, gvt.bodytype FROM gearguard.gg_vehicle_bodytype gvt order by gvt.id";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public static function getAllVehicleEngineCapacitiesWithID() {
        $sql = "SELECT gvt.id, gvt.capacity FROM gearguard.gg_vehicle_engine_capacity gvt order by gvt.id";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public static function getAllVehicleClassesWithID()
    {
        $sql = "SELECT gvt.id, gvt.class FROM gearguard.gg_vehicle_class gvt order by gvt.id";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    /**
     * @param int $vehicleId
     * @return array 
     */
    public static function getVehicleDetails(int $vehicleId): array {
        $sql = "select gv.id, gv.vin, gvm.model, gvm2.name as manufacturer, gv.year_manufactured, gv.license_plate_no, gvc.class, gvec.capacity, gvf.fueltype, gvb.bodytype, gv.insurance_no, gv.engine_no, coalesce (gv.current_user_id, guo.user_id) as vehicle_user, gvt.`type` , gv.status_id from gearguard.gg_vehicle gv left join gearguard.gg_user_owner guo on gv.`id` = guo.vehicle_id left join gearguard.gg_vehicle_model gvm on gv.model_id = gvm.`id` left join gearguard.gg_vehicle_class gvc on gv.class_id = gvc.`id` left join gearguard.gg_vehicle_engine_capacity gvec on gv.engine_capacity_id = gvec.`id` left join gearguard.gg_vehicle_fueltype gvf on gv.fuel_type_id = gvf.`id` left join gearguard.gg_vehicle_bodytype gvb on gv.bodytype_id = gvb.`id` left join gearguard.gg_vehicle_type gvt on gv.vehicle_type_id = gvt.`id` left join gearguard.gg_vehicle_manufacturer gvm2 on gvm.manufacturer_id = gvm2.`id` WHERE gv.id = :vehicle_id where status;";
        $statement = \gearguard\phpmvc\Application::$app->db->prepare($sql);
        $statement->bindValue(':vehicle_id', $vehicleId);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}
