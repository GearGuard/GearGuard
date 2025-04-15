<?php

namespace app\controllers;

use app\models\SparePart;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Application;


class SparepartController extends Controller
{

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
                $reviewData[] = $part;
            }

            echo json_encode($partData);
        
    }

    //review deletion
    public function deleteSparePart(){
        
        try {
            $spareId = Application::$app->request->getBody()['id'] ?? null;
            

            if (!$spareId) {
                throw new \Exception('spare ID not provided');
            }

            // Debugging statement
            error_log("spare ID received: " . $spareId);

            $spare = SparePart::findOne(['id' => $spareId]);

            if (!$spare) {
                throw new \Exception('spare part not found');
            }

            if (!$spare->delete()) {
                throw new \Exception('Failed to delete spare part');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function updateSparePart()
    {

        $spare = new SparePart();
        try {
            $spareId = Application::$app->request->getBody()['id'] ?? null;
            if (!$spareId) {
                throw new \Exception('spare ID not provided');
            }

            $spare = SparePart::findOne(['id' => $spareId]);
            if (!$spare) {
                throw new \Exception('spare part not found');
            }

            $spareData = Application::$app->request->getBody();
            $spare->loadData($spareData);

            if (!$spare->update()) {
                throw new \Exception('Failed to update spare part');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


}
