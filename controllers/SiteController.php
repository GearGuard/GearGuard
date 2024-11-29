<?php

namespace app\controllers;

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
    public function login()
    {
        $params = [
            'name' => "The GearGurd"
        ];
        return $this->render('common', $params);
    }

    public function type()
    {
        $params = [
            'name' => "The GearGurd - User Type"
        ];
        return $this->render('type', $params);
    }
}
