<?php

namespace app\models;

use app\models\User;
use gearguard\phpmvc\Application;

class Admin extends User
{
    private function __construct()
    {
    }

    public function tableName(): string
    {
        return "gg_user_admin";
    }

    public function primaryKey(): string
    {
        return 'user_id';
    }

    public static function getInstance(): ?Admin
    {
        $loggedInUser = Application::$app->user;
        $sql = "SELECT * FROM gg_user_admin WHERE user_id = :user_id";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':user_id', $loggedInUser->id);
        $statement->execute();

        $obj = $statement->fetchObject(Admin::class);
        if ($obj === false)
            return null;

        return $obj;
    }

}