<?php

namespace app\controllers;

use app\models\GarageService;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\Response;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use app\models\Garage;
use http\Exception\InvalidArgumentException;

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
        if (Application::$app->user instanceof Garage) {
            return $this->render('garage/services/viewAll', [
                'name' => 'The GearGuard',
                'services' => Application::$app->user->getServices(),
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
                'services' => Application::$app->user->getServices(),
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
                throw new InvalidArgumentException();
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
                'services' => Application::$app->user->getServices(),
            ]);
        }

        throw new NotFoundException();
    }

    public function markServiceDeleted(Request $request, Response $response)
    {
        if (Application::$app->user instanceof Garage) {
            $body = $request->getBody();
            $id = $body['serviceID'] ?? '';
            if (is_int($id))
                throw new InvalidArgumentException();
            $id = htmlspecialchars($id);
            $toUpdate = [
                'status_id' => 3
            ];
            Application::$app->user->getServiceByID((int) $id)->update($toUpdate);

            return $this->render('garage/services/viewAll', [
                'name' => 'The GearGuard',
                'services' => Application::$app->user->getServices(),
            ]);
        }

        throw new NotFoundException();
    }

}