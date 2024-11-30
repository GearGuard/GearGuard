<?php

namespace app\models;

use app\models\User;
use gearguard\phpmvc\Application;

class VehicleOwner extends User
{
    private $vehicle_list;

    public function __construct()
    {
        $this->updateVehicleList();
    }

    public function updateVehicleList()
    {
        $sql = "SELECT * FROM gg_user_owner WHERE user_id = :user_id";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':user_id', Application::$app->session->get('user'));
        $statement->execute();

        $this->vehicle_list = $statement->fetchAll();
    }

}