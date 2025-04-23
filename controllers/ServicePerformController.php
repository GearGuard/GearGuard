<?php

namespace app\controllers;

use gearguard\phpmvc\Application;
use gearguard\phpmvc\Controller;
use gearguard\phpmvc\Request;
use gearguard\phpmvc\Response;
use app\models\ServicePerform;
use app\models\Vehicle;
use gearguard\phpmvc\middlewares\ExtendedMiddleware;
use app\models\User;

class ServicePerformController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new ExtendedMiddleware([], self::isCustomer()));
    }

    /**
     * Check if the current user is a customer
     * 
     * @return bool
     */
    public static function isCustomer(): bool
    {
        return Application::$app->user instanceof User && Application::$app->session->get('isCustomer');
    }

    /**
     * View service history for all vehicles owned by the current user
     * 
     * @return string
     */
    public function serviceHistory(Request $request): string
    {
        // Get the current user ID
        $userId = Application::$app->user->id ?? null;

        if (!$userId) {
            Application::$app->session->setFlash('error', 'You must be logged in to view service history');
            Application::$app->response->redirect('/login');
            exit;
        }

        // Get all vehicles owned by the user
        $vehicleModel = new Vehicle();
        $vehicles = $vehicleModel->getVehiclesByOwner($userId);

        // Get service history for all vehicles owned by the user
        $serviceHistory = ServicePerform::getServiceHistoryByUser($userId);

        // For testing purposes only - uncomment to add sample data if needed
        if (empty($serviceHistory)) {
            ServicePerform::insertSampleService();
            $serviceHistory = ServicePerform::getServiceHistoryByUser($userId);
        }

        // Check if a specific vehicle is selected
        $selectedVehicle = null;
        if ($request->isGet()) {
            $body = $request->getBody();
            if (isset($body['vehicle_id']) && !empty($body['vehicle_id'])) {
                $selectedVehicle = $body['vehicle_id'];
                // Filter service history for the selected vehicle
                $serviceHistory = ServicePerform::getServiceHistoryByVehicle($selectedVehicle);
            }
        }

        return $this->render('serviceHistory', [
            'serviceHistory' => $serviceHistory,
            'vehicles' => $vehicles,
            'selectedVehicle' => $selectedVehicle
        ]);
    }

    /**
     * View service history for a specific vehicle
     * 
     * @param Request $request
     * @param Response $response
     * @return string
     */
    public function vehicleServiceHistory(Request $request, Response $response): string
    {
        // Get the current user ID
        $userId = Application::$app->user->id ?? null;

        if (!$userId) {
            Application::$app->session->setFlash('error', 'You must be logged in to view service history');
            $response->redirect('/login');
            exit;
        }

        $vehicleId = $request->getBody()['vehicle_id'] ?? null;

        if (!$vehicleId) {
            Application::$app->session->setFlash('error', 'Vehicle ID is required');
            $response->redirect('/customer/appointment/service_history');
            exit;
        }

        // Check if the user owns the vehicle
        $vehicleModel = new Vehicle();
        $vehicle = $vehicleModel->findOne(['id' => $vehicleId]);

        if (!$vehicle || !$vehicle->isOwnedByUser($userId)) {
            Application::$app->session->setFlash('error', 'You do not have permission to view this vehicle\'s service history');
            $response->redirect('/customer/appointment/service_history');
            exit;
        }

        // Get all vehicles owned by the user for the dropdown

        $vehicleModel = new Vehicle();
        $vehicles = $vehicleModel->getVehiclesByOwner($userId);

        // Get service history for the specific vehicle
        $serviceHistory = ServicePerform::getServiceHistoryByVehicle($vehicleId);

        return $this->render('serviceHistory', [
            'serviceHistory' => $serviceHistory,
            'vehicles' => $vehicles,
            'selectedVehicle' => $vehicleId
        ]);
    }
}
