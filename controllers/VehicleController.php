<?php

namespace app\controllers;

use app\models\User;
use app\models\Vehicle;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\Response;

class VehicleController extends Controller
{
	public static function isCustomer(): bool
	{
		return Application::$app->user instanceof User && Application::$app->session->get('isCustomer');
	}

	public function __construct()
	{
		$this->registerMiddleware(new ExtendedMiddleware([], self::isCustomer()));
	}

	/**
	 * @throws NotFoundException
	 */
	/**
	 * Show vehicle registration form
	 */
	public function addVehicle(Request $request, Response $response)
	{
		if (!(Application::$app->user instanceof User)) {
			throw new NotFoundException();
		}

		$model = new Vehicle();

		// Get dropdown data from database
		$fuelTypes = $this->getFuelTypes();
		$vehicleTypes = $this->getVehicleTypes();
		$bodyTypes = $this->getBodyTypes();
		$engineCapacities = $this->getEngineCapacities();
		$vehicleClasses = $this->getVehicleClasses();

		return $this->render('customer/vehicle/register', [
			'model' => $model,
			'fuelTypes' => $fuelTypes,
			'vehicleTypes' => $vehicleTypes,
			'bodyTypes' => $bodyTypes,
			'engineCapacities' => $engineCapacities,
			'vehicleClasses' => $vehicleClasses
		]);
	}

	/**
	 * Process vehicle registration form submission
	 * @throws NotFoundException
	 */
	public function addVehiclePost(Request $request, Response $response)
	{
		// save vehicle data to database
		if (!(Application::$app->user instanceof User)) {
			throw new NotFoundException();
		}
		$data = $request->getBody();
		$vehicle = new Vehicle();
		$vehicle->loadData($data);

		$vehicle->status_id = Vehicle::STATUS_ACTIVE;
		$vehicle->model_id = $data['model_id'] ?? null;
		$vehicle->fuel_type_id = $data['fuel_type_id'] ?? null;
		$vehicle->vehicle_type_id = $data['vehicle_type_id'] ?? null;
		$vehicle->bodytype_id = $data['bodytype_id'] ?? null;
		$vehicle->engine_capacity_id = $data['engine_capacity_id'] ?? null;
		$vehicle->class_id = $data['class_id'] ?? null;
		$vehicle->license_plate_no = $data['license_plate_no'] ?? null;
		$vehicle->insurance_no = $data['insurance_no'] ?? null;


		// Validate vehicle data
		if (!$vehicle->validate()) {
			Application::$app->session->setFlash('error', 'Please fill in all required fields.');
			return $this->redirectToVehicleForm($response, $data, $vehicle);
		}
		// Check if vehicle already exists
		$stmt = Application::$app->db->prepare('SELECT COUNT(*) FROM gg_vehicle WHERE license_plate_no = :license_plate_no AND status_id = :status_id');
		$stmt->bindValue(':license_plate_no', $vehicle->license_plate_no);
		$stmt->bindValue(':status_id', Vehicle::STATUS_ACTIVE);
		$stmt->execute();

		$vehicleExists = $stmt->fetchColumn() > 0;
		if ($vehicleExists) {
			Application::$app->session->setFlash('error', 'Vehicle with this license plate number already exists.');
			return $this->redirectToVehicleForm($response, $data, $vehicle);
		}
		// Insert vehicle data into database
		$stmt = Application::$app->db->prepare('
			INSERT INTO gg_vehicle (user_id, model_id, fuel_type_id, vehicle_type_id, bodytype_id, engine_capacity_id, class_id, license_plate_no, insurance_no, status_id, created_at, updated_at)
			VALUES (:user_id, :model_id, :fuel_type_id, :vehicle_type_id, :bodytype_id, :engine_capacity_id, :class_id, :license_plate_no, :insurance_no, :status_id, :created_at, :updated_at)
		');

		$stmt->bindValue(':model_id', $vehicle->model_id);
		$stmt->bindValue(':fuel_type_id', $vehicle->fuel_type_id);
		$stmt->bindValue(':vehicle_type_id', $vehicle->vehicle_type_id);
		$stmt->bindValue(':bodytype_id', $vehicle->bodytype_id);
		$stmt->bindValue(':engine_capacity_id', $vehicle->engine_capacity_id);
		$stmt->bindValue(':class_id', $vehicle->class_id);
		$stmt->bindValue(':license_plate_no', $vehicle->license_plate_no);
		$stmt->bindValue(':insurance_no', $vehicle->insurance_no);
		$stmt->bindValue(':status_id', $vehicle->status_id);

		$stmt->execute();
		$stmt->closeCursor();

		// Get the last inserted vehicle ID
		$vehicleId = Application::$app->db->pdo->lastInsertId();
		if ($vehicleId) {
			// Insert into gg_user_owner table
			$stmt = Application::$app->db->prepare('
				INSERT INTO gg_user_owner (user_id, vehicle_id, registration_date)
				VALUES (:user_id, :vehicle_id, NOW())
			');

			$stmt->bindValue(':vehicle_id', $vehicleId);
			$stmt->execute();
			Application::$app->session->setFlash('success', 'Vehicle registered successfully!');
		} else {
			Application::$app->session->setFlash('error', 'Failed to register vehicle. Please try again.');
		}
		$response->redirect('/customer/vehicle/all');
		return;
	}

	/**
	 * Helper method to redirect back to vehicle form with data
	 */
	private function redirectToVehicleForm(Response $response, array $data, ?Vehicle $model = null)
	{
		if (!$model) {
			$model = new Vehicle();
			foreach ($data as $key => $value) {
				if (property_exists($model, $key)) {
					$model->{$key} = $value;
				}
			}

			// Handle model name separately
			if (isset($data['model'])) {
				$model->model = $data['model'];
			}
		}

		// Get dropdown data from database
		$fuelTypes = $this->getFuelTypes();
		$vehicleTypes = $this->getVehicleTypes();
		$bodyTypes = $this->getBodyTypes();
		$engineCapacities = $this->getEngineCapacities();
		$vehicleClasses = $this->getVehicleClasses();

		return $this->render('customer/vehicle/register', [
			'model' => $model,
			'fuelTypes' => $fuelTypes,
			'vehicleTypes' => $vehicleTypes,
			'bodyTypes' => $bodyTypes,
			'engineCapacities' => $engineCapacities,
			'vehicleClasses' => $vehicleClasses
		]);
	}

	/**
	 * Get fuel types for dropdown
	 */
	private function getFuelTypes()
	{
		$stmt = Application::$app->db->prepare('SELECT id, fueltype FROM gg_vehicle_fueltype');
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	/**
	 * Get vehicle types for dropdown
	 */
	private function getVehicleTypes()
	{
		$stmt = Application::$app->db->prepare('SELECT id, type FROM gg_vehicle_type');
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	/**
	 * Get body types for dropdown
	 */
	private function getBodyTypes()
	{
		$stmt = Application::$app->db->prepare('SELECT id, bodytype FROM gg_vehicle_bodytype');
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	/**
	 * Get engine capacities for dropdown
	 */
	private function getEngineCapacities()
	{
		$stmt = Application::$app->db->prepare('SELECT id, capacity FROM gg_vehicle_engine_capacity');
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	/**
	 * Get vehicle classes for dropdown
	 */
	private function getVehicleClasses()
	{
		$stmt = Application::$app->db->prepare('SELECT id, class FROM gg_vehicle_class');
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}


	public function viewAllVehicle(Request $request, Response $response)
	{
		if (!(Application::$app->user instanceof User)) {
			throw new NotFoundException();
		}

		$vehicles = $this->getOwnedVehiclesList(Application::$app->user->id);
		return $this->render('customer/vehicle/viewAll', [
			'name' => 'The GearGuard',
			'vehicles' => $vehicles
		]);
	}

	public function getOwnedVehiclesList($userId)
	{
		$stmt = Application::$app->db->prepare('
            SELECT v.*, vm.model as model_name, vf.fueltype as fuel_type, 
                   vc.class as vehicle_class, vt.type as vehicle_type,
                   ve.capacity as engine_capacity, vb.bodytype as body_type,
                   uo.registration_date as bought_date, u.nic
            FROM gg_vehicle v
            INNER JOIN gg_user_owner uo ON v.id = uo.vehicle_id
            INNER JOIN gg_user u ON uo.user_id = u.id
            LEFT JOIN gg_vehicle_model vm ON v.model_id = vm.id
            LEFT JOIN gg_vehicle_fueltype vf ON v.fuel_type_id = vf.id
            LEFT JOIN gg_vehicle_class vc ON v.class_id = vc.id
            LEFT JOIN gg_vehicle_type vt ON v.vehicle_type_id = vt.id
            LEFT JOIN gg_vehicle_engine_capacity ve ON v.engine_capacity_id = ve.id
            LEFT JOIN gg_vehicle_bodytype vb ON v.bodytype_id = vb.id
            WHERE uo.user_id = :userId AND v.status_id = :status_id
        ');
		$stmt->bindValue(':userId', $userId);
		$stmt->bindValue(':status_id', Vehicle::STATUS_ACTIVE);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	public function viewMyVehicleDetails(Request $request, Response $response)
	{
		if (!(Application::$app->user instanceof User)) {
			throw new NotFoundException();
		}

		$current_user_id = Application::$app->user->id;
		$vehicles = $this->getOwnedVehiclesList($current_user_id);

		return $this->render('customer/vehicle/viewMyDetails', [
			'vehicles' => $vehicles
		]);
	}

	/**
	 * Get vehicle data for editing
	 */
	public function getVehicleData(Request $request, Response $response)
	{
		if (!(Application::$app->user instanceof User)) {
			throw new NotFoundException();
		}

		$vehicleId = $request->getBody()['id'] ?? null;

		if (!$vehicleId) {
			Application::$app->session->setFlash('error', 'Vehicle ID is required');
			$response->redirect('/customer/vehicle/my');
			return;
		}

		// Get vehicle details
		$stmt = Application::$app->db->prepare('
            SELECT v.*, vm.model as model_name, vf.fueltype as fuel_type
            FROM gg_vehicle v
            INNER JOIN gg_user_owner uo ON v.id = uo.vehicle_id
            LEFT JOIN gg_vehicle_model vm ON v.model_id = vm.id
            LEFT JOIN gg_vehicle_fueltype vf ON v.fuel_type_id = vf.id
            WHERE v.id = :vehicleId AND uo.user_id = :userId
        ');
		$stmt->bindValue(':vehicleId', $vehicleId);
		$stmt->bindValue(':userId', Application::$app->user->id);
		$stmt->execute();
		$vehicle = $stmt->fetch(\PDO::FETCH_OBJ);

		if (!$vehicle) {
			Application::$app->session->setFlash('error', 'Vehicle not found or you do not have permission to edit it');
			$response->redirect('/customer/vehicle/my');
			return;
		}

		// Get fuel types for dropdown
		$fuelTypesStmt = Application::$app->db->prepare('SELECT id, fueltype FROM gg_vehicle_fueltype');
		$fuelTypesStmt->execute();
		$fuelTypes = $fuelTypesStmt->fetchAll(\PDO::FETCH_OBJ);

		// Store vehicle data in session for the edit form
		Application::$app->session->set('edit_vehicle', [
			'id' => $vehicle->id,
			'model_name' => $vehicle->model_name,
			'license_plate_no' => $vehicle->license_plate_no,
			'insurance_no' => $vehicle->insurance_no,
			'fuel_type_id' => $vehicle->fuel_type_id,
			'fuel_types' => $fuelTypes
		]);

		// Redirect back to the edit form
		$response->redirect('/customer/vehicle/edit/' . $vehicleId);
	}

	/**
	 * Show edit form
	 */
	public function editVehicle(Request $request, Response $response)
	{
		if (!(Application::$app->user instanceof User)) {
			throw new NotFoundException();
		}

		$vehicleId = $request->getRouteParam('id');
		if (!$vehicleId) {
			Application::$app->session->setFlash('error', 'Vehicle ID is required');
			$response->redirect('/customer/vehicle/my');
			return;
		}

		// Get vehicle details
		$stmt = Application::$app->db->prepare('
            SELECT v.*, vm.model as model_name, vf.fueltype as fuel_type
            FROM gg_vehicle v
            INNER JOIN gg_user_owner uo ON v.id = uo.vehicle_id
            LEFT JOIN gg_vehicle_model vm ON v.model_id = vm.id
            LEFT JOIN gg_vehicle_fueltype vf ON v.fuel_type_id = vf.id
            WHERE v.id = :vehicleId AND uo.user_id = :userId
        ');
		$stmt->bindValue(':vehicleId', $vehicleId);
		$stmt->bindValue(':userId', Application::$app->user->id);
		$stmt->execute();
		$vehicle = $stmt->fetch(\PDO::FETCH_OBJ);

		if (!$vehicle) {
			Application::$app->session->setFlash('error', 'Vehicle not found or you do not have permission to edit it');
			$response->redirect('/customer/vehicle/my');
			return;
		}

		// Get fuel types for dropdown
		$fuelTypesStmt = Application::$app->db->prepare('SELECT id, fueltype FROM gg_vehicle_fueltype');
		$fuelTypesStmt->execute();
		$fuelTypes = $fuelTypesStmt->fetchAll(\PDO::FETCH_OBJ);

		return $this->render('customer/vehicle/edit', [
			'vehicle' => $vehicle,
			'fuelTypes' => $fuelTypes
		]);
	}

	/**
	 * Update vehicle
	 */
	public function updateVehicle(Request $request, Response $response)
	{
		if (!(Application::$app->user instanceof User)) {
			throw new NotFoundException();
		}

		$data = $request->getBody();
		$vehicleId = $data['id'] ?? null;
		$current_user_id = Application::$app->user->id;

		if (!$vehicleId) {
			Application::$app->session->setFlash('error', 'Vehicle ID is required');
			$response->redirect('/customer/vehicle/all');
			return;
		}

		// Verify ownership
		$ownershipStmt = Application::$app->db->prepare('
        SELECT COUNT(*) FROM gg_user_owner 
        WHERE vehicle_id = :vehicleId AND user_id = :userId
    ');
		$ownershipStmt->bindValue(':vehicleId', $vehicleId);
		$ownershipStmt->bindValue(':userId', $current_user_id);
		$ownershipStmt->execute();

		if ($ownershipStmt->fetchColumn() == 0) {
			Application::$app->session->setFlash('error', 'You do not have permission to edit this vehicle');
			$response->redirect('/customer/vehicle/all');
			return;
		}

		// Get current vehicle data
		$vehicleStmt = Application::$app->db->prepare('
        SELECT * FROM gg_vehicle WHERE id = :vehicleId
    ');
		$vehicleStmt->bindValue(':vehicleId', $vehicleId);
		$vehicleStmt->execute();
		$vehicleData = $vehicleStmt->fetch(\PDO::FETCH_ASSOC);

		if (!$vehicleData) {
			Application::$app->session->setFlash('error', 'Vehicle not found');
			$response->redirect('/customer/vehicle/all');
			return;
		}

		// Update vehicle data
		$updateStmt = Application::$app->db->prepare('
        UPDATE gg_vehicle SET 
            license_plate_no = :license_plate_no,
            insurance_no = :insurance_no,
            fuel_type_id = :fuel_type_id
        WHERE id = :id
    ');

		$updateStmt->bindValue(':license_plate_no', $data['license_plate_no'] ?? $vehicleData['license_plate_no']);
		$updateStmt->bindValue(':insurance_no', $data['insurance_no'] ?? $vehicleData['insurance_no']);
		$updateStmt->bindValue(':fuel_type_id', $data['fuel_type_id'] ?? $vehicleData['fuel_type_id']);
		$updateStmt->bindValue(':id', $vehicleId);

		if ($updateStmt->execute()) {
			Application::$app->session->setFlash('success', 'Vehicle updated successfully!');
		} else {
			Application::$app->session->setFlash('error', 'Failed to update vehicle. Please try again.');
		}

		$response->redirect('/customer/vehicle/all');
	}

	/**
	 * Delete vehicle
	 */
	public function deleteVehicle(Request $request, Response $response)
	{
		if (!(Application::$app->user instanceof User)) {
			throw new NotFoundException();
		}

		$data = $request->getBody();
		$vehicleId = $data['id'] ?? null;
		$current_user_id = Application::$app->user->id;

		if (!$vehicleId) {
			Application::$app->session->setFlash('error', 'Vehicle ID is required');
			$response->redirect('/customer/vehicle/all');
			return;
		}

		// Verify ownership
		$ownershipStmt = Application::$app->db->prepare('
        SELECT COUNT(*) FROM gg_user_owner 
        WHERE vehicle_id = :vehicleId AND user_id = :userId
    ');
		$ownershipStmt->bindValue(':vehicleId', $vehicleId);
		$ownershipStmt->bindValue(':userId', $current_user_id);
		$ownershipStmt->execute();

		if ($ownershipStmt->fetchColumn() == 0) {
			Application::$app->session->setFlash('error', 'You do not have permission to delete this vehicle');
			$response->redirect('/customer/vehicle/all');
			return;
		}

		// Soft delete by updating status
		$deleteStmt = Application::$app->db->prepare('
        UPDATE gg_vehicle SET status_id = :status_id WHERE id = :id
    ');
		$deleteStmt->bindValue(':status_id', Vehicle::STATUS_DELETED);
		$deleteStmt->bindValue(':id', $vehicleId);

		if ($deleteStmt->execute()) {
			Application::$app->session->setFlash('success', 'Vehicle deleted successfully!');
		} else {
			Application::$app->session->setFlash('error', 'Failed to delete vehicle. Please try again.');
		}

		$response->redirect('/customer/vehicle/all');
	}
}
