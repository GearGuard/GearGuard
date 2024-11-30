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
$app->router->get('/appointment/getServices', [SiteController::class, 'getServices']);
$app->router->get('/customer/appointment/appoint', [AuthController::class, 'newAppointments']);
$app->router->get('/customer/vehicle/register', [AuthController::class, 'addVehicle']);
$app->run();
