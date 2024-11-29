<?php

/** @var $model \app\models\User */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GearGuard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #FFFFFFFF;
            --background: #181a20;
            --primary: #FFFFFFFF;
            --secondary: #25272d;
            --accent: #2463eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            background-color: var(--background);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background-color: var(--secondary);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .login-info {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--secondary);
        }

        .login-info img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 1.5rem;
            border-radius: 12px;
        }

        .login-info h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .login-info p {
            color: var(--primary);
            opacity: 0.8;
            line-height: 1.6;
            text-align: center;
        }

        .login-form {
            flex: 1.5;
            padding: 3rem;
            background-color: var(--background);
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 2px solid var(--secondary);
        }

        .form-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title h1 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .form-title p {
            color: var(--text);
            opacity: 0.7;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.25rem;
            font-size: 1rem;
            color: var(--primary);
            font-weight: 500;
        }

        .required-dot {
            color: #ef4444;
            margin-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--secondary);
            background-color: transparent;
            border-radius: 8px;
            color: var(--text);
            transition: all 0.3s ease;
            border: 1px solid white;
        }

        .form-input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.1);
        }

        .login-button {
            width: 40%;
            padding: 0.875rem;
            background-color: var(--accent);
            color: var(--text);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .login-button:hover {
            background-color: #1b4ebd;
            transform: translateY(-2px);
        }

        .register-link {
            text-align: center;
            margin-top: 1rem;
        }

        .register-link a {
            color: var(--accent);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-info">
            <img src="/assets/img/favicon.png" alt="GearGuard Logo">
            <h2>Welcome Back!</h2>
            <p>Log in to access your GearGuard account and manage your vehicle maintenance needs with ease.</p>
        </div>
        <div class="login-form">
            <div class="form-title">
                <h1>Login</h1>
                <p>Access your account</p>
            </div>
            <?php $form = \gearguard\phpmvc\form\Form::begin('', 'post') ?>

            <?php echo $form->field($model, 'username') ?>
            <?php echo $form->field($model, 'password')->passwordField() ?>

            <button type="submit" class="login-button">Login</button>

            <?php echo \gearguard\phpmvc\form\Form::end() ?>
            <div class="register-link">
                <a href="/type">Don't have an account? Sign Up</a>
            </div>
        </div>
    </div>
</body>

</html>