<?php

namespace app\models;

use gearguard\phpmvc\Model;
use gearguard\phpmvc\DbModel;
use gearguard\phpmvc\UserModel;

class Garage extends UserModel
{
	const STATUS_INACTIVE = 1;
	const STATUS_ACTIVE = 2;
	const STATUS_DELETED = 3;

    private int $id;
    public string $username = '';
	public string $name = '';
	public string $email = '';
	public int $status_id = self::STATUS_INACTIVE;
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
		$this->status_id = self::STATUS_INACTIVE;
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
}
