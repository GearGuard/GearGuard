<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\GarageService;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\Response;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use app\models\Garage;

class GarageController extends Controller
{
    public static function isGarage() : bool {
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
        $page = htmlspecialchars($page);
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
            return $this->render('garage/mechanic/manage', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function getAppointments(Request $request, Response $response)
    {
        $body = $request->getBody();
        $page = $body['page'] ?? 1;
        if(!is_numeric($page)) throw new NotFoundException();
        $page = htmlspecialchars($page);
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
            if (!isset($_GET['searchQuery']))
                echo '';
            $data = Application::$app->user->getServiceByType(htmlspecialchars($_GET['searchQuery']));
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
            $id = htmlspecialchars($body['id']);

            $type = htmlspecialchars($body['type']);
            $price = htmlspecialchars($body['price']);
            $duration = htmlspecialchars($body['duration']);
            $description = htmlspecialchars($body['description']);

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

    public function markServiceDeleted(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            $id = $body['serviceID'] ?? '';
            if (!is_numeric($id))
                throw new NotFoundException();
            $id = htmlspecialchars($id);
            $toUpdate = [
                'status_id' => GarageService::STATUS_DELETED
            ];
            Application::$app->user->getServiceByID((int) $id)->update($toUpdate, true);

            return $this->render('garage/services/viewAll', [
                'name' => 'The GearGuard',
            ]);
        }

        throw new NotFoundException();
    }

    public function filteredAppointments(Request $request, Response $response)
    {
        $body = $request->getBody();
        $firstname = htmlspecialchars(isset($body['firstname']) ? '%'.htmlspecialchars($body['firstname']).'%' : '%');
        $lastname = htmlspecialchars(isset($body['lastname']) ? '%'.htmlspecialchars($body['lastname']).'%' : '%');
        $numberplate = htmlspecialchars(isset($body['numberplate']) ? '%'.htmlspecialchars($body['numberplate']).'%' : '%');
        $contact = htmlspecialchars(isset($body['contact']) ? '%'.htmlspecialchars($body['contact']).'%' : '%');
        $date = htmlspecialchars((isset($body['date']) && !$body['date'] == '') ? htmlspecialchars($body['date']) : date("Y-m-d"));
        $condition = htmlspecialchars((isset($body['condition'])  && !$body['condition'] == '') ? htmlspecialchars($body['condition']) : 'on or before');
        $status = htmlspecialchars((isset($body['status'])  && !$body['status'] == '') ? htmlspecialchars($body['status']) : 'pending');
        $page = $body['page'] ?? 1;
        if(!is_numeric($page)) throw new NotFoundException();
        $page = htmlspecialchars($page);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode(Application::$app->user->getAllAppointmentsFiltered($firstname, $lastname, $numberplate, $contact, $date, $condition, $status, (int)$page));
    }

    public function getCustomers(Request $request, Response $response)
    {
        $body = $request->getBody();
        $page = $body['page'] ?? 1;
        if(!is_numeric($page)) throw new NotFoundException();
        $page = htmlspecialchars($page);
        $firstname = htmlspecialchars(isset($body['firstname']) ? '%'.htmlspecialchars($body['firstname']).'%' : '%');
        $lastname = htmlspecialchars(isset($body['lastname']) ? '%'.htmlspecialchars($body['lastname']).'%' : '%');
        $email = htmlspecialchars(isset($body['email']) ? '%'.htmlspecialchars($body['email']).'%' : '%');
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
        $customerID = htmlspecialchars($customerID);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode(Application::$app->user->getCustomerVehicleDetails((int)$customerID));
    }

}