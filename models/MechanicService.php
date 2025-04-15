<?php

namespace app\models;

use Couchbase\InvalidStateException;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Model;
use gearguard\phpmvc\DbModel;
use gearguard\phpmvc\UserModel;

class MechanicService extends UserModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    public int $id;
    public int $vehicle_id = 0;
    public int $service_id = 0;
    public int $mechanic_id = 0;
    public int $duration = 0;
    public string $note = '';
    public int $status_id = self::STATUS_INACTIVE;
    public string $begin_timestamp = '';
    public string $end_timestamp = '';

    public static function initialize(int $vehicle_id, int $service_id, int $duration, string $note): MechanicService
    {
        $object = new MechanicService();

        $object->vehicle_id = $vehicle_id;
        $object->service_id = $service_id;
        $object->mechanic_id = Application::$app->session->get('user');
        $object->duration = $duration;
        $object->note = $note;
        $object->status_id = self::STATUS_ACTIVE;
        $object->begin_timestamp = date('Y-m-d H:i:s');
        $object->end_timestamp = date('Y-m-d H:i:s', strtotime("+{$duration} minutes"));

        return $object;
    }

    public static function getMechanicService(int $id, int $vehicle_id, int $service_id, int $duration, int $status, string $note): MechanicService
    {
        $object = new MechanicService();

        $object->id = $id;
        $object->vehicle_id = $vehicle_id;
        $object->service_id = $service_id;
        $object->mechanic_id = Application::$app->session->get('user');
        $object->duration = $duration;
        $object->note = $note;
        $object->status_id = $status;
        $object->begin_timestamp = date('Y-m-d H:i:s');
        $object->end_timestamp = date('Y-m-d H:i:s', strtotime("+{$duration} minutes"));

        return $object;
    }

    public function tableName(): string
    {
        return 'gg_vehicle_service_take';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => [self::RULE_REQUIRED],
            'service_id' => [self::RULE_REQUIRED],
            'duration' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 1]],
            'note' => [self::RULE_REQUIRED],
            'status_id' => [self::RULE_REQUIRED]
        ];
    }

    public function attributes(): array
    {
        return [
            'vehicle_id',
            'service_id',
            'mechanic_id',
            'duration',
            'note',
            'status_id',
            'begin_timestamp',
            'end_timestamp'
        ];
    }

    public function labels(): array
    {
        return [
            'vehicle_id' => 'Vehicle ID',
            'service_id' => 'Service ID',
            'mechanic_id' => 'Mechanic ID',
            'duration' => 'Duration',
            'note' => 'Notes',
            'status_id' => 'Status ID',
            'begin_timestamp' => 'Start Time',
            'end_timestamp' => 'End Time'
        ];
    }

    public function getDisplayName(): string
    {
        return "Service #{$this->id}";
    }

    public function getMechanicName(): string
    {
        if ($this->mechanic_id === 0) {
            throw new InvalidStateException('Mechanic ID is not set');
        }

        $sql = "SELECT name FROM gg_mechanic WHERE id = :id LIMIT 1";
        $statement = self::prepare($sql);
        $statement->bindValue(':id', $this->mechanic_id);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            throw new InvalidStateException('Mechanic not found');
        }

        return $result[0]['name'];
    }

    public function getVehicleDetails(): array
    {
        if ($this->vehicle_id === 0) {
            throw new InvalidStateException('Vehicle ID is not set');
        }

        $sql = "SELECT * FROM gg_vehicle WHERE id = :id LIMIT 1";
        $statement = self::prepare($sql);
        $statement->bindValue(':id', $this->vehicle_id);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function getServiceDetails(): array
    {
        if ($this->service_id === 0) {
            throw new InvalidStateException('Service ID is not set');
        }

        $sql = "SELECT * FROM gg_service WHERE id = :id LIMIT 1";
        $statement = self::prepare($sql);
        $statement->bindValue(':id', $this->service_id);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    
}
