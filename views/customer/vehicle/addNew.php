<!DOCTYPE html>
<html lang='en'>

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0FF;
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
            padding: 10px;
        }

        .navMenu {
            background-color: var(--secondary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 67.5%;
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
            padding: 0.75rem 2.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            white-space: nowrap;
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .vehicle-form {
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
        input[type='date'],
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #fff;
            color: var(--primary);
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background-color: var(--secondary);
        }

        input[type='text']:hover,
        input[type='date']:hover,
        select:hover {
            border-color: #94a3b8;
        }

        input[type='text']:focus,
        input[type='date']:focus,
        select:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .checkbox-group input[type='checkbox'] {
            width: 1rem;
            height: 1rem;
            border-radius: 4px;
            border: 1px solid var(--border);
            cursor: pointer;
            margin-bottom: 6px;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .submit-button {
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

        .submit-button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .clear-button {
            background: #f1f5f9;
            color: var(--background);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .clear-button:hover {
            background: #002D8DFF;
            color: var(--text);
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navMenu {
                flex-direction: column;
                padding: 0.5rem;
                width: 90%;
            }

            .navMenu a {
                width: 100%;
                text-align: center;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .vehicle-form {
                padding: 1rem;
            }

            .button-container {
                flex-direction: column-reverse;
            }

            .submit-button,
            .clear-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<nav class='navMenu'>
    <a href='#' class='active'>New Vehicle</a>
    <a href='/customer/vehicle/all' target='_self'>My Vehicle</a>
    <a href='/customer/vehicle/service_history' target='_self'>Service History</a>
</nav>

<div class='vehicle-form'>
    <h2 class='title'>Register New Vehicle</h2>
	
	<?php use gearguard\phpmvc\form\Form;
		
		$form = Form::begin('/customer/vehicle/register', 'post') ?>

    <div class="form-row">
        <div class="form-column">
            <div class="form-group">
                <label for="brand">Vehicle Brand<span class="required-dot">*</span></label>
                <input type="text" id="brand" name="brand" required placeholder="Enter vehicle brand">
            </div>
        </div>
        <div class="form-column">
            <div class="form-group">
                <label for="vehicle-type">Vehicle Type<span class="required-dot">*</span></label>
                <select id="vehicle-type" name="vehicle_type" required>
                    <option value="">Select Vehicle Type</option>
                    <option value="car">Car</option>
                    <option value="motorcycle">Motorcycle</option>
                    <option value="truck">Truck</option>
                    <option value="van">Van</option>
                    <option value="suv">SUV</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-column">
            <div class="form-group">
                <label for="year_manufactured">Manufactured Year<span class="required-dot">*</span></label>
                <select id="year_manufactured" name="yeyear_manufactured" required>
                    <option value="">Select Year</option>
					<?php for ($i = date('Y'); $i >= 1980; $i--) { ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
					<?php } ?>
                </select>
            </div>
        </div>
        <div class="form-column">
            <div class="form-group">
                <label for="license_plate_no">Number Plate<span class="required-dot">*</span></label>
                <input type="text" id="license_plate_no" name="license_plate_no" required placeholder="Enter plate number">
            </div>
        </div>
    </div>

    <div class="form-row">
<!--        <div class="form-column">-->
<!--            <div class="form-group">-->
<!--                <label for="nic">Registered NIC<span class="required-dot">*</span></label>-->
<!--                <input type="text" id="nic" name="nic" required placeholder="Enter NIC number">-->
<!--            </div>-->
<!--        </div>-->
        <div class="form-column">
<!--            <div class="form-group">-->
<!--                <label for="nickname">Vehicle Nickname</label>-->
<!--                <input type="text" id="nickname" name="nickname" placeholder="Enter nickname for your vehicle">-->
<!--            </div>-->
        </div>
    </div>

    <div class="form-row">
        <div class="form-column">
            <div class="form-group">
                <label for="fuel_type_id">Fuel Type<span class="required-dot">*</span></label>
                <select id="fuel_type_id" name="fuel_type_id" required>
                    <option value="">Select Fuel Type</option>
                    <option value="1">Petrol</option>
                    <option value="2">Diesel</option>
                    <option value="3">Electric</option>
                </select>
            </div>
        </div>
        <div class="form-column">
<!--            <div class="form-group">-->
<!--                <label for="registration-date">Registration Date<span class="required-dot">*</span></label>-->
<!--                <input type="date" id="registration-date" name="registration_date" required>-->
<!--            </div>-->
        </div>
    </div>

    <div class="form-row">
        <div class="form-column">
            <div class="form-group">
                <label for="engine-no">Engine Number<span class="required-dot">*</span></label>
                <input type="text" id="engine-no" name="engine_no" required placeholder="Enter engine number">
            </div>
        </div>
        <div class="form-column">
            <div class="form-group">
                <label for="chassis-no">Chassis Number<span class="required-dot">*</span></label>
                <input type="text" id="chassis-no" name="chassis_no" required placeholder="Enter chassis number">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-column">
            <div class="form-group">
                <label for="color">Vehicle Color<span class="required-dot">*</span></label>
                <input type="text" id="color" name="color" required placeholder="Enter vehicle color">
            </div>
        </div>
        <div class="form-column">
            <div class="form-group">
                <label for="engine-capacity">Engine Capacity<span class="required-dot">*</span></label>
                <select id="engine-capacity" name="engine_capacity" required>
                    <option value="">Select Engine Capacity</option>
                    <option value="1000">1000cc</option>
                    <option value="1500">1500cc</option>
                    <option value="2000">2000cc</option>
                    <option value="2500">2500cc</option>
                    <option value="3000">3000cc</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-column">
            <div class="form-group">
                <label for="model_id">Model ID<span class="required-dot">*</span></label>
                <input type="text" id="model_id" name="model_id" required placeholder="Enter model ID">
            </div>
        </div>
        <div class='form-column'>
            <div class='form-group'>
                <label for='vin'>VIN<span class='required-dot'>*</span></label>
                <input type='text' id='vin' name='vin' required placeholder='Enter VIN'>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit">Register Vehicle</button>
    </div>
	
	<?php Form::end(); ?>
</div>

<div class="button-container">
    <button type="reset" class="clear-button">Clear</button>
    <button type="submit" class="submit-button">Register Vehicle</button>
</div>
<?php echo Form::end() ?>
</div>
</body>

</html>
