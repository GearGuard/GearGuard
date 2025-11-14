<?php

/** @var $model \app\models\Garage */


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Registration - GearGuard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #FFFFFFFF;
            --background: #181a20;
            --primary: #c7adad;
            --secondary: #25272d;
            --accent: #2463eb;
            --border: #33363f;
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

        .registration-wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 1200px;
            background-color: var(--secondary);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .registration-info {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--secondary);
            text-align: center;
        }

        .registration-info img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin-bottom: 1.5rem;
            border-radius: 12px;
        }

        .registration-info h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--text);
        }

        .registration-info p {
            color: var(--text);
            opacity: 0.8;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
        }

        .registration-form {
            padding: 3rem;
            background-color: var(--background);
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-top: 2px solid var(--accent);
        }

        .form-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title h1 {
            font-size: 2.2rem;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .form-title p {
            color: var(--text);
            opacity: 0.7;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 0.25rem;
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
            border: 1px solid var(--border);
            background-color: #33363f;
            border-radius: 8px;
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-input:hover {
            border-color: var(--accent);
        }

        .form-input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        .form-input.is-invalid {
            border-color: #ef4444;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .register-button {
            width: 100%;
            padding: 1rem;
            background-color: var(--accent);
            color: var(--text);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
        }

        .register-button:hover {
            background-color: #1b4ebd;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: var(--accent);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
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
            <h2>Join GearGuard Network</h2>
            <p>Become a part of our trusted network of garages. Expand your business reach and provide top-notch services to vehicle owners through our platform.</p>
        </div>
        <div class="registration-form">
            <div class="form-title">
                <h1>Register Your Garage</h1>
                <p>Fill in the details below to get started</p>
            </div>
            <?php $form = \gearguard\phpmvc\form\Form::begin('', "post") ?>
            <div class="form-grid">
                <div class="form-group">
                    <?php echo $form->field($model, 'name')->label('Garage Name') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'registration_no')->label('Business Registration Number') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'email') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'contact_no')->label('Contact Number') ?>
                </div>
                <div class="form-group full-width">
                    <?php echo $form->field($model, 'address') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'username') ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'password')->passwordField() ?>
                </div>
                <div class="form-group">
                    <?php echo $form->field($model, 'passwordConfirm')->passwordField()->label('Confirm Password') ?>
                </div>
            </div>
            <button type="submit" class="register-button">Register Garage</button>
            <?php echo \gearguard\phpmvc\form\Form::end() ?>
            <div class="login-link">
                <a href="/garage/login">Already registered? Sign In to your garage account</a>
            </div>
        </div>
    </div>
</body>

</html>