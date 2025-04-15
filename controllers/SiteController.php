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
use app\models\GarageService;


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

    public function community(Request $request, Response $response)
    {
        return $this->render('community/allPosts', ['name' => 'The GearGuard']);
    }


    // Admin section-------------------------------
    public function admin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin');
    }

    // Admin users section
    public function viewUsers(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/users/viewUsers');
    }
    public function addUser(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/users/addUser');
    }
    public function editUser(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/users/editUser');
    }

    // Admin services section
    public function viewServices(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/services/viewServices');
    }
    public function addService(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/services/addService');
    }
    public function editService(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/services/editService');
    }

    // Admin vehicles section
    public function viewVehiclesByAdmin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/vehicles/viewvehicles');
    }
    public function addVehicleByAdmin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/vehicles/addvehicle');
    }
    public function editVehicleByAdmin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/vehicles/editvehicle');
    }

    // Admin transactions section
    public function admin_transaction(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/transaction');
    }

    public function admin_dashboard(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/dashboard');
    }

    public function questions(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/q&a');
    }


    //Add spare parts
    public function addSparepart(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('customer/sparepart/newPart');
    }
    public function viewSparepart(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('customer/sparepart/viewPart');
    }



    public function tets(Request $request, Response $response)

    {
        $model = new GarageService(); 
        $services = []; // Initialize the $services variable
        return $this->render('tets', [
            'model' => $model,
            'services' => $services
        ]);
    }



//mechanic
public function mechanicDashboard(Request $request, Response $response)
{
    $params = [
        'name' => "The GearGurd"
    ];
    return $this->render('mechanic/dashboard', $params);
}

public function mechanicSidebar(Request $request, Response $response)
{
    $params = [
        'name' => "The GearGurd"
    ];
    return $this->render('mechanic/sidebar', $params);
}

public function viewServicesByMechanic(Request $request, Response $response)
{
    $params = [
        'name' => "The GearGurd"
    ];
    return $this->render('mechanic/services/viewService', $params);
}
// private function getServicesListByMechanic()
// {
//     $sql = "SELECT id, type FROM gg_garage_service WHERE status_id = 1 AND mechanic_id = :mechanic_id";
//     $statement = Application::$app->db->prepare($sql);
//     $statement->bindValue(':mechanic_id', Application::$app->session->get('mechanic_id'));
//     $statement->execute();
//     return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
// }

public function addServices(Request $request, Response $response)
{
    $params = [
        'name' => "The GearGurd"
    ];
    return $this->render('mechanic/services/addService', $params);
}

public function addServicesPost(Request $request, Response $response)
{
    $params = [
        'name' => "The GearGurd"
    ];
    return $this->render('mechanic/services/addService', $params);
}

public function editServices(Request $request, Response $response)
{
    $params = [
        'name' => "The GearGurd"
    ];
    return $this->render('mechanic/services/editService', $params);
}

public function deleteServices(Request $request, Response $response)
{
    $params = [
        'name' => "The GearGurd"
    ];
    return $this->render('mechanic/services/deleteService', $params);
}

public function mechanicProfile(Request $request, Response $response)
{
    $params = [
        'name' => "The GearGurd"
    ];
    return $this->render('mechanic/profile', $params);
}


private function getServicesList()
{
    $sql = "SELECT id, type FROM gg_garage_service WHERE status_id = 1";
    $statement = Application::$app->db->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
}


public function mechanicProfileUpdate(Request $request, Response $response)
    {
        $params = [
            'name' => "The GearGurd"
        ];
        return $this->render('mechanic/profile_update', $params);
    }

    



    // public function mechanicservices(Request $request, Response $response)
    // {
    //     $params = [
    //         'name' => "The GearGurd"
    //     ];
    //     return $this->render('mechanic/services', $params);
    // } 

    // public function mechanicServiceHistory(Request $request, Response $response)
    // {
    //     $params = [
    //         'name' => "The GearGurd"
    //     ];
    //     return $this->render('mechanic/service_history', $params);
    // }

public function mechanicSparePart(Request $request, Response $response)
    {
        $params = [
            'name' => "The GearGurd"
        ];
        return $this->render('mechanic/spareparts', $params);
    }

    public function mechanicMessages(Request $request, Response $response)
    {
        $params = [
            'name' => "The GearGurd"
        ];
        return $this->render('mechanic/messages', $params);
    }

    public function mechanicAddServices(Request $request, Response $response)
    {
        $this->setLayout('mechanic_navbar');
        $service = new GarageService();
        return $this->render('mechanic/services/addService', [
            'model' => $service
        ]);
    }

    public function mechanicAddServicesPost(Request $request, Response $response)
    {
        $this->setLayout('mechanic_navbar');
        $service = new GarageService();
        $service->loadData($request->getBody());
        $service->garage_id = Application::$app->session->get('user');
        $service->status_id = GarageService::STATUS_ACTIVE;

        if ($service->validate() && $service->save()) {
            Application::$app->session->setFlash('success', 'Service added successfully');
            return $response->redirect('/mechanic/services');
        }

        return $this->render('mechanic/services/addService', [
            'model' => $service
        ]);
    }
}