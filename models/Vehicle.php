<?php

namespace app\models;

use gearguard\phpmvc\db\DbModel;
use gearguard\phpmvc\exception\NotFoundException;

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

    public static function getCurrentUserOrOwner(int $vehicleId): int {
        $sql = "select coalesce (gv.current_user_id, guo.user_id) as vehicle_user from gearguard.gg_vehicle gv left join gearguard.gg_user_owner guo on gv.`id` = guo.vehicle_id WHERE gv.id = :vehicle_id;";
        $statement = \gearguard\phpmvc\Application::$app->db->prepare($sql);
        $statement->bindValue(':vehicle_id', $vehicleId);
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            throw new NotFoundException('Vehicle not found');
        } elseif (is_numeric($result['vehicle_user'])) {
            return (int)$result['vehicle_user'];
        } else {
            throw new NotFoundException('Current user or owner not found');
        }
    }

    /**
     * @param int $vehicleId
     * @return array contains id, vin, model, manufacturer, year_manufactured, license_plate_no, class, capacity, fueltype, bodytype, insurance_no, engine_no, vehicle_user, type and status_id.
     */
    public static function getVehicleDetails(int $vehicleId): array {
        $sql = "select gv.id, gv.vin, gvm.model, gvm2.name as manufacturer, gv.year_manufactured, gv.license_plate_no, gvc.class, gvec.capacity, gvf.fueltype, gvb.bodytype, gv.insurance_no, gv.engine_no, coalesce (gv.current_user_id, guo.user_id) as vehicle_user, gvt.`type` , gv.status_id from gearguard.gg_vehicle gv left join gearguard.gg_user_owner guo on gv.`id` = guo.vehicle_id left join gearguard.gg_vehicle_model gvm on gv.model_id = gvm.`id` left join gearguard.gg_vehicle_class gvc on gv.class_id = gvc.`id` left join gearguard.gg_vehicle_engine_capacity gvec on gv.engine_capacity_id = gvec.`id` left join gearguard.gg_vehicle_fueltype gvf on gv.fuel_type_id = gvf.`id` left join gearguard.gg_vehicle_bodytype gvb on gv.bodytype_id = gvb.`id` left join gearguard.gg_vehicle_type gvt on gv.vehicle_type_id = gvt.`id` left join gearguard.gg_vehicle_manufacturer gvm2 on gvm.manufacturer_id = gvm2.`id` WHERE gv.id = :vehicle_id;";
        $statement = \gearguard\phpmvc\Application::$app->db->prepare($sql);
        $statement->bindValue(':vehicle_id', $vehicleId);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}