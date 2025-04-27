<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\GarageAppointment;
use app\models\GarageService;
use app\models\LoginFormGarage;
use app\models\Notification;
use app\models\Vehicle;
use app\models\LoginFormMechanic;
use app\models\VehicleOwner;
use app\models\SparePart;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\Request;
use app\models\User;
use app\models\Garage;
use app\models\Mechanic;
use app\models\MechanicService;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Response;
use app\models\LoginForm;
use gearguard\phpmvc\middlewares\AuthMiddleware;
use Ratchet\App;

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
        } else if (Application::$app->user instanceof Mechanic) {
            $mechanic = Application::$app->user;
            return $this->render('mechanic/profile', [
                'title' => 'Profile',
                'mechanic' => $mechanic
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
        } else if (Application::$app->user instanceof Mechanic) {
            $this->setLayout('garage_layout');
            return $this->render('mechanic/mechanic', [
                'title' => 'Mechanic Dashboard'
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
        } else if (Application::$app->user instanceof Mechanic) {
            $mechanic = Application::$app->user;
            return $this->render('mechanic/dashboard', [
                'title' => 'Mechanic Dashboard',
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
        } else if (Application::$app->user instanceof Mechanic) {
            return $this->render('mechanic/setting', [
                'title' => 'Settings'
            ]);
        }

        throw new NotFoundException();
    }

    public function newSparePart(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            if (Application::$app->user->getOwnedVehiclesList() || Application::$app->user->getAccessAvailableVehiclesList()) {
                $model = new SparePart();


                $vehicles_list = $this->getVehiclesListForDropDown();

                return $this->render('customer/sparepart/newPart', [
                    'model' => $model,
                    'title' => 'Add Spare Part',
                    'vehicles' => $vehicles_list,
                ]);
            } else {
                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
            }
        }

        throw new NotFoundException();
    }


    public function viewSparepart(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            if (Application::$app->user->getOwnedVehiclesList() || Application::$app->user->getAccessAvailableVehiclesList()) {
                return $this->render('customer/sparepart/viewPart', [
                    'title' => 'View Sparepart'
                ]);
            } else {
                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
            }
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
            $garage_id = $body['garage_id'] ?? '';
            $model = Appointment::initialize(
                ($service_id),
                ($vehicle_id),
                ($date),
                ($time),
                ($notes),
                $garage_id
            );
            if ($model->validate() && $model->save()) {
                return $this->render('customer/appointment/myAppointment', [
                    'name' => 'The GearGuard',

                ]);
            }

            return $this->render('customer/appointment/newAppointment', [
                'name' => 'The GearGuard',
                'model' => $model,
            ]);
        }
        throw new NotFoundException();
    }

    public function addVehiclePost(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            $body = $request->getBody();
            $model = new Vehicle();
            $model->loadData($body);
            $model->year_manufactured = $body['year_manufactured'] . '-01-01';
            if ($model->validate() && $model->save()) {
                // Application::$app->session->setFlash('success', 'Vehicle added successfully');
                Application::$app->response->redirect('/customer/vehicle/all');
                return;
            }
            return $this->render('customer/vehicle/addNew', [
                'name' => 'The GearGuard',
                'model' => $model
            ]);
        }
        throw new NotFoundException();
    }

    //mechanic
   
    public function mechanicSignup(Request $request, Response $response)
    {
        $errors = [];
        $mechanic = new Mechanic();
        if ($request->isPost()) {
            $mechanic->loadData($request->getBody());


            if ($mechanic->validate() && $mechanic->save()) {
                Application::$app->session->setFlash('success', 'Thanks for Registering');
                Application::$app->response->redirect('/');
                exit;
            }
            return $this->render('mechanic/signup', [
                'model' => $mechanic
            ]);
        }
        $this->setLayout('auth');
        return $this->render('mechanic/signup', [
            'model' => $mechanic
        ]);
    }

    public function mechanicLogin(Request $request, Response $response)
    {
        $loginForm = new LoginFormMechanic();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->session->set('isMechanic', true);
                Application::$app->response->redirect('/');
                return;
            }
        }

        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function mechanicAddServices(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            $model = new MechanicService();
            return $this->render('mechanic/services/addService', [
                'name' => 'The GearGuard',
                'garage_id' => Application::$app->session->get('user'),
                'model' => $model
            ]);
        }

        throw new NotFoundException();
    }

    public function assignMechanicService(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            $message = '';
            if ($request->isPost()) {
                $service_id = $request->getBody()['service_id'] ?? null;
                $mechanic_id = $request->getBody()['mechanic_id'] ?? null;

                if (!$service_id || !$mechanic_id) {
                    $message = "Service ID and Mechanic ID are required.";
                } else {
                    $model = new MechanicService();
                    $success = $model->assignMechanicToService((int)$service_id, (int)$mechanic_id);
                    if ($success) {
                        $message = "New record inserted successfully!";
                    } else {
                        $message = "Error inserting record.";
                    }
                }
            }
            return $this->render('mechanic/services/addService', [
                'message' => $message
            ]);
        }

        throw new NotFoundException();
    }

    public function MechanicAddServicesPost(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            $body = $request->getBody();
            $model = MechanicService::initialize(
                $body['begin_timestamp'],
                $body['end_timestamp'],
                $body['note']
            );
            $model->save();
            return $this->render('mechanic/services/viewService', [
                'name' => 'The GearGuard',
                'services' => $this->getServicesByGarage()
            ]);
        }

        throw new NotFoundException();
    }

    public function viewServicesByMechanic(Request $request, Response $response)
    {
        $sql = "SELECT vst.id, v.license_plate_no, gs.type AS service_type, 
                       CONCAT(m.first_name, ' ', m.last_name) AS mechanic_name,
                       vst.begin_timestamp, vst.end_timestamp, vst.duration, vst.notes
                FROM gg_vehicle_service_take vst
                JOIN gg_vehicle v ON vst.vehicle_id = v.id
                JOIN gg_garage_service gs ON vst.service_id = gs.id
                JOIN gg_garage_mechanic m ON vst.mechanic_id = m.id
                ORDER BY vst.begin_timestamp DESC";

        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        $serviceAssignments = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $params = [
            'name' => "The GearGurd",
            'serviceAssignments' => $serviceAssignments
        ];
        return $this->render('mechanic/services/viewService', $params);
    }

    public function MechanicEditServices(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            $model = new GarageService();
            return $this->render('mechanic/services/editService', [
                'name' => 'The GearGuard',
                'garage_id' => Application::$app->session->get('user'),
                'model' => $model
            ]);
        }

        throw new NotFoundException();
    }

    public function MechanicDeleteServices(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            return $this->render('mechanic/services/deleteService', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }


    public function mechanicServiceHistory(Request $request, Response $response)
    {
        if (Application::$app->user instanceof \app\models\Mechanic) {
            $sql = "SELECT vst.id, v.license_plate_no, gs.type AS service_type, 
                           CONCAT(m.first_name, ' ', m.last_name) AS mechanic_name,
                           vst.begin_timestamp, vst.end_timestamp, vst.duration, vst.notes
                    FROM gg_vehicle_service_take vst
                    JOIN gg_vehicle v ON vst.vehicle_id = v.id
                    JOIN gg_garage_service gs ON vst.service_id = gs.id
                    JOIN gg_garage_mechanic m ON vst.mechanic_id = m.id
                    ORDER BY vst.begin_timestamp DESC";

            $statement = Application::$app->db->prepare($sql);
            $statement->execute();
            $serviceRecords = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $this->setLayout('garage_layout');
            return $this->render('mechanic/serviceHistory/viewAll', [
                'serviceRecords' => $serviceRecords,
                'title' => 'Vehicle Service Assignments'
            ]);
        }

        throw new NotFoundException();
    }

    public function mechanicServiceHistoryEdit(Request $request, Response $response)
    {
        if (Application::$app->user instanceof \app\models\Mechanic) {
            $this->setLayout('garage_layout');
            return $this->render('mechanic/serviceHistory/edit', [
                'title' => 'Edit Vehicle Service'
            ]);
        }
        throw new NotFoundException();
    }

    public function updateServiceHistory(Request $request, Response $response)
    {
        if (Application::$app->user instanceof \app\models\Mechanic) {
            $body = $request->getBody();
            $id = $body['id'] ?? null;
            $begin_timestamp = $body['begin_timestamp'] ?? null;
            $end_timestamp = $body['end_timestamp'] ?? null;
            $notes = $body['notes'] ?? null;

            if (!$id || !$begin_timestamp || !$end_timestamp) {
                $response->setStatusCode(400);
                return json_encode(['success' => false, 'message' => 'Missing required fields']);
            }

            $sql = "UPDATE gg_vehicle_service_take SET begin_timestamp = :begin_timestamp, end_timestamp = :end_timestamp, notes = :notes WHERE id = :id";
            $statement = Application::$app->db->prepare($sql);
            $statement->bindValue(':begin_timestamp', $begin_timestamp);
            $statement->bindValue(':end_timestamp', $end_timestamp);
            $statement->bindValue(':notes', $notes);
            $statement->bindValue(':id', $id);

            try {
                $statement->execute();
                return json_encode(['success' => true]);
            } catch (\Exception $e) {
                $response->setStatusCode(500);
                return json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        throw new NotFoundException();
    }

    public function mechanicSparePart(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User || Application::$app->user instanceof Mechanic) {
            return $this->render('mechanic/sparepart/addNew', [
                'title' => 'Add Spare Part'
            ]);
        }

        throw new NotFoundException();
    }

    public function mechanicSparePartAddNew(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            return $this->render('mechanic/sparepart/addNew', [
                'title' => 'Add Spare Part'
            ]);
        }

        throw new NotFoundException();
    }

    public function mechanicSparePartAddNewPost(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $part = new \app\models\SparePart();
            $part->loadData($request->getBody());

            if ($part->save()) {
                $response->redirect('/mechanic/sparepart');
                return;
            } else {
                return $this->render('mechanic/sparepart/addNew', [
                    'model' => $part,
                    'errors' => $part->errors ?? []
                ]);
            }
        }
        $response->redirect('/mechanic/sparepart');
    }

    public function mechanicSparePartViewAll(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            $sql = "SELECT * FROM gg_sparepart";
            $statement = Application::$app->db->prepare($sql);
            $statement->execute();
            $spareParts = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $this->render('mechanic/sparepart/viewAll', [
                'name' => 'The GearGuard',
                'spareParts' => $spareParts
            ]);
        }
        throw new NotFoundException();
    }


    public function MechanicSendMessages(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            return $this->render('mechanic/messages', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function updateProfile(Request $request, Response $response)
    {

        $body = $request->getBody();
        try {
            Application::$app->user->update($body);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
            ]);
        } catch (\Exception $ex) {

            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    public function loadServiceAssignments(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            $sql = "SELECT vst.id, v.license_plate_no, gs.type AS service_type, 
                           CONCAT(m.first_name, ' ', m.last_name) AS mechanic_name,
                           vst.begin_timestamp, vst.end_timestamp, vst.duration, vst.notes
                    FROM gg_vehicle_service_take vst
                    JOIN gg_vehicle v ON vst.vehicle_id = v.id
                    JOIN gg_garage_service gs ON vst.service_id = gs.id
                    JOIN gg_garage_mechanic m ON vst.mechanic_id = m.id
                    ORDER BY vst.begin_timestamp DESC";

            $statement = Application::$app->db->prepare($sql);
            $statement->execute();
            $serviceAssignments = $statement->fetchAll(\PDO::FETCH_ASSOC);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($serviceAssignments);
        } else {
            $response->setStatusCode(403);
            echo json_encode(['error' => 'Unauthorized']);
        }
    }

    public function loadAppointments(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Mechanic) {
            $sql = "SELECT a.id, v.type AS vehicle_type, u.name AS client_name, u.contact_number, v.license_plate_no, gs.type AS service_type, 
                           CONCAT(a.date, ' ', a.time) AS date_time, a.notes, a.status
                    FROM gg_appointment a
                    JOIN gg_vehicle v ON a.vehicle_id = v.id
                    JOIN gg_user u ON v.owner_id = u.id
                    JOIN gg_garage_service gs ON a.service_id = gs.id
                    ORDER BY a.date DESC, a.time DESC
                    LIMIT 100";

            $statement = Application::$app->db->prepare($sql);
            $statement->execute();
            $appointments = $statement->fetchAll(\PDO::FETCH_ASSOC);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($appointments);
        } else {
            $response->setStatusCode(403);
            echo json_encode(['error' => 'Unauthorized']);
        }
    }

    public function notifications(Request $request, Response $response) {
        if (Application::$app->user instanceof User || Application::$app->user instanceof Garage) {
            $this->setLayout('garage_layout');
            $notifications = Notification::receiveNotification(Application::$app->user->id);
            return $this->render('notifications', [
                'name' => 'The GearGuard',
                'notifications' => $notifications,
            ]);
        }

        throw new NotFoundException();
    }

    public function markNotificationAsRead(Request $request, Response $response) {
        if (Application::$app->user instanceof User || Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            $notificationId = $body['id'] ?? null;

            if (Notification::readNotification($notificationId, Application::$app->user->id)){
                echo 'success';
                return;
            }
        } else {
            throw new NotFoundException();
        }
    }

    public function markAllNotificationsAsRead(Request $request, Response $response) {
        if (Application::$app->user instanceof User || Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            $userId = Application::$app->user->id;

            if (!isset($body['ids'])) {
                throw new NotFoundException();
            }

            $ids = json_decode($body['ids']);

            if (!$ids) {
                throw new NotFoundException();
            }

            if (Notification::readAllNotifications($ids)) {
                echo 'success';
                return;
            }
        } else {
            throw new NotFoundException();
        }
    }

    public function messages(Request $request, Response $response) {
        if (Application::$app->user instanceof User || Application::$app->user instanceof Garage) {
            $this->setLayout('garage_layout');
            return $this->render('messages', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }
   
}
