<?php

namespace app\models;

use Couchbase\InvalidStateException;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\db\DbModel;

class MechanicService extends DbModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    // Existing properties for garage service
    public int $id;
    public string $type = '';
    public float $price = 0;
    public float $duration = 0;
    public string $description = '';
    public int $garage_id = 0;
    private string $garage_name = '';
    public int $status_id = self::STATUS_INACTIVE;

    // New properties for vehicle service assignment
    public ?int $vehicle_id = null;
    public ?int $mechanic_id = null;
    public ?string $begin_timestamp = null;
    public ?string $end_timestamp = null;
    public ?string $notes = null;
    public ?float $cost = null;

    // Existing initialize method for garage service
    public static function initialize(string $type, float $price, float $duration, string $description, int $garage_id = -1): GarageService
    {
        $object = new GarageService();

        $object->type = $type;
        $object->price = $price;
        $object->duration = $duration;
        $object->description = $description;
        $object->garage_id = ($garage_id < 0 ? Application::$app->session->get('user') : $garage_id);
        $object->status_id = self::STATUS_ACTIVE;

        return $object;
    }

    // New initialize method for vehicle service assignment
    public static function initializeVehicleService(
        int $vehicle_id,
        int $service_id,
        int $mechanic_id,
        string $begin_timestamp,
        string $end_timestamp,
        string $duration,
        ?string $notes = null,
        ?float $cost = null
    ): MechanicService {
        $object = new MechanicService();
        $object->vehicle_id = $vehicle_id;
        $object->id = $service_id; // service id
        $object->mechanic_id = $mechanic_id;
        $object->begin_timestamp = $begin_timestamp;
        $object->end_timestamp = $end_timestamp;
        $object->duration = floatval(strtotime($duration) - strtotime("2000-01-01 00:00:00")); // convert duration string to float seconds
        $object->notes = $notes;
        $object->cost = $cost;
        return $object;
    }

    public function assignMechanicToService(int $service_id, int $mechanic_id): bool
    {
        $sql = "INSERT INTO gg_service_mechanic_perform (service_id, mechanic_id) VALUES (:service_id, :mechanic_id)";
        $statement = self::prepare($sql);
        $statement->bindValue(':service_id', $service_id);
        $statement->bindValue(':mechanic_id', $mechanic_id);
        try {
            return $statement->execute();
        } catch (\Exception $e) {
            return false;
        }
    }

    // Override save method to handle vehicle service assignment insertion
    public function save()
    {
        if ($this->vehicle_id !== null && $this->mechanic_id !== null && $this->begin_timestamp !== null && $this->end_timestamp !== null) {
            $sql = "INSERT INTO gg_vehicle_service_take (vehicle_id, service_id, mechanic_id, begin_timestamp, end_timestamp, duration, notes, cost)
                    VALUES (:vehicle_id, :service_id, :mechanic_id, :begin_timestamp, :end_timestamp, :duration, :notes, :cost)";
            $statement = self::prepare($sql);
            $statement->bindValue(':vehicle_id', $this->vehicle_id);
            $statement->bindValue(':service_id', $this->id);
            $statement->bindValue(':mechanic_id', $this->mechanic_id);
            $statement->bindValue(':begin_timestamp', $this->begin_timestamp);
            $statement->bindValue(':end_timestamp', $this->end_timestamp);
            $statement->bindValue(':duration', gmdate("H:i:s", intval($this->duration)));
            $statement->bindValue(':notes', $this->notes);
            $statement->bindValue(':cost', $this->cost);
            try {
                return $statement->execute();
            } catch (\Exception $e) {
                return false;
            }
        } else {
            // Call parent save for garage service save
            return parent::save();
        }
    }

    public static function getGarageService(int $id, string $type, float $price, float $duration, int $status, string $description, int $garage_id = -1): GarageService
    {
        $object = new GarageService();

        $object->id = $id;
        $object->type = $type;
        $object->price = $price;
        $object->duration = $duration;
        $object->description = $description;
        $object->garage_id = ($garage_id < 0 ? Application::$app->session->get('user') : $garage_id);
        $object->status_id = $status;

        return $object;
    }

    public function tableName(): string
    {
        return 'gg_garage_service';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    /**
     * <em>Note: This method fills the model with the data given in the $valueUpdates array.</em>
     */
    public function validate($valueUpdates = [], bool $validateType = true, bool $validatePrice = true, bool $validateDuration = true, bool $validateInternals = false ) : bool
    {
        if (isset($valueUpdates)){
            foreach ($valueUpdates as $key => $value)
                $this->{$key} = $value;
        }
        if ($validateType && !$this->type) {
            $this->addError('type', 'Type can not be empty.');
        }
        if ($validatePrice && $this->price <= 0) {
            $this->addError('price', 'Price can not be less than or equal to zero.');
        }
        if ($validateDuration && $this->duration <= 0) {
            $this->addError('duration', 'Duration can not be less than or equal to zero.');
        }
        if ($validateInternals && !(Garage::verifyGarageExistance($this->garage_id))) {
            $this->addError('garage_id', 'Garage could not be found.');
        }
        if ($validateInternals && (($this->status_id > 3) || $this->status_id <= 0)) {
            $this->addError('status_id', 'Status ID must be between one and three.');
        }
        if (isset($this->id) && !(GarageService::verifyServiceExistance($this->garage_id, $this->id))) {
            $this->addError('id', 'Internal Error: Please contact administrators.');
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }


    public function rules(): array
    {
        return [
            'type' => [self::RULE_REQUIRED],
            'price' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 0]],
            'duration' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 0]],
            'description' => [self::RULE_REQUIRED],
            'garage_id' => [self::RULE_REQUIRED],
            'status_id' => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return ['type', 'price', 'duration', 'description', 'garage_id', 'status_id'];
    }

    public function labels(): array
    {
        return [
            'type' => 'Service Type',
            'price' => 'Price',
            'duration' => 'Duration',
            'description' => 'Description',
            'garage_id' => 'Garage ID',
            'status_id' => 'Status ID',
        ];
    }
    public function getDisplayName(): string
    {
        return $this->type;
    }

    public function getGarageName(): string
    {
        if ($this->garage_id === 0) {
            throw new InvalidStateException('Garage ID is not set');
        }

        if ($this->garage_name !== '') {
            return $this->garage_name;
        }

        $sql = "SELECT name FROM gg_garage WHERE id = :id LIMIT 1";
        $statement = self::prepare($sql);
        $statement->bindValue(':id', $this->garage_id);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            throw new InvalidStateException('Garage not found');
        } else {
            $garage_name = $result[0]['name'];
        }

        return $garage_name;
    }

    public function update($data, bool $overrideValidations = false)
    {
        $attributeList = $this->attributes();
        $updateData = [];
        if (is_null($data) || $this->garage_id < 0)
            return false;

        foreach ($data as $key => $value) {
            if (in_array($key, $attributeList)) {
                $updateData[$key] = $value;
            }
        }

        if (!$overrideValidations && !$this->validate($data, validateInternals : true))
            throw new \Exception(array_values($this->errors)[0][0], 400);

        return parent::update($updateData);
    }

    public static function verifyServiceExistance(int $garageID, int $serviceID) : bool
    {
        $sql = "SELECT ggs.id FROM gearguard.gg_garage_service ggs WHERE ggs.garage_id = :garage_id AND ggs.id = :service_id";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $garageID, \PDO::PARAM_INT);
        $statement->bindValue(':service_id', $serviceID, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        if (count($result) > 0)
            return true;

        return false;
    }
}
