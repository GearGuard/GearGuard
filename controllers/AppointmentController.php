<?php
	
	namespace app\controllers;
	
	use gearguard\phpmvc\Application;
	
	class AppointmentController extends Controller
	{
		private function getAppointment()
		{
			$sql = 'SELECT id, name FROM gg_garage WHERE status_id = 1'; // Assuming 2 is the status for active garages
			$statement = Application::$app->db->prepare($sql);
			$statement->execute();
			return $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
		}
	}
