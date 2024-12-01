<?php
/*
User: GearGurd
*/

use app\controllers\AuthController;
use app\controllers\SiteController;
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
$app->router->get('/tets', [SiteController::class, 'tets']);
$app->router->get('/community', [SiteController::class, 'community']);

$app->router->get('/home', [AuthController::class, 'customer']);
$app->router->get('/customer/dashboard', [AuthController::class, 'dashboard']);
$app->router->get('/customer/settings', [AuthController::class, 'settings']);
$app->router->get('/customer/appointment/appoint', [AuthController::class, 'newAppointments']);
$app->router->get('/customer/vehicle/register', [AuthController::class, 'addVehicle']);
$app->router->get('/customer/appointment/my_appointment', [AuthController::class, 'appointments']);
$app->router->get('/customer/vehicleTransfer/instruction', [AuthController::class, 'transferVehicle']);
$app->router->get('/customer/vehicleTransfer/transferForm', [AuthController::class, 'transferVehicleForm']);
$app->router->get('/customer/appointment/service_history', [AuthController::class, 'serviceHistory']);
$app->router->get('/customer/appointment/spareparts_warranty', [AuthController::class, 'sparepartsWarranty']);
$app->router->get('/customer/sparepart/add_sparepart', [AuthController::class, 'newSparepart']);
$app->router->get('/customer/sparepart/view_sparepart', [AuthController::class, 'viewSparepart']);
$app->router->get('/customer/profile/my_profile', [AuthController::class, 'myProfile']);

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
$app->router->get('/garage/services/update', [AuthController::class, 'editServices']);
$app->router->get('/garage/services/delete', [AuthController::class, 'deleteServices']);
$app->router->get('/garage/customers/view', [AuthController::class, 'viewCustomers']);
$app->router->get('/garage/customers/send_message', [AuthController::class, 'sendMessages']);
$app->router->get('/garage/customers/search', [AuthController::class, 'searchCustomer']);
$app->router->get('/garage/mechanic', [AuthController::class, 'manageMechanic']);
$app->router->get('/appointment/getServices', [SiteController::class, 'getServices']);
$app->router->get('/community/post', [AuthController::class, 'newPost']);
$app->router->get('/community/my_posts', [AuthController::class, 'viewPosts']);

$app->run();
