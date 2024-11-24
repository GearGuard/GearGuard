<?php

namespace app\controllers;

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
        return $this->render('customer');
    }

    public function appointment()
    {
        return Application::$app->view->renderView('customer/appointment', [
            'title' => 'Customer Appointment'
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
            return $this->render('register', [
                'model' => $garage
            ]);
        }
        $this->setLayout('auth');
        return $this->render('garage/signup', [
            'model' => $garage
        ]);
    }
}
