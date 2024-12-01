<?php

/** @var $model \app\models\Garage */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Registration - GearGuard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #FFFFFF;
            --background: #0F172A;
            --primary: #3B82F6;
            --secondary: #1E293B;
            --accent: #F59E0B;
            --border: #334155;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }

        body {
            font-family: "Poppins", sans-serif;
            background-color: var(--background);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .registration-wrapper {
            display: flex;
            width: 100%;
            max-width: 1500px;
            background-color: var(--secondary);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .registration-info {
            flex: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;


        }

        .registration-info img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 0.55rem;

        }

        .info-content {
            max-width: 80%;
            margin-bottom: 1px;
            text-align: justify;
            margin-left: 30px;

        }

        .registration-info h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--text);
            text-align: center;

        }

        .registration-info p {
            color: var(--text);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .feature-list {
            list-style-type: none;
        }

        .feature-list li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .feature-list li::before {
            content: "✓";
            margin-right: 0.5rem;
            color: var(--accent);
            font-weight: bold;
        }

        .registration-form {
            flex: 2;
            padding: 2rem;
            background-color: var(--background);
            display: flex;
            flex-direction: column;
            justify-content: center;

        }

        .form-title {
            text-align: left;
            margin-bottom: 2rem;
        }

        .form-title h1 {
            font-size: 2.5rem;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .form-title p {
            color: var(--text);
            opacity: 0.7;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;

        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--text);
            font-weight: 500;

        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            background-color: var(--secondary);
            border-radius: 8px;
            color: var(--text);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .register-button {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary);
            color: var(--text);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .required-dot {
            color: #ef4444;
            margin-left: 4px;
        }

        .register-button:hover {
            background-color: #2563EB;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1024px) {
            .registration-wrapper {
                flex-direction: column;
            }

            .registration-info,
            .registration-form {
                width: 100%;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <div class="registration-wrapper">
        <div class="registration-info">
            <img src="/assets/img/favicon.png" alt="GearGuard Logo">
            <div class="info-content">
                <h2>Join GearGuard Network</h2>
                <p>Expand your garage business and connect with more customers through our platform.</p>
                <ul class="feature-list">
                    <li>Increase visibility to potential customers</li>
                    <li>Manage appointments efficiently</li>
                    <li>Access to a wide network of vehicle owners</li>
                    <li>Streamline your garage operations</li>
                </ul>
            </div>
        </div>
        <div class="registration-form">
            <div class="form-title">
                <h1>Register Your Garage</h1>
                <p>Fill in the details to get started with GearGuard</p>
            </div>
            <?php $form = \gearguard\phpmvc\form\Form::begin('', "post") ?>
            <div class="form-grid">
                <div class="form-group full-width">
                    <?php echo $form->field($model, 'name') ?>
                </div>
                <div class="form-group full-width">
                    <?php echo $form->field($model, 'address') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'contact_no') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'registration_no') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'email') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'username') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'password')->passwordField() ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'passwordConfirm')->passwordField() ?>
                </div>
            </div>
            <button type="submit" class="register-button">Register Garage</button>
            <?php echo \gearguard\phpmvc\form\Form::end() ?>
            <div class="login-link">
                <a href="/garage/login">Already registered? Sign In</a>
            </div>
        </div>
    </div>
</body>

</html>