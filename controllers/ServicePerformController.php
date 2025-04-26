<?php

namespace app\controllers;

use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\Response;

class ServicePerformController extends Controller
{
    public function viewServicePerformanceCustomer()
    {
        $userId = Application::$app->user->id ?? null;
        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        try {
            $sql = "
           SELECT vst.id,
    v.license_plate_no AS 'Vehicle Number Plate',  cost AS 'Service Cost',
    DATE(vst.begin_timestamp) AS 'Service Date', 
    g.name AS 'Garage Name', 
    CONCAT(gm.first_name, ' ', IFNULL(gm.last_name, '')) AS 'Mechanic Name',
    TIMEDIFF(vst.end_timestamp, vst.begin_timestamp) AS 'Service Duration', 
    vst.notes AS 'Service Notes' 
FROM gg_vehicle_service_take vst 
JOIN gg_vehicle v ON vst.vehicle_id = v.id 
JOIN gg_garage_mechanic gm ON vst.mechanic_id = gm.id 
JOIN gg_garage g ON gm.garage_id = g.id 
JOIN gg_user_owner uo ON v.id = uo.vehicle_id 
WHERE uo.user_id = :userId 
ORDER BY vst.begin_timestamp DESC



            ";

            $stmt = Application::$app->db->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();

            $history = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            echo json_encode($history);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'error'   => 'Failed to fetch details',
                'details' => $e->getMessage()
            ]);
        }
    }

    public function deleteServicePerformance(Request $request, Response $response)
    {
        // Extract the ID from the request parameters or body
        $id = $request->getBody()['id'] ?? null;

        // Validate the ID
        if (!$id || !is_numeric($id)) {
            $response->setStatusCode(400);
            echo json_encode(['success' => false, 'message' => 'Invalid Service ID']);
            exit;
        }
        try {
            $sql = "DELETE FROM gg_vehicle_service_take WHERE id = :id ";
            $stmt = Application::$app->db->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

            if ($stmt->execute()) {
                Application::$app->response->redirect('/customer/appointment/service_history');
            } else {
                $response->setStatusCode(500);
                echo json_encode(['success' => false, 'message' => 'Failed to cancel appointment']);
            }
        } catch (\PDOException $e) {
            error_log('Error deleting Service Performed: ' . $e->getMessage());
            $response->setStatusCode(500);
            echo json_encode(['success' => false, 'message' => 'Database error occurred']);
        }
    }
}
