<?php

namespace app\models;

use gearguard\phpmvc\db\DbModel;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\Request;

class Appointment extends DbModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    public int $id;
    public int $vehicle_id = 0;
    public int $garage_id = 0;
    public int $service_id = 0;

    public $date;

    public $time;
    public string $notes = '';
    public int $status_id = 1;

    public function tableName(): string
    {
        return 'gg_vehicle_service_appointment';
    }

    public function attributes(): array
    {
        return ['vehicle_id', 'service_id', 'date', 'time', 'notes', 'status_id'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => [self::RULE_REQUIRED],
            'garage_id' => [self::RULE_REQUIRED],
            'service_id' => [self::RULE_REQUIRED],
            'appointment_date' => [self::RULE_REQUIRED],
            'appointment_time' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'vehicle_id' => 'Vehicle',
            'garage_id' => 'Garage',
            'service_id' => 'Service Type',
            'appointment_date' => 'Appointment Date',
            'appointment_time' => 'Appointment Time',
            'notes' => 'Additional Notes',
            'status_id' => 'Status'
        ];
    }

    public function validate($valueUpdates = [], $validateVehicleID = true, $validateGarageID = true, $validateServiceID = true, $validateAppointmentDateAndTime = true, $validateInternals = false) : bool
    {
        if ($validateInternals && ($this->status_id < 1 || $this->status_id > 3)) {
            $this->errors[] = "Status ID must be between 1 and 3.";
            return false;
        }

        if (Application::$app->user instanceof User) {
            if (isset($valueUpdates)){
                foreach ($valueUpdates as $key => $value)
                    $this->{$key} = $value;
            }

            if ($validateVehicleID && (!in_array($this->vehicle_id, array_column(Application::$app->user->getAccessAvailableVehiclesList(), 'id')) || !in_array($this->vehicle_id, array_column(Application::$app->user->getOwnedVehiclesList(), 'id')))){
                $this->errors[] = "You don't own or have access to this vehicle.";
                return false;
            }
            if ($validateGarageID && (!Garage::verifyGarageExistance($this->garage_id))) {
                $this->errors[] = "The garage could not be found.";
                return false;
            }
            if ($validateServiceID && (!GarageService::verifyServiceExistance($this->garage_id, $this->service_id))) {
                $this->errors[] = "The service could not be found.";
                return false;
            }
            if ($validateAppointmentDateAndTime) {
                try {
                    $dateandtime = $this->date . " " . $this->time;
                    $apDateTime = new \DateTime($dateandtime);

                    if ($apDateTime < new \DateTime()){
                        $this->errors[] = "Appointment date and time should not be in the past.";
                        return false;
                    }
                } catch (\Exception $ex) {
                    throw new \Exception("Sorry, we could not verify date and time of the appointment. Please contact an administrator.");
                }
            }
            if ((isset($this->id) && $this->id < 0)) {
                $this->errors[] = "Internal Error: Please contact an administrator.";
                return false;
            }

            return true;
        }

        if (Application::$app->user instanceof Garage) {
            if (count($valueUpdates) == 1 && in_array("status_id", $valueUpdates)) {
                if ((isset($this->id) && $this->id < 0)) {
                    $this->errors[] = "Internal Error: Please contact an administrator.";
                    return false;
                }

                return true;
            }
            return false;
        }

        return false;
    }

    public function save()
    {
        return parent::save();
    }

    public static function getGarages()
    {
        $sql = "SELECT id, name FROM gg_garage WHERE status_id = 2"; // Assuming 2 is the status for active garages
        $statement = self::prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public static function getServicesByGarage($garageId)
    {
        $sql = "SELECT id, type FROM gg_garage_service WHERE garage_id = :garage_id AND status_id = 2"; // Assuming 2 is the status for active services
        $statement = self::prepare($sql);
        $statement->bindValue(':garage_id', $garageId);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function getServices(Request $request)
    {
        $garageId = $request->getBody()['garage_id'];
        $services = $this->getServicesByGarage($garageId);

        $options = '<option value="">Select Service</option>';
        foreach ($services as $id => $name) {
            $options .= "<option value=\"{$id}\">{$name}</option>";
        }

        return $options;
    }

    public function newAppointment(Request $request)
    {
        if ($request->isPost()) {
            $this->loadData($request->getBody());
            if ($this->validate() && $this->save()) {
                return Application::$app->response->redirect('/appointment/success');
            }
        }

        $garages = $this->getGarages();
        return Application::$app->view->renderView('newAppointment', [
            'model' => $this,
            'garages' => $garages
        ]);
    }

    public static function initialize(int $service_id, int $vehicle_id,  $date,  $time, string $note): Appointment
    {
        $object = new Appointment();
        $object->service_id = $service_id;
        $object->vehicle_id = $vehicle_id;
        $object->date = $date;
        $object->time = $time;
        $object->notes = $note;
        $object->status_id = 2;
        return $object;
    }

    public static function getAppointment(int $id, int $vehicle_id, int $service_id, $date, $time, string $note) {
        $object = new Appointment();
        $object->id = $id;
        $object->vehicle_id = $vehicle_id;
        $object->service_id = $service_id;
        $object->date = $date;
        $object->time = $time;
        $object->notes = $note;
        return $object;
    }

}
