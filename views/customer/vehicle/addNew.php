<?php

use gearguard\phpmvc\Application;
use gearguard\phpmvc\form\Form;

/** @var $model \app\models\Vehicle */
/** @var $fuelTypes array */
/** @var $vehicleTypes array */
/** @var $bodyTypes array */
/** @var $engineCapacities array */
/** @var $vehicleClasses array */
?>

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
            background-color: var(--secondary);
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
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

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .is-invalid {
            border-color: #ef4444 !important;
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

        <?php $form = Form::begin('/customer/vehicle/register', 'post'); ?>

        <div class="form-row">
            <div class="form-column">
                <?php $form->vehicleModelField = new \gearguard\phpmvc\form\DropDownField($model, 'model_id', \app\models\Vehicle::getAllVehicleModelsWithIDs());
                        echo $form->vehicleModelField->required();
                ?>
<!--                <div class="form-group">
                    <label for="model">Vehicle Model<span class="required-dot">*</span></label>
                    <input type="text" id="model" name="model" value="<?php /*= $model->model ?? '' */?>" required placeholder="Enter vehicle model" class="<?php /*= $model->hasError('model') ? 'is-invalid' : '' */?>">
                    <?php /*if ($model->hasError('model')): */?>
                        <div class="invalid-feedback"><?php /*= $model->getFirstError('model') */?></div>
                    <?php /*endif; */?>
                </div>-->
            </div>
            <div class="form-column">
                <div class="form-group">
                    <label for="vin">VIN (Vehicle Identification Number)<span class="required-dot">*</span></label>
                    <input type="text" id="vin" name="vin" value="<?= $model->vin ?? '' ?>" required placeholder="Enter VIN" class="<?= $model->hasError('vin') ? 'is-invalid' : '' ?>">
                    <?php if ($model->hasError('vin')): ?>
                        <div class="invalid-feedback"><?= $model->getFirstError('vin') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <div class="form-group">
                    <label for="license_plate_no">License Plate Number<span class="required-dot">*</span></label>
                    <input type="text" id="license_plate_no" name="license_plate_no" value="<?= $model->license_plate_no ?? '' ?>" required placeholder="Enter plate number" class="<?= $model->hasError('license_plate_no') ? 'is-invalid' : '' ?>">
                    <?php if ($model->hasError('license_plate_no')): ?>
                        <div class="invalid-feedback"><?= $model->getFirstError('license_plate_no') ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <label for="year_manufactured">Year Manufactured<span class="required-dot">*</span></label>
                    <select id="year_manufactured" name="year_manufactured" required class="<?= $model->hasError('year_manufactured') ? 'is-invalid' : '' ?>">
                        <option value="">Select Year</option>
                        <?php for ($i = date('Y'); $i >= 1980; $i--): ?>
                            <option value="<?= $i ?>" <?= (isset($model->year_manufactured) && date('Y', strtotime($model->year_manufactured)) == $i) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <?php if ($model->hasError('year_manufactured')): ?>
                        <div class="invalid-feedback"><?= $model->getFirstError('year_manufactured') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <div class="form-group">
                    <label for="engine_no">Engine Number<span class="required-dot">*</span></label>
                    <input type="text" id="engine_no" name="engine_no" value="<?= $model->engine_no ?? '' ?>" required placeholder="Enter engine number" class="<?= $model->hasError('engine_no') ? 'is-invalid' : '' ?>">
                    <?php if ($model->hasError('engine_no')): ?>
                        <div class="invalid-feedback"><?= $model->getFirstError('engine_no') ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <label for="insurance_no">Insurance Number</label>
                    <input type="text" id="insurance_no" name="insurance_no" value="<?= $model->insurance_no ?? '' ?>" placeholder="Enter insurance number" class="<?= $model->hasError('insurance_no') ? 'is-invalid' : '' ?>">
                    <?php if ($model->hasError('insurance_no')): ?>
                        <div class="invalid-feedback"><?= $model->getFirstError('insurance_no') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <?php $form->vehicleFuelField = new \gearguard\phpmvc\form\DropDownField($model, 'fuel_type_id', \app\models\Vehicle::getAllVehicleFuelTypesWithID());
                        echo $form->vehicleFuelField->required();
                ?>
                <!--<div class="form-group">
                    <label for="fuel_type_id">Fuel Type<span class="required-dot">*</span></label>
                    <select id="fuel_type_id" name="fuel_type_id" required class="<?php /*= $model->hasError('fuel_type_id') ? 'is-invalid' : '' */?>">
                        <option value="">Select Fuel Type</option>
                        <option value="Petrol" <?php /*= ($model->fuel_type_id == '1') ? 'selected' : '' */?>>Petrol</option>
                        <option value="Diesel" <?php /*= ($model->fuel_type_id == '2') ? 'selected' : '' */?>>Diesel</option>
                        <option value="Electric" <?php /*= ($model->fuel_type_id == '3') ? 'selected' : '' */?>>Electric</option>
                        <option value="Hybrid" <?php /*= ($model->fuel_type_id == '4') ? 'selected' : '' */?>>Hybrid</option>
                    </select>
                    <?php /*if ($model->hasError('fuel_type_id')): */?>
                        <div class="invalid-feedback"><?php /*= $model->getFirstError('fuel_type_id') */?></div>
                    <?php /*endif; */?>
                </div>-->
            </div>
            <div class="form-column">
                <?php $form->vehicleTypeField = new \gearguard\phpmvc\form\DropDownField($model, 'vehicle_type_id', \app\models\Vehicle::getAllVehicleTypesWithID());
                        echo $form->vehicleTypeField->required();
                ?>
                <!--<div class="form-group">
                    <label for="vehicle_type_id">Vehicle Type<span class="required-dot">*</span></label>
                    <select id="vehicle_type_id" name="vehicle_type_id" required class="<?php /*= $model->hasError('vehicle_type_id') ? 'is-invalid' : '' */?>">
                        <option value="">Select Vehicle Type</option>
                        <option value="Car" <?php /*= ($model->vehicle_type_id == '1') ? 'selected' : '' */?>>Car</option>
                        <option value="Truck" <?php /*= ($model->vehicle_type_id == '2') ? 'selected' : '' */?>>Truck</option>
                        <option value="Motorcycle" <?php /*= ($model->vehicle_type_id == '3') ? 'selected' : '' */?>>Motorcycle</option>
                        <option value="Bus" <?php /*= ($model->vehicle_type_id == '4') ? 'selected' : '' */?>>Bus</option>
                        <option value="Van" <?php /*= ($model->vehicle_type_id == '5') ? 'selected' : '' */?>>Van</option>
                        <option value="SUV" <?php /*= ($model->vehicle_type_id == '6') ? 'selected' : '' */?>>SUV</option>
                        <option value="Pickup" <?php /*= ($model->vehicle_type_id == '7') ? 'selected' : '' */?>>Pickup</option>
                        <option value="Other" <?php /*= ($model->vehicle_type_id == '8') ? 'selected' : '' */?>>Other</option>
                    </select>
                    <?php /*if ($model->hasError('vehicle_type_id')): */?>
                        <div class="invalid-feedback"><?php /*= $model->getFirstError('vehicle_type_id') */?></div>
                    <?php /*endif; */?>
                </div>-->
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <?php $form->vehicleBodyField = new \gearguard\phpmvc\form\DropDownField($model, 'bodytype_id', \app\models\Vehicle::getAllVehicleBodyTypesWithID());
                        echo $form->vehicleBodyField->required();
                ?>
                <!--<div class="form-group">
                    <label for="bodytype_id">Body Type<span class="required-dot">*</span></label>
                    <select id="bodytype_id" name="bodytype_id" required class="<?php /*= $model->hasError('bodytype_id') ? 'is-invalid' : '' */?>">
                        <option value="">Select Body Type</option>
                        <option value="Sedan" <?php /*= ($model->bodytype_id == '1') ? 'selected' : '' */?>>Sedan</option>
                        <option value="Hatchback" <?php /*= ($model->bodytype_id == '2') ? 'selected' : '' */?>>Hatchback</option>
                        <option value="Coupe" <?php /*= ($model->bodytype_id == '3') ? 'selected' : '' */?>>Coupe</option>
                    </select>
                    <?php /*if ($model->hasError('bodytype_id')): */?>
                        <div class="invalid-feedback"><?php /*= $model->getFirstError('bodytype_id') */?></div>
                    <?php /*endif; */?>
                </div>-->
            </div>
            <div class="form-column">
                <?php $form->vehicleEngineCapacityField = new \gearguard\phpmvc\form\DropDownField($model, 'engine_capacity_id', \app\models\Vehicle::getAllVehicleEngineCapacitiesWithID());
                        echo $form->vehicleEngineCapacityField->required();
                ?>
                <!--<div class="form-group">
                    <label for="engine_capacity_id">Engine Capacity<span class="required-dot">*</span></label>
                    <select id="engine_capacity_id" name="engine_capacity_id" required class="<?php /*= $model->hasError('engine_capacity_id') ? 'is-invalid' : '' */?>">
                        <option value="">Select Engine Capacity</option>
                        <option value="1000cc" <?php /*= ($model->engine_capacity_id == '1') ? 'selected' : '' */?>>1000cc</option>
                        <option value="1500cc" <?php /*= ($model->engine_capacity_id == '2') ? 'selected' : '' */?>>1500cc</option>
                        <option value="2000cc" <?php /*= ($model->engine_capacity_id == '3') ? 'selected' : '' */?>>2000cc</option>
                    </select>
                    <?php /*if ($model->hasError('engine_capacity_id')): */?>
                        <div class="invalid-feedback"><?php /*= $model->getFirstError('engine_capacity_id') */?></div>
                    <?php /*endif; */?>
                </div>-->
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <?php
                $form->vehicleClassField = new \gearguard\phpmvc\form\DropDownField($model, 'class_id', \app\models\Vehicle::getAllVehicleClassesWithID());
                        echo $form->vehicleClassField->required();
                ?>
                <!--<div class="form-group">
                    <label for="class_id">Vehicle Class<span class="required-dot">*</span></label>
                    <select id="class_id" name="class_id" required class="<?php /*= $model->hasError('class_id') ? 'is-invalid' : '' */?>">
                        <option value="">Select Vehicle Class</option>
                        <option value="Luxury" <?php /*= ($model->class_id == '1') ? 'selected' : '' */?>>Luxury</option>
                        <option value="Economy" <?php /*= ($model->class_id == '2') ? 'selected' : '' */?>>Economy</option>
                        <option value="Standard" <?php /*= ($model->class_id == '3') ? 'selected' : '' */?>>Standard</option>
                        <option value="Premium" <?php /*= ($model->class_id == '4') ? 'selected' : '' */?>>Premium</option>
                    </select>
                    <?php /*if ($model->hasError('class_id')): */?>
                        <div class="invalid-feedback"><?php /*= $model->getFirstError('class_id') */?></div>
                    <?php /*endif; */?>
                </div>-->
            </div>
            <div class="form-column">
                <!-- This column is intentionally left empty for balance -->
            </div>
        </div>

        <div class="button-container">
            <button type="reset" class="clear-button">Clear</button>
            <button type="submit" class="submit-button">Register Vehicle</button>
        </div>
        <?php Form::end(); ?>
    </div>
</body>

</html>