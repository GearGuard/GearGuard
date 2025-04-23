<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\Model;

use PDO;



class ServicePerform extends Model
{
    /**
     * Define validation rules for the model attributes
     * 
     * @return array
     */

    public int $id = 0;
    public int $vehicle_id = 0;
    public int $service_id = 0;
    public int $mechanic_id = 0;
    public string $begin_timestamp = '';
    public string $end_timestamp = '';
    public ?string $duration = null;
    public ?string $notes = null;

    // For display purposes
    public string $license_plate_no = '';
    public string $service_type = '';
    public string $mechanic_name = '';
    public string $garage_name = '';

    public static function tableName(): string
    {
        return 'gg_vehicle_service_take';
    }

    public function attributes(): array
    {
        return ['vehicle_id', 'service_id', 'mechanic_id', 'begin_timestamp', 'end_timestamp', 'duration', 'notes'];
    }

    public function labels(): array
    {
        return [
            'vehicle_id' => 'Vehicle',
            'service_id' => 'Service Type',
            'mechanic_id' => 'Mechanic',
            'begin_timestamp' => 'Service Start Time',
            'end_timestamp' => 'Service End Time',
            'duration' => 'Duration',
            'notes' => 'Notes'
        ];
    }
    public function rules(): array
    {
        return [
            'vehicle_id' => [self::RULE_REQUIRED],
            'service_id' => [self::RULE_REQUIRED],
            'mechanic_id' => [self::RULE_REQUIRED],
            'begin_timestamp' => [self::RULE_REQUIRED],
            'end_timestamp' => [self::RULE_REQUIRED],
            'notes' => [self::RULE_REQUIRED,]
        ];
    }
    /**
     * Get service history for a specific vehicle
     * 
     * @param int $vehicleId
     * @return array
     */
    public static function getServiceHistoryByVehicle(int $vehicleId): array
    {
        $sql = "SELECT 
                vst.id, 
                vst.vehicle_id, 
                vst.service_id, 
                vst.mechanic_id, 
                vst.begin_timestamp, 
                vst.end_timestamp, 
                vst.duration, 
                vst.notes,
                v.license_plate_no,
                gs.type AS service_type,
                gs.price AS service_price,
                CONCAT(IFNULL(gm.first_name, ''), ' ', IFNULL(gm.last_name, '')) AS mechanic_name,
                g.name AS garage_name
            FROM gg_vehicle_service_take vst
            JOIN gg_vehicle v ON vst.vehicle_id = v.id
            JOIN gg_garage_service gs ON vst.service_id = gs.id
            JOIN gg_garage g ON gs.garage_id = g.id
            LEFT JOIN gg_garage_mechanic gm ON vst.mechanic_id = gm.id
            WHERE vst.vehicle_id = :vehicle_id
            ORDER BY vst.begin_timestamp DESC";

        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':vehicle_id', $vehicleId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Get all service history for vehicles owned by a user
     * 
     * @param int $userId
     * @return array
     */
    public static function getServiceHistoryByUser(int $userId): array
    {
        $sql = "SELECT 
                vst.id, 
                vst.vehicle_id, 
                vst.service_id, 
                vst.mechanic_id, 
                vst.begin_timestamp, 
                vst.end_timestamp, 
                vst.duration, 
                vst.notes,
                v.license_plate_no,
                gs.type AS service_type,
                gs.price AS service_price,
                CONCAT(IFNULL(gm.first_name, 'Not'), ' ', IFNULL(gm.last_name, 'Assigned')) AS mechanic_name,
                g.name AS garage_name
            FROM gg_vehicle_service_take vst
            JOIN gg_vehicle v ON vst.vehicle_id = v.id
            JOIN gg_garage_service gs ON vst.service_id = gs.id
            JOIN gg_garage g ON gs.garage_id = g.id
            LEFT JOIN gg_garage_mechanic gm ON vst.mechanic_id = gm.id
            JOIN gg_user_owner uo ON v.id = uo.vehicle_id
            WHERE uo.user_id = :user_id
            ORDER BY vst.begin_timestamp DESC";

        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Format the duration for display
     * 
     * @return string
     */
    public function getFormattedDuration(): string
    {
        if (empty($this->duration)) {
            // Calculate duration from begin and end timestamps
            $begin = new \DateTime($this->begin_timestamp);
            $end = new \DateTime($this->end_timestamp);
            $interval = $begin->diff($end);

            $hours = $interval->h + ($interval->days * 24);
            return $hours . ' hours, ' . $interval->i . ' minutes';
        }

        return $this->duration;
    }

    /**
     * Format the timestamp for display
     * 
     * @param string $timestamp
     * @return string
     */
    public function formatTimestamp(string $timestamp): string
    {
        $date = new \DateTime($timestamp);
        return $date->format('d M Y, h:i A');
    }

    /**
     * Insert a sample service record for testing
     * This can be used to add test data if the table is empty
     * 
     * @return bool
     */
    public static function insertSampleService(): bool
    {
        // First check if there's a mechanic record
        $mechanic = Application::$app->db->prepare("SELECT id FROM gg_garage_mechanic LIMIT 1");
        $mechanic->execute();
        $mechanicId = $mechanic->fetchColumn();

        // If no mechanic exists, create one
        if (!$mechanicId) {
            $createMechanic = Application::$app->db->prepare("
                INSERT INTO gg_garage_mechanic 
                (username, password, first_name, last_name, nic, address, email, contact_no, date_employeed, garage_id, status_id)
                VALUES 
                ('mechanic1', '$2y$10', 'John', 'Doe', '123456789V', 'Mechanic Address', 'mechanic@example.com', '071-1234567', '2025-01-01', 1, 2)
            ");
            $createMechanic->execute();
            $mechanicId = Application::$app->db->lastInsertId();
        }

        // Insert a sample service record
        $sql = "INSERT INTO gg_vehicle_service_take 
                (vehicle_id, service_id, mechanic_id, begin_timestamp, end_timestamp, notes) 
                VALUES (1, 1, :mechanic_id, '2025-04-20 10:00:00', '2025-04-20 12:00:00', 'Sample service record for testing')";

        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':mechanic_id', $mechanicId);
        return $statement->execute();
    }
}
