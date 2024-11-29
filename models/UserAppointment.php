<?php

namespace app\models;

use gearguard\phpmvc\Model;
use gearguard\phpmvc\DbModel;
use gearguard\phpmvc\UserModel;

class UserAppointment extends UserModel
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $contact_no = '';
    public string $vehicle_type = '';
    public string $service_type = '';
    public string $notes = '';
    public string $status = 'pending';
    public string $appointment_date = '';

    public function tableName(): string
    {
        return 'gg_appointments';
    }
    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'first_name',
            'last_name',
            'email',
            'contact_no',
            'vehicle_type',
            'service_type',
            'notes',
            'status',
            'appointment_date'
        ];
    }

    public function labels(): array
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'contact_no' => 'Contact Number',
            'vehicle_type' => 'Vehicle Type',
            'service_type' => 'Service Type',
            'notes' => 'Additional Notes'
        ];
    }

    public function rules(): array
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'contact_no' => [self::RULE_REQUIRED],
            'vehicle_type' => [self::RULE_REQUIRED],
            'service_type' => [self::RULE_REQUIRED],
            'notes' => []
        ];
    }

    public function save()
    {
        $this->status = 'pending';
        $this->appointment_date = date('Y-m-d H:i:s');
        return parent::save();
    }

    public function getDisplayName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
