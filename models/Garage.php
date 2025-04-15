<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\Model;
use gearguard\phpmvc\DbModel;
use gearguard\phpmvc\UserModel;

class Garage extends UserModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    public int $id;
    public string $username = '';
    public string $name = '';
    public string $email = '';
    public int $status_id = self::STATUS_ACTIVE;
    public string $password = '';
    public string $passwordConfirm = '';
    public string $address = '';
    public string $contact_no = '';
    public string $registration_no = '';


    public function tableName(): string
    {
        return 'gg_garage';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        $this->status_id = self::STATUS_ACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 30], [self::RULE_UNIQUE, 'class' => self::class]],
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL,],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'address' => [self::RULE_REQUIRED],
            'contact_no' => [self::RULE_REQUIRED],
            'status_id' => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return ['username', 'password', 'name', 'address', 'email', 'contact_no', 'registration_no', 'status_id'];
    }

    public function labels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'address' => 'Address',
            'email' => 'Email',
            'contact_no' => 'Contact No',
            'registration_no' => 'Registration No',
            'status_id' => 'Status',
            'passwordConfirm' => 'Confirm Password',
        ];
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

    public function getServiceByType(string $type): ?GarageService
    {
        $sql = "SELECT * FROM gg_garage_service WHERE garage_id = :garage_id AND type = :type AND status_id = 2 LIMIT 1";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id);
        $statement->bindValue(':type', $type);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }
        $result = $result[0];
        $service = GarageService::getGarageService($result['id'], $result['type'], $result['price'], $result['duration'], $result['status_id'], $result['description']);
        return $service;
    }

    public function getServiceByID(int $sid): ?GarageService
    {
        $sql = "SELECT * FROM gg_garage_service WHERE garage_id = :garage_id AND id = :id AND status_id = 2 LIMIT 1";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id);
        $statement->bindValue(':id', $sid);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }
        $result = $result[0];
        $service = GarageService::getGarageService($result['id'], $result['type'], $result['price'], $result['duration'], $result['status_id'], $result['description']);
        return $service;
    }

    public function getServices(int $page): array
    {
        $sql = "SELECT ggs.type, ggs.description, ggs.duration, ggs.id, ggs.price FROM gg_garage_service ggs WHERE garage_id = :garage_id AND status_id = 2 ORDER BY ggs.id LIMIT 25 OFFSET :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id);
        $offset = ($page - 1) * 25;
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllAppointments(int $page): array
    {
        $sql = "select gvsa.id, gvsa.date, gvsa.time, gvsa.notes, gvsa.status_id, gv.license_plate_no, ggs.`id` as service_id, ggs.`type` as service_type, gu.first_name, gu.last_name, gu.contact_no, gvt.`type` as vehicle_type, gvm.model as vehicle_model  from gearguard.gg_vehicle_service_appointment gvsa left join gearguard.gg_vehicle gv on gvsa.vehicle_id = gv.`id` left join gearguard.gg_garage_service ggs on gvsa.service_id = ggs.`id` left join gearguard.gg_user_owner guo on gvsa.vehicle_id = guo.vehicle_id right join gearguard.gg_user gu on gu.`id` = coalesce (gv.current_user_id, guo.user_id) left join gearguard.gg_vehicle_type gvt on gv.vehicle_type_id = gvt.`id`  left join gearguard.gg_vehicle_model gvm on gv.model_id = gvm.`id`  where gvsa.service_id in (select ggs2.`id` from gearguard.gg_garage_service ggs2 where ggs2.garage_id = :garageID) order by gvsa.`date` desc, gvsa.`time` limit 25 offset :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garageID', $this->id);
        $page = ($page - 1) * 25;
        $statement->bindValue(':offset', $page, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getAppointmentByID(int $id): ?Appointment
    {
        $sql = "SELECT * FROM gg_vehicle_service_appointment gvsa WHERE gvsa.id = :id and gvsa.service_id in (select ggs.id from gearguard.gg_garage_service ggs where ggs.garage_id = :garage_id) LIMIT 1";
        $statement = self::prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':garage_id', $this->id);
        $statement->execute();
        $object = $statement->fetchObject();

        $appointment = Appointment::getAppointment($object->id, $object->service_id, $object->vehicle_id, $object->date, $object->time, $object->notes, $object->status_id);
        return $appointment;
    }

    public function getAllAppointmentsFiltered(string $firstName, string $lastName, string $numberPlate, string $contactNo, string $date, string $condition, string $status, int $page): array
    {
        switch (strtolower($condition)) {
            case 'before':
                $operator = '<';
                break;
            case 'after':
                $operator = '>';
                break;
            case 'on':
                $operator = '=';
                break;
            case 'on or before':
                $operator = '<=';
                break;
            case 'on or after':
                $operator = '>=';
                break;
            default:
                $operator = '=';
        }

        switch (strtolower($status)) {
            case 'pending':
                $status_id = 1;
                break;
            case 'accepted':
                $status_id = 2;
                break;
            case 'rejected':
                $status_id = 3;
                break;
            default:
                $status_id = 2;
        }
        $sql = "select gvsa.*, coalesce (gv.current_user_id, guo.user_id) as current_user_id, gv.license_plate_no, ggs.`id` as service_id, ggs.`type` as service_type, gu.`id` as user_id, gu.first_name, gu.last_name, gu.contact_no, gvt.`type` as vehicle_type, gvm.model as vehicle_model  from gearguard.gg_vehicle_service_appointment gvsa left join gearguard.gg_vehicle gv on gvsa.vehicle_id = gv.`id` left join gearguard.gg_garage_service ggs on gvsa.service_id = ggs.`id` left join gearguard.gg_user_owner guo on gvsa.vehicle_id = guo.vehicle_id right join gearguard.gg_user gu on gu.`id` = coalesce (gv.current_user_id, guo.user_id) left join gearguard.gg_vehicle_type gvt on gv.vehicle_type_id = gvt.`id`  left join gearguard.gg_vehicle_model gvm on gv.model_id = gvm.`id`  where gvsa.service_id in (select ggs2.`id` from gearguard.gg_garage_service ggs2 where ggs2.garage_id = :garageID) and (gu.first_name like :first_name and gu.last_name like :last_name and gv.license_plate_no like :number_plate and gu.contact_no like :contact_no and gvsa.`date` $operator :date and gvsa.`status_id` = :status_id) order by gvsa.`date` desc, gvsa.`time`; limit 25 offset :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garageID', $this->id, \PDO::PARAM_INT);
        $statement->bindValue(':first_name', $firstName);
        $statement->bindValue(':last_name', $lastName);
        $statement->bindValue(':number_plate', $numberPlate);
        $statement->bindValue(':contact_no', $contactNo);
        $statement->bindValue(':date', $date);
        $statement->bindValue(':status_id', $status_id, \PDO::PARAM_INT);
        $offset = ($page - 1) * 25;
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCustomerVehicleDetails(int $customerID) : array {
        $sql = "with garage_services as (select ggs.`id` from gearguard.gg_garage_service ggs where ggs.garage_id = :garage_id), relevant_vehicles as (select gvsa.vehicle_id from gearguard.gg_vehicle_service_appointment gvsa where gvsa.service_id in (select id from garage_services) union select gvst.vehicle_id from gearguard.gg_vehicle_service_take gvst where service_id in (select id from garage_services)) select gv.license_plate_no, gvt.`type`, gvm.model, gv.year_manufactured from gearguard.gg_vehicle gv right join relevant_vehicles rv on gv.id = rv.vehicle_id left join gearguard.gg_vehicle_model gvm on gv.model_id = gvm.`id` left join gearguard.gg_vehicle_type gvt on gv.vehicle_type_id = gvt.`id` left join gearguard.gg_user_owner guo on gv.`id` = guo.vehicle_id where gv.current_user_id = :user_id or guo.user_id = :user_id order by gv.id;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id, \PDO::PARAM_INT);
        $statement->bindValue(':user_id', $customerID, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllCustomerDetails(int $page) : array {
        $sql = "SELECT gu.id, gu.first_name, gu.last_name, gu.contact_no, gu.email, gu.address FROM gearguard.gg_user gu left JOIN gearguard.gg_vehicle gv ON gu.id = coalesce(gv.current_user_id, (select guo.user_id from gearguard.gg_user_owner guo where guo.vehicle_id = gv.`id`)) WHERE gv.id IN (SELECT gvsa.vehicle_id FROM gearguard.gg_vehicle_service_appointment gvsa right JOIN gearguard.gg_garage_service ggs ON gvsa.service_id = ggs.id WHERE ggs.garage_id = :garage_id UNION SELECT gvst.vehicle_id FROM gearguard.gg_vehicle_service_take gvst right JOIN gearguard.gg_garage_service ggs ON gvst.service_id = ggs.id WHERE ggs.garage_id = :garage_id) order by gu.id limit 25 offset :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id, \PDO::PARAM_INT);
        $offset = ($page - 1) * 25;
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCustomersFiltered($first_name, $last_name, $email, int $page) : array {
        $sql = "SELECT gu.id, gu.first_name, gu.last_name, gu.contact_no, gu.email, gu.address FROM gearguard.gg_user gu left JOIN gearguard.gg_vehicle gv ON gu.id = coalesce(gv.current_user_id, (select guo.user_id from gearguard.gg_user_owner guo where guo.vehicle_id = gv.`id`)) WHERE gv.id IN (SELECT gvsa.vehicle_id FROM gearguard.gg_vehicle_service_appointment gvsa right JOIN gearguard.gg_garage_service ggs ON gvsa.service_id = ggs.id WHERE ggs.garage_id = :garage_id UNION SELECT gvst.vehicle_id FROM gearguard.gg_vehicle_service_take gvst right JOIN gearguard.gg_garage_service ggs ON gvst.service_id = ggs.id WHERE ggs.garage_id = :garage_id) and gu.first_name like :firstName and gu.last_name like :last_name and gu.email like :email order by gu.id limit 25 offset :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id, \PDO::PARAM_INT);
        $offset = ($page - 1) * 25;
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->bindValue(':firstName', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email', $email);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
	
}
