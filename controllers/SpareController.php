<?php

namespace app\controllers;

use app\models\MechanicSparePart;
use app\models\Vehicle;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\Response;

class SpareController extends Controller
{
    public function addNew(Request $request, Response $response)
    {
        if ($request->isGet()) {
            // Render the add new spare part form
            return $this->render('mechanic/sparepart/addNew', [
                'errors' => []
            ]);
        }

        if ($request->isPost()) {
            $body = $request->getBody();

            $errors = [];

            // Validate required fields
            $requiredFields = [
                'Vehicle', 'serial_no', 'type', 'manufacturer', 'price', 'manufactured_date', 'waranty_period'
            ];

            foreach ($requiredFields as $field) {
                if (empty($body[$field])) {
                    $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
                }
            }

            // Check if vehicle exists by license_plate_no
            $vehicle = null;
            if (!empty($body['Vehicle'])) {
                $vehicle = Vehicle::findOne(['license_plate_no' => $body['Vehicle']]);
                if (!$vehicle) {
                    $errors['Vehicle'][] = 'Vehicle with license plate number "' . htmlspecialchars($body['Vehicle']) . '" does not exist.';
                }
            }

            if (!empty($errors)) {
                // Render form with errors
                return $this->render('mechanic/sparepart/addNew', [
                    'errors' => $errors
                ]);
            }

            // Create new SparePart model and load data
            $sparePart = new MechanicSparePart();
            $sparePart->serial_no = $body['serial_no'];
            $sparePart->type = $body['type'];
            $sparePart->manufacturer = $body['manufacturer'];
            $sparePart->price = $body['price'];
            $sparePart->manufactured_date = $body['manufactured_date'];
            $sparePart->waranty_period = $body['waranty_period'];
            $sparePart->vehicle_license_plate_no = $body['Vehicle'];
            $sparePart->status_id = MechanicSparePart::STATUS_ACTIVE;

            if (!$sparePart->validate()) {
                $errors = $sparePart->errors;
                return $this->render('mechanic/sparepart/addNew', [
                    'errors' => $errors
                ]);
            }

            if ($sparePart->save()) {
                // Render addNew with success message instead of redirect
                $success = 'Spare part added successfully.';
                return $this->render('mechanic/sparepart/addNew', [
                    'errors' => [],
                    'success' => $success
                ]);
            } else {
                $errors['save'][] = 'Failed to save spare part. Please try again.';
                return $this->render('mechanic/sparepart/addNew', [
                    'errors' => $errors
                ]);
            }
        }
    }

    public function viewAll(Request $request, Response $response)
    {
        $db = \gearguard\phpmvc\Application::$app->db;

        $sql = "
            SELECT 
                sp.id,
                sp.serial_no,
                sp.type,
                sp.manufacturer,
                sp.price,
                sp.manufactured_date,
                sp.waranty_period,
                svi.installed_date,
                v.license_plate_no,
                v.id AS vehicle_id,
                uo.user_id
            FROM gg_sparepart sp
            JOIN gg_sparepart_service_vehicle_install svi ON sp.id = svi.sparepart_id
            JOIN gg_vehicle v ON svi.vehicle_id = v.id
            LEFT JOIN gg_user_owner uo ON v.id = uo.vehicle_id
            WHERE sp.status_id = :status_active
        ";

        $statement = $db->prepare($sql);
        $statement->bindValue(':status_active', \app\models\MechanicSparePart::STATUS_ACTIVE);
        $statement->execute();
        $spareParts = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $success = null;
        if (isset($_GET['success']) && $_GET['success'] == '1') {
            $success = 'Spare part added successfully.';
        }

        return $this->render('mechanic/sparepart/viewAll', [
            'spareParts' => $spareParts,
            'success' => $success
        ]);
    }

    public function updateSparePart(Request $request, Response $response)
    {
        if (!$request->isPost()) {
            $response->setStatusCode(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $body = json_decode(file_get_contents('php://input'), true);

        $requiredFields = [
            'id', 'vehicle', 'serial_no', 'type', 'manufacturer', 'price', 'manufactured_date', 'waranty_period'
        ];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($body[$field])) {
                $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
            }
        }

        if (!empty($errors)) {
            $response->setStatusCode(400);
            echo json_encode(['errors' => $errors]);
            return;
        }

        $sparePart = MechanicSparePart::findOne(['id' => $body['id']]);
        if (!$sparePart) {
            $response->setStatusCode(404);
            echo json_encode(['error' => 'Spare part not found']);
            return;
        }

        // Check if vehicle exists by license_plate_no
        $vehicle = null;
        if (!empty($body['vehicle'])) {
            $vehicle = \app\models\Vehicle::findOne(['license_plate_no' => $body['vehicle']]);
            if (!$vehicle) {
                $response->setStatusCode(400);
                echo json_encode(['error' => 'Vehicle with license plate number "' . htmlspecialchars($body['vehicle']) . '" does not exist.']);
                return;
            }
        }

        $sparePart->vehicle_license_plate_no = $body['vehicle'];
        $sparePart->serial_no = $body['serial_no'];
        $sparePart->type = $body['type'];
        $sparePart->manufacturer = $body['manufacturer'];
        $sparePart->price = $body['price'];
        $sparePart->manufactured_date = $body['manufactured_date'];
        $sparePart->waranty_period = $body['waranty_period'];

        if (!$sparePart->validate()) {
            $response->setStatusCode(400);
            echo json_encode(['errors' => $sparePart->errors]);
            return;
        }

        if ($sparePart->update()) {
            echo json_encode(['success' => true]);
        } else {
            $response->setStatusCode(500);
            echo json_encode(['error' => 'Failed to update spare part']);
        }
    }

    public function deleteSparePart(Request $request, Response $response)
    {
        if (!$request->isPost()) {
            $response->setStatusCode(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $body = json_decode(file_get_contents('php://input'), true);
        if (empty($body['id'])) {
            $response->setStatusCode(400);
            echo json_encode(['error' => 'ID is required']);
            return;
        }

        $sparePart = MechanicSparePart::findOne(['id' => $body['id']]);
        if (!$sparePart) {
            $response->setStatusCode(404);
            echo json_encode(['error' => 'Spare part not found']);
            return;
        }

        if ($sparePart->delete()) {
            echo json_encode(['success' => true]);
        } else {
            $response->setStatusCode(500);
            echo json_encode(['error' => 'Failed to delete spare part']);
        }
    }
}
