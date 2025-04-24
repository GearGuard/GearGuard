<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\GarageService;
use app\models\LoginFormGarage;
use app\models\LoginFormMechanic;
use app\models\VehicleOwner;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\Request;
use app\models\User;
use app\models\Garage;
use app\models\Mechanic;
use app\models\MechanicService;
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
            return $this->render('customer/my_Profile', [
                'title' => 'My Profile'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            return $this->render('garage/profile', [
                'title' => 'Profile'
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
            return $this->render('customer/customer', [
                'title' => 'Customer Dashboard'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            return $this->render('garage/garage', [
                'title' => 'Garage Dashboard'
            ]);
        } else if (Application::$app->user instanceof Mechanic) {
            return $this->render('mechanic/mechanic', [
                'title' => 'Mechanic Dashboard'
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
            }
            else
                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
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

    private function getServicesByGarage($garage_id = 0): array
    {
        if ($garage_id === 0) {
            $garage_id = Application::$app->session->get('user');
        }

        $sql = "SELECT * FROM gg_garage_service WHERE garage_id = :garage_id AND status_id = 2";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $garage_id);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getServicesByGarageForDropDown($garage_id = 0): array
    {
        if ($garage_id === 0) {
            $garage_id = Application::$app->session->get('user');
        }

        $sql = "SELECT id, type FROM gg_garage_service WHERE garage_id = :garage_id AND status_id = 2";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $garage_id);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
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

    public function addServicesPost(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            $model = GarageService::initialize(
                $body['type'],
                $body['price'],
                $body['duration'],
                $body['description']
            );
            $model->save();
            return $this->render('garage/services/viewAll', [
                'name' => 'The GearGuard',
                'services' => $this->getServicesByGarage()
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
            if (Application::$app->user->getOwnedVehiclesList() || Application::$app->user->getAccessAvailableVehiclesList()) {
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
            if (Application::$app->user->getOwnedVehiclesList() || Application::$app->user->getAccessAvailableVehiclesList()) {
                return $this->render('customer/vehicle/serviceHistory', [
                    'name' => 'The GearGuard',
                ]);
            } else {
                return $this->render('customer/noVehicles', ['name' => 'The GearGuard']);
            }

        throw new NotFoundException();
    }

    public function getService(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $data = Application::$app->user->getServiceByType(htmlspecialchars($_GET['searchQuery']));
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
    }

    public function updateService(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            $id = htmlspecialchars($body['id']);
            $type = htmlspecialchars($body['type']);
            $price = htmlspecialchars($body['price']);
            $duration = htmlspecialchars($body['duration']);
            $description = htmlspecialchars($body['description']);
            $toUpdate = [
                'type' => $type,
                'price' => $price,
                'duration' => $duration,
                'description' => $description
            ];
            Application::$app->user->getServiceByID((int) $id)->update($toUpdate);

            return $this->render('garage/services/viewAll', [
                'name' => 'The GearGuard',
                'services' => $this->getServicesByGarage()
            ]);
        }

        throw new NotFoundException();
    }

    public function markServiceDeleted(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            $id = htmlspecialchars($body['serviceID']);
            $toUpdate = [
                'status_id' => 3
            ];
            Application::$app->user->getServiceByID((int) $id)->update($toUpdate);

            return $this->render('garage/services/viewAll', [
                'name' => 'The GearGuard',
                'services' => $this->getServicesByGarage()
            ]);
        }

        throw new NotFoundException();
    }

    public function newAppointmentsPost(Request $request, Response $response)
    {
        if (Application::$app->user instanceof User) {
            $body = $request->getBody();
            $model = Appointment::initialize(
                $body['service_id'],
                $body['vehicle_id'],
                $body['date'],
                $body['time'],
                $body['notes']
            );
            $model->save();
            return $this->render('customer/appointment/myAppointment', [
                'name' => 'The GearGuard',

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
        if (Application::$app->user instanceof User) {
            return $this->render('/mechanic/service_history', [
                'title' => 'Service History'
            ]);
        } else if (Application::$app->user instanceof Garage) {
            return $this->render('/mechanic/service_history', [
                'title' => 'Service History'
            ]);
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

   
}
