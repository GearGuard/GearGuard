<?php

namespace app\models;

use gearguard\phpmvc\Model;
use app\models\User;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\DbModel;


class LoginForm extends Model
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
			'username' => 'Your Username',
			'password' => 'Password'
		];
	}

	public function login()
	{
		$userModel = new User();
		$user = $userModel->findOne(['username' => $this->username]);
		if (!$user) {
			$this->addError('username', 'User does not exist with this username');
			return false;
		}
		if (!password_verify($this->password, $user->password)) {
			$this->addError('password', 'Password is incorrect');
			return false;
		};
		return 	Application::$app->login($user);
	}
}
