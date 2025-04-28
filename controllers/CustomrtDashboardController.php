<?php

namespace app\controllers;

use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Application;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\Response;

class CustomrtDashboardController extends Controller
{
    public function viewNextAppointment()
    {
        $userId = Application::$app->user->id ?? null;
        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        try {
            $sql = "
          SELECT a.id, a.date, a.time, a.notes, s.type as service_type, 
            g.name as garage_name, v.license_plate_no, 
            vm.model as vehicle_model, vman.name as manufacturer
            FROM gg_vehicle_service_appointment a
            JOIN gg_garage_service s ON a.service_id = s.id
            JOIN gg_garage g ON s.garage_id = g.id
            JOIN gg_vehicle v ON a.vehicle_id = v.id
            JOIN gg_vehicle_model vm ON v.model_id = vm.id
            JOIN gg_vehicle_manufacturer vman ON vm.manufacturer_id = vman.id
            JOIN gg_user_owner uo ON v.id = uo.vehicle_id
            WHERE uo.user_id = :userId AND a.date >= CURDATE() AND a.status_id = 2
            ORDER BY a.date ASC, a.time ASC
            LIMIT 1
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


    public function viewWarrentyExpireFirst()
    {
        $userId = Application::$app->user->id ?? null;
        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        try {
            $sql = " 
           SELECT sp.type as part_name, sp.waranty_period as expiry_date,
            DATEDIFF(sp.waranty_period, CURDATE()) as days_remaining
            FROM gg_sparepart_vehicleuser_vehicle_install svi
            JOIN gg_sparepart sp ON svi.sparepart_id = sp.id
            WHERE svi.user_id = :userId AND sp.waranty_period >= CURDATE()
            ORDER BY sp.waranty_period ASC
            LIMIT 1;
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
    public function ViewLastServiceDone()
    {
        $userId = Application::$app->user->id ?? null;
        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        try {
            $sql = " 
           SELECT vst.begin_timestamp as service_date, gs.type as service_type,
            g.name as garage_name, v.license_plate_no
            FROM gg_vehicle_service_take vst
            JOIN gg_garage_service gs ON vst.service_id = gs.id
            JOIN gg_garage g ON gs.garage_id = g.id
            JOIN gg_vehicle v ON vst.vehicle_id = v.id
            JOIN gg_user_owner uo ON v.id = uo.vehicle_id
            WHERE uo.user_id = :userId
            ORDER BY vst.begin_timestamp DESC
            LIMIT 1
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
    function getMaintenanceTip()
    {
        $tips = [
            "Regular tire pressure checks can improve fuel efficiency and extend tire life.",
            "Change your oil every 5,000 to 7,500 miles to keep your engine running smoothly.",
            "Replace your air filter every 15,000 to 30,000 miles to improve fuel efficiency.",
            "Check your brake pads regularly and replace them when they're worn down to 3-4mm thickness.",
            "Rotate your tires every 5,000 to 8,000 miles to ensure even wear."
        ];

        return $tips[array_rand($tips)];
    }

    public function logedinUser()
    {
        $userId = Application::$app->user->id ?? null;
        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        try {
            $sql = " 
            SELECT CONCAT(first_name, ' ', COALESCE(last_name, '')) AS full_name
                FROM gg_user
                WHERE id = :userId;
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

    public function vehicleCount()
    {
        $userId = Application::$app->user->id ?? null;
        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        try {
            $sql = "
            SELECT COUNT(*) AS vehicle_count
FROM gg_user_owner uo
JOIN gg_vehicle v ON uo.vehicle_id = v.id
WHERE uo.user_id = :userId
AND v.status_id = 2;

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

    public function upcmingServicesCount()
    {
        $userId = Application::$app->user->id ?? null;
        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        try {
            $sql = "
            SELECT COUNT(*) AS upcoming_services_count
                FROM gg_vehicle_service_appointment vsa
                JOIN gg_user_owner uo ON vsa.vehicle_id = uo.vehicle_id
                WHERE uo.user_id = :userId
                AND vsa.date >= CURDATE()
                AND vsa.status_id = 2;

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

    public function nonExpire()
    {
        $userId = Application::$app->user->id ?? null;
        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        try {
            $sql = "
            SELECT COUNT(*) AS valid_spareparts_count
                FROM gg_sparepart_vehicleuser_vehicle_install spvi
                WHERE spvi.user_id = :userId
                AND (spvi.installed_date IS NULL OR 
                    (SELECT sp.waranty_period FROM gg_sparepart sp WHERE sp.id = spvi.sparepart_id) >= CURDATE());

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


    public function viewMyProfile(Request $request, Response $response)
    {
        $userId = Application::$app->user->id ?? null;
        header('Content-Type: application/json');

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        try {
            $sql = "
      SELECT * FROM gg_vehicle_users_view 
      WHERE id = :userId AND vehicle_status_id = 2;
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

    public function myProfileUpdate(Request $request, Response $response)
    {
        try {
            // Log to help debug
            error_log("Profile update initiated");

            // Check content type and parse request body accordingly
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            error_log("Content-Type: " . $contentType);

            if (strpos($contentType, 'application/json') !== false) {
                // Get the raw POST data and decode it from JSON
                $rawData = file_get_contents('php://input');
                error_log("Raw POST data: " . $rawData);
                $data = json_decode($rawData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    error_log("JSON decode error: " . json_last_error_msg());
                }
            } else {
                // For form data
                $data = $request->getBody();
                error_log("Form data: " . print_r($data, true));
            }

            $action = $data['_action'] ?? null;
            error_log("Action: " . ($action ?? 'none'));

            header('Content-Type: application/json'); // Set response content type to JSON

            if (!Application::$app->user) {
                $response->setStatusCode(401);
                error_log("Error: Unauthorized access");
                echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
                return;
            }

            $user_id = Application::$app->user->id;
            error_log("User ID: " . $user_id);

            // Handle different actions
            if ($action === 'updateProfile') {
                error_log("Processing profile update");
                // Update user profile information
                $userModel = new \app\models\User();
                $user = $userModel->findOne(['id' => $user_id]);

                if (!$user) {
                    $response->setStatusCode(404);
                    error_log("Error: User not found");
                    echo json_encode(['success' => false, 'message' => 'User not found']);
                    return;
                }

                // Log current and new values for debugging
                error_log("Current first_name: " . $user->first_name . ", New: " . ($data['first_name'] ?? 'not provided'));
                error_log("Current last_name: " . $user->last_name . ", New: " . ($data['last_name'] ?? 'not provided'));

                // Update fields with values from request
                $user->first_name = $data['first_name'] ?? $user->first_name;
                $user->last_name = $data['last_name'] ?? $user->last_name;
                $user->nic = $data['nic'] ?? $user->nic;
                $user->address = $data['address'] ?? $user->address;
                $user->email = $data['email'] ?? $user->email;
                $user->contact_no = $data['contact_no'] ?? $user->contact_no;
                $user->username = $data['username'] ?? $user->username;

                // Check if email is already taken by another user
                if (isset($data['email']) && $user->email !== $data['email']) {
                    $existingUser = $userModel->findOne(['email' => $data['email']]);
                    if ($existingUser && $existingUser->id != $user_id) {
                        error_log("Error: Email already in use");
                        echo json_encode(['success' => false, 'message' => 'Email is already in use']);
                        return;
                    }
                }

                // Check if username is already taken by another user
                if (isset($data['username']) && $user->username !== $data['username']) {
                    $existingUser = $userModel->findOne(['username' => $data['username']]);
                    if ($existingUser && $existingUser->id != $user_id) {
                        error_log("Error: Username already in use");
                        echo json_encode(['success' => false, 'message' => 'Username is already in use']);
                        return;
                    }
                }

                // Save to database
                $tableName = 'gg_user';
                $sql = "UPDATE $tableName SET 
                        first_name = :first_name, 
                        last_name = :last_name, 
                        nic = :nic, 
                        address = :address, 
                        email = :email, 
                        contact_no = :contact_no, 
                        username = :username 
                        WHERE id = :id";

                error_log("Executing SQL: $sql");

                $stmt = Application::$app->db->prepare($sql);
                $stmt->bindValue(':first_name', $user->first_name);
                $stmt->bindValue(':last_name', $user->last_name);
                $stmt->bindValue(':nic', $user->nic);
                $stmt->bindValue(':address', $user->address);
                $stmt->bindValue(':email', $user->email);
                $stmt->bindValue(':contact_no', $user->contact_no);
                $stmt->bindValue(':username', $user->username);
                $stmt->bindValue(':id', $user_id);

                if ($stmt->execute()) {
                    error_log("Profile update successful");
                    echo json_encode(['success' => true]);
                } else {
                    error_log("Error: SQL update failed: " . print_r($stmt->errorInfo(), true));
                    echo json_encode(['success' => false, 'message' => 'Update failed']);
                }
            } elseif ($action === 'changePassword') {
                error_log("Processing password change");
                // Handle password change
                $currentPassword = $data['currentPassword'] ?? '';
                $newPassword = $data['newPassword'] ?? ''; // Note: frontend sends 'newPassword', not 'password'
                $passwordConfirm = $data['confirmPassword'] ?? ''; // Note: frontend sends 'confirmPassword', not 'passwordConfirm'

                error_log("Current password provided: " . (!empty($currentPassword) ? 'Yes' : 'No'));
                error_log("New password provided: " . (!empty($newPassword) ? 'Yes' : 'No'));
                error_log("Confirm password provided: " . (!empty($passwordConfirm) ? 'Yes' : 'No'));

                // Validate password confirmation
                if ($newPassword !== $passwordConfirm) {
                    error_log("Error: Passwords do not match");
                    echo json_encode(['success' => false, 'message' => 'New password and confirmation do not match']);
                    return;
                }

                // Get current user data to verify password
                $userModel = new \app\models\User();
                $user = $userModel->findOne(['id' => $user_id]);

                if (!$user) {
                    $response->setStatusCode(404);
                    error_log("Error: User not found");
                    echo json_encode(['success' => false, 'message' => 'User not found']);
                    return;
                }

                // Verify current password
                if (!password_verify($currentPassword, $user->password)) {
                    error_log("Error: Current password incorrect");
                    echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
                    return;
                }

                // Hash new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update password in database
                $tableName = 'gg_user';
                $sql = "UPDATE $tableName SET password = :password WHERE id = :id";
                $stmt = Application::$app->db->prepare($sql);
                $stmt->bindValue(':password', $hashedPassword);
                $stmt->bindValue(':id', $user_id);

                if ($stmt->execute()) {
                    error_log("Password change successful");
                    echo json_encode(['success' => true]);
                } else {
                    error_log("Error: Password update failed: " . print_r($stmt->errorInfo(), true));
                    echo json_encode(['success' => false, 'message' => 'Password update failed']);
                }
            } else {
                $response->setStatusCode(400);
                error_log("Error: Invalid action: " . ($action ?? 'none'));
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
            }
        } catch (\Exception $e) {
            error_log("Exception in myProfileUpdate: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
        }
    }
}
