<?php

namespace app\controllers;

use app\models\LoginFormGarage;
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

    public function profile()
    {

        return $this->render('profile');
    }

    public function customer()
    {
        return $this->render('customer/customer', [
            'title' => 'Customer Dashboard'
        ]);
    }
    public function customerAppointment()
    {
        return $this->render('customer/appointment/myAppointment', [
            'title' => 'Customer Dashboard'
        ]);
    }



    // public function appointment()
    // {
    //     return Application::$app->view->renderView('customer/appointment', [
    //         'title' => 'Customer Appointment'
    //     ]);
    // }

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
        return $this->render('customer/appointment/newAppointment', ['name' => 'The GearGuard']);
    }

    public function addVehicle(Request $request, Response $response)
    {
        return $this->render('customer/vehicle/addNew', ['name' => 'The GearGuard']);
    }
}
