<?php

namespace app\controllers;

use app\models\SparePart;
use app\models\User;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\exception\NotFoundException;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\Response;

class SparePartController extends Controller
{
	public static function isCustomer(): bool
	{
		if (Application::$app->user instanceof User && Application::$app->session->get('isCustomer')) {
			return true;
		}

		return false;
	}

	public static function isGarage(): bool
	{
		if (Application::$app->user instanceof User && Application::$app->session->get('isGarage')) {
			return true;
		}

		return false;
	}
	public function __construct()
	{
		$this->registerMiddleware(new ExtendedMiddleware([], self::isCustomer()));
	}


	/**
	 * @throws NotFoundException
	 */
	public function addSparePart(Request $request, Response $response)
	{
		if (Application::$app->user instanceof User) {
			$data = $request->getBody();
			$serial_no = $data['serial_no'] ?? '1';
			$type = $data['type'] ?? null;
			$manufacturer = $data['manufacturer'] ?? null;
			$price = $data['price'] ?? null;
			$manufactured_date = $data['manufactured_date'] ?? null;
			$waranty_period = $data['waranty_period'] ?? '';
			$vehicle_id = $data['vehicle_id'] ?? null;
			$installed_date = $data['installed_date'] ?? date('Y-m-d'); // Default to current date

			// Start transaction to ensure data consistency
			Application::$app->db->pdo->beginTransaction();

			try {
				// Create and save spare part
				$sparepart = SparePart::initialize([
					'serial_no' => $serial_no,
					'type' => $type,
					'manufacturer' => $manufacturer,
					'price' => $price,
					'manufactured_date' => $manufactured_date,
					'waranty_period' => $waranty_period,
				]);

				if ($sparepart->save()) {
					// Get the newly inserted spare part ID
					$sparepart_id = Application::$app->db->pdo->lastInsertId();

					// Get the current logged-in user's ID
					$user_id = Application::$app->user->id;

					// Insert record into the installation table
					$sql = "INSERT INTO gg_sparepart_vehicleuser_vehicle_install 
							(vehicle_id, user_id, sparepart_id, installed_date) 
							VALUES (:vehicle_id, :user_id, :sparepart_id, :installed_date)";

					$statement = Application::$app->db->prepare($sql);
					$statement->bindValue(':vehicle_id', $vehicle_id);
					$statement->bindValue(':user_id', $user_id);
					$statement->bindValue(':sparepart_id', $sparepart_id);
					$statement->bindValue(':installed_date', $installed_date);

					if ($statement->execute()) {
						// Commit transaction if everything is successful
						Application::$app->db->pdo->commit();
						$response->redirect('/customer/sparepart/view_sparepart');
						echo 'SparePart added successfully';
						return;
					} else {
						// Rollback if installation record fails
						Application::$app->db->pdo->rollBack();
						echo 'Failed to associate spare part with vehicle. Please try again.';
					}
				} else {
					// Rollback if spare part save fails
					Application::$app->db->pdo->rollBack();
					echo 'Failed to save spare part. Please check your input and try again.';
				}
			} catch (\Exception $e) {
				// Rollback on any exception
				Application::$app->db->pdo->rollBack();
				echo 'An error occurred: ' . $e->getMessage();
			}
		}
		throw new NotFoundException();
	}




	/**
	 * @throws NotFoundException
	 */

	public function getMySpareParts()
	{
		$userId = Application::$app->user->id ?? null;

		if (!$userId) {
			header('Content-Type: application/json');
			echo json_encode([]);
			exit;
		}
		$sql = 'SELECT DISTINCT sp.id, sp.serial_no, sp.type, sp.manufacturer, 
					   sp.price, sp.manufactured_date, sp.waranty_period,
					   COALESCE(svi.installed_date, ssvi.installed_date) as installed_date
				FROM gg_sparepart sp
				LEFT JOIN gg_sparepart_vehicleuser_vehicle_install svi 
					ON sp.id = svi.sparepart_id AND svi.user_id = :user_id
				LEFT JOIN (
					SELECT ssvi.sparepart_id, ssvi.installed_date, v.id as vehicle_id
					FROM gg_sparepart_service_vehicle_install ssvi
					JOIN gg_vehicle v ON ssvi.vehicle_id = v.id
					JOIN gg_user_owner uo ON v.id = uo.vehicle_id
					WHERE uo.user_id = :user_id2
				) ssvi ON sp.id = ssvi.sparepart_id
				WHERE svi.user_id IS NOT NULL OR ssvi.sparepart_id IS NOT NULL';

		$statement = Application::$app->db->prepare($sql);
		$statement->bindValue(':user_id', $userId);
		$statement->bindValue(':user_id2', $userId);
		$statement->execute();
		$spareparts = $statement->fetchAll(\PDO::FETCH_ASSOC);

		header('Content-Type: application/json');
		echo json_encode($spareparts);
		exit;
	}

	public function editSparePart(Request $request, Response $response)
	{
		if (Application::$app->user instanceof User) {
			$data = $request->getBody();
			$id = $data['id'] ?? null;
			$serial_no = $data['serial_no'] ?? '1';
			$type = $data['type'] ?? null;
			$manufacturer = $data['manufacturer'] ?? null;
			$price = $data['price'] ?? null;
			$manufactured_date = $data['manufactured_date'] ?? null;
			$waranty_period = $data['waranty_period'] ?? '';

			$sparepart = SparePart::initialize([
				'id' => $id,
				'serial_no' => $serial_no,
				'type' => $type,
				'manufacturer' => $manufacturer,
				'price' => $price,
				'manufactured_date' => $manufactured_date,
				'waranty_period' => $waranty_period,
			]);
			if ($sparepart->update($data)) {
				echo 'SparePart updated successfully';
				return;
			} else {
				echo 'Failed to update spare part. Please check your input and try again.';
			}
		}
		throw new NotFoundException();
	}

	public function deleteSparePart(Request $request, Response $response)
	{
		if (Application::$app->user instanceof User) {
			$data = $request->getBody();
			$id = $data['id'] ?? null;

			$sparepart = SparePart::initialize([
				'id' => $id,
			]);
			if ($sparepart->delete()) {
				echo 'SparePart deleted successfully';
				return;
			} else {
				echo 'Failed to delete spare part. Please check your input and try again.';
			}
		}
		throw new NotFoundException();
	}
}
