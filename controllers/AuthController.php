<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\GarageService;
use app\models\LoginFormGarage;
use app\models\VehicleOwner;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
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

    public function myProfile(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            return $this->render('customer/profile/myProfile', [
                'title' => 'My Profile'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            return $this->render('garage/profile', [
                'title' => 'Profile'
            ]);
        }

        throw new NotFoundException();
    }

    public function customer(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            return $this->render('customer/customer', [
                'title' => 'Customer Dashboard'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            return $this->render('garage/garage', [
                'title' => 'Garage Dashboard'
            ]);
        }
        throw new NotFoundException();
    }

    public function dashboard(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            return $this->render('customer/dashboard', [
                'title' => 'Customer Dashboard'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            return $this->render('garage/dashboard', [
                'title' => 'Garage Dashboard'
            ]);
        }
        throw new NotFoundException();
    }

    public function settings(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            return $this->render('customer/setting', [
                'title' => 'Settings'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            return $this->render('garage/setting', [
                'title' => 'Settings'
            ]);
        }

        throw new NotFoundException();
    }

    public function newSparepart(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            return $this->render('customer/sparepart/newPart', [
                'title' => 'Add Sparepart'
            ]);
        }

        throw new NotFoundException();
    }

    public function viewSparepart(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            return $this->render('customer/sparepart/viewPart', [
                'title' => 'View Spareparts'
            ]);
        }

        throw new NotFoundException();
    }

    public function garageSignup(Request $request, Response $response)
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
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function newAppointments(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            // TODO: Check for assigned vehicles
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

        throw new NotFoundException();
    }

    public function appointments(Request $request, Response $response)
    {
        // TODO: Check for vehicles
        if (Application::$app->user instanceof User) {
            return $this->render('customer/appointment/myAppointment', ['name' => 'The GearGuard']);
        } else if (Application::$app->user instanceof Garage) {
            return $this->render('garage/appointment/all', ['name' => 'The GearGuard']);
        }

        throw new NotFoundException();
    }

    public function serviceHistory(Request $request, Response $response)
    {
        // TODO: Check for vehicles
        if (Application::$app->user instanceof User) {
            return $this->render('customer/appointment/serviceHistory', ['name' => 'The GearGuard']);
        }

        throw new NotFoundException();
    }

    public function sparepartsWarranty(Request $request, Response $response)
    {
        // TODO: Complete
        if (Application::$app->user instanceof User) {
            return $this->render('customer/appointment/warrenty', ['name' => 'The GearGuard']);
        }

        throw new NotFoundException();
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
        // TODO: Complete
        if (Application::$app->user instanceof User) {
            return $this->render('customer/vehicle/addNew', ['name' => 'The GearGuard']);
        }

        throw new NotFoundException();
    }

    public function transferVehicle(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User)
            if ((Application::$app->user->isVehicleOwner() ?? false) && Application::$app->user->getOwnedVehiclesList()) {
                return $this->render('customer/vehicleTransfer/transferForm', [
                    'name' => 'The GearGuard',
                ]);
            } else {
                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
            }

        throw new NotFoundException();
    }

    public function transferInstructions(Request $request, Response $response)
    {
        return $this->render('customer/vehicleTransfer/instruction', [
            'name' => 'The GearGuard',
        ]);
    }

    private function getGarages()
    {
        $sql = "SELECT id, name FROM gg_garage WHERE status_id = 2"; // Assuming 2 is the status for active garages
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function getServices(Request $request, Response $response)
    {
        $garageId = $request->getBody()['garage_id'];
        $services = $this->getServicesByGarage();

        $options = '<option value="">Select Service</option>';
        foreach ($services as $id => $name) {
            $options .= "<option value=\"{$id}\">{$name}</option>";
        }

        return $options;
    }

    private function getServicesByGarage(): array
    {
        $sql = "SELECT * FROM gg_garage_service WHERE garage_id = :garage_id";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', Application::$app->session->get('user'));
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    // end of the newAppointment page in the customer section

    public function viewServices(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            return $this->render('garage/services/viewAll', [
                'name' => 'The GearGuard',
                'services' => $this->getServicesByGarage()
            ]);
        }

        throw new NotFoundException();
    }

    public function viewCustomers(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            return $this->render('garage/customer/allCustomers', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function manageMechanic(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            return $this->render('garage/mechanic/manage', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function searchAppointments(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            return $this->render('garage/appointment/search', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function deleteAppointment(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            return $this->render('garage/appointment/delete', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function addServices(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $model = new GarageService();
            return $this->render('garage/services/newService', [
                'name' => 'The GearGuard',
                'garage_id' => Application::$app->session->get('user'),
                'model' => $model
            ]);
        }

        throw new NotFoundException();
    }

    public function editServices(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $model = new GarageService();
            return $this->render('garage/services/editService', [
                'name' => 'The GearGuard',
                'garage_id' => Application::$app->session->get('user'),
                'model' => $model
            ]);
        }

        throw new NotFoundException();
    }

    public function deleteServices(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            return $this->render('garage/services/deleteService', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function sendMessages(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            return $this->render('garage/customer/sendMessages', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function searchCustomer(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            return $this->render('garage/customer/searchCustomers', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function newPost(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User || Application::$app->user instanceof Garage) {
            return $this->render('community/newPost', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function viewPosts(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User || Application::$app->user instanceof Garage) {
            return $this->render('community/myPosts', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function viewAllVehicle(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User)
            if ((Application::$app->user->isVehicleOwner() ?? false) && Application::$app->user->getOwnedVehiclesList()) {
                return $this->render('customer/vehicle/viewAll', [
                    'name' => 'The GearGuard',
                ]);
            } else {
                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
            }

        throw new NotFoundException();
    }

    public function vehicleServiceHistory(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User)
            if ((Application::$app->user->isVehicleOwner() ?? false) && Application::$app->user->getOwnedVehiclesList()) {
                return $this->render('customer/vehicle/serviceHistory', [
                    'name' => 'The GearGuard',
                ]);
            } else {
                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
            }

        throw new NotFoundException();
    }
}
