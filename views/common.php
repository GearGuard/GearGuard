<?php

/** @var $model \app\models\Appointment */
/** @var $garages array */
/** @var $vehicles array */

use gearguard\phpmvc\form\Form;
use gearguard\phpmvc\form\TextAreaField;
use gearguard\phpmvc\form\DateField;
use gearguard\phpmvc\form\TimeField;
use gearguard\phpmvc\form\DropDownField;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - GearGuard</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #c7adad;
            --secondary: #25272d;
            --accent: #2463eb;
            --hover-bg: rgba(36, 99, 235, 0.1);
            --border: #33363f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--background);
            font-family: "Inter", sans-serif;
            color: var(--text);
            line-height: 1.6;
            padding: 20px;
        }

        .navMenu {
            background-color: var(--secondary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 70%;
            padding: 1rem;
            margin: 0 auto 2rem;
            position: sticky;
            top: 20px;
            z-index: 100;
        }

        .navMenu a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .appointment-form {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .title {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-column {
            flex: 1;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .required-dot {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="time"],
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #33363f;
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

        input[type="text"]:hover,
        input[type="email"]:hover,
        input[type="date"]:hover,
        input[type="time"]:hover,
        select:hover,
        textarea:hover {
            border-color: var(--accent);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        input[type="time"]:focus,
        select:focus,
        textarea:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        input::placeholder,
        textarea::placeholder {
            color: #c7c7c7;
        }

        .notes {
            height: 120px;
            resize: vertical;
            min-height: 120px;
            font-family: "Inter", sans-serif;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .book-button {
            background: var(--accent);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .book-button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        .clear-button {
            background: var(--secondary);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .clear-button:hover {
            background: var(--hover-bg);
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navMenu {
                flex-direction: column;
                gap: 0.5rem;
            }

            .navMenu a {
                width: 100%;
                text-align: center;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .appointment-form {
                padding: 1rem;
            }

            .button-container {
                flex-direction: column-reverse;
            }

            .book-button,
            .clear-button {
                width: 100%;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const minDate = new Date(today.setDate(today.getDate() + 3));
            const maxDate = new Date(today.setDate(today.getDate() + 30));
            const dateInput = document.getElementById('appointment_date');
            dateInput.min = minDate.toISOString().split('T')[0];
            dateInput.max = maxDate.toISOString().split('T')[0];

            $('#garage_id').change(function() {
                var garageId = $(this).val();
                if (garageId) {
                    $.ajax({
                        url: '/appointment/getServices',
                        type: 'GET',
                        data: {
                            garage_id: garageId
                        },
                        success: function(response) {
                            $('#service_id').html(response);
                        }
                    });
                } else {
                    $('#service_id').html('<option value="">Select Service Type</option>');
                }
            });
        });

        $(document).ready(function() {
            $('#garage_id').change(function() {
                var garageId = $(this).val();
                if (garageId) {
                    $.ajax({
                        url: '/appointment/getServices',
                        type: 'GET',
                        data: {
                            garage_id: garageId
                        },
                        success: function(response) {
                            $('#service_id').html(response);
                        }
                    });
                } else {
                    $('#service_id').html('<option value="">Select Garage first</option>');
                }
            });
        });
    </script>
</head>

<body>
<nav class="navMenu">
    <a href="#" class="active">Book Appointment</a>
    <a href="/customer/appointment/my_appointment" target='_self'>My Appointments</a>
    <a href="/customer/appointment/service_history" target='_self'>Service History</a>
    <a href="/customer/appointment/spareparts_warranty" target='_self'>Spare Parts Warranty</a>
</nav>
<div class="appointment-form">
    <h2 class="title">Book Your Appointment</h2>
    <?php $form = Form::begin('', "post") ?>
    <div class="form-row">
        <div class="form-column">
            <?php echo $form->field = new \gearguard\phpmvc\form\DropDownField($model, 'vehicle_id', $vehicles)?>
        </div>
    </div>
    <div class="form-row">
        <div class="form-column">
            <?php echo $form->field = new \gearguard\phpmvc\form\DropDownField($model, 'garage_id', $garages)?>
        </div>
        <div class="form-column">
            <?php echo $form->field = new \gearguard\phpmvc\form\DropDownField($model, 'service_id', [])?>
        </div>
    </div>
    <div class="form-row">
        <div class="form-column">
            <?php echo $form->field = new \gearguard\phpmvc\form\DateField($model, 'appointment_date') ?>
        </div>
        <div class="form-column">
            <?php echo $form->field = new \gearguard\phpmvc\form\TimeField($model, 'appointment_time') ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo new TextAreaField($model, 'notes') ?>
    </div>
    <div class="button-container">
        <button type="reset" class="clear-button">Clear</button>
        <button type="submit" class="book-button">Book Appointment</button>
    </div>
    <?php echo Form::end() ?>
</div>
</body>

</html>