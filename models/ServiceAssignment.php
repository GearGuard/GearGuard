<?php

namespace app\models;

use gearguard\phpmvc\db\DbModel;

class ServiceAssignment extends DbModel
{
    public string $license_plate_no = '';
    public string $service_type = '';
    public string $mechanic_name = '';
    public string $begin_timestamp = '';
    public string $end_timestamp = '';
    public string $duration = '';
    public string $notes = '';

    public function tableName(): string
    {
        return 'gg_vehicle_service_take';
    }

    public function attributes(): array
    {
        return ['license_plate_no', 'service_type', 'mechanic_name', 'begin_timestamp', 'end_timestamp', 'duration', 'notes'];
    }

    public function getServiceAssignments()
    {
        $sql = "SELECT vst.id, v.license_plate_no, gs.type AS service_type, 
                       CONCAT(m.first_name, ' ', m.last_name) AS mechanic_name,
                       vst.begin_timestamp, vst.end_timestamp, vst.duration, vst.notes
                FROM gg_vehicle_service_take vst
                JOIN gg_vehicle v ON vst.vehicle_id = v.id
                JOIN gg_garage_service gs ON vst.service_id = gs.id
                JOIN gg_garage_mechanic m ON vst.mechanic_id = m.id
                ORDER BY vst.begin_timestamp DESC";

        $statement = self::prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
