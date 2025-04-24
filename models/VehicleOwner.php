<?php

namespace app\models;

use app\models\User;
use gearguard\phpmvc\Application;

class VehicleOwner extends User
{
    private array $vehicle_list;

    public function __construct()
    {
        $this->updateVehicleList();
    }

    public function tableName(): string
    {
        return "gg_user_owner";
    }

    public function primaryKeys(): array
    {
        return ['vehicle_id', 'user_id'];
    }

    public function updateVehicleList()
    {
        $sql = "SELECT * FROM gg_user_owner uo LEFT JOIN gg_vehicle v ON uo.vehicle_id = v.id WHERE uo.user_id = :user_id";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':user_id', Application::$app->session->get('user'));
        $statement->execute();

        $this->vehicle_list = $statement->fetchAll();
    }

    public function getOwnedVehiclesList() : array
    {
        return $this->vehicle_list;
    }

}