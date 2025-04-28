<?php

/** @var $model  \app\models\SparePart */
/** @var $garages array */
/** @var $vehicles array */

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Add New Spare Part</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

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
            font-family: 'Inter', sans-serif;
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

        .spare-part-form {
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

        input[type='text'],
        input[type='number'],
        input[type='date'],
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #33363f;
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        input[type='text']:hover,
        input[type='number']:hover,
        input[type='date']:hover,
        select:hover {
            border-color: var(--accent);
        }

        input[type='text']:focus,
        input[type='number']:focus,
        input[type='date']:focus,
        select:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .add-button {
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

        .add-button:hover {
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

            .spare-part-form {
                padding: 1rem;
            }

            .button-container {
                flex-direction: column-reverse;
            }

            .add-button,
            .clear-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class='navMenu'>
        <a href='#' class='active'>Add New Spare Part</a>
        <a href='/customer/sparepart/view_sparepart' target='_self'>View All Spare Parts</a>
    </nav>

    <div class='spare-part-form'>
        <h2 class='title'>Add New Spare Part</h2>
        <?php

        use gearguard\phpmvc\form\Form;

        $form = Form::begin('/customer/sparepart/add_sparepart', 'post', ['onsubmit' => 'return validateDates()']) ?>
        <div class='form-row'>
            <div class='form-column'>
                <div class='form-group'>
                    <div class="form-column">
                        <?php $form->field = new \gearguard\phpmvc\form\DropDownField($model, 'vehicle_id', $vehicles);
                        echo $form->field->required() ?>
                    </div>
                </div>
            </div>
            <div class='form-column'>
                <div class='form-group'>
                    <label for='serial_no'>Serial Number<span class='required-dot'>*</span></label>
                    <input type='text' id='serial_no' name='serial_no' required placeholder='Enter serial number'>
                </div>
            </div>
        </div>

        <div class='form-row'>
            <div class='form-column'>
                <label for='type'>Spare Part Type<span class='required-dot'>*</span></label>
                <input type='text' id='type' name='type' required placeholder='Enter spare part type'>
            </div>
            <div class='form-column'>
                <div class='form-group'>
                    <label for='price'>Price<span class='required-dot'>*</span></label>
                    <input type='number' id='price' name='price' required placeholder='Enter manufacturer'>
                </div>
            </div>
        </div>

        <div class='form-row'>
            <div class='form-column'>
                <div class='form-group'>
                    <label for='manufactured_date'>Manufactured Date<span class='required-dot'>*</span></label>
                    <input type='date' id='manufactured_date' name='manufactured_date' step='0.01' required
                        placeholder='Enter price' onchange="updateInstalledDateMin()">
                </div>
            </div>
            <div class='form-column'>
                <div class='form-group'>
                    <label for='manufacturer'>Manufacturer<span class='required-dot'>*</span></label>
                    <input type='text' id='manufacturer' name='manufacturer' required
                        placeholder='Enter spare part type'>
                </div>
            </div>
        </div>

        <div class='form-row'>
            <div class='form-column'>
                <div class='form-group'>
                    <label for='installed-date'>Installed Date<span class='required-dot'>*</span> (must be after Manufactured Date)</label>
                    <input type='date' id='installed-date' name='installed_date' required>
                    <p id="date-error" style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem; display: none;">Installed date must be after manufactured date</p>
                </div>
            </div>
            <div class='form-column'>
                <div class='form-group'>
                    <label for='waranty_period'>Warranty Period<span class='required-dot'>*</span></label>
                    <input type='date' id='waranty_period' name='waranty_period' required>
                </div>
            </div>
        </div>

        <div class='button-container'>
            <button type='reset' class='clear-button'>Clear</button>
            <button type='submit' class='add-button'>Add Spare Part</button>
        </div>
        <?php Form::end() ?>
    </div>

    <script>
        function updateInstalledDateMin() {
            const manufacturedDate = document.getElementById('manufactured_date').value;
            const installedDateInput = document.getElementById('installed-date');

            if (manufacturedDate) {
                installedDateInput.min = manufacturedDate;
            }

            // Validate if the current installed date is valid
            validateInstalledDate();
        }

        function validateInstalledDate() {
            const manufacturedDate = document.getElementById('manufactured_date').value;
            const installedDate = document.getElementById('installed-date').value;
            const dateError = document.getElementById('date-error');

            if (manufacturedDate && installedDate && new Date(installedDate) < new Date(manufacturedDate)) {
                dateError.style.display = 'block';
                return false;
            } else {
                dateError.style.display = 'none';
                return true;
            }
        }

        function validateDates() {
            return validateInstalledDate();
        }

        // Initialize validation on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set up validation for installed date when it changes
            document.getElementById('installed-date').addEventListener('change', validateInstalledDate);

            // Initial setup
            updateInstalledDateMin();
        });
    </script>
</body>

</html>