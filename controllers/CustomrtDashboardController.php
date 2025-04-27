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
}
