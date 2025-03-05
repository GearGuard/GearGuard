<?php
/*
User: GearGurd
*/

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\controllers\AdminController;
use app\controllers\GarageController;
	use app\controllers\VehicleController;
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
$app->router->get('/typelogin', [SiteController::class, 'typelogin']);
$app->router->get('/tets', [SiteController::class, 'tets']);
$app->router->get('/community', [SiteController::class, 'community']);

$app->router->get('/home', [AuthController::class, 'customer']);
$app->router->get('/customer/dashboard', [AuthController::class, 'dashboard']);
$app->router->get('/customer/settings', [AuthController::class, 'settings']);
$app->router->get('/customer/appointment/appoint', [AuthController::class, 'newAppointments']);
$app->router->post('/customer/appointment/appoint', [AuthController::class, 'newAppointmentsPost']);
$app->router->get('/customer/vehicle/register', [AuthController::class, 'addVehicle']);
$app->router->post('/customer/vehicle/register', [VehicleController::class, 'addVehiclePost']);
$app->router->get('/customer/vehicle/all', [AuthController::class, 'viewAllVehicle']);
$app->router->get('/customer/vehicle/all', [VehicleController::class, 'viewAllVehicle']);

$app->router->get('/customer/vehicle/service_history', [AuthController::class, 'vehicleServiceHistory']);
$app->router->get('/customer/appointment/my_appointment', [AuthController::class, 'appointments']);
$app->router->get('/customer/vehicleTransfer/transfer', [AuthController::class, 'transferVehicle']);
$app->router->get('/customer/vehicleTransfer/instruction', [AuthController::class, 'transferInstructions']);
$app->router->get('/customer/appointment/service_history', [AuthController::class, 'serviceHistory']);
$app->router->get('/customer/appointment/spareparts_warranty', [AuthController::class, 'sparepartsWarranty']);
$app->router->get('/customer/sparepart/add_sparepart', [AuthController::class, 'newSparepart']);
$app->router->get('/customer/sparepart/view_sparepart', [AuthController::class, 'viewSparepart']);
$app->router->get('/customer/profile', [AuthController::class, 'myProfile']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/garage/register', [AuthController::class, 'garageSignup']);
$app->router->post('/garage/register', [AuthController::class, 'garageSignup']);
$app->router->get('/garage/login', [AuthController::class, 'garageLogin']);
$app->router->post('/garage/login', [AuthController::class, 'garageLogin']);
$app->router->get('/dashboard', [AuthController::class, 'dashboard']);
$app->router->get('/profile', [AuthController::class, 'myProfile']);
$app->router->get('/settings', [AuthController::class, 'settings']);
$app->router->get('/appointment/appointments', [AuthController::class, 'appointments']);
$app->router->post('/appointment/update_status', [AuthController::class, 'updateAppointmentStatus']);

$app->router->get('/appointment/search', [GarageController::class, 'searchAppointments']);
$app->router->get('/appointment/filtered', [GarageController::class, 'filteredAppointments']);
$app->router->get('/appointment/delete', [GarageController::class, 'deleteAppointment']);
$app->router->get('/services/view', [GarageController::class, 'viewServices']);
$app->router->get('/services/add', [GarageController::class, 'addServices']);
$app->router->post('/services/add', [GarageController::class, 'addServicesPost']);
$app->router->get('/services/update', [GarageController::class, 'editServices']);
$app->router->post('/services/update', [GarageController::class, 'updateService']);
$app->router->get('/services/delete', [GarageController::class, 'deleteServices']);
$app->router->post('/services/delete', [GarageController::class, 'markServiceDeleted']);
$app->router->get('/services/search', [GarageController::class, 'getService']);
$app->router->get('/customers/view', [GarageController::class, 'viewCustomers']);
$app->router->get('/customers/send_message', [GarageController::class, 'sendMessages']);
$app->router->get('/customers/search', [GarageController::class, 'searchCustomer']);
$app->router->get('/mechanic', [GarageController::class, 'manageMechanic']);


$app->router->get('/appointment/getServices', [AuthController::class, 'getGarageServices']);
$app->router->get('/community/post', [AuthController::class, 'newPost']);
$app->router->get('/community/my_posts', [AuthController::class, 'viewPosts']);

$app->router->get('/admin', [AdminController::class, 'admin']);
$app->router->get('/admin/dashboard', [AdminController::class, 'admin_dashboard']);
$app->router->get('/admin/viewusers', [AdminController::class, 'viewUsers']);
$app->router->get('/admin/adduser', [AdminController::class, 'addUser']);
$app->router->get('/admin/edituser', [AdminController::class, 'editUser']);
$app->router->get('/admin/viewservices', [AdminController::class, 'viewServices']);
$app->router->get('/admin/addservice', [AdminController::class, 'addService']);
$app->router->get('/admin/editservice', [AdminController::class, 'editService']);
$app->router->get('/admin/viewvehicles', [AdminController::class, 'viewVehiclesByAdmin']);
$app->router->get('/admin/addvehicle', [AdminController::class, 'addVehicleByAdmin']);
$app->router->get('/admin/editvehicle', [AdminController::class, 'editVehicleByAdmin']);
$app->router->get('/admin/transaction', [AdminController::class, 'admin_transaction']);
$app->router->get('/admin/q&a', [AdminController::class, 'questions']);


$app->run();
