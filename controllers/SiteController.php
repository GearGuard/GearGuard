<?php

namespace app\controllers;

use Couchbase\RequestSpan;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\View;
use gearguard\phpmvc\Response;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => "The GearGurd"
        ];
        return $this->render('home', $params);
    }
    public function common()
    {
        $params = [
            'name' => "The GearGurd"
        ];
        return $this->render('common', $params);
    }


    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();
        if ($request->isPost()) {
            $contact->loadData($request->getBody());
            if ($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash('success', 'Thanks for contacting us.');
                return $response->redirect('/contact');
            }
        }
        return $this->render('contact', [
            'model' => $contact
        ]);
    }

    public function navbar_customer(Request $request, Response $response){
        return $this->render('navbar_customer', ['name' => 'The GearGuard']);
    }

    public function newAppointments(Request $request, Response $response){
        return $this->render('customer/appointment/newAppointment', ['name' => 'The GearGuard']);
    }

    public function addVehicle(Request $request, Response $response){
        return $this->render('customer/vehicle/addNew', ['name' => 'The GearGuard']);
    }

    public function community(Request $request, Response $response){
        return $this->render('community/allPosts', ['name' => 'The GearGuard']);
    }
}
