<?php

namespace app\controllers;

use app\models\SparePart;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\exception\NotFoundException;
use app\models\mechanic;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\Response;

class SpareController extends Controller
{
    public static function isMechanic(): bool
    {
        if (Application::$app->user instanceof User && Application::$app->session->get('isMechanic')) {
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

    public function addSparePart()
    {
        $part = new SparePart();
        $part->loadData(Application::$app->request->getBody());

        if ($part->save()) {
            echo json_encode(['success' => true]);
        } else {
            error_log('Review validation or save failed: ' . json_encode($part->errors));
            echo json_encode(['success' => false, 'errors' => $part->errors]);
        }
    }

    public function getSparePart()
    {
        $parts = SparePart::findAll([]);
        $partData = [];

        foreach ($parts as $part) {
            $partData[] = $part;
        }

        header('Content-Type: application/json');
        echo json_encode($partData);
    }

    
    public function deleteSparepartPostCustomer(Request $request, Response $response)
    {
        $id = $request->getBody()['id'] ?? null;

        
        if (!$id || !is_numeric($id)) {
            $response->setStatusCode(400);
            echo json_encode(['success' => false, 'message' => 'Invalid Spare Part ID']);
            return;
        }

        try {
            // Use the correct table name for your database
            $sql = 'DELETE FROM gg_sparepart_service_vehicle_install WHERE sparepart_id = :sparepart_id';
            $statement = Application::$app->db->prepare($sql);
            $statement->bindValue(':sparepart_id', $id, \PDO::PARAM_INT); // Bind the extracted ID value

            if ($statement->execute()) {
                Application::$app->response->redirect('/mechanic/sparepart/getMySpareParts');
            } else {
                $response->setStatusCode(500);
                echo json_encode(['success' => false, 'message' => 'Failed to cancel Spare Part']);
            }
        } catch (\PDOException $e) {
            error_log('Error deleting Spare Part: ' . $e->getMessage());
            $response->setStatusCode(500);
            echo json_encode(['success' => false, 'message' => 'Database error occurred']);
        }
        error_log('POST data: ' . print_r($_POST, true));
        error_log('Request body: ' . print_r($request->getBody(), true));
    }


    // EDIT SPARE PART (POST)
    public function editSparepartPostCustomer(Request $request, Response $response)
    {
        $id = $request->getBody()['id'] ?? null;
        $data = $request->getBody();

        if (!$id || !is_numeric($id)) {
            $response->setStatusCode(400);
            echo json_encode(['success' => false, 'message' => 'Invalid Spare Part ID']);
            return;
        }

        // Check ownership
        $stmt = Application::$app->db->prepare(
            "SELECT * FROM gg_sparepart_service_vehicle_install WHERE sparepart_id = :sparepart_id AND user_id = :user_id"
        );
        $sparepart_id = $request->getBody()['id'] ?? null; // Extract the spare part ID from the request
        $stmt->bindValue(':sparepart_id', $sparepart_id);
        $user_id = Application::$app->user->id ?? null; // Get the current logged-in user's ID
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        if (!$stmt->fetch()) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }

        $sparePartModel = new SparePart();
        $sparePart = $sparePartModel->findOne(['sparepart_id' => $sparepart_id]);
        if (!$sparePart) {
            echo json_encode(['success' => false, 'error' => 'Not found']);
            return;
        }

        // Update fields
        $sparePart->serial_no = $data['serial_no'] ?? $sparePart->serial_no;
        $sparePart->type = $data['type'] ?? $sparePart->type;
        $sparePart->manufacturer = $data['manufacturer'] ?? $sparePart->manufacturer;
        $sparePart->price = $data['price'] ?? $sparePart->price;
        $sparePart->manufactured_date = $data['manufactured_date'] ?? $sparePart->manufactured_date;
        $sparePart->waranty_period = $data['waranty_period'] ?? $sparePart->waranty_period;

        // Save
        $tableName = $sparePart->tableName();
        $sql = "UPDATE $tableName SET serial_no = :serial_no, type = :type, manufacturer = :manufacturer, price = :price, manufactured_date = :manufactured_date, waranty_period = :waranty_period WHERE id = :id";
        $stmt = Application::$app->db->prepare($sql);
        $stmt->bindValue(':serial_no', $sparePart->serial_no);
        $stmt->bindValue(':type', $sparePart->type);
        $stmt->bindValue(':manufacturer', $sparePart->manufacturer);
        $stmt->bindValue(':price', $sparePart->price);
        $stmt->bindValue(':manufactured_date', $sparePart->manufactured_date);
        $stmt->bindValue(':waranty_period', $sparePart->waranty_period);
        $stmt->bindValue(':id', $sparepart_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Update failed']);
        }
    }


    public function addSparePartCustomer(Request $request, Response $response)
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
                    $sql = "INSERT INTO gg_sparepart_service_vehicle_install 
                        (vehicle_id, service_id, sparepart_id, installed_date) 
                        VALUES (:vehicle_id, :service_id, :sparepart_id, :installed_date)";

                    $statement = Application::$app->db->prepare($sql);
                    $statement->bindValue(':vehicle_id', $vehicle_id);
                    $statement->bindValue('service_id', $user_id);
                    $statement->bindValue(':sparepart_id', $sparepart_id);
                    $statement->bindValue(':installed_date', $installed_date);

                    if ($statement->execute()) {
                        // Commit transaction if everything is successful
                        Application::$app->db->pdo->commit();
                        $response->redirect('/mechanic/sparepart/viewAll');
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
    public function getSpareParts()
    {
        $userId = Application::$app->user->id ?? null;
        if (!$userId) {
            header('Content-Type: application/json');
            echo json_encode([]);
            exit;
        }

        try {
            $sql = '
            SELECT sp.id, sp.serial_no, sp.type, sp.manufacturer, sp.price, sp.manufactured_date, sp.waranty_period, svi.installed_date, v.license_plate_no, v.id AS vehicle_id FROM gg_sparepart sp JOIN gg_sparepart_service_vehicle_install svi ON sp.id = svi.sparepart_id JOIN gg_vehicle v ON svi.vehicle_id = v.id JOIN gg_user_owner uo ON v.id = uo.vehicle_id WHERE uo.user_id = :user_id
            ';

            $statement = Application::$app->db->prepare($sql);
            $statement->bindValue(':user_id', $userId);
            $statement->execute();

            $spareparts = $statement->fetchAll(\PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode($spareparts);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch spare parts.']);
        }
        return;
    }
}
