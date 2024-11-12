<?php

namespace app\models;

use app\core\Model;
use app\models\User;
use app\core\Application;
use app\core\DbModel;


class LoginForm extends Model
{
	public string $email = '';
	public string $password = '';
	public function rules(): array
	{
		return [
			'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
			'password' => [self::RULE_REQUIRED]
		];
	}

	public function attributes(): array
	{
		return ['email', 'password'];
	}

	public function labels(): array
	{
		return [
			'email' => 'Your Email',
			'password' => 'Password'
		];
	}

	public function login()
	{
		$userModel = new User();
		$user = $userModel->findOne(['email' => $this->email]);
		if (!$user) {
			$this->addError('email', 'User does not exist with this email');
			return false;
		}
		if (!password_verify($this->password, $user->password)) {
			$this->addError('password', 'Password is incorrect');
			return false;
		};
		return 	Application::$app->login($user);;
	}
}
