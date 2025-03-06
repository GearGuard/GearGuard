<?php
	
	namespace app\controllers;
	
	use app\models\SparePart;
	use app\models\User;
	use gearguard\phpmvc\Application;
	use gearguard\phpmvc\Controller;
	use gearguard\phpmvc\exception\NotFoundException;
	use gearguard\phpmvc\middlewares\ExtendedMiddleware;
	use gearguard\phpmvc\Request;
	use gearguard\phpmvc\Response;
	
	class SparePartController extends Controller
	{
		public static function isCustomer(): bool
		{
			if (Application::$app->user instanceof User && Application::$app->session->get('isCustomer')) {
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
		public function __construct()
		{
			$this->registerMiddleware(new ExtendedMiddleware([], self::isCustomer()));
		}
		
		
		/**
		 * @throws NotFoundException
		 */
		public function addSparePart(Request $request, Response $response){
			if (Application::$app->user instanceof User) {
				$data = $request->getBody(); // Assuming your framework provides this method
				$serial_no = $data['serial_no'] ?? '1';
				$type = $data['type'] ?? null;
				$manufacturer = $data['manufacturer'] ?? null;
				$price = $data['price'] ?? null;
				$manufactured_date = $data['manufactured_date'] ?? null;
				$warenty_period = $data['warenty_period'] ?? '';
				// Now pass it safely to initialize()
		
				$sparepart = SparePart::initialize([
					'serial_no' => $serial_no,
					'type' => $type,
					'manufacturer' => $manufacturer,
					'price' => $price,
					'manufactured_date' => $manufactured_date,
					'waranty_period' => $warenty_period,
				]);
				if ($sparepart->save()) {
					$response->redirect('/customer/sparepart/view_sparepart');
					echo 'SparePart added successfully';
					return;
				} else {
					echo 'Failed to save spare part. Please check your input and try again.';
				}
			}
			throw new NotFoundException();
		}
	}
?>
