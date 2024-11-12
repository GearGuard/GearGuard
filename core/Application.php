<?php

namespace app\core;

use app\core\Database;
use app\core\Controller;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Controller $controller;
    public Database $db;
	public Session $session;
    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
		$this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);
    }
    public function run()
    {
        echo $this->router->resolve();
    }

    /**
     * @return \app\core\Controller
     */

    public function getController(): \app\core\Controller
    {
        return $this->controller;
    }

    /**
     * @param \app\core\Controller $controller
     */

    public function setController(\app\core\Controller $controller): void
    {
        $this->controller = $controller;
    }
}
