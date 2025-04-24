<?php
	
	namespace app\models;
	
	use gearguard\phpmvc\Application;
	use gearguard\phpmvc\db\DbModel;
	
	class SparePart extends DbModel
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
		public int $status_id = self::STATUS_INACTIVE;	
		
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
				'status_id' => [self::RULE_REQUIRED],
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
				'status_id' => 'Status'
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
