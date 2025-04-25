<?php

/** @var $this \gearguard\phpmvc\View */
$this->title = 'Add Service Details';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service Details - GearGuard</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

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
            font-family: "Inter", sans-serif;
            color: var(--text);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--background);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--primary);
        }

        h1 {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary);
            font-weight: 500;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            background-color: var(--background);
            border-radius: 8px;
            color: var(--text);
            font-family: inherit;
            font-size: 1rem;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--hover-bg);
        }

        button {
            background: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: block;
            width: 100%;
            margin-top: 1rem;

        }

        button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        #vehicleDetails,
        #serviceForm {
            display: none;
        }

        .details-group {
            background: var(--background);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--text);

        }

        .details-group p {
            margin-bottom: 0.5rem;
        }

        fieldset.details-group {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        legend {
            color: var(--primary);
            font-weight: 600;
            padding: 0 0.5rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Vehicle Service Details</h1>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="plateNumber">Vehicle Plate Number:</label>
            <input type="text" id="plateNumber" name="plateNumber" required>
        </div>

        <button onclick="loadVehicleDetails()">Load Vehicle Details</button>

        <div id="vehicleDetails" class="details-group">
            <h2>Vehicle Details</h2>
            <p><strong>Customer Name:</strong> <span id="customerName"></span></p>
            <p><strong>Vehicle Model:</strong> <span id="vehicleModel"></span></p>
            <p><strong>Year Manufactured:</strong> <span id="yearManufactured"></span></p>
        </div>

        <form id="serviceForm">
            <fieldset class="details-group">
                <legend>Add Service Details</legend>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="totalCost">Total Cost:</label>
                    <input type="number" id="totalCost" name="totalCost" required>
                </div>
            </fieldset>

            <fieldset class="details-group">
                <legend>Spare Part</legend>
                <div class="form-group">
                    <label for="serialNumber">Serial Number:</label>
                    <input type="text" id="serialNumber" name="serialNumber">
                </div>
                <div class="form-group">
                    <label for="partType">Type:</label>
                    <input type="text" id="partType" name="partType">
                </div>
                <div class="form-group">
                    <label for="manufacturer">Manufacturer:</label>
                    <input type="text" id="manufacturer" name="manufacturer">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price">
                </div>
                <div class="form-group">
                    <label for="manufacturedDate">Manufactured Date:</label>
                    <input type="date" id="manufacturedDate" name="manufacturedDate">
                </div>
                <div class="form-group">
                    <label for="installedDate">Installed Date:</label>
                    <input type="date" id="installedDate" name="installedDate">
                </div>
                <div class="form-group">
                    <label for="expireDate">Expire Date:</label>
                    <input type="date" id="expireDate" name="expireDate">
                </div>
            </fieldset>

            <button type="submit">Submit Service Details</button>
        </form>
    </div>

    <script>
        function loadVehicleDetails() {
            const username = document.getElementById('username').value;
            const plateNumber = document.getElementById('plateNumber').value;

            if (username === 'abc' && plateNumber === '123') {

                setTimeout(() => {
                    document.getElementById('customerName').textContent = 'John Doe';
                    document.getElementById('vehicleModel').textContent = 'Toyota Camry';
                    document.getElementById('yearManufactured').textContent = '2019';

                    document.getElementById('vehicleDetails').style.display = 'block';
                    document.getElementById('serviceForm').style.display = 'block';
                }, 1000);
            } else {
                alert('Please enter both username and plate number.');
            }
        }

        document.getElementById('serviceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would typically send the form data to your server
            alert('Service details submitted successfully!');
        });
    </script>
</body>

</html>