<?php
	
namespace app\models;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\UserModel;

class SparePart extends UserModel
{
	const STATUS_INACTIVE = 1;
	const STATUS_ACTIVE = 2;
	const STATUS_DELETED = 3;
	public int $id;
	public string $serial_no;
	public string $type;
	public  string $manufacturer;
	public float $price;
	public string $manufactured_date;
	public string $waranty_period;
	public string $installed_date;
	public int $current_user_id = 0;
	
	public function tableName(): string
	{
		return 'gg_sparepart';
	}
	
	public function attributes(): array
	{
		return ['serial_no', 'type', 'manufacturer', 'price', 'manufactured_date', 'waranty_period'];
	}
	
	public function primaryKey(): string
	{
		return 'id';
	}
	
	public function rules(): array
	{
		return [
			'serial_no' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
			'type' => [self::RULE_REQUIRED],
			'manufacturer' => [self::RULE_REQUIRED],
			'price' => [self::RULE_REQUIRED],
			'manufactured_date' => [self::RULE_REQUIRED],
			'waranty_period' => [self::RULE_REQUIRED],
		];
	}
	
	public function labels(): array
	{
		return [
			'serial_no' => 'Serial Number',
			'type' => 'Type',
			'manufacturer' => 'Manufacturer',
			'price' => 'Price',
			'manufactured_date' => 'Manufactured Date',
			'waranty_period' => 'Warranty Period',
		];
	}
	

	
	public static function initialize(array $data): SparePart
	{
		$sparePart = new SparePart();
		$sparePart->loadData($data);
		return $sparePart;
	}
	
	public function getDisplayName(): string
	{
		return $this->serial_no;
	}
	
	
}
