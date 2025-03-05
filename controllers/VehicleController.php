<?php

namespace app\controllers;

use app\models\Garage;
use app\models\User;

use app\models\Vehicle;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use gearguard\phpmvc\db\DbModel;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\Response;

class VehicleController extends Controller
{
	public static function isCustomer(): bool
	{
		if (Application::$app->user instanceof User && Application::$app->session->get('isCustomer')) {
			return true;
		}

		return false;
	}

	public function __construct()
	{
		$this->registerMiddleware(new ExtendedMiddleware([], self::isCustomer()));
		$this->setLayout('customer_layout');
	}

	/**
	 * @throws NotFoundException
	 */
	public function addVehiclePost(Request $request, Response $response)
	{
		// if (Application::$app->user instanceof User) {
		// 	$data = $request->getBody(); // Assuming your framework provides this method
		// 	$engine_no = $data['engine_no'] ?? null;
		// 	$vin = $data['vin'] ?? null;
		// 	$model_id = $data['model_id'] ?? 0;
		// 	$license_plate_no = $data['license_plate_no'] ?? null;
		// 	$class_id = $data['class_id'] ?? 0;
		// 	$engine_capacity_id = $data['engine_capacity_id'] ?? 0;
		// 	$fuel_type_id = $data['fuel_type_id'] ?? 0;
		// 	$bodytype_id = $data['bodytype_id'] ?? 0;
		// 	$insurance_no = $data['insurance_no'] ?? '';
		// 	$year_manufactured = $data['year_manufactured'] ?? '';

		// 	// Now pass it safely to initialize()
		// 	$vehicle = Vehicle::initialize([
		// 		'vin' => $vin,
		// 		'model_id' => $model_id,
		// 		'license_plate_no' => $license_plate_no,
		// 		'class_id' => $class_id,
		// 		'engine_capacity_id' => $engine_capacity_id,
		// 		'fuel_type_id' => $fuel_type_id,
		// 		'bodytype_id' => $bodytype_id,
		// 		'insurance_no' => $insurance_no,
		// 		'current_user_id' => (int) Application::$app->user->primaryKey(),
		// 		'status_id' => Vehicle::STATUS_ACTIVE,
		// 		'engine_no' => $engine_no,
		// 		'year_manufactured' => $year_manufactured,
		// 	]);

		// 	if ($vehicle->save()) {
		// 		$response->redirect('/vehicles');
		// 		echo "Vehicle added successfully";
		// 		return;
		// 	} else {
		// 		// Log detailed error message

		// 		echo "Failed to save vehicle. Please check your input and try again.";
		// 	}
		// }
		// throw new NotFoundException();
		if (Application::$app->user instanceof Vehicle) {
			$body = $request->getBody();
			$model = Vehicle::initialize(
				$body['vin'],
				$body['engine_no'],
				$body['license_plate_no'],
				$body['year_manufactured'],
				$body['model_id'],
				$body['class_id'],
				$body['engine_capacity_id'],
				$body['fuel_type_id'],
				$body['bodytype_id'],
				$body['insurance_no'],
				$body['current_user_id'],
				$body['status_id'],
			);
			$model->save();
			return $this->render('customer/vehicle/all', [
				'name' => 'The GearGuard',

			]);
		}

		throw new NotFoundException();
	}
	public function viewAllVehicle(Request $request, Response $response)
	{
	
	}
}
