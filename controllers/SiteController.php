<?php

namespace app\controllers;

use Couchbase\RequestSpan;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\View;
use gearguard\phpmvc\Response;
use app\models\ContactForm;
use app\models\Appointment;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => "The GearGurd"
        ];
        return $this->render('home', $params);
    }

    // Used for the newAppointment page in the customer section
    public function common(Request $request, Response $response)
    {
        $model = new Appointment();

        // Fetch garages from the database
        $garages = $this->getGarages();

        return $this->render('common', [
            'model' => $model,
            'garages' => $garages
        ]);
    }

    private function getGarages()
    {
        $sql = "SELECT id, name FROM gg_garage WHERE status_id = 1"; // Assuming 2 is the status for active garages
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function getServices(Request $request)
    {
        $garageId = $request->getBody()['garage_id'];
        $services = $this->getServicesByGarage($garageId);

        $options = '<option value="">Select Service</option>';
        foreach ($services as $id => $name) {
            $options .= "<option value=\"{$id}\">{$name}</option>";
        }

        return $options;
    }

    private function getServicesByGarage($garageId)
    {
        $sql = "SELECT id, type FROM gg_garage_service WHERE garage_id = :garage_id AND status_id = 1";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':garage_id', $garageId);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    // end of the newAppointment page in the customer section


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

    public function navbar_customer(Request $request, Response $response)
    {
        return $this->render('navbar_customer', ['name' => 'The GearGuard']);
    }

    public function newAppointments(Request $request, Response $response)
    {
        return $this->render('customer/appointment/newAppointment', ['name' => 'The GearGuard']);
    }

    public function addVehicle(Request $request, Response $response)
    {
        return $this->render('customer/vehicle/addNew', ['name' => 'The GearGuard']);
    }

    public function community(Request $request, Response $response)
    {
        return $this->render('community/allPosts', ['name' => 'The GearGuard']);
    }
}
