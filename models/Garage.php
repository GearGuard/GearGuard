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

    public function getServiceByType(string $type) : ?GarageService
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

    public function getServiceByID(int $sid) : ?GarageService
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

    public function getServices() : array
    {
        $sql = "SELECT ggs.type, ggs.description, ggs.duration, ggs.id, ggs.price FROM gg_garage_service ggs WHERE garage_id = :garage_id AND status_id = 2";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllAppointments() : array
    {
        $sql = "select gvsa.date, gvsa.time, gvsa.notes, gv.license_plate_no, ggs.`id` as service_id, ggs.`type` as service_type, gu.first_name, gu.last_name, gu.contact_no, gvt.`type` as vehicle_type, gvm.model as vehicle_model  from gearguard.gg_vehicle_service_appointment gvsa left join gearguard.gg_vehicle gv on gvsa.vehicle_id = gv.`id` left join gearguard.gg_garage_service ggs on gvsa.service_id = ggs.`id` left join gearguard.gg_user_owner guo on gvsa.vehicle_id = guo.vehicle_id right join gearguard.gg_user gu on gu.`id` = coalesce (gv.current_user_id, guo.user_id) left join gearguard.gg_vehicle_type gvt on gv.vehicle_type_id = gvt.`id`  left join gearguard.gg_vehicle_model gvm on gv.model_id = gvm.`id`  where gvsa.service_id in (select ggs2.`id` from gearguard.gg_garage_service ggs2 where ggs2.garage_id = :garageID);";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garageID', $this->id);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }
	
}
