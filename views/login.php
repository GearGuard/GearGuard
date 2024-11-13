<?php
/** @var $model \app\models\User */
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        /* Custom CSS for styling */
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-input.is-invalid {
            border-color: #e74c3c;
            /* Red border for invalid input */
            background-color: #fce4e4;
        }

        .invalid-feedback {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .form-button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-button:hover {
            background-color: #0056b3;
        }

        .invalid-feedback {
            display: none;
            /* Initially hidden */
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            /* Smaller text */
            color: #dc3545;
            /* Red text for error message */
        }

        .is-invalid~.invalid-feedback {
            display: block;
            /* Display feedback when input is invalid */
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 class="form-title">Login</h2>

        <!-- PHP Form with Custom Form Handling -->
        <?php $form = \app\core\form\Form::begin('', 'post') ?>

        <?php echo $form->field($model, 'email') ?>
        <?php echo $form->field($model, 'password')->passwordField() ?>

        <button type="submit" class="form-button">Login</button>

        <?php echo \app\core\form\Form::end() ?>
    </div>
</body>

</html>
