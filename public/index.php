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

$app->router->get('/customer', [AuthController::class, 'customer']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/profile', [AuthController::class, 'profile']);
$app->router->get('/garage', [AuthController::class, 'garage']);
$app->router->get('/garage/register', [AuthController::class, 'garageSignup']);
$app->router->post('/garage/register', [AuthController::class, 'garageSignup']);
$app->router->get('/garage/login', [AuthController::class, 'garageLogin']);
$app->router->post('/garage/login', [AuthController::class, 'garageLogin']);
$app->router->get('/customer/appointment/', [SiteController::class, 'login']);
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

$app->run();
