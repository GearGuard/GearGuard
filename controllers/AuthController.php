<?php

namespace app\controllers;

class AuthController extends Controller
{
    public function login()
    {
        return $this->render('login');
    }
    public function register()
    {
        return $this->render('register');
    }
}