<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\db\DbModel;

class MechanicSparePart extends DbModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    public int $id;
    public string $serial_no;
    public string $type;
    public string $manufacturer;
    public float $price;
    public string $manufactured_date;
    public string $waranty_period;
    public string $vehicle_license_plate_no;
    public int $status_id = self::STATUS_INACTIVE;

    public function tableName(): string
    {
        return 'gg_sparepart';
    }

    public function attributes(): array
    {
        return ['serial_no', 'type', 'manufacturer', 'price', 'manufactured_date', 'waranty_period', 'vehicle_license_plate_no', 'status_id'];
    }

    public function rules(): array
    {
        return [
            'serial_no' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'type' => [self::RULE_REQUIRED],
            'manufacturer' => [self::RULE_REQUIRED],
            'price' => [self::RULE_REQUIRED],
            'manufactured_date' => [self::RULE_REQUIRED],
            'waranty_period' => [self::RULE_REQUIRED],
            'vehicle_license_plate_no' => [self::RULE_REQUIRED],
            'status_id' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'serial_no' => 'Serial Number',
            'type' => 'Type',
            'manufacturer' => 'Manufacturer',
            'price' => 'Price',
            'manufactured_date' => 'Manufactured Date',
            'waranty_period' => 'Warranty Period',
            'vehicle_license_plate_no' => 'Vehicle License Plate Number',
            'status_id' => 'Status',
        ];
    }

    public function save()
    {
        $db = Application::$app->db;
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = $db->prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(',', $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $success = $statement->execute();

        if (!$success) {
            return false;
        }

        // After saving spare part, link to vehicle in relationship table
        $sparepartId = $db->pdo->lastInsertId();

        // Find vehicle by license plate
        $vehicleStmt = $db->prepare("SELECT id FROM gg_vehicle WHERE license_plate_no = :license_plate_no");
        $vehicleStmt->bindValue(':license_plate_no', $this->vehicle_license_plate_no);
        $vehicleStmt->execute();
        $vehicle = $vehicleStmt->fetch(\PDO::FETCH_ASSOC);

        if ($vehicle) {
            $linkStmt = $db->prepare("INSERT INTO gg_sparepart_service_vehicle_install (vehicle_id, sparepart_id, service_id, installed_date) VALUES (:vehicle_id, :sparepart_id, NULL, NULL)");
            $linkStmt->bindValue(':vehicle_id', $vehicle['id']);
            $linkStmt->bindValue(':sparepart_id', $sparepartId);
            $linkStmt->execute();
        }

        return true;
    }

    public function update()
    {
        $db = Application::$app->db;
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $setClause = implode(', ', array_map(fn($attr) => "$attr = :$attr", $attributes));
        $sql = "UPDATE $tableName SET $setClause WHERE id = :id";
        $statement = $db->prepare($sql);

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->bindValue(':id', $this->id);

        return $statement->execute();
    }
}
