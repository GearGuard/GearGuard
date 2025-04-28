<?php

namespace app\controllers;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Response;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use app\models\User;

class AdminController extends Controller
{
    public static function isAdmin() : bool {
        if (Application::$app->user instanceof User)
            return (bool)Application::$app->user->isAdmin();

        return false;
    }

    public function __construct()
    {
        $this->registerMiddleware(new ExtendedMiddleware([], self::isAdmin()));
    }

    private function getGarages()
    {
        $sql = "SELECT id, name FROM gg_garage WHERE status_id = 2"; // active garages
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function admin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin');
    }

    // Admin users section
    public function viewUsers(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        $sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.contact_no,
                CASE WHEN ua.user_id IS NOT NULL THEN 'admin' ELSE 'customer' END AS user_role
                FROM gg_user u
                LEFT JOIN gg_user_admin ua ON u.id = ua.user_id";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $this->render('admin/users/viewUsers', [
            'users' => $users
        ]);
    }
    public function addUser(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/users/addUser');
    }

    public function addUserPost(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        if ($request->isPost()) {
            $user = new \app\models\User();

            $user->first_name = $request->getBody()['fname'] ?? '';
            $user->last_name = $request->getBody()['lname'] ?? '';
            $user->email = $request->getBody()['email'] ?? '';
            $user->contact_no = $request->getBody()['phone'] ?? '';
            $user->status = \app\models\User::STATUS_ACTIVE;

            // Set a default password or generate one, here using 'password123' hashed
            $user->password = password_hash('password123', PASSWORD_DEFAULT);

            // Additional user role handling can be added here if needed

            if ($user->save()) {
                // Redirect to view users page after successful save
                $response->redirect('/admin/viewusers');
                return;
            } else {
                // Handle validation errors or save failure
                // For simplicity, re-render the form with errors (not implemented here)
                return $this->render('admin/users/addUser', ['errors' => $user->errors ?? []]);
            }
        }

        // If not POST, redirect to add user form
        $response->redirect('/admin/adduser');
    }
    public function editUser(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $response->redirect('/admin/viewusers');
            return;
        }

        $sql = "SELECT * FROM gg_user WHERE id = :id";
        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            $response->redirect('/admin/viewusers');
            return;
        }

        return $this->render('admin/users/editUser', [
            'user' => $user
        ]);
    }

    public function editUserPost(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        if ($request->isPost()) {
            $body = $request->getBody();
            $id = $body['id'] ?? null;

            if (!$id) {
                $response->redirect('/admin/viewusers');
                return;
            }

            $sql = "UPDATE gg_user SET first_name = :fname, last_name = :lname, email = :email, contact_no = :phone, status_id = :status_id WHERE id = :id";
            $statement = Application::$app->db->prepare($sql);
            $statement->bindValue(':fname', $body['fname'] ?? '');
            $statement->bindValue(':lname', $body['lname'] ?? '');
            $statement->bindValue(':email', $body['email'] ?? '');
            $statement->bindValue(':phone', $body['phone'] ?? '');
            $statement->bindValue(':status_id', !empty($body['status_id']) ? $body['status_id'] : 2);
            $statement->bindValue(':id', $id);

            if ($statement->execute()) {
                $response->redirect('/admin/viewusers');
                return;
            } else {
                // Handle update failure, re-render form with error (not implemented)
                return $this->render('admin/users/editUser', [
                    'user' => $body,
                    'errors' => ['Failed to update user.']
                ]);
            }
        }

        $response->redirect('/admin/viewusers');
    }

    public function deleteUserPost(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        if ($request->isPost()) {
            $body = $request->getBody();
            $id = $body['id'] ?? null;

            if (!$id) {
                $response->redirect('/admin/viewusers');
                return;
            }

            $sql = "DELETE FROM gg_user WHERE id = :id";
            $statement = Application::$app->db->prepare($sql);
            $statement->bindValue(':id', $id);

            if ($statement->execute()) {
                $response->redirect('/admin/viewusers');
                return;
            } else {
                // Handle delete failure, re-render with error (not implemented)
                $response->setStatusCode(500);
                echo "Failed to delete user.";
                exit;
            }
        }

        $response->redirect('/admin/viewusers');
    }

    // Admin services section
    public function viewServices(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        $sql = "SELECT s.id, s.type, s.description, s.price, s.duration, g.name AS garage_name
                FROM gg_garage_service s
                JOIN gg_garage g ON s.garage_id = g.id
                WHERE s.status_id = 2"; // active services

        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        $services = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $this->render('admin/services/viewServices', [
            'services' => $services
        ]);
    }

    public function deleteServicePost(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        if ($request->isPost()) {
            $body = $request->getBody();
            $id = $body['id'] ?? null;

            if (!$id) {
                $response->redirect('/admin/viewservices');
                return;
            }

            $sql = "DELETE FROM gg_garage_service WHERE id = :id";
            $statement = Application::$app->db->prepare($sql);
            $statement->bindValue(':id', $id);

            if ($statement->execute()) {
                $response->redirect('/admin/viewservices');
                return;
            } else {
                $response->setStatusCode(500);
                echo "Failed to delete service.";
                exit;
            }
        }

        $response->redirect('/admin/viewservices');
    }
    public function addService(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        // Fetch garages from database
        $sql = "SELECT id, name FROM gg_garage WHERE status_id = 2"; // active garages
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        $garages = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $this->render('admin/services/addService', [
            'garages' => $garages
        ]);
    }
    public function editService(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        $serviceId = null;
        $service = null;
        $errors = [];

        // Check for GET param 'id' to load service data directly
        $queryParams = $_GET;
        if (isset($queryParams['id'])) {
            $serviceId = $queryParams['id'];
            $sql = "SELECT s.*, g.name AS garage_name FROM gg_garage_service s JOIN gg_garage g ON s.garage_id = g.id WHERE s.id = :id AND s.status_id = 2";
            $statement = Application::$app->db->prepare($sql);
            $statement->bindValue(':id', $serviceId);
            $statement->execute();
            $service = $statement->fetch(\PDO::FETCH_ASSOC);

            if (!$service) {
                $errors[] = "Service with ID $serviceId not found.";
            }
        }

        if ($request->isPost()) {
            $body = $request->getBody();
            $action = $body['action'] ?? null;

            if ($action === 'search') {
                $serviceId = $body['service_id'] ?? null;

                if ($serviceId) {
                    $sql = "SELECT s.*, g.name AS garage_name FROM gg_garage_service s JOIN gg_garage g ON s.garage_id = g.id WHERE s.id = :id AND s.status_id = 2";
                    $statement = Application::$app->db->prepare($sql);
                    $statement->bindValue(':id', $serviceId);
                    $statement->execute();
                    $service = $statement->fetch(\PDO::FETCH_ASSOC);

                    if (!$service) {
                        $errors[] = "Service with ID $serviceId not found.";
                    }
                } else {
                    $errors[] = "Please provide a service ID.";
                }
            } elseif ($action === 'update') {
                $serviceId = $body['service_id'] ?? null;
                $serviceName = $body['service_name'] ?? '';
                $serviceDescription = $body['service_description'] ?? '';
                $servicePrice = $body['service_price'] ?? '';
                $serviceDuration = $body['service_duration'] ?? '';
                $garageName = $body['garage'] ?? '';

                // Convert duration to float (strip non-numeric characters)
                $serviceDuration = floatval(preg_replace('/[^0-9.]/', '', $serviceDuration));

                $errors = [];

                if (!$serviceId) {
                    $errors[] = "Service ID is required for update.";
                }
                if (!$serviceName) {
                    $errors[] = "Service name is required.";
                }
                if (!$serviceDescription) {
                    $errors[] = "Service description is required.";
                }
                if (!$servicePrice || !is_numeric($servicePrice)) {
                    $errors[] = "Valid service price is required.";
                }
                if (!$serviceDuration) {
                    $errors[] = "Service duration is required.";
                }
                if (!$garageName) {
                    $errors[] = "Garage name is required.";
                }

                if (!empty($errors)) {
                    return $this->render('admin/services/editService', [
                        'errors' => $errors,
                        'service' => $body
                    ]);
                }

                // Get garage id from garage name
                $garageSql = "SELECT id FROM gg_garage WHERE name = :garage_name";
                $garageStmt = Application::$app->db->prepare($garageSql);
                $garageStmt->bindValue(':garage_name', $garageName);
                $garageStmt->execute();
                $garageRow = $garageStmt->fetch(\PDO::FETCH_ASSOC);

                if (!$garageRow) {
                    $errors[] = "Garage not found.";
                    return $this->render('admin/services/editService', [
                        'errors' => $errors,
                        'service' => $body
                    ]);
                }

                $garageId = $garageRow['id'];

                $sql = "UPDATE gg_garage_service SET type = :type, description = :description, price = :price, duration = :duration, garage_id = :garage_id WHERE id = :id";
                $statement = Application::$app->db->prepare($sql);
                $statement->bindValue(':type', $serviceName);
                $statement->bindValue(':description', $serviceDescription);
                $statement->bindValue(':price', $servicePrice);
                $statement->bindValue(':duration', $serviceDuration);
                $statement->bindValue(':garage_id', $garageId);
                $statement->bindValue(':id', $serviceId);

                if ($statement->execute()) {
                    $response->redirect('/admin/viewservices');
                    return;
                } else {
                    $errors[] = "Failed to update service.";
                    return $this->render('admin/services/editService', [
                        'errors' => $errors,
                        'service' => $body
                    ]);
                }
            }
        }

        return $this->render('admin/services/editService', [
            'service' => $service,
            'errors' => $errors
        ]);
    }

    public function addServicePost(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        if ($request->isPost()) {
            $body = $request->getBody();

            $serviceName = $body['service_name'] ?? '';
            $serviceDescription = $body['service_description'] ?? '';
            $servicePrice = $body['service_price'] ?? '';
            $serviceDuration = $body['service_duration'] ?? '';
            $garage = $body['garage'] ?? '';

            // Basic validation
            $errors = [];
            if (!$serviceName) {
                $errors[] = 'Service name is required.';
            }
            if (!$serviceDescription) {
                $errors[] = 'Service description is required.';
            }
            if (!$servicePrice || !is_numeric($servicePrice)) {
                $errors[] = 'Valid service price is required.';
            }
            if (!$serviceDuration) {
                $errors[] = 'Service duration is required.';
            }
            if (!$garage) {
                $errors[] = 'Garage is required.';
            }

            if (!empty($errors)) {
                return $this->render('admin/services/addService', [
                    'errors' => $errors,
                    'body' => $body,
                    'garages' => $this->getGarages()
                ]);
            }

            // Insert into database
            $sql = "INSERT INTO gg_garage_service (type, price, duration, description, garage_id, status_id) VALUES (:type, :price, :duration, :description, :garage_id, 2)";
            $statement = Application::$app->db->prepare($sql);

            $statement->bindValue(':type', $serviceName);
            $statement->bindValue(':price', $servicePrice);
            $statement->bindValue(':duration', $serviceDuration);
            $statement->bindValue(':description', $serviceDescription);
            $statement->bindValue(':garage_id', $garage);

            if ($statement->execute()) {
                $response->redirect('/admin/viewservices');
                return;
            } else {
                $errors[] = 'Failed to add service.';
                return $this->render('admin/services/addService', [
                    'errors' => $errors,
                    'body' => $body,
                    'garages' => $this->getGarages()
                ]);
            }
        }

        $response->redirect('/admin/addservice');
    }

    // Admin vehicles section
    public function viewVehiclesByAdmin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        $vehicles = $this->getVehicles();
        return $this->render('admin/vehicles/viewvehicles', [
            'vehicles' => $vehicles
        ]);
    }

    public function deleteVehiclePost(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        if ($request->isPost()) {
            $body = $request->getBody();
            $id = $body['id'] ?? null;

            if (!$id) {
                $response->redirect('/admin/viewvehicles');
                return;
            }

            // Delete related records in gg_user_owner first to avoid foreign key constraint error
            $sqlDeleteOwner = "DELETE FROM gg_user_owner WHERE vehicle_id = :id";
            $stmtDeleteOwner = Application::$app->db->prepare($sqlDeleteOwner);
            $stmtDeleteOwner->bindValue(':id', $id);
            $stmtDeleteOwner->execute();

            // Delete related records in gg_vehicle_service_appointment to avoid foreign key constraint error
            $sqlDeleteAppointments = "DELETE FROM gg_vehicle_service_appointment WHERE vehicle_id = :id";
            $stmtDeleteAppointments = Application::$app->db->prepare($sqlDeleteAppointments);
            $stmtDeleteAppointments->bindValue(':id', $id);
            $stmtDeleteAppointments->execute();

            // Now delete the vehicle
            $sql = "DELETE FROM gg_vehicle WHERE id = :id";
            $statement = Application::$app->db->prepare($sql);
            $statement->bindValue(':id', $id);

            if ($statement->execute()) {
                $response->redirect('/admin/viewvehicles');
                return;
            } else {
                $response->setStatusCode(500);
                echo "Failed to delete vehicle.";
                exit;
            }
        }

        $response->redirect('/admin/viewvehicles');
    }

    private function getVehicles()
    {
        $sql = "SELECT v.id, v.vin, v.license_plate_no, v.year_manufactured, v.engine_no, v.insurance_no,
                       m.name AS manufacturer, mo.model AS model, c.class AS class, ec.capacity AS engine_capacity,
                       ft.fueltype AS fuel_type, bt.bodytype AS bodytype, vt.type AS vehicle_type, s.status AS status,
                       CONCAT(u.first_name, ' ', u.last_name) AS owner_name
                FROM gg_vehicle v
                LEFT JOIN gg_vehicle_model mo ON v.model_id = mo.id
                LEFT JOIN gg_vehicle_manufacturer m ON mo.manufacturer_id = m.id
                LEFT JOIN gg_vehicle_class c ON v.class_id = c.id
                LEFT JOIN gg_vehicle_engine_capacity ec ON v.engine_capacity_id = ec.id
                LEFT JOIN gg_vehicle_fueltype ft ON v.fuel_type_id = ft.id
                LEFT JOIN gg_vehicle_bodytype bt ON v.bodytype_id = bt.id
                LEFT JOIN gg_vehicle_type vt ON v.vehicle_type_id = vt.id
                LEFT JOIN gg_status s ON v.status_id = s.id
                LEFT JOIN gg_user_owner uo ON v.id = uo.vehicle_id
                LEFT JOIN gg_user u ON uo.user_id = u.id
                ORDER BY v.id DESC";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    // private function getGarages()
    // {
    //     $sql = "SELECT id, name FROM gg_garage WHERE status_id = 2"; // active garages
    //     $statement = Application::$app->db->prepare($sql);
    //     $statement->execute();
    //     return $statement->fetchAll(\PDO::FETCH_ASSOC);
    // }

    private function getVehicleModels()
    {
        $sql = "SELECT id, model AS name FROM gg_vehicle_model"; // no status_id column
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getVehicleShapes()
    {
        $sql = "SELECT id, bodytype AS name FROM gg_vehicle_bodytype"; // no status_id column
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getVehicleManufacturers()
    {
        $sql = "SELECT id, name FROM gg_vehicle_manufacturer"; // no status_id column
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getVehicleClasses()
    {
        $sql = "SELECT id, class AS name FROM gg_vehicle_class"; // no status_id column
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getEngineCapacities()
    {
        $sql = "SELECT id, capacity AS name FROM gg_vehicle_engine_capacity"; // no status_id column
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getFuelTypes()
    {
        $sql = "SELECT id, fueltype AS name FROM gg_vehicle_fueltype"; // no status_id column
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getVehicleTypes()
    {
        $sql = "SELECT id, type AS name FROM gg_vehicle_type"; // no status_id column
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getVehicleOwners()
    {
        $sql = "SELECT uo.user_id, u.first_name, u.last_name FROM gg_user_owner uo JOIN gg_user u ON uo.user_id = u.id";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getVehicleStatuses()
    {
        $sql = "SELECT id, status AS name FROM gg_status";
        $statement = Application::$app->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addVehicleByAdmin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');

        $garages = $this->getGarages();
        $models = $this->getVehicleModels();
        $shapes = $this->getVehicleShapes();
        $manufacturers = $this->getVehicleManufacturers();
        $classes = $this->getVehicleClasses();
        $engineCapacities = $this->getEngineCapacities();
        $fuelTypes = $this->getFuelTypes();
        $vehicleTypes = $this->getVehicleTypes();
        $owners = $this->getVehicleOwners();
        $statuses = $this->getVehicleStatuses();

        return $this->render('admin/vehicles/addvehicle', [
            'garages' => $garages,
            'models' => $models,
            'shapes' => $shapes,
            'manufacturers' => $manufacturers,
            'classes' => $classes,
            'engineCapacities' => $engineCapacities,
            'fuelTypes' => $fuelTypes,
            'vehicleTypes' => $vehicleTypes,
            'owners' => $owners,
            'statuses' => $statuses
        ]);
    }

    public function editVehicleByAdmin(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        return $this->render('admin/vehicles/editvehicle');
    }

    public function addVehicleByAdminPost(Request $request, Response $response)
    {
        $this->setLayout('admin_navbar');
        $data = $request->getBody();

        // Validate required fields (basic example)
        $requiredFields = [
            'owner_id', 'manufacturer_id', 'model_id', 'year_manufactured', 'license_plate_no',
            'class_id', 'engine_capacity_id', 'fuel_type_id', 'bodytype_id', 'engine_no',
            'vehicle_type_id', 'status_id'
        ];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $response->setStatusCode(400);
                echo "Field {$field} is required.";
                exit;
            }
        }

        // Insert vehicle data into gg_vehicle table
        $sql = "INSERT INTO gg_vehicle 
            (vin, model_id, year_manufactured, license_plate_no, class_id, engine_capacity_id, fuel_type_id, bodytype_id, insurance_no, engine_no, current_user_id, status_id, vehicle_type_id)
            VALUES (:vin, :model_id, :year_manufactured, :license_plate_no, :class_id, :engine_capacity_id, :fuel_type_id, :bodytype_id, :insurance_no, :engine_no, :current_user_id, :status_id, :vehicle_type_id)";
        $statement = Application::$app->db->prepare($sql);

        // VIN is optional, generate or get from input
        $vin = $data['vin'] ?? null;
        $insurance_no = $data['insurance_no'] ?? null;
        $current_user_id = $data['owner_id']; // Assuming owner is current user

        $statement->bindValue(':vin', $vin);
        $statement->bindValue(':model_id', $data['model_id']);
        $statement->bindValue(':year_manufactured', $data['year_manufactured']);
        $statement->bindValue(':license_plate_no', $data['license_plate_no']);
        $statement->bindValue(':class_id', $data['class_id']);
        $statement->bindValue(':engine_capacity_id', $data['engine_capacity_id']);
        $statement->bindValue(':fuel_type_id', $data['fuel_type_id']);
        $statement->bindValue(':bodytype_id', $data['bodytype_id']);
        $statement->bindValue(':insurance_no', $insurance_no);
        $statement->bindValue(':engine_no', $data['engine_no']);
        $statement->bindValue(':current_user_id', $current_user_id);
        $statement->bindValue(':status_id', $data['status_id']);
        $statement->bindValue(':vehicle_type_id', $data['vehicle_type_id']);

        try {
            $success = $statement->execute();
            if (!$success) {
                $errorInfo = $statement->errorInfo();
                echo "Database error: " . $errorInfo[2];
                exit;
            }
            $vehicleId = Application::$app->db->pdo->lastInsertId();

            // Insert ownership record in gg_user_owner
            $sqlOwner = "INSERT INTO gg_user_owner (user_id, vehicle_id, ownership_status_id, registration_date) VALUES (:user_id, :vehicle_id, 1, NOW())";
            $stmtOwner = Application::$app->db->prepare($sqlOwner);
            $stmtOwner->bindValue(':user_id', $current_user_id);
            $stmtOwner->bindValue(':vehicle_id', $vehicleId);
            $stmtOwner->execute();

            // Redirect to view vehicles page or success page
            $response->redirect('/admin/viewvehicles');
            return;
        } catch (\PDOException $e) {
            $response->setStatusCode(500);
            echo "Error adding vehicle: " . $e->getMessage();
            exit;
        }
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
}