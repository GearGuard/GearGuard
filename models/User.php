<?php

namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\Model;
use gearguard\phpmvc\db\Database;
use gearguard\phpmvc\db\DbModel;
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
	public int $status_id = self::STATUS_ACTIVE;
	public string $passwordConfirm = '';

    private VehicleOwner $vehicleOwner;

    public function __construct()
    {
        $this->vehicleOwner = new VehicleOwner();
    }

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
		$this->status = self::STATUS_ACTIVE;
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
		return ['first_name', 'last_name', 'email', 'nic', 'address', 'username', 'password', 'contact_no', 'status_id'];
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
			'username' => 'Username',
			'password' => 'Password',
			'passwordConfirm' => 'Confirm Password',
		];
	}

	public function getDisplayName(): string
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public function getUserType(): string
	{
		$sql = "SELECT 
            CASE 
                WHEN uo.user_id IS NOT NULL THEN 'vehicle_owner'
                WHEN uv.user_id IS NOT NULL THEN 'vehicle_user'
                WHEN ua.user_id IS NOT NULL THEN 'admin'
                WHEN g.id IS NOT NULL THEN 'garage'
                WHEN gm.id IS NOT NULL THEN 'mechanic'
                ELSE 'unknown'
            END AS user_type
        FROM gg_user u
        LEFT JOIN gg_user_owner uo ON u.id = uo.user_id
        LEFT JOIN gg_user_vehicleuser uv ON u.id = uv.user_id
        LEFT JOIN gg_user_admin ua ON u.id = ua.user_id
        LEFT JOIN gg_garage g ON u.id = g.id
        LEFT JOIN gg_garage_mechanic gm ON u.id = gm.id
        WHERE u.id = :user_id";

		$statement = $this->prepare($sql);
		$statement->bindValue(':user_id', $this->id);
		$statement->execute();

		return $statement->fetchColumn();
	}

	// check if the user is a vehicle owner @PasinduRavimal pls check this :)
	public function isGarage()

	{
		return $this->role === 'garage';
	}

    public function isVehicleOwner() : bool
    {
        return $this->vehicleOwner->getOwnedVehiclesList() !== null;
    }

    public function getOwnedVehiclesList() : array
    {
        return $this->vehicleOwner->getOwnedVehiclesList()?? [];
    }

    public function getAccessAvailableVehiclesList() : array
    {
        $sql = "SELECT * FROM gg_vehicle WHERE id in (select distinct vehicle_id FROM gg_vehicle_assignments WHERE user_id = :user_id OR owner_id = :user_id)";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':user_id', Application::$app->session->get('user'));
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }


}
