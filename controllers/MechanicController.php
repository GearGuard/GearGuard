<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\MechanicService;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\Response;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use app\models\LoginFormMechanic;
use app\models\Mechanic;
use app\utilities\EscapeAttributes;

class MechanicController extends Controller
{
    public static function isMechanic() : bool {
        if (Application::$app->user instanceof Mechanic && Application::$app->session->get('isMechanic')) {
            return true;
        }

        return false;
    }
    public function __construct()
    {
        $this->registerMiddleware(new ExtendedMiddleware([], self::isMechanic()));
       
    }

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

    // public function mechanicSparePart(Request $request, Response $response)
    // {
    //     if (Application::$app->user instanceof User) {
    //         return $this->render('/mechanic/spareparts', [
    //             'title' => 'Spareparts'
    //         ]);
    //     } else if (Application::$app->user instanceof Garage) {
    //         return $this->render('/mechanic/spareparts', [
    //             'title' => 'Spareparts'
    //         ]);
    //     }

    //     throw new NotFoundException();
    // }

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
}