<?php

namespace app\models;

use gearguard\phpmvc\Model;
use app\models\User;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\DbModel;


class LoginFormMechanic extends Model
{
	public string $username = '';
	public string $password = '';
	public function rules(): array
	{
		return [
			'username' => [self::RULE_REQUIRED],
			'password' => [self::RULE_REQUIRED]
		];
	}

	public function attributes(): array
	{
		return ['username', 'password'];
	}

	public function labels(): array
	{
		return [
			'username' => 'Username',
			'password' => 'Password'
		];
	}

	public function login()
	{
		$mechanicModel = new Mechanic();
		$mechanic = $mechanicModel->findOne(['username' => $this->username]);
		if (!$mechanic) {
			$this->addError('username', 'User does not exist with this username');
			return false;
		}
		if (!password_verify($this->password, $mechanic->password)) {
			$this->addError('password', 'Password is incorrect');
			return false;
		};
        return 	Application::$app->login($mechanic);
	}
}
