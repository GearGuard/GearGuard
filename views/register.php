<?php

use app\models\RegisterModel;
use app\core\form\Form;

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
            display: none; /* Initially hidden */
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em; /* Smaller text */
            color: #dc3545; /* Red text for error message */
        }

        .is-invalid ~ .invalid-feedback {
            display: block; /* Display feedback when input is invalid */
        }

    </style>
</head>

<body>
    <div class="form-container">
        <h2 class="form-title">Register</h2>

        <!-- PHP Form with Custom Form Handling -->
        <?php $form = \app\core\form\Form::begin('', "post") ?>

        <?php echo $form->field($model, 'firstname') ?>
        <?php echo $form->field($model, 'lastname') ?>
        <?php echo $form->field($model, 'email') ?>
        <?php echo $form->field($model, 'password')->passwordField() ?>
        <?php echo $form->field($model, 'passwordConfirm')->passwordField() ?>

        <button type="submit" class="form-button">Register</button>

        <?php echo \app\core\form\Form::end() ?>

        <!-- Direct HTML Form Example -->
        <!--    <form method="POST" class="custom-form">-->
        <!--        <div class="form-group">-->
        <!--            <label class="form-label">First Name:</label>-->
        <!--            <input type="text" name="firstname" value="--><?php //echo $model->firstname 
                                                                        ?><!--"-->
        <!--                   placeholder="Enter your first name"-->
        <!--                   class="form-input --><?php //echo $model->hasError('firstname') ? 'is-invalid' : '' 
                                                    ?><!--">-->
        <!--			--><?php //if ($model->hasError('firstname')): 
                            ?>
        <!--                <div class="invalid-feedback">--><?php //echo $model->getFirstError('firstname'); 
                                                                ?><!--</div>-->
        <!--			--><?php //endif; 
                            ?>
        <!--        </div>-->
        <!---->
        <!--        <div class="form-group">-->
        <!--            <label class="form-label">Last Name:</label>-->
        <!--            <input type="text" name="lastname" placeholder="Enter your last name" class="form-input">-->
        <!--        </div>-->
        <!---->
        <!--        <div class="form-group">-->
        <!--            <label class="form-label">Email:</label>-->
        <!--            <input type="email" name="email" placeholder="Enter your email" class="form-input">-->
        <!--        </div>-->
        <!---->
        <!--        <div class="form-group">-->
        <!--            <label class="form-label">Password:</label>-->
        <!--            <input type="password" name="password" placeholder="Enter your password" class="form-input">-->
        <!--        </div>-->
        <!---->
        <!--        <div class="form-group">-->
        <!--            <label class="form-label">Confirm Password:</label>-->
        <!--            <input type="password" name="passwordConfirm" placeholder="Confirm your password" class="form-input">-->
        <!--        </div>-->
        <!---->
        <!--        <button type="submit" class="form-button">Register</button>-->
        <!--    </form>-->
    </div>
</body>

</html>
