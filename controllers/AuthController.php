<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\GarageAppointment;
use app\models\GarageService;
use app\models\LoginFormGarage;
use app\models\Notification;
use app\models\Vehicle;
use app\models\VehicleOwner;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\Request;
use app\models\User;
use app\models\Garage;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Response;
use app\models\LoginForm;
use gearguard\phpmvc\middlewares\AuthMiddleware;

class AuthController extends Controller
{
    // public string $layout = 'customer'; 
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['dashboard']));
        $this->registerMiddleware(new AuthMiddleware(['myProfile']));
        $this->registerMiddleware(new AuthMiddleware(['settings']));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $data = array_map(function ($value) {
                return $value;
            }, $request->getBody());
            $loginForm->loadData($data);
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
            $data = $request->getBody();
            $user->loadData($data);

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

    public function garageSignup(Request $request, Response $response)
    {
        $errors = [];
        $garage = new Garage();
        if ($request->isPost()) {
            $data = $request->getBody();
            $garage->loadData($data);


            if ($garage->validate() && $garage->save()) {
                Application::$app->session->setFlash('success', 'Thanks for Registering');
                Application::$app->response->redirect('/');
                exit;
            }
            $this->setLayout('auth');
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
            $data = $request->getBody();

            $loginForm->loadData($data);
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

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function myProfile(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            return $this->render('customer/my_Profile', [
                'title' => 'My Profile'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            $this->setLayout('garage_layout');
            $model = Garage::with(Application::$app->user);
            return $this->render('garage/profile', [
                'title' => 'Profile',
                'model' => $model,
            ]);
        }

        throw new NotFoundException();
    }

    public function customer(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            if (Application::$app->user->isAdmin()) {
                $this->setLayout('admin_layout');
                return $this->render('admin/admin', [
                    'title' => 'Admin Dashboard'
                ]);
            }
            return $this->render('customer/customer', [
                'title' => 'Customer Dashboard'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            $this->setLayout('garage_layout');
            return $this->render('garage/garage', [
                'title' => 'Garage Dashboard'
            ]);
        }
        throw new NotFoundException();
    }

    public function dashboard(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            if (Application::$app->user->isAdmin()) {
                $this->setLayout('admin_layout');
                return $this->render('admin/dashboard', [
                    'title' => 'Admin Dashboard'
                ]);
            }
            return $this->render('customer/dashboard', [
                'title' => 'Customer Dashboard'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            $this->setLayout('garage_layout');
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
            $this->setLayout('garage_layout');
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

    public function newAppointments(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            if (Application::$app->user->getOwnedVehiclesList() || Application::$app->user->getAccessAvailableVehiclesList()) {
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

    public function getGarageServices(Request $request)
    {
        $body = $request->getBody();
        if (!isset($body['garage_id'])) {
            throw new NotFoundException();
        }
        $garageId = $request->getBody()['garage_id'];
        $services = $this->getServicesByGarageForDropdown($garageId);

        $options = '<option value="">Select Service</option>';
        foreach ($services as $id => $name) {
            $options .= "<option value=\"{$id}\">{$name}</option>";
        }

        return $options;
    }

    public function appointments(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            if (Application::$app->user->getOwnedVehiclesList() || Application::$app->user->getAccessAvailableVehiclesList()) {
                $model = Application::$app->user->getAppointmentsList();
                return $this->render('customer/appointment/myAppointment', [
                    'name' => 'The GearGuard',
                    'appointments' => $model,
                ]);
            } else
                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
        } else if (Application::$app->user instanceof Garage) {
            $this->setLayout('garage_layout');
            return $this->render('garage/appointment/all', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function updateAppointmentStatus(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            $appointmentID = $body['appointment_id'] ?? '';
            $status = $body['status_id'] ?? '';
            if (!is_numeric($appointmentID) || !is_numeric($status))
                throw new NotFoundException();

            $model = Application::$app->user->getAppointmentByID((int) $appointmentID);

            if (!$model) {
                throw new NotFoundException();
            }

            $model->update(
                ['status_id' => $status],
                true
            );

            $vehicleDetails = Vehicle::getVehicleDetails($model->vehicle_id);

            if ($status == 3) {
                $description = 'Your appointment for ' . $vehicleDetails['license_plate_no'] .  ' has been cancelled by the garage ' . GarageService::getGarageOfService($model->service_id) ?? 'NO-NAME'  . '.';
                Notification::sendNotification(
                    $vehicleDetails['vehicle_user'],
                    $description,
                    'Appointment Cancelled'
                );
            } elseif ($status == 2) {
                $description = 'Your appointment for ' . $vehicleDetails['license_plate_no'] .  ' has been confirmed by the garage ' . GarageService::getGarageOfService($model->service_id) ?? 'NO-NAME'  . '.';
                Notification::sendNotification(
                    $vehicleDetails['vehicle_user'],
                    $description,
                    'Appointment Confirmed'
                );
            }

            return 'success';
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

        if ($vehicles) {
            foreach ($vehicles as $vehicle) {
                $vehicles_list[$vehicle['id']] = $vehicle['license_plate_no'];
            }
        }

        $vehicles = Application::$app->user->getAccessAvailableVehiclesList();

        if ($vehicles) {
            foreach ($vehicles as $vehicle) {
                $vehicles_list[$vehicle['id']] = $vehicle['license_plate_no'];
            }
        }

        return $vehicles_list;
    }

    public function addVehicle(Request $request, Response $response)
    {
        if (!(Application::$app->user instanceof User)) {
            throw new NotFoundException();
        }

        // Create a new Vehicle model instance
        $model = new Vehicle();

    

        return $this->render('customer/vehicle/addNew', [
            'name' => 'The GearGuard',
            'model' => $model
        ]);
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
        $sql = "SELECT id, name FROM gg_garage WHERE status_id = 2";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    private function getServicesByGarageForDropDown($garage_id = 0): array
    {
        if ($garage_id == 0) {
            return [];
        }

        $sql = "SELECT id, type FROM gg_garage_service WHERE garage_id = :garage_id AND status_id = 2";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $garage_id);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    // end of the newAppointment page in the customer section

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

    //    public function viewAllVehicle(Request $request, Response $response)
    //    {
    //        if (Application::$app->user instanceof User)
    //            if (Application::$app->user->getOwnedVehiclesList() || Application::$app->user->getAccessAvailableVehiclesList()) {
    //                return $this->render('customer/vehicle/viewAll', [
    //                    'name' => 'The GearGuard',
    //                ]);
    //            } else {
    //                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
    //            }
    //
    //        throw new NotFoundException();
    //    }

    public function vehicleServiceHistory(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User)
            if (Application::$app->user->getOwnedVehiclesList() || Application::$app->user->getAccessAvailableVehiclesList()) {
                return $this->render('customer/vehicle/serviceHistory', [
                    'name' => 'The GearGuard',
                ]);
            } else {
                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
            }

        throw new NotFoundException();
    }

    public function newAppointmentsPost(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            $body = $request->getBody();
            $service_id = $body['service_id'] ?? '';
            $vehicle_id = $body['vehicle_id'] ?? '';
            $date = $body['date'] ?? '';
            $time = $body['time'] ?? '';
            $notes = $body['notes'] ?? '';
            $model = Appointment::initialize(
                ($service_id),
                ($vehicle_id),
                ($date),
                ($time),
                ($notes)
            );
            $model->save();
            return $this->render('customer/appointment/myAppointment', [
                'name' => 'The GearGuard',

            ]);
        }
        throw new NotFoundException();
    }
}
