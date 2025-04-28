<?php

namespace app\controllers;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;


class WarrentyController extends Controller
{
    public function actionIndex()
    {
        $userId = Application::$app->user->id ?? null;
        if (!$userId) {
            Application::$app->session->setFlash('error', 'You must be logged in to view this page.');
            Application::$app->response->redirect('/login');
            return;
        }

        $sql = 'SELECT sp.id, sp.serial_no, sp.type, sp.manufacturer, sp.price, sp.manufactured_date, sp.waranty_period,
            COALESCE(svi.installed_date, ssvi.installed_date) as installed_date,
            COALESCE(svi.vehicle_id, ssvi.vehicle_id) as vehicle_id,
            g.name as garage_name,
            CASE
                WHEN svi.user_id IS NOT NULL THEN "Self Installed"
                WHEN g.name IS NOT NULL THEN g.name
                ELSE NULL
            END as installed_by
            FROM gg_sparepart sp
            LEFT JOIN gg_sparepart_vehicleuser_vehicle_install svi
                ON sp.id = svi.sparepart_id AND svi.user_id = :user_id
            LEFT JOIN (
                SELECT ssvi.sparepart_id, ssvi.installed_date, v.id as vehicle_id, ssvi.service_id
                FROM gg_sparepart_service_vehicle_install ssvi
                JOIN gg_vehicle v ON ssvi.vehicle_id = v.id
                JOIN gg_user_owner uo ON v.id = uo.vehicle_id
                WHERE uo.user_id = :user_id2
            ) ssvi ON sp.id = ssvi.sparepart_id
            LEFT JOIN gg_garage_service gs ON ssvi.service_id = gs.id
            LEFT JOIN gg_garage g ON gs.garage_id = g.id
            WHERE sp.id IN (
                SELECT sparepart_id FROM gg_sparepart_vehicleuser_vehicle_install WHERE user_id = :user_id3
            ) OR sp.id IN (
                SELECT ssvi.sparepart_id
                FROM gg_sparepart_service_vehicle_install ssvi
                JOIN gg_vehicle v ON ssvi.vehicle_id = v.id
                JOIN gg_user_owner uo ON v.id = uo.vehicle_id
                WHERE uo.user_id = :user_id4
            )';

        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':user_id2', $userId);
        $statement->bindValue(':user_id3', $userId);
        $statement->bindValue(':user_id4', $userId);
        $statement->execute();
        $spareparts = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $this->render('warrenty', [
            'spareparts' => $spareparts
        ]);
    }

    public function actionGetMySpareParts()
    {
       
        $userId = Application::$app->user->id ?? null;
        if (!$userId) {
            return json_encode([]);
        }

        $sql = 'SELECT sp.id, sp.serial_no, sp.type, sp.manufacturer, sp.price, sp.manufactured_date, sp.waranty_period,
            COALESCE(svi.installed_date, ssvi.installed_date) as installed_date,
            v.license_plate_no,
            CASE
                WHEN svi.user_id IS NOT NULL THEN "Self Installed"
                WHEN g.name IS NOT NULL THEN g.name
                ELSE NULL
            END as installed_by
            FROM gg_sparepart sp
            LEFT JOIN gg_sparepart_vehicleuser_vehicle_install svi
                ON sp.id = svi.sparepart_id AND svi.user_id = :user_id
            LEFT JOIN (
                SELECT ssvi.sparepart_id, ssvi.installed_date, v.id as vehicle_id, ssvi.service_id
                FROM gg_sparepart_service_vehicle_install ssvi
                JOIN gg_vehicle v ON ssvi.vehicle_id = v.id
                JOIN gg_user_owner uo ON v.id = uo.vehicle_id
                WHERE uo.user_id = :user_id2
            ) ssvi ON sp.id = ssvi.sparepart_id
            LEFT JOIN gg_vehicle v ON COALESCE(svi.vehicle_id, ssvi.vehicle_id) = v.id
            LEFT JOIN gg_garage_service gs ON ssvi.service_id = gs.id
            LEFT JOIN gg_garage g ON gs.garage_id = g.id
            WHERE sp.id IN (
                SELECT sparepart_id FROM gg_sparepart_vehicleuser_vehicle_install WHERE user_id = :user_id3
            ) OR sp.id IN (
                SELECT ssvi.sparepart_id
                FROM gg_sparepart_service_vehicle_install ssvi
                JOIN gg_vehicle v ON ssvi.vehicle_id = v.id
                JOIN gg_user_owner uo ON v.id = uo.vehicle_id
                WHERE uo.user_id = :user_id4
            )';

        $statement = Application::$app->db->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':user_id2', $userId);
        $statement->bindValue(':user_id3', $userId);
        $statement->bindValue(':user_id4', $userId);
        $statement->execute();
        $spareparts = $statement->fetchAll(\PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($spareparts);
        exit;
    }
}
