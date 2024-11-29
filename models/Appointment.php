<?php

namespace app\models;

use gearguard\phpmvc\db\DbModel;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Request;

class Appointment extends DbModel
{
    public int $user_id = 0;
    public int $garage_id = 0;
    public int $service_id = 0;
    public string $appointment_date = '';
    public string $appointment_time = '';
    public string $notes = '';

    public function tableName(): string
    {
        return 'gg_vehicle_service_appointment';
    }

    public function attributes(): array
    {
        return ['vehicle_id', 'service_id', 'date', 'time', 'notes'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED],
            'garage_id' => [self::RULE_REQUIRED],
            'service_id' => [self::RULE_REQUIRED],
            'appointment_date' => [self::RULE_REQUIRED],
            'appointment_time' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'garage_id' => 'Garage',
            'service_id' => 'Service Type',
            'appointment_date' => 'Appointment Date',
            'appointment_time' => 'Appointment Time',
            'notes' => 'Additional Notes',
        ];
    }

    public function save()
    {
        $this->user_id = Application::$app->user->id; // Assuming you have a way to get the logged-in user's ID
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
        $appointment = new Appointment();

        if ($request->isPost()) {
            $appointment->loadData($request->getBody());
            $appointment->user_id = Application::$app->user->id; // Set the user_id
            if ($appointment->validate() && $appointment->save()) {
                return Application::$app->response->redirect('/appointment/success');
            }
        }

        $garages = $this->getGarages();
        return Application::$app->view->renderView('newAppointment', [
            'model' => $appointment,
            'garages' => $garages
        ]);
    }
}
