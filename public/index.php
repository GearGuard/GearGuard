<?php
/*
User: GearGurd
*/

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\controllers\SparepartController;
use gearguard\phpmvc\Application;


require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
	'userClass' => \app\models\User::class,
	'db' => [
		'dsn' => $_ENV['DB_DSN'],
		'user' => $_ENV['DB_USER'],
		'password' => $_ENV['DB_PASSWORD'],
	]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);
$app->router->get('/about', [SiteController::class, 'about']);
$app->router->get('/common', [SiteController::class, 'common']);
$app->router->get('/type', [SiteController::class, 'type']);

$app->router->get('/navbar_customer', [SiteController::class, 'navbar_customer']);

$app->router->get('/customer/appointment/appoint', [SiteController::class, 'newAppointments']);
$app->router->get('/customer/appointment/myappoint', [SiteController::class, 'myAppointments']);

$app->router->get('/customer/vehicle/register', [SiteController::class, 'addVehicle']);
$app->router->get('/community', [SiteController::class, 'community']);

$app->router->get('/tets', [SiteController::class, 'tets']);
$app->router->get('/community', [SiteController::class, 'community']);

$app->router->get('/home', [AuthController::class, 'customer']);
$app->router->get('/customer/dashboard', [AuthController::class, 'dashboard']);
$app->router->get('/customer/settings', [AuthController::class, 'settings']);
$app->router->get('/customer/appointment/appoint', [AuthController::class, 'newAppointments']);
$app->router->post('/customer/appointment/appoint', [AuthController::class, 'newAppointmentsPost']);
$app->router->get('/customer/vehicle/register', [AuthController::class, 'addVehicle']);
$app->router->get('/customer/vehicle/all', [AuthController::class, 'viewAllVehicle']);
$app->router->get('/customer/vehicle/service_history', [AuthController::class, 'vehicleServiceHistory']);
$app->router->get('/customer/appointment/my_appointment', [AuthController::class, 'appointments']);
$app->router->get('/customer/vehicleTransfer/transfer', [AuthController::class, 'transferVehicle']);
$app->router->get('/customer/vehicleTransfer/instruction', [AuthController::class, 'transferInstructions']);
$app->router->get('/customer/appointment/service_history', [AuthController::class, 'serviceHistory']);
$app->router->get('/customer/appointment/spareparts_warranty', [AuthController::class, 'sparepartsWarranty']);
$app->router->get('/customer/sparepart/add_sparepart', [AuthController::class, 'newSparepart']);
$app->router->get('/customer/sparepart/view_sparepart', [AuthController::class, 'viewSparepart']);
$app->router->get('/customer/my_profile', [AuthController::class, 'myProfile']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/garage/register', [AuthController::class, 'garageSignup']);
$app->router->post('/garage/register', [AuthController::class, 'garageSignup']);
$app->router->get('/garage/login', [AuthController::class, 'garageLogin']);
$app->router->post('/garage/login', [AuthController::class, 'garageLogin']);
$app->router->get('/garage/dashboard', [AuthController::class, 'dashboard']);
$app->router->get('/garage/profile', [AuthController::class, 'myProfile']);
$app->router->get('/garage/settings', [AuthController::class, 'settings']);
$app->router->get('/garage/appointment/appointments', [AuthController::class, 'appointments']);
$app->router->get('/garage/appointment/search', [AuthController::class, 'searchAppointments']);
$app->router->get('/garage/appointment/delete', [AuthController::class, 'deleteAppointment']);
$app->router->get('/garage/services/view', [AuthController::class, 'viewServices']);
$app->router->get('/garage/services/add', [AuthController::class, 'addServices']);
$app->router->post('/garage/services/add', [AuthController::class, 'addServicesPost']);
$app->router->get('/garage/services/update', [AuthController::class, 'editServices']);
$app->router->post('/garage/services/update', [AuthController::class, 'updateService']);
$app->router->get('/garage/services/delete', [AuthController::class, 'deleteServices']);
$app->router->post('/garage/services/delete', [AuthController::class, 'markServiceDeleted']);
$app->router->get('/garage/services/search', [AuthController::class, 'getService']);
$app->router->get('/garage/customers/view', [AuthController::class, 'viewCustomers']);
$app->router->get('/garage/customers/send_message', [AuthController::class, 'sendMessages']);
$app->router->get('/garage/customers/search', [AuthController::class, 'searchCustomer']);
$app->router->get('/garage/mechanic', [AuthController::class, 'manageMechanic']);
$app->router->get('/appointment/getServices', [SiteController::class, 'getServices']);

$app->router->get('/admin', [SiteController::class, 'admin']);
$app->router->get('/admin/dashboard', [SiteController::class, 'admin_dashboard']);

$app->router->get('/admin/viewusers', [SiteController::class, 'viewUsers']);
$app->router->get('/admin/adduser', [SiteController::class, 'addUser']);
$app->router->get('/admin/edituser', [SiteController::class, 'editUser']);

$app->router->get('/admin/viewservices', [SiteController::class, 'viewServices']);
$app->router->get('/admin/addservice', [SiteController::class, 'addService']);
$app->router->get('/admin/editservice', [SiteController::class, 'editService']);

$app->router->get('/admin/viewvehicles', [SiteController::class, 'viewVehiclesByAdmin']);
$app->router->get('/admin/addvehicle', [SiteController::class, 'addVehicleByAdmin']);
$app->router->get('/admin/editvehicle', [SiteController::class, 'editVehicleByAdmin']);

$app->router->get('/admin/transaction', [SiteController::class, 'admin_transaction']);
$app->router->get('/admin/q&a', [SiteController::class, 'questions']);

$app->router->get('/customer/addsparepart', [SiteController::class, 'addSparepart']);
$app->router->get('/customer/viewsparepart', [SiteController::class, 'viewSparepart']);

//spare pats
$app->router->post('/sparepart/add', [SparepartController::class, 'addSparePart']);
$app->router->get('/sparepart/get', [SparepartController::class, 'getSparePart']);
$app->router->post('/sparepart/delete', [SparepartController::class, 'deleteSparePart']);
$app->router->post('/sparepart/edit', [SparepartController::class, 'editSparePart']);

$app->router->get('/appointment/getServices', [AuthController::class, 'getGarageServices']);
$app->router->get('/community/post', [AuthController::class, 'newPost']);
$app->router->get('/community/my_posts', [AuthController::class, 'viewPosts']);


//mechanic

// $app->router->get('/mechanic', [SiteController::class, 'mechanic']);
$app->router->get('/home', [AuthController::class, 'customer']);
$app->router->get('/mechanic/register', [AuthController::class, 'mechanicSignup']);
$app->router->post('/mechanic/register', [AuthController::class, 'mechanicSignup']);
$app->router->get('/mechanic/login', [AuthController::class, 'mechanicLogin']);
$app->router->post('/mechanic/login', [AuthController::class, 'mechanicLogin']);
$app->router->get('/mechanic/dashboard', [AuthController::class, 'dashboard']);
$app->router->get('/mechanic/services/viewService', [SiteController::class, 'viewServicesByMechanic']);
$app->router->get('/mechanic/services/addService', [AuthController::class, 'assignMechanicService']);
$app->router->post('/mechanic/services/addService', [AuthController::class, 'assignMechanicService']);
$app->router->get('/mechanic/services/editService', [SiteController::class, 'editServices']);
$app->router->post('/mechanic/services/editService', [SiteController::class, 'editServices']);
$app->router->get('/mechanic/services/deleteService', [SiteController::class, 'deleteServices']);
$app->router->post('/mechanic/services/deleteService', [SiteController::class, 'markServiceDeleted']);
$app->router->get('/mechanic/services/search', [AuthController::class, 'getService']);
$app->router->get('/mechanic/profile', [AuthController::class, 'myProfile']);
$app->router->post('/mechanic/profile/update', [AuthController::class, 'updateProfile']);
$app->router->get('/mechanic/services', [SiteController::class, 'mechanicservices']);
$app->router->get('/mechanic/service_history', [SiteController::class, 'mechanicServiceHistory']);
$app->router->get('/mechanic/spareparts', [SiteController::class, 'mechanicSparePart']);
$app->router->get('/mechanic/messages', [AuthController::class, 'MechanicSendMessages']);
$app->router->get('/mechanic/settings', [AuthController::class, 'settings']);


$app->run();
