<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\GarageService;
use app\models\Mechanic;
use app\models\Notification;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\Model;
use gearguard\phpmvc\Response;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use app\models\Garage;
use app\utilities\EscapeAttributes;
use Ratchet\App;

class GarageController extends Controller
{
    public static function isGarage(): bool
    {
        if (Application::$app->user instanceof Garage && Application::$app->session->get('isGarage')) {
            return true;
        }

        return false;
    }
    public function __construct()
    {
        $this->registerMiddleware(new ExtendedMiddleware([], self::isGarage()));
        $this->setLayout('garage_layout');
    }

    public function viewServices(Request $request, Response $response)
    {
        return $this->render('garage/services/viewAll', [
            'name' => 'The GearGuard',
        ]);
    }

    public function getServices(Request $request, Response $response)
    {
        $body = $request->getBody();
        $page = $body['page'] ?? 1;
        if(!is_numeric($page)) throw new NotFoundException();
        header('Content-Type: application/json; charset=utf-8');
        return json_encode(Application::$app->user->getServices((int)$page));
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
            $model = new Mechanic();
            return $this->render('garage/mechanic/manage', [
                'name' => 'The GearGuard',
                'model' => $model,
            ]);
        }

        throw new NotFoundException();
    }

    public function getAppointments(Request $request, Response $response)
    {
        $body = $request->getBody();
        $page = $body['page'] ?? 1;
        if(!is_numeric($page)) throw new NotFoundException();
        header('Content-Type: application/json; charset=utf-8');
        return json_encode(Application::$app->user->getAllAppointments((int)$page));
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
            if (!isset($body['type']) || !isset($body['price']) || !isset($body['duration']) || !isset($body['description']))
                throw new NotFoundException();

            $model = GarageService::initialize(
                $body['type'],
                (is_numeric($body['price'])) ? $body['price'] : -1,
                (is_numeric($body['duration'])) ? $body['duration'] : -1,
                $body['description']
            );
            try {
                $model->save();
            } catch (\Exception $ex) {
                return $this->render('garage/services/newService', [
                    'name' => 'The GearGuard',
                    'error' => array_values($model->errors)[0][0] ?? '',
                    'model' => $model,
                    'garage_id' => Application::$app->session->get('user'),
                ]);
            }
            return $this->render('garage/services/viewAll', [
                'name' => 'The GearGuard',
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

    public function getService(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            if (!isset($body['searchQuery'])) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(null);
                return;
            }
            $data = Application::$app->user->getServiceByType($body['searchQuery']);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
    }

    public function updateService(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            if (!isset($body['id']) || !isset($body['type']) || !isset($body['price']) || !isset($body['duration']) || !isset($body['description']))
                throw new NotFoundException();
            $id = $body['id'];
            $type = ($body['type']);
            $price = ($body['price']);
            $duration = ($body['duration']);
            $description = ($body['description']);

            if (!is_numeric($id) || !is_numeric($duration) || !is_numeric($price))
                throw new NotFoundException();

            $toUpdate = [
                'type' => $type,
                'price' => $price,
                'duration' => $duration,
                'description' => $description
            ];
            $model = Application::$app->user->getServiceByID((int)$id);
            try {
                $model->update($toUpdate);
            } catch (\Exception $ex) {
                return $this->render('garage/services/editService', [
                    'name' => 'The GearGuard',
                    'error' => array_values($model->errors)[0][0] ?? '',
                    'model' => new GarageService(),
                    'garage_id' => Application::$app->session->get('user'),
                ]);
            }

            return $this->render('garage/services/viewAll', [
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

    public function markServiceDeleted(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            $id = $body['serviceID'] ?? '';
            if (!is_numeric($id))
                throw new NotFoundException();
            $toUpdate = [
                'status_id' => GarageService::STATUS_DELETED
            ];
            Application::$app->user->getServiceByID((int) $id)->update($toUpdate, true);

            header('Content-Type: application/json;');

            echo json_encode([
                'success' => true,
                'message' => 'Service deleted successfully',
            ]);
        }

        throw new NotFoundException();
    }

    public function addMechanic(Request $request, Response $response)
    {
        $model = new Mechanic();
        $servicesModel = new class extends Model {
            public $services = [];

            public function rules(): array
            {
                return [];
            }

            public function labels(): array
            {
                return [
                    'services' => 'Services',
                ];
            }
        };
        return $this->render('garage/mechanic/add', [
            'name' => 'The GearGuard',
            'model' => $model,
            'servicesModel' => $servicesModel,
            'serviceOptions' => Application::$app->user->getAllGarageServiceTypesForDropDown(),
        ]);
    }

    public function addMechanicPost(Request $request, Response $response)
    {
        $model =  new Mechanic();
        $model->loadData($body = $request->getBody());
        $model->password = ".";
        $model->garage_id = Application::$app->user->id?: Application::$app->session->get('user');
        $model->status_id = Mechanic::STATUS_ACTIVE;

        if (isset($request->getBody()['services'])) {
            $services = json_decode(($request->getBody())['services']);
            $servicesAllowed = Application::$app->user->getAllGarageServiceTypesForDropDown();
            $servicesNumeric = [];

            foreach ($servicesAllowed as $key => $value) {
                $servicesNumeric[] = (int)$key;
            }

            foreach ($services as $service) {
                if (is_numeric($service)) {
                    if (in_array($service, $servicesNumeric)) {
                        $model->mechanicServices[] = (int)$service;
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Invalid service type',
                        ]);
                        return;
                    }
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Invalid service type',
                    ]);
                    return;
                }
            }
        }

        if ($model->validate(validatePassword: false, useFrameworkValidations: false) && $model->save()) {
            echo json_encode([
                'success' => true,
                'message' => 'Mechanic added successfully',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => array_values($model->errors)[0][0] ?? '',
            ]);
        }
    }

    public function filteredAppointments(Request $request, Response $response)
    {
        $body = $request->getBody();
        $firstname = (isset($body['firstname']) ? '%'.($body['firstname']).'%' : '%');
        $lastname = (isset($body['lastname']) ? '%'.($body['lastname']).'%' : '%');
        $numberplate = (isset($body['numberplate']) ? '%'.($body['numberplate']).'%' : '%');
        $contact = (isset($body['contact']) ? '%'.($body['contact']).'%' : '%');
        $date = ((isset($body['date']) && !$body['date'] == '') ? ($body['date']) : date("Y-m-d"));
        $condition = ((isset($body['condition'])  && !$body['condition'] == '') ? ($body['condition']) : 'on or before');
        $status = ((isset($body['status'])  && !$body['status'] == '') ? ($body['status']) : 'pending');
        $page = $body['page'] ?? 1;
        if(!is_numeric($page)) throw new NotFoundException();
        header('Content-Type: application/json; charset=utf-8');
        return json_encode(Application::$app->user->getAllAppointmentsFiltered($firstname, $lastname, $numberplate, $contact, $date, $condition, $status, (int)$page));
    }

    public function getCustomers(Request $request, Response $response)
    {
        $body = $request->getBody();
        $page = $body['page'] ?? 1;
        if(!is_numeric($page)) throw new NotFoundException();
        $firstname = (isset($body['firstname']) ? '%'.($body['firstname']).'%' : '%');
        $lastname = (isset($body['lastname']) ? '%'.($body['lastname']).'%' : '%');
        $email = (isset($body['email']) ? '%'.($body['email']).'%' : '%');
        header('Content-Type: application/json; charset=utf-8');
        if (isset($body['firstname']) || isset($body['lastname']) || isset($body['email'])) {
            return json_encode(Application::$app->user->getCustomersFiltered($firstname, $lastname, $email, (int)$page));
        }
        return json_encode(Application::$app->user->getAllCustomerDetails((int)$page));
    }

    public function getCustomerVehicles(Request $request, Response $response)
    {
        $body = $request->getBody();
        $customerID = $body['customerID'] ?? '';
        if (!is_numeric($customerID)) throw new NotFoundException();
        header('Content-Type: application/json; charset=utf-8');
        return json_encode(Application::$app->user->getCustomerVehicleDetails((int)$customerID));
    }
}
