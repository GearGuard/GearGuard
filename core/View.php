<?php

namespace app\core;

/**
 * @author Sandhavi Wanigasooriya
 * @package app/core
 */


class View
{
	public string $title = '';

	public function renderView($view, $params = [])
	{
		$viewContent = $this->rendorOnlyView($view, $params);
		$layoutContent = $this->layoutContent();
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	public function renderContent($viewContent)
	{
		$layoutContent = $this->layoutContent();
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	protected function layoutContent()
	{
		$requestUri = $_SERVER['REQUEST_URI']; // Get the current request URI
		error_log("Current Request URI: $requestUri"); // Log the request URI for debugging

		// Default layout
		$layout = Application::$app->layout;

		// Determine which layout to use based on the request URI
		if (strpos($requestUri, '/customer') === 0) {
			$layout = 'customer'; // Use customer layout
		} elseif (strpos($requestUri, '/admin') === 0) {
			$layout = 'admin'; // Use admin layout
		}

		// Log which layout is being used
		error_log("Using Layout: $layout");

		// Check if a controller-specific layout is set
		if (Application::$app->controller && Application::$app->controller->layout) {
			$layout = Application::$app->controller->layout; // Override with controller layout if set
		}

		ob_start();
		include_once Application::$ROOT_DIR . "/views/layouts/$layout.php"; // Include the selected layout
		return ob_get_clean();
	}
	protected function rendorOnlyView($view, $params)
	{
		// Extract parameters for the view
		foreach ($params as $key => $value) {
			$$key = $value;
		}

		// Build the correct path for the view file
		$viewPath = Application::$ROOT_DIR . "/views/" . str_replace('.', '/', $view) . ".php";

		// Check if the view file exists
		if (!file_exists($viewPath)) {
			throw new \Exception("View file not found: $viewPath");
		}

		ob_start();
		include_once $viewPath;
		return ob_get_clean();
	}
}
