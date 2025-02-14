<?php

namespace app\models;

use gearguard\phpmvc\db\DbModel;

class GarageAppointment extends DbModel
{

    public int $id;
    public string $vehicleType = '';
    public string $ownerName = '';
    public string $contactNo = '';
    public string $numberPlate = '';
    public string $vehicleModel = '';
    public string $serviceType = '';
    public string $dateAndTime = '';
    public string $notes = '';

    public function tableName(): string
    {
        return 'gg_vehicle_service_appointment';
    }

    public function attributes(): array
    {
        return [];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [];
    }
}