<?php

namespace app\controllers;

use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Response;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;

class AdminController extends Controller
{
    public static function isAdmin() : bool {
        return true;
    }
    public function __construct()
    {
        $this->registerMiddleware(new ExtendedMiddleware([], self::isAdmin()));
    }

    public function admin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin');
    }

    // Admin users section
    public function viewUsers(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/users/viewUsers');
    }
    public function addUser(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/users/addUser');
    }
    public function editUser(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/users/editUser');
    }

    // Admin services section
    public function viewServices(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/services/viewServices');
    }
    public function addService(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/services/addService');
    }
    public function editService(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/services/editService');
    }

    // Admin vehicles section
    public function viewVehiclesByAdmin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/vehicles/viewvehicles');
    }
    public function addVehicleByAdmin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/vehicles/addvehicle');
    }
    public function editVehicleByAdmin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/vehicles/editvehicle');
    }

    // Admin transactions section
    public function admin_transaction(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/transaction');
    }

    public function admin_dashboard(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/dashboard');
    }

    public function questions(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/q&a');
    }
}