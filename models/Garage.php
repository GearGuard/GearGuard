<?php

namespace app\models;

use app\utilities\JWTGenerator;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Model;
use gearguard\phpmvc\DbModel;
use gearguard\phpmvc\UserModel;
use app\utilities\EscapeAttributes;
use http\Env\Request;
use http\Env\Response;

class Garage extends UserModel
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    public int $id;
    public string $username = '';
    public string $name = '';
    public string $email = '';
    public int $status_id = self::STATUS_ACTIVE;
    public string $password = '';
    public string $passwordConfirm = '';
    public string $address = '';
    public string $contact_no = '';
    public string $registration_no = '';
    public ?string $description = null;

    private $secretKey = 'Abracadabra@Hogwarts1959';

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
        $this->status_id = self::STATUS_ACTIVE;
        if (!$this->validate())
            throw new \Exception(array_values($this->errors)[0][0], 400);

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::save();
    }

    public function update($toUpdate, bool $overrideValidations = false)
    {
        $shouldValidatePassword = false;
        $shouldValidateUsername = false;
        $updateData = [];
        $attributeList = $this->attributes();
        if (empty($toUpdate))
            return false;

        foreach ($toUpdate as $key => $value) {
            if (in_array($key, $attributeList)) {
                $updateData[$key] = $value;
            }
        }

        if (isset($toUpdate['password']) && $this->password != $toUpdate['password']) {
            if (empty($toUpdate['currentPassword'])) {
                throw new \Exception("Current password is required.", 400);
            } elseif (!password_verify($toUpdate['currentPassword'], $this->password)) {
                throw new \Exception("Invalid password.", 400);
            }
            $shouldValidatePassword = true;
        }

        if (isset($toUpdate['username']) && $this->username != $toUpdate['username']) {
            $shouldValidateUsername = true;
        }

        $data = Garage::with(Application::$app->user);
        $data->loadData($updateData);

        if (!$overrideValidations && !$data->validate($toUpdate, validateUsername: $shouldValidateUsername, validatePassword: $shouldValidatePassword, useFrameworkValidations : false)) {
            throw new \Exception(array_values($data->errors)[0][0], 400);
        }

        if ($shouldValidatePassword) {
            $updateData['password'] = password_hash($data->password, PASSWORD_DEFAULT);
        }

        return parent::update($updateData);
    }

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 30], [self::RULE_UNIQUE, 'class' => self::class]],
            'name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 100]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL,],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 72]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'address' => [self::RULE_REQUIRED],
            'contact_no' => [self::RULE_REQUIRED],
            'status_id' => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return ['username', 'password', 'name', 'address', 'email', 'contact_no', 'registration_no', 'status_id', 'description'];
    }

    public function labels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'address' => 'Address',
            'email' => 'Email',
            'contact_no' => 'Contact Number',
            'registration_no' => 'Business Registration Number',
            'status_id' => 'Status',
            'passwordConfirm' => 'Confirm Password',
            'description' => 'Description',
        ];
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

    /** This method should <b>never</b> be called directly on the logged-in User model without setting $useFrameworkValidations to true.
     * Instead, create a new model and use {@code Garage::with($model)} to create a new Garage model with the data from the User model.
     * <br><br>
     * <em>Note: This method fills up the model it is called on with $valueUpdates parameter values if it is set.<em>
     */
    public function validate($valueUpdates = [], $validateUsername = true, $validatePassword = true, $validateName = true, $validateAddress = true, $validateEmail = true, $validateContactNo = true, $validateBRN = true, $validateInternals = true, $useFrameworkValidations = true): bool
    {
        if ($useFrameworkValidations) {
            return parent::validate();
        }

        if (isset($valueUpdates)) {
            foreach($valueUpdates as $key => $value) {
                $this->{$key} = $value;
            }
        }

        if ($validateUsername) {
            if (empty($this->username)) {
                $this->addError('username', 'Username can not be empty.');
            } elseif (strlen($this->username) < 3 || strlen($this->username) > 30) {
                $this->addError('username', 'Username must be between 3 and 30 characters.');
            } elseif (!Garage::isUsernameAvailable($this->username)) {
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
        if ($validateName) {
            if (empty($this->name)) {
                $this->addError('name', 'Name can not be empty.');
            } elseif (strlen($this->name) < 3 || strlen($this->name) > 100) {
                $this->addError('name', 'Name must be between 3 and 100 characters.');
            }
        }
        if ($validateAddress) {
            if (empty($this->address)) {
                $this->addError('address', 'Address can not be empty.');
            }
        }
        if ($validateEmail) {
            if (empty($this->email)) {
                $this->addError('email', 'Email can not be empty.');
            } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->addError('email', 'Email is not valid.');
            }
        }
        if ($validateContactNo) {
            if (!preg_match('/^\+?(?:\d+[-\s]?)*\d+$|^\+?[-\s]?\((?:\d+[-\s]?)*\d+\)[-\s]?$|^\+?(?:\d*[-\s]?\((?:\d+[-\s]?)*\d+\)[-\s]?(?:\d+[-\s]?)*\d+)+$|^\+?(?:(?:\d+[-\s]?)*\d+[-\s]?\((?:\d+[-\s]?)*\d+\)[-\s]?\d*)+$/', $this->contact_no)) {
                $this->addError('contact_no', 'Contact Number is not valid.');
            }
            $contactTemp = str_replace([' ', '-', '+', '(', ')'], '', $this->contact_no);
            if (empty($this->contact_no)) {
                $this->addError('contact_no', 'Contact Number can not be empty.');
            } elseif (!preg_match('/^\d{7,20}$/', $contactTemp)) {
                $this->addError('contact_no', 'Contact Number is not valid.');
            }
        }
        if ($validateBRN) {
            $brnTemp = str_replace(' ', '', $this->registration_no);
            $brnTemp = str_replace('-', '', $brnTemp);
            if (empty($this->registration_no)) {
                $this->addError('registration_no', 'Business Registration Number can not be empty.');
            } elseif (!preg_match('/^[0-9A-Za-z]{8,30}$/', $brnTemp)) {
                $this->addError('registration_no', 'Business Registration Number is not valid.');
            }
        }
        if ($validateInternals) {
            if (isset($this->id) && $this->id < 0 && !Garage::verifyGarageExistance($this->id)) {
                $this->addError('id', 'Internal Error: Please contact administrators.');
            }
            if ($this->status_id < 1 || $this->status_id > 3) {
                $this->addError('status_id', 'Status ID must be between one and three.');
            }
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;

    }

    public static function isUsernameAvailable(string $username) : bool
    {
        $sql = "SELECT * FROM gearguard.gg_garage gg WHERE gg.username = :username LIMIT 1";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_NUM);
        if (count($result) > 0) {
            return false;
        }

        return true;
    }

    public static function with(UserModel $model) : Garage
    {
        if (!$model instanceof Garage) {
            throw new \Exception('Invalid model type passed.');
        }

        $garage = new Garage();
        $garage->loadData($model);

        return $garage;
    }

    public function getServiceByType(string $type): ?GarageService
    {
        $sql = "SELECT * FROM gg_garage_service WHERE garage_id = :garage_id AND type = :type AND status_id = 2 LIMIT 1";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id);
        $statement->bindValue(':type', $type);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }
        $result = $result[0];
        $service = GarageService::getGarageService($result['id'], $result['type'], $result['price'], $result['duration'], $result['status_id'], $result['description']);
        return $service;
    }

    public function getServiceByID(int $sid): GarageService
    {
        $sql = "SELECT * FROM gg_garage_service WHERE garage_id = :garage_id AND id = :id AND status_id = 2 LIMIT 1";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id);
        $statement->bindValue(':id', $sid);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        if (!$result) {
            return GarageService::getGarageService(-1, '', 0, 0, 0, '');
        }
        $result = $result[0];
        $service = GarageService::getGarageService($result['id'], $result['type'], $result['price'], $result['duration'], $result['status_id'], $result['description']);
        return $service;
    }

    public function getServices(int $page): array
    {
        $sql = "SELECT ggs.type, ggs.description, ggs.duration, ggs.id, ggs.price FROM gg_garage_service ggs WHERE garage_id = :garage_id AND status_id = 2 ORDER BY ggs.id LIMIT 25 OFFSET :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id);
        $offset = ($page - 1) * 25;
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllAppointments(int $page): array
    {
        $sql = "select gvsa.id, gvsa.date, gvsa.time, gvsa.notes, gvsa.status_id, gv.license_plate_no, ggs.`id` as service_id, ggs.`type` as service_type, gu.first_name, gu.last_name, gu.contact_no, gvt.`type` as vehicle_type, gvm.model as vehicle_model  from gearguard.gg_vehicle_service_appointment gvsa left join gearguard.gg_vehicle gv on gvsa.vehicle_id = gv.`id` left join gearguard.gg_garage_service ggs on gvsa.service_id = ggs.`id` left join gearguard.gg_user_owner guo on gvsa.vehicle_id = guo.vehicle_id right join gearguard.gg_user gu on gu.`id` = coalesce (gv.current_user_id, guo.user_id) left join gearguard.gg_vehicle_type gvt on gv.vehicle_type_id = gvt.`id`  left join gearguard.gg_vehicle_model gvm on gv.model_id = gvm.`id`  where gvsa.service_id in (select ggs2.`id` from gearguard.gg_garage_service ggs2 where ggs2.garage_id = :garageID) order by gvsa.`date` desc, gvsa.`time` limit 25 offset :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garageID', $this->id);
        $page = ($page - 1) * 25;
        $statement->bindValue(':offset', $page, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getAppointmentByID(int $id): Appointment
    {
        $sql = "SELECT * FROM gg_vehicle_service_appointment gvsa WHERE gvsa.id = :id and gvsa.service_id in (select ggs.id from gearguard.gg_garage_service ggs where ggs.garage_id = :garage_id) LIMIT 1";
        $statement = self::prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':garage_id', $this->id);
        $statement->execute();
        $object = $statement->fetchObject();

        if (!$object)
            return Appointment::getAppointment(-1, -1, -1, null, null, null);

        return Appointment::getAppointment($object->id, $object->service_id, $object->vehicle_id, $object->date, $object->time, $object->notes, $object->status_id);
    }

    public function getAllAppointmentsFiltered(string $firstName, string $lastName, string $numberPlate, string $contactNo, string $date, string $condition, string $status, int $page): array
    {
        switch (strtolower($condition)) {
            case 'before':
                $operator = '<';
                break;
            case 'after':
                $operator = '>';
                break;
            case 'on':
                $operator = '=';
                break;
            case 'on or before':
                $operator = '<=';
                break;
            case 'on or after':
                $operator = '>=';
                break;
            default:
                $operator = '=';
        }

        switch (strtolower($status)) {
            case 'pending':
                $status_id = 1;
                break;
            case 'accepted':
                $status_id = 2;
                break;
            case 'rejected':
                $status_id = 3;
                break;
            case 'completed':
                $status_id = 4;
                break;
            case 'cancelled':
                $status_id = 5;
                break;
            default:
                $status_id = 2;
        }
        $sql = "select gvsa.*, coalesce (gv.current_user_id, guo.user_id) as current_user_id, gv.license_plate_no, ggs.`id` as service_id, ggs.`type` as service_type, gu.`id` as user_id, gu.first_name, gu.last_name, gu.contact_no, gvt.`type` as vehicle_type, gvm.model as vehicle_model  from gearguard.gg_vehicle_service_appointment gvsa left join gearguard.gg_vehicle gv on gvsa.vehicle_id = gv.`id` left join gearguard.gg_garage_service ggs on gvsa.service_id = ggs.`id` left join gearguard.gg_user_owner guo on gvsa.vehicle_id = guo.vehicle_id right join gearguard.gg_user gu on gu.`id` = coalesce (gv.current_user_id, guo.user_id) left join gearguard.gg_vehicle_type gvt on gv.vehicle_type_id = gvt.`id`  left join gearguard.gg_vehicle_model gvm on gv.model_id = gvm.`id`  where gvsa.service_id in (select ggs2.`id` from gearguard.gg_garage_service ggs2 where ggs2.garage_id = :garageID) and (gu.first_name like :first_name and gu.last_name like :last_name and gv.license_plate_no like :number_plate and gu.contact_no like :contact_no and gvsa.`date` $operator :date and gvsa.`status_id` = :status_id) order by gvsa.`date` desc, gvsa.`time`; limit 25 offset :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garageID', $this->id, \PDO::PARAM_INT);
        $statement->bindValue(':first_name', $firstName);
        $statement->bindValue(':last_name', $lastName);
        $statement->bindValue(':number_plate', $numberPlate);
        $statement->bindValue(':contact_no', $contactNo);
        $statement->bindValue(':date', $date);
        $statement->bindValue(':status_id', $status_id, \PDO::PARAM_INT);
        $offset = ($page - 1) * 25;
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCustomerVehicleDetails(int $customerID) : array {
        $sql = "with garage_services as (select ggs.`id` from gearguard.gg_garage_service ggs where ggs.garage_id = :garage_id), relevant_vehicles as (select gvsa.vehicle_id from gearguard.gg_vehicle_service_appointment gvsa where gvsa.service_id in (select id from garage_services) union select gvst.vehicle_id from gearguard.gg_vehicle_service_take gvst where service_id in (select id from garage_services)) select gv.license_plate_no, gvt.`type`, gvm.model, gv.year_manufactured from gearguard.gg_vehicle gv right join relevant_vehicles rv on gv.id = rv.vehicle_id left join gearguard.gg_vehicle_model gvm on gv.model_id = gvm.`id` left join gearguard.gg_vehicle_type gvt on gv.vehicle_type_id = gvt.`id` left join gearguard.gg_user_owner guo on gv.`id` = guo.vehicle_id where gv.current_user_id = :user_id or guo.user_id = :user_id order by gv.id;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id, \PDO::PARAM_INT);
        $statement->bindValue(':user_id', $customerID, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllCustomerDetails(int $page) : array {
        $sql = "SELECT gu.id, gu.first_name, gu.last_name, gu.contact_no, gu.email, gu.address FROM gearguard.gg_user gu left JOIN gearguard.gg_vehicle gv ON gu.id = coalesce(gv.current_user_id, (select guo.user_id from gearguard.gg_user_owner guo where guo.vehicle_id = gv.`id`)) WHERE gv.id IN (SELECT gvsa.vehicle_id FROM gearguard.gg_vehicle_service_appointment gvsa right JOIN gearguard.gg_garage_service ggs ON gvsa.service_id = ggs.id WHERE ggs.garage_id = :garage_id UNION SELECT gvst.vehicle_id FROM gearguard.gg_vehicle_service_take gvst right JOIN gearguard.gg_garage_service ggs ON gvst.service_id = ggs.id WHERE ggs.garage_id = :garage_id) order by gu.id limit 25 offset :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id, \PDO::PARAM_INT);
        $offset = ($page - 1) * 25;
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCustomersFiltered($first_name, $last_name, $email, int $page) : array {
        $sql = "SELECT gu.id, gu.first_name, gu.last_name, gu.contact_no, gu.email, gu.address FROM gearguard.gg_user gu left JOIN gearguard.gg_vehicle gv ON gu.id = coalesce(gv.current_user_id, (select guo.user_id from gearguard.gg_user_owner guo where guo.vehicle_id = gv.`id`)) WHERE gv.id IN (SELECT gvsa.vehicle_id FROM gearguard.gg_vehicle_service_appointment gvsa right JOIN gearguard.gg_garage_service ggs ON gvsa.service_id = ggs.id WHERE ggs.garage_id = :garage_id UNION SELECT gvst.vehicle_id FROM gearguard.gg_vehicle_service_take gvst right JOIN gearguard.gg_garage_service ggs ON gvst.service_id = ggs.id WHERE ggs.garage_id = :garage_id) and (gu.first_name like :firstName or gu.last_name like :last_name or gu.email like :email) order by gu.id limit 25 offset :offset;";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id, \PDO::PARAM_INT);
        $offset = ($page - 1) * 25;
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->bindValue(':firstName', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email', $email);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function verifyGarageExistance(int $garageID) : bool {
        $sql = "SELECT gg.id FROM gearguard.gg_garage gg WHERE gg.id = :garage_id LIMIT 1";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $garageID, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        if (count($result) > 0)
            return true;

        return false;
    }

    public function hasNotifications(): bool
    {
        if (count(Notification::receiveNotification($this->id)) > 0)
            return true;

        return false;
    }

    public function hasMessages(): bool
    {
        return Message::hasMessages($this->id);
    }

    public function getToken()
    {
        return JWTGenerator::generateJWT(JWTGenerator::generatePayloadForJWT($this->id), $this->secretKey);
    }

    public function getAllGarageServiceTypesForDropDown() {
        $sql = "SELECT ggs.id, ggs.type FROM gearguard.gg_garage_service ggs WHERE ggs.garage_id = :garage_id AND ggs.status_id = 2 order by ggs.id";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $this->id);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function getMechanicByUsername(string $username) : ?Mechanic
    {
        $sql = "SELECT gm.* FROM gearguard.gg_garage_mechanic gm WHERE gm.username = :username AND gm.garage_id = :garage_id LIMIT 1";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':garage_id', $this->id);
        $statement->execute();
        $result = $statement->fetchObject(Mechanic::class);
        if ($result)
            return $result;

        return null;
    }
	
}
