<?php
$this->title = 'Customer Appointment';
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
            width: fit-content;
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
            max-width: 1200px;
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

        input[type="text"]:hover,
        input[type="email"]:hover,
        input[type="date"]:hover,
        select:hover,
        textarea:hover {
            border-color: var(--accent);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
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
</head>

<body>
    <nav class="navMenu">
        <a href="/admin/viewvehicles">View Vehicles</a>
        <a href="/admin/addvehicle" class="active">Add New Vehicle</a>
        <a href="/admin/editvehicle">Edit Vehicle</a>
    </nav>

    <div class="appointment-form">
    <h2 class="title">Add New Vehicle</h2>
    <form action="/admin/addvehiclepost" method="POST">
        <div class="form-row">
            <div class="form-column">
                <div class="form-group">
                    <label for="owner-name">Owner Name<span class="required-dot">*</span></label>
                    <select id="owner-name" name="owner_id" required>
                        <option value="">Select Vehicle Owner</option>
                        <?php if (!empty($owners)): ?>
                            <?php foreach ($owners as $owner): ?>
                                <option value="<?= htmlspecialchars($owner['user_id']) ?>"><?= htmlspecialchars($owner['first_name'] . ' ' . $owner['last_name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <label for="vehicle-make">Vehicle Make<span class="required-dot">*</span></label>
                    <select id="vehicle-make" name="manufacturer_id" required>
                        <option value="">Select Vehicle Make</option>
                        <?php if (!empty($manufacturers)): ?>
                            <?php foreach ($manufacturers as $manufacturer): ?>
                                <option value="<?= htmlspecialchars($manufacturer['id']) ?>"><?= htmlspecialchars($manufacturer['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <div class="form-group">
                    <label for="vehicle-model">Vehicle Model<span class="required-dot">*</span></label>
                    <select id="vehicle-model" name="model_id" required>
                        <option value="">Select Vehicle Model</option>
                        <?php if (!empty($models)): ?>
                            <?php foreach ($models as $model): ?>
                                <option value="<?= htmlspecialchars($model['id']) ?>"><?= htmlspecialchars($model['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <label for="vehicle-year">Year Manufactured<span class="required-dot">*</span></label>
                    <input type="date" id="vehicle-year" name="year_manufactured" required placeholder="Enter vehicle year">
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <div class="form-group">
                    <label for="license-plate">License Plate<span class="required-dot">*</span></label>
                    <input type="text" id="license-plate" name="license_plate_no" required placeholder="Enter license plate">
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <label for="bodytype">Vehicle Shape<span class="required-dot">*</span></label>
                    <select id="bodytype" name="bodytype_id" required>
                        <option value="">Select Vehicle Shape</option>
                        <?php if (!empty($shapes)): ?>
                            <?php foreach ($shapes as $shape): ?>
                                <option value="<?= htmlspecialchars($shape['id']) ?>"><?= htmlspecialchars($shape['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <div class="form-group">
                    <label for="class">Vehicle Class<span class="required-dot">*</span></label>
                    <select id="class" name="class_id" required>
                        <option value="">Select Vehicle Class</option>
                        <?php if (!empty($classes)): ?>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= htmlspecialchars($class['id']) ?>"><?= htmlspecialchars($class['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <label for="engine-capacity">Engine Capacity<span class="required-dot">*</span></label>
                    <select id="engine-capacity" name="engine_capacity_id" required>
                        <option value="">Select Engine Capacity</option>
                        <?php if (!empty($engineCapacities)): ?>
                            <?php foreach ($engineCapacities as $engineCapacity): ?>
                                <option value="<?= htmlspecialchars($engineCapacity['id']) ?>"><?= htmlspecialchars($engineCapacity['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <div class="form-group">
                    <label for="fuel-type">Fuel Type<span class="required-dot">*</span></label>
                    <select id="fuel-type" name="fuel_type_id" required>
                        <option value="">Select Fuel Type</option>
                        <?php if (!empty($fuelTypes)): ?>
                            <?php foreach ($fuelTypes as $fuelType): ?>
                                <option value="<?= htmlspecialchars($fuelType['id']) ?>"><?= htmlspecialchars($fuelType['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <label for="insurance-no">Insurance Number</label>
                    <input type="text" id="insurance-no" name="insurance_no" placeholder="Enter insurance number">
                </div>
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
                    <label for="vehicle-type">Vehicle Type<span class="required-dot">*</span></label>
                    <select id="vehicle-type" name="vehicle_type_id" required>
                        <option value="">Select Vehicle Type</option>
                        <?php if (!empty($vehicleTypes)): ?>
                            <?php foreach ($vehicleTypes as $vehicleType): ?>
                                <option value="<?= htmlspecialchars($vehicleType['id']) ?>"><?= htmlspecialchars($vehicleType['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-column">
                <div class="form-group">
                    <label for="status">Vehicle Status<span class="required-dot">*</span></label>
                    <select id="status" name="status_id" required>
                        <option value="">Select Vehicle Status</option>
                        <?php if (!empty($statuses)): ?>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= htmlspecialchars($status['id']) ?>"><?= htmlspecialchars($status['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="button-container">
            <button type="reset" class="clear-button">Clear</button>
            <button type="submit" class="book-button">Add Vehicle</button>
        </div>
    </form>
</div>
</body>

</html>