<?php

namespace app\models;

use gearguard\phpmvc\Model;
use gearguard\phpmvc\DbModel;
use gearguard\phpmvc\UserModel;

class User extends UserModel
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
	public string $username = '';
	public int $status = self::STATUS_INACTIVE;
	public string $password = '';
	public int $status_id = self::STATUS_INACTIVE;
	public string $passwordConfirm = '';

	public function tableName(): string
	{
		return 'gg_user';
	}

	public function primaryKey(): string
	{
		return 'id';
	}

	public function save()
	{
		$this->status = self::STATUS_INACTIVE;
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
		return ['first_name', 'last_name', 'email', 'nic', 'address', 'username', 'password', 'status', 'contact_no', 'status_id'];
	}

	public function labels(): array
	{
		return [
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'password' => 'Password',
			'passwordConfirm' => 'Confirm Password',
		];
	}
	public function getDisplayName(): string
	{
		return $this->first_name . ' ' . $this->last_name;
	}
}
