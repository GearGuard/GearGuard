<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\Model;
use gearguard\phpmvc\DbModel;
use gearguard\phpmvc\UserModel;
use app\utilities\EscapeAttributes;

class Mechanic extends UserModel
{
	const STATUS_INACTIVE = 1;
	const STATUS_ACTIVE = 2;
	const STATUS_DELETED = 3;

	public int $id;
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
	public int $garage_id;
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
		if (!$this->validate(validatePassword: false, useFrameworkValidations: false))
			throw new \Exception(array_values($this->errors)[0][0], 400);

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
			'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 72]],
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

	public function getDisplayPassword(): string 
	{
		return str_repeat('*', 8); // Return 8 asterisks for security
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

	public function update($toUpdate, bool $overrideValidations = false)
	{
		$shouldValidatePassword = false;
		$shouldValidateUsername = false;
		$updateData = [];
		$attributeList = $this->attributes();
		
		if (empty($toUpdate)) {
			return false;
		}

		foreach ($toUpdate as $key => $value) {
			if (in_array($key, $attributeList)) {
				$updateData[$key] = $value;
			}
		}

		if (isset($toUpdate['password'])) {
			if (empty($toUpdate['currentPassword'])) {
				throw new \Exception("Current password is required.", 400);
			}
			if (!password_verify($toUpdate['currentPassword'], $this->password)) {
				throw new \Exception("Invalid password.", 400);
			}
			$shouldValidatePassword = true;
			$updateData['password'] = $toUpdate['password'];
			$this->passwordConfirm = $toUpdate['passwordConfirm'] ?? '';
		}

		if (isset($toUpdate['username']) && $this->username !== $toUpdate['username']) {
			$shouldValidateUsername = true;
		}

		if (!$overrideValidations && !$this->validate($updateData, $shouldValidateUsername, $shouldValidatePassword, false, false, false, false)) {
			throw new \Exception(array_values($this->errors)[0][0], 400);
		}

		if ($shouldValidatePassword) {
			$updateData['password'] = password_hash($updateData['password'], PASSWORD_DEFAULT);
		}

		return parent::update($updateData);
	}

	public static function with(UserModel $model) : Mechanic
	{
		if(!$model instanceof Mechanic) {
			throw new \Exception("Invalid model type.", 400);
		}
		$mechanic = new Mechanic();
		$mechanic->loadData($model);

		return $mechanic;

	}

	public function validate($valueUpdates = [], $validateUsername = true, $validatePassword = true, $validatePersonalInfo = true, $validateContact = true, $validateInternals = true, $validateEmployedDate = true, $useFrameworkValidations = true): bool
	{
		if ($useFrameworkValidations) {
			return parent::validate();
		}

		if ($valueUpdates) {
			$this->loadData($valueUpdates);
		}

        if ($validateUsername) {
            if (empty($this->username)) {
                $this->addError('username', 'Username can not be empty.');
            } elseif (strlen($this->username) < 3 || strlen($this->username) > 30) {
                $this->addError('username', 'Username must be between 3 and 30 characters.');
            } elseif (!Mechanic::isUsernameAvailable($this->username)) {
                $this->addError('username', 'Username already exists.');
            }
        }

        if ($validatePassword) {
            if (empty($this->password)) {
                $this->addError('password', 'Password can not be empty.');
            } elseif (strlen($this->password) < 8 || strlen($this->password) > 72) {
                $this->addError('password', 'Password must be between 8 and 72 characters.');
            } elseif ($this->password != $this->passwordConfirm) {
                $this->addError('passwordConfirm', 'Password and Confirm Password do not match.');
            }
        }

		if ($validatePersonalInfo) {
			if (empty($this->first_name)) {
				$this->addError('first_name', 'First name cannot be empty.');
			}
			if (empty($this->last_name)) {
				$this->addError('last_name', 'Last name cannot be empty.');
			}
			if (empty($this->nic)) {
				$this->addError('nic', 'NIC cannot be empty.');
			} elseif (!preg_match('/^[A-Z]{0,3}[-\s]?\d{2,8}(?:[-\/\s]?\d{2,8}){0,4}[A-Za-z]?\(?\d{0,3}\)?$/', $this->nic)) {
                $this->addError('nic', 'NIC is not valid.');
            }
			if (empty($this->email)) {
				$this->addError('email', 'Email cannot be empty.');
			} elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
				$this->addError('email', 'Email is not valid.');
			}
		}

		if ($validateContact) {
            if (!preg_match('/^\+?(?:\d+[-\s]?)*\d+$|^\+?[-\s]?\((?:\d+[-\s]?)*\d+\)[-\s]?$|^\+?(?:\d*[-\s]?\((?:\d+[-\s]?)*\d+\)[-\s]?(?:\d+[-\s]?)*\d+)+$|^\+?(?:(?:\d+[-\s]?)*\d+[-\s]?\((?:\d+[-\s]?)*\d+\)[-\s]?\d*)+$/', $this->contact_no)) {
                $this->addError('contact_no', 'Contact Number is not valid.');
            }
			$contactTemp = str_replace([' ', '-', '+', '(', ')'], '', $this->contact_no);
			if (empty($this->contact_no)) {
				$this->addError('contact_no', 'Contact Number cannot be empty.');
			} elseif (!preg_match('/^\d{7,20}$/', $contactTemp)) {
				$this->addError('contact_no', 'Contact Number is not valid.');
			}
		}

        if ($validateEmployedDate) {
            if (empty($this->date_employeed)) {
                $this->addError('date_employeed', 'Date Employed cannot be empty.');
            } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_employeed)) {
                $this->addError('date_employeed', 'Date Employed is not valid.');
            } else {
                $date = \DateTime::createFromFormat('Y-m-d', $this->date_employeed);
                if ($date === false) {
                    $this->addError('date_employeed', 'Date Employed is not valid.');
                } elseif ($date > new \DateTime()) {
                    $this->addError('date_employeed', 'Date Employed cannot be in the future.');
                }
            }
        }

		if ($validateInternals) {
			if ($this->status_id < 1 || $this->status_id > 3) {
				$this->addError('status_id', 'Status ID must be between one and three.');
			}
			if (!Garage::verifyGarageExistance($this->garage_id)) {
				$this->addError('garage_id', 'Invalid garage assignment.');
			}
		}

		return empty($this->errors);
	}

	public static function isUsernameAvailable(string $username) : bool
	{
		$sql = "SELECT * FROM gg_garage_mechanic WHERE username = :username LIMIT 1";
		$statement = Application::$app->db->prepare($sql);
		$statement->bindValue(':username', $username);
		$statement->execute();
		$result = $statement->fetch();
		return $result === false;
	}

	public function getAllServices(int $page = 1): array 
	{
		$sql = "SELECT * FROM gg_vehicle_service_take WHERE mechanic_id = :mechanic_id AND status_id = 2 ORDER BY id LIMIT 25 OFFSET :offset";
		$statement = Application::$app->db->prepare($sql);
		$statement->bindValue(':mechanic_id', $this->id);
		$offset = ($page - 1) * 25;
		$statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
		$statement->execute();
		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getServiceHistory(int $page = 1): array
	{
		$sql = "SELECT vst.*, v.license_plate_no, u.first_name, u.last_name 
				FROM gg_vehicle_service_take vst 
				LEFT JOIN gg_vehicle v ON vst.vehicle_id = v.id
				LEFT JOIN gg_user u ON v.current_user_id = u.id 
				WHERE vst.mechanic_id = :mechanic_id 
				ORDER BY vst.begin_timestamp DESC 
				LIMIT 25 OFFSET :offset";
		$statement = Application::$app->db->prepare($sql);
		$statement->bindValue(':mechanic_id', $this->id);
		$offset = ($page - 1) * 25;
		$statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
		$statement->execute();
		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}
}
