<?php
/*
User: GearGurd
*/

use app\controllers\AuthController;
use app\controllers\MechanicController;
use app\controllers\SiteController;
use app\controllers\AdminController;
use app\controllers\GarageController;
use app\controllers\SparePartController;
use app\controllers\VehicleController;
use app\controllers\AppointmentController;
use app\controllers\WarrentyController;
use gearguard\phpmvc\Application;
use app\controllers\ServicePerformController;



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

date_default_timezone_set('Asia/Colombo');

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);
$app->router->get('/about', [SiteController::class, 'about']);
$app->router->get('/common', [SiteController::class, 'common']);
$app->router->get('/type', [SiteController::class, 'type']);
$app->router->get('/typelogin', [SiteController::class, 'typelogin']);
$app->router->get('/notifications', [AuthController::class, 'notifications']);
$app->router->get('/notifications/markAsRead', [AuthController::class, 'markNotificationAsRead']);
$app->router->post('/notifications/markAllAsRead', [AuthController::class, 'markAllNotificationsAsRead']);
$app->router->get('/messages', [AuthController::class, 'messages']);

$app->router->get('/navbar_customer', [SiteController::class, 'navbar_customer']);

$app->router->get('/customer/appointment/appoint', [SiteController::class, 'newAppointments']);
$app->router->get('/customer/appointment/myappoint', [SiteController::class, 'myAppointments']);

$app->router->get('/customer/vehicle/register', [SiteController::class, 'addVehicle']);
$app->router->get('/community', [SiteController::class, 'community']);

$app->router->get('/tets', [SiteController::class, 'tets']);
$app->router->get('/community', [SiteController::class, 'community']);
$app->router->get('/logout', [SiteController::class, 'logout']);

$app->router->get('/home', [AuthController::class, 'customer']);
$app->router->get('/customer/dashboard', [AuthController::class, 'dashboard']);
$app->router->get('/customer/settings', [AuthController::class, 'settings']);
$app->router->get('/customer/appointment/appoint', [AuthController::class, 'newAppointments']);
$app->router->post('/customer/appointment/appoint', [AuthController::class, 'newAppointmentsPost']);

$app->router->get('/customer/appointment/getMyAppointments', [AppointmentController::class, 'getMyAppointments']);
$app->router->get('/customer/appointment/my_appointment', [AppointmentController::class, 'appointment']);
$app->router->post('/customer/appointment/update', [AppointmentController::class, 'updateAppointment']);
$app->router->post('/customer/appointment/delete', [app\controllers\AppointmentController::class, 'deleteAppointment']);
$app->router->get('/customer/warrenty', [WarrentyController::class, 'actionIndex']);


// $app->router->post('/customer/vehicle/register', [VehicleController::class, 'addVehiclePost']);
//$app->router->get('/customer/vehicle/all', [AuthController::class, 'viewAllVehicle']);
$app->router->get('/customer/vehicle/all', [VehicleController::class, 'viewAllVehicle']);

$app->router->get('/customer/vehicle/my', [VehicleController::class, 'viewMyVehicleDetails']);
$app->router->post('/customer/vehicle/update', [VehicleController::class, 'updateVehicle']);
$app->router->post('/customer/vehicle/delete', [VehicleController::class, 'deleteVehicle']);


//Vehicle/Service History
$app->router->get('/customer/appointment/service_history_customer', [ServicePerformController::class, 'viewServicePerformanceCustomer']);

$app->router->post('/customer/appointment/vehicle_service_history', [ServicePerformController::class, 'viewVehicleServiceHistory']);
$app->router->get('/customer/appointment/get_vehicle_service_history', [ServicePerformController::class, 'getVehicleServiceHistory']);



$app->router->get('/customer/vehicle/register', [AuthController::class, 'addVehicle']);
$app->router->post('/customer/vehicle/register', [AuthController::class, 'addVehiclePost']);

$app->router->get('/customer/vehicle/service_history', [AuthController::class, 'vehicleServiceHistory']);
$app->router->get('/customer/appointment/my_appointment', [AuthController::class, 'appointments']);
$app->router->get('/customer/vehicleTransfer/transfer', [AuthController::class, 'transferVehicle']);
$app->router->get('/customer/vehicleTransfer/instruction', [AuthController::class, 'transferInstructions']);
$app->router->get('/customer/appointment/service_history', [AuthController::class, 'serviceHistory']);
$app->router->get('/customer/appointment/spareparts_warranty', [AuthController::class, 'sparepartsWarranty']);

// Spare Part
$app->router->get('/customer/sparepart/add_sparepart', [AuthController::class, 'newSparePart']);
$app->router->post('/customer/sparepart/add_sparepart', [SparePartController::class, 'addSparePartCustomer']);
$app->router->get('/customer/sparepart/getMySpareParts', [SparePartController::class, 'getMySpareParts']);
$app->router->get('/customer/sparepart/edit_sparepart', [SparePartController::class, 'editSparepartPostCustomer']);
$app->router->post('/customer/sparepart/edit_sparepart', [SparePartController::class, 'editSparepartPostCustomer']);
$app->router->get('/customer/sparepart/delete_sparepart', [SparePartController::class, 'deleteSparepartPostCustomer']);
$app->router->post('/customer/sparepart/delete_sparepart', [SparePartController::class, 'deleteSparepartPostCustomer']);

//$app->router->post('/customer/sparepart/add_sparepart', [AuthController::class, 'newSparepartPost']);
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

$app->router->get('/garage/appointment/search', [GarageController::class, 'searchAppointments']);
$app->router->get('/garage/appointment/delete', [GarageController::class, 'deleteAppointment']);
$app->router->post('/garage/appointment/delete', [AuthController::class, 'updateAppointmentStatus']);
$app->router->get('/garage/services/view', [GarageController::class, 'viewServices']);
$app->router->get('/garage/services/add', [GarageController::class, 'addServices']);
$app->router->post('/garage/services/add', [GarageController::class, 'addServicesPost']);
$app->router->get('/garage/services/update', [GarageController::class, 'editServices']);
$app->router->post('/garage/services/update', [GarageController::class, 'updateService']);
$app->router->get('/garage/services/delete', [GarageController::class, 'deleteServices']);
$app->router->post('/garage/services/delete', [GarageController::class, 'markServiceDeleted']);
$app->router->get('/garage/services/search', [GarageController::class, 'getService']);
$app->router->get('/garage/customers/view', [GarageController::class, 'viewCustomers']);
$app->router->get('/garage/customers/search', [GarageController::class, 'searchCustomer']);
$app->router->post('/garage/profile/update', [GarageController::class, 'updateProfile']);
$app->router->get('/garage/mechanic/add', [GarageController::class, 'addMechanic']);
$app->router->post('/garage/mechanic/add', [GarageController::class, 'addMechanicPost']);
$app->router->get('/garage/mechanic/manage', [GarageController::class, 'manageMechanic']);


$app->router->get('/appointment/getServices', [SiteController::class, 'getServices']);

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

$app->router->get('/api/garage/getCustomers', [GarageController::class, 'getCustomers']);
$app->router->get('/api/garage/getAppointments', [GarageController::class, 'getAppointments']);
$app->router->get('/api/garage/getAppointmentsFiltered', [GarageController::class, 'filteredAppointments']);
$app->router->get('/api/garage/getServices', [GarageController::class, 'getServices']);
$app->router->get('/api/garage/getCustomerVehicles', [GarageController::class, 'getCustomerVehicles']);



//mechanic

// $app->router->get('/mechanic', [SiteController::class, 'mechanic']);
$app->router->get('/mechanic/register', [AuthController::class, 'mechanicSignup']);
$app->router->post('/mechanic/register', [AuthController::class, 'mechanicSignup']);
$app->router->get('/mechanic/login', [AuthController::class, 'mechanicLogin']);
$app->router->post('/mechanic/login', [AuthController::class, 'mechanicLogin']);
$app->router->get('/mechanic/dashboard', [AuthController::class, 'dashboard']);
$app->router->get('/mechanic/services/viewService', [AuthController::class, 'viewServicesByMechanic']);
$app->router->post('/mechanic/services/viewService', [\app\controllers\AuthController::class, 'viewServicesByMechanic']);
$app->router->get('/mechanic/services/addService', [AuthController::class, 'assignMechanicService']);
$app->router->post('/mechanic/services/addService', [AuthController::class, 'assignMechanicService']);
$app->router->get('/mechanic/services/loadAppointments', [AuthController::class, 'loadAppointments']);
$app->router->get('/mechanic/services/loadServiceAssignments', [AuthController::class, 'loadServiceAssignments']);
$app->router->get('/mechanic/services/editService', [SiteController::class, 'editServices']);
$app->router->post('/mechanic/services/editService', [SiteController::class, 'editServices']);
$app->router->get('/mechanic/services/deleteService', [SiteController::class, 'deleteServices']);
$app->router->post('/mechanic/services/deleteService', [SiteController::class, 'markServiceDeleted']);
$app->router->get('/mechanic/services/search', [AuthController::class, 'getService']);
$app->router->get('/mechanic/profile', [AuthController::class, 'myProfile']);
$app->router->post('/mechanic/profile/update', [AuthController::class, 'updateProfile']);
$app->router->get('/mechanic/services', [SiteController::class, 'mechanicservices']);
$app->router->get('/mechanic/sparepart/addNew', [MechanicController::class, 'mechanicSparePartAddNew']);
$app->router->post('/mechanic/sparepart/addNew', [AuthController::class, 'mechanicSparePartAddNewPost']);
$app->router->get('/mechanic/sparepart/viewAll', [AuthController::class, 'mechanicSparePartViewAll']);
$app->router->get('/mechanic/messages', [AuthController::class, 'MechanicSendMessages']);
$app->router->get('/mechanic/settings', [AuthController::class, 'settings']);
$app->router->get('/mechanic/serviceHistory', [AuthController::class, 'mechanicServiceHistory']);
$app->router->get('/mechanic/serviceHistory/viewAll', [AuthController::class, 'mechanicServiceHistory']);
$app->router->get('/mechanic/serviceHistory/edit', [AuthController::class, 'mechanicServiceHistoryEdit']);
$app->router->get('/mechanic/serviceHistory/editService', [AuthController::class, 'mechanicServiceHistorySearch']);
$app->router->post('/mechanic/serviceHistory/update', [AuthController::class, 'updateServiceHistory']);
$app->router->post('/mechanic/serviceHistory/deleteConfirm', [AuthController::class, 'mechanicServiceHistoryDeleteConfirm']);
$app->router->get('/mechanic/serviceHistory/delete', [AuthController::class, 'mechanicServiceHistoryDelete']);

$app->run();
