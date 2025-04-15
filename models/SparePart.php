<?php

namespace app\models;

use gearguard\phpmvc\db\DbModel;
use gearguard\phpmvc\Model;
use gearguard\phpmvc\UserModel;

class SparePart extends UserModel
{
	

	public int $id;
	public string $serial_no = '';
	public string $type = '';
	public string $manufacturer	 = '';
	public string $price = '';
	public string $manufactured_date = '';
	public string $waranty_period = '';
	
	

	public function tableName(): string
	{
		return 'gg_sparepart';
	}

	public function primaryKey(): string
	{
		return 'id';
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
		return ['serial_no', 'type', 'manufacturer', 'price', 'manufactured_date', 'waranty_period'];
	}


    public function save()
    {
        $tableName = static::tableName();
        $attributes = $this->attributes();
        

        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") VALUES (".implode(',', $params).")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function findAll($where)
{
    $tableName = static::tableName();
    $attributes = array_keys($where);

    $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
    $statement = self::prepare("
        SELECT * FROM $tableName 
        
    ");
    foreach ($where as $key => $value) {
        $statement->bindValue(":$key", $value);
    }
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
}

public function delete()
    {
        $tableName = static::tableName();
        $primaryKey = static::primaryKey();
        $sql = "DELETE FROM $tableName WHERE $primaryKey = :$primaryKey";
        $statement = self::prepare($sql);
        $statement->bindValue(":$primaryKey", $this->{$primaryKey});
        return $statement->execute();
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    
    }

    

	
}
