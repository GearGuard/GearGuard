<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8fafc;
            font-family: "Inter", sans-serif;
            color: #334155;
            line-height: 1.6;
            padding: 10px;
        }

        .navMenu {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
            color: #64748b;
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
            color: #2563eb;
            background: #eff6ff;
        }

        .navMenu a:hover {
            color: #2563eb;
            background: #f8fafc;
        }

        .vehicle-form {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .title {
            color: #1e293b;
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
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .required-dot {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #fff;
            color: #1e293b;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        input[type="text"]:hover,
        input[type="date"]:hover,
        select:hover {
            border-color: #94a3b8;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
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
            background: #2563eb;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .submit-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .clear-button {
            background: #f1f5f9;
            color: #475569;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .clear-button:hover {
            background: #e2e8f0;
            color: #1e293b;
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
    <nav class="navMenu">
        <a href="#" class="active">New Vehicle</a>
        <a href="#">My Vehicle</a>
        <a href="#">Service History</a>
    </nav>

    <div class="vehicle-form">
        <h2 class="title">Register New Vehicle</h2>

        <form action="/register-vehicle" method="POST" id="vehicleForm">
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
                        <label for="year">Manufactured Year<span class="required-dot">*</span></label>
                        <select id="year" name="year" required>
                            <option value="">Select Year</option>
                        </select>
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="plate-number">Number Plate<span class="required-dot">*</span></label>
                        <input type="text" id="plate-number" name="plate_number" required placeholder="Enter plate number">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="nic">Registered NIC<span class="required-dot">*</span></label>
                        <input type="text" id="nic" name="nic" required placeholder="Enter NIC number">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="nickname">Vehicle Nickname</label>
                        <input type="text" id="nickname" name="nickname" placeholder="Enter nickname for your vehicle">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="bought-date">Vehicle Bought Date<span class="required-dot">*</span></label>
                        <input type="date" id="bought-date" name="bought_date" required>
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="fuel-type">Fuel Type<span class="required-dot">*</span></label>
                        <select id="fuel-type" name="fuel_type" required>
                            <option value="">Select Fuel Type</option>
                            <option value="petrol">Petrol</option>
                            <option value="diesel">Diesel</option>
                            <option value="electric">Electric</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="is-hybrid" name="is_hybrid">
                    <label for="is-hybrid">This is a hybrid vehicle</label>
                </div>
            </div>

            <div class="button-container">
                <button type="reset" class="clear-button">Clear Form</button>
                <button type="submit" class="submit-button">Register Vehicle</button>
            </div>
        </form>
    </div>

    <script>
        // Populate year dropdown with years from 1990 to current year
        function populateYears() {
            const yearSelect = document.getElementById('year');
            const currentYear = new Date().getFullYear();

            for (let year = currentYear; year >= 1990; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            }
        }

        // Set max date for bought date to today
        function setMaxDate() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('bought-date').setAttribute('max', today);
        }

        // Form validation
        function validateForm(event) {
            const plateNumber = document.getElementById('plate-number').value;
            const nic = document.getElementById('nic').value;

            // Add your custom validation rules here
            // For example, validate plate number format, NIC format, etc.

            // This is a basic example - modify according to your needs
            if (plateNumber.length < 6) {
                alert('Please enter a valid plate number');
                event.preventDefault();
                return false;
            }

            if (nic.length < 10) {
                alert('Please enter a valid NIC number');
                event.preventDefault();
                return false;
            }

            return true;
        }

        // Initialize form
        window.onload = function() {
            populateYears();
            setMaxDate();

            // Add form validation on submit
            document.getElementById('vehicleForm').addEventListener('submit', validateForm);
        };
    </script>
</body>

</html>