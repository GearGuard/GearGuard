<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => "The GearGurd"
        ];
        return $this->render('home', $params);
    }
   public function contact()
   {
       return Application::$app->router->renderView('contact');
   }
    public function handleContact()
    {
        return 'Handling Submitted Data';
    }
}