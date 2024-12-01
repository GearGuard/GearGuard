<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\LoginFormGarage;
use app\models\VehicleOwner;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Request;
use app\models\User;
use app\models\Garage;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Response;
use gearguard\phpmvc\Router;
use app\models\LoginForm;
use gearguard\phpmvc\middlewares\AuthMiddleware;

class AuthController extends Controller
{
    // public string $layout = 'customer'; 
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
        $this->registerMiddleware(new AuthMiddleware(['customer']));
    }
    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->response->redirect('/');
                return;
            }
        }

        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }
    public function register(Request $request)
    {
        $errors = [];
        $user = new User();
        if ($request->isPost()) {
            $user->loadData($request->getBody());


            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlash('success', 'Thanks for Registering');
                Application::$app->response->redirect('/');
                exit;
            }
            return $this->render('register', [
                'model' => $user
            ]);
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user
        ]);
    }
    public function logOut(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function myProfile()
    {
        return $this->render('customer/profile/myProfile', [
            'title' => 'My Profile'
        ]);
    }

    public function customer()
    {
        return $this->render('customer/customer', [
            'title' => 'Customer Dashboard'
        ]);
    }

    public function dashboard()
    {
        return $this->render('customer/dashboard', [
            'title' => 'Customer Dashboard'
        ]);
    }

    public function settings()
    {
        return $this->render('customer/setting', [
            'title' => 'Settings'
        ]);
    }

    public function newSparepart()
    {
        return $this->render('customer/sparepart/newPart', [
            'title' => 'Add Sparepart'
        ]);
    }

    public function viewSparepart()
    {
        return $this->render('customer/sparepart/viewPart', [
            'title' => 'View Spareparts'
        ]);
    }

    public function garageSignup(Request $request)
    {
        $errors = [];
        $garage = new Garage();
        if ($request->isPost()) {
            $garage->loadData($request->getBody());


            if ($garage->validate() && $garage->save()) {
                Application::$app->session->setFlash('success', 'Thanks for Registering');
                Application::$app->response->redirect('/');
                exit;
            }
            return $this->render('garage/signup', [
                'model' => $garage
            ]);
        }
        $this->setLayout('auth');
        return $this->render('garage/signup', [
            'model' => $garage
        ]);
    }

    public function garageLogin(Request $request, Response $response)
    {
        $loginForm = new LoginFormGarage();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->session->set('isGarage', true);
                Application::$app->response->redirect('/');
                return;
            }
        }

        $this->setLayout('auth');
        return $this->render('garage/signin', [
            'model' => $loginForm
        ]);
    }

    //  Not sure about this, i used this for file permission, its kinda working but not sure @PasinduRavimal can you check this
    public function garage()
    {
        // Check if the user is logged in
        if (Application::isGuest()) {
            // If not logged in, redirect to login page
            Application::$app->response->redirect('/login');
            return;
        }

        // Check if the logged-in user is a garage
        if (!Application::$app->user->isGarage()) {
            // If not a garage, redirect to an appropriate page (e.g., home or error page)
            Application::$app->response->redirect('/');
            return;
        }

        // If the user is logged in and is a garage, render the garage dashboard
        return $this->render('garage/garage', [
            'title' => 'Garage Dashboard'
        ]);
    }

    public function newAppointments(Request $request, Response $response)
    {
        if ((Application::$app->user->isVehicleOwner() ?? false) && Application::$app->user->getOwnedVehiclesList()) {
            $model = new Appointment();

            // Fetch garages from the database
            $garages = $this->getGarages();
            $vehicles_list = $this->getVehiclesListForDropDown();

            return $this->render('customer/appointment/newAppointment', [
                'model' => $model,
                'garages' => $garages,
                'vehicles' => $vehicles_list,
            ]);
        } else {
            return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
        }
    }

    public function myAppointments(Request $request, Response $response)
    {
        return $this->render('customer/appointment/myAppointment', ['name' => 'The GearGuard']);
    }

    public function serviceHistory(Request $request, Response $response)
    {
        return $this->render('customer/appointment/serviceHistory', ['name' => 'The GearGuard']);
    }

    public function sparepartsWarranty(Request $request, Response $response)
    {
        return $this->render('customer/appointment/warrenty', ['name' => 'The GearGuard']);
    }

    private function getVehiclesListForDropDown(): array
    {
        $vehicles = Application::$app->user->getOwnedVehiclesList();

        $vehicles_list = [];

        foreach ($vehicles as $vehicle) {
            $vehicles_list[$vehicle['id']] = $vehicle['license_plate_no'];
        }

        return $vehicles_list;
    }

    public function addVehicle(Request $request, Response $response)
    {
        return $this->render('customer/vehicle/addNew', ['name' => 'The GearGuard']);
    }
    public function transferVehicle(Request $request, Response $response)
    {
        return $this->render('customer/vehicleTransfer/instruction', ['name' => 'The GearGuard']);
    }



    private function getGarages()
    {
        $sql = "SELECT id, name FROM gg_garage WHERE status_id = 1"; // Assuming 2 is the status for active garages
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function getServices(Request $request)
    {
        $garageId = $request->getBody()['garage_id'];
        $services = $this->getServicesByGarage($garageId);

        $options = '<option value="">Select Service</option>';
        foreach ($services as $id => $name) {
            $options .= "<option value=\"{$id}\">{$name}</option>";
        }

        return $options;
    }

    private function getServicesByGarage($garageId)
    {
        $sql = "SELECT id, type FROM gg_garage_service WHERE garage_id = :garage_id AND status_id = 1";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $garageId);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    // end of the newAppointment page in the customer section

}
