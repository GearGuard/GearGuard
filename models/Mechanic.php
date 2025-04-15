<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\Model;
use gearguard\phpmvc\DbModel;
use gearguard\phpmvc\UserModel;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\Response;

class Mechanic extends UserModel
{
	const STATUS_INACTIVE = 1;
	const STATUS_ACTIVE = 2;
	const STATUS_DELETED = 3;

	public string $first_name = '';
	public string $last_name = '';
	public string $email = '';
	public string $nic = '';
	public string $address = '';
	public string $contact_no = '';
	public string $date_employeed = '';	
	public string $username = '';
	public int $status = self::STATUS_INACTIVE;
	public string $password = '';
	public int $status_id = self::STATUS_ACTIVE;
	public int $garage_id = self::STATUS_ACTIVE;
	public string $passwordConfirm = '';

	public function tableName(): string
	{
		return 'gg_garage_mechanic';
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
			'first_name' => [self::RULE_REQUIRED],
			'last_name' => [self::RULE_REQUIRED],
			'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
			'nic' => [self::RULE_REQUIRED],
			'address' => [self::RULE_REQUIRED],
			'contact_no' => [self::RULE_REQUIRED],
			'username' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 30], [self::RULE_UNIQUE, 'class' => self::class]],
			'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
			'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
		];
	}

	public function attributes(): array
	{
		return ['first_name', 'last_name', 'email', 'nic', 'address', 'username', 'password', 'contact_no', 'status_id' , 'garage_id', 'date_employeed'];
	}


	public function labels(): array
	{
		return [
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'nic' => 'NIC',
			'address' => 'Address',
			'contact_no' => 'Contact No',
			'date_employeed' => 'Date Employed',
			'username' => 'Username',
			'password' => 'Password',
			'passwordConfirm' => 'Confirm Password',
		];
	}
	public function getDisplayName(): string
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public function getServiceByType(string $type) : ?MechanicService
	{
		$sql = "SELECT * FROM gg_vehicle_service_take WHERE mechanic_id = :mechanic_id AND type = :type AND status_id = 2 LIMIT 1";
		$statement = Application::$app->db->prepare($sql);
		$statement->bindValue(':mechanic_id', $this->id);
		$statement->bindValue(':type', $type);
		$statement->execute();
		$result = $statement->fetchAll(\PDO::FETCH_ASSOC);
		if (!$result) {
			return null;
		}
		$result = $result[0];
		$service = MechanicService::getMechanicService($result['id'], $result['type'], $result['price'], $result['duration'], $result['status_id'], $result['description']);
		return $service;
	}

	public function getServiceByID(int $sid) : ?MechanicService
	{
		$sql = "SELECT * FROM gg_vehicle_service_take WHERE mechanic_id = :mechanic_id AND id = :id AND status_id = 2 LIMIT 1";
		$statement = Application::$app->db->prepare($sql);
		$statement->bindValue(':mechanic_id', $this->id);
		$statement->bindValue(':id', $sid);
		$statement->execute();
		$result = $statement->fetchAll(\PDO::FETCH_ASSOC);
		if (!$result) {
			return null;
		}
		$result = $result[0];
		$service = MechanicService::getMechanicService($result['id'], $result['type'], $result['price'], $result['duration'], $result['status_id'], $result['description']);
		return $service;
	}
	
	// public function mechanicSignup(Request $request, Response $response)
	// {
	// 	$mechanic = new Mechanic();
	// 	if ($request->isPost()) {
	// 		$mechanic->loadData($request->getBody());
	// 		$mechanic->garage_id = Application::$app->session->get('garage_id'); // Set garage_id from session or request

	// 		if (!$mechanic->garage_id) {
	// 			Application::$app->session->setFlash('error', 'Garage ID is required.');
	// 			return $this->render('mechanic/signup', ['model' => $mechanic]);
	// 		}

	// 		if ($mechanic->validate() && $mechanic->save()) {
	// 			Application::$app->session->setFlash('success', 'Thanks for Registering');
	// 			Application::$app->response->redirect('/');
	// 			exit;
	// 		}
	// 		return $this->render('mechanic/signup', [
	// 			'model' => $mechanic
	// 		]);
	// 	}
	// 	$this->setLayout('auth');
	// 	return $this->render('mechanic/signup', [
	// 		'model' => $mechanic
	// 	]);
	// }
}
