<?php

namespace app\controllers;

use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Application;
use app\models\Appointment;

class AppointmentController extends Controller

{

	public function appointment()
	{
		// Fetch appointments from database or other source
		$appointment = $this->getAllAppointments();

		// Pass data to the view
		return $this->render('myAppointment', [
			'appointment' => $appointment
		]);
	}
	public function getMyAppointments()
	{
		// Get the current user ID
		$userId = Application::$app->user->id ?? null;

		if (!$userId) {
			// Return empty array if user is not logged in
			header('Content-Type: application/json');
			echo json_encode([]);
			exit;
		}

		// Fetch appointments for the current user
		$sql = 'SELECT a.id, a.date, a.time, a.notes, v.license_plate_no, vm.model AS vehicle_model, vman.name AS vehicle_manufacturer, vt.type AS vehicle_type, g.name AS garage_name, gs.type AS service_type, gs.price AS service_price, gs.duration AS service_duration, s.status
		FROM gg_vehicle_service_appointment a JOIN gg_vehicle v ON a.vehicle_id = v.id JOIN gg_vehicle_model vm ON v.model_id = vm.id JOIN gg_vehicle_manufacturer vman ON vm.manufacturer_id = vman.id JOIN gg_vehicle_type vt ON v.vehicle_type_id = vt.id JOIN gg_garage_service gs ON a.service_id = gs.id JOIN gg_garage g ON gs.garage_id = g.id JOIN gg_status s ON a.status_id = s.id JOIN gg_user_owner uo ON v.id = uo.vehicle_id WHERE uo.user_id = :user_id ORDER BY a.date DESC, a.time ASC;';

		$statement = Application::$app->db->prepare($sql);
		$statement->bindValue(':user_id', $userId);
		$statement->execute();
		$appointments = $statement->fetchAll(\PDO::FETCH_ASSOC);

		// Return the appointments as JSON
		header('Content-Type: application/json');
		echo json_encode($appointments);
		exit;
	}
	public function updateAppointment()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $_POST['id'] ?? null;
			$date = $_POST['date'] ?? null;
			$time = $_POST['time'] ?? null;
			$notes = $_POST['notes'] ?? '';

			if (!$id || !$date || !$time) {
				$_SESSION['error'] = 'Missing required fields';
				Application::$app->response->redirect('/customer/appointment/my_appointment');
				return;
			}

			try {
				$sql = 'UPDATE gg_vehicle_service_appointment SET date = :date, time = :time, notes = :notes WHERE id = :id';
				$statement = Application::$app->db->prepare($sql);
				$statement->bindValue(':date', $date);
				$statement->bindValue(':time', $time);
				$statement->bindValue(':notes', $notes);
				$statement->bindValue(':id', $id);

				if ($statement->execute()) {
					$_SESSION['success'] = 'Appointment updated successfully';
				} else {
					$_SESSION['error'] = 'Failed to update appointment';
				}
			} catch (\PDOException $e) {
				error_log('Error updating appointment: ' . $e->getMessage());
				$_SESSION['error'] = 'Database error occurred';
			}

			Application::$app->response->redirect('/customer/appointment/my_appointment');
		}
	}

	public function deleteAppointment($id)
	{
		if (!$id) {
			$_SESSION['error'] = 'Invalid appointment ID';
			Application::$app->response->redirect('/customer/appointment/my_appointment');
			return;
		}

		try {
			$sql = 'DELETE FROM gg_vehicle_service_appointment WHERE id = :id';
			$statement = Application::$app->db->prepare($sql);
			$statement->bindValue(':id', $id);

			if ($statement->execute()) {
				$_SESSION['success'] = 'Appointment cancelled successfully';
			} else {
				$_SESSION['error'] = 'Failed to cancel appointment';
			}
		} catch (\PDOException $e) {
			error_log('Error deleting appointment: ' . $e->getMessage());
			$_SESSION['error'] = 'Database error occurred';
		}

		Application::$app->response->redirect('/customer/appointment/my_appointment');
	}

	public function getAllAppointments()
	{
		$sql = 'SELECT * FROM gg_appointments';
		$statement = Application::$app->db->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}
}
