<?php

/** @var $this \app\core\View */
$this->title = 'Appointment';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #F2F6FCFF;
            font-family: "Montserrat", sans-serif;
        }

        .navMenu {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            top: 0;
            padding: 20px 0;
        }

        .navMenu a {
            color: #002366;
            text-decoration: none;
            font-size: 1em;
            text-transform: uppercase;
            font-weight: 500;
            display: inline-block;
            margin: 0 15px;
            position: relative;
        }

        .navMenu a:hover {
            color: #002366;
        }

        .navMenu .dot {
            width: 6px;
            height: 6px;
            background: #002366;
            border-radius: 50%;
            position: absolute;
            bottom: -10px;
            /* Position it below the text */
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            /* Initially hidden */
            transition: all 0.5s ease-in-out;
        }

        .navMenu a:hover .dot {
            opacity: 1;
            /* Show dot on hover */
        }

        /* Active link styling */
        .navMenu a.active {
            color: #002366;
            /* Change color for active link */
            font-weight: bold;
            /* Make active link bold */
        }

        .navMenu a.active .dot {
            opacity: 1;
            /* Ensure dot is visible for active link */
        }

        /* Form styling */
        .appointment-form {
            max-width: 900px;
            margin: 10px auto;
            /* Center the form */
            padding: 20px;
            background-color: rgba(238, 245, 249, 0.5);
            opacity: 0.8;
            /* White background for the form */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            /* Subtle shadow for depth */
        }

        .form-group {
            margin-bottom: 15px;
            /* Spacing between form groups */
        }

        label {
            display: block;
            /* Block display for labels */
            margin-bottom: 10px;
            /* Space between label and input */
            font-weight: 500;
            /* Bold labels for emphasis */
            text-align: left;
            /* Align labels to the left */
            margin-left: 13px
        }

        input[type="text"],
        input[type="email"],
        select,
        input[type="date"],
        input[type="time"] {
            width: calc(100% - 20px);
            /* Full width inputs minus padding */
            padding: 10px;
            /* Padding inside inputs */
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            /* Rounded corners for inputs */
            border: 1px solid #ccc;
            /* Light border around inputs */
            font-size: 16px;
            /* Font size for inputs */
        }

        input::placeholder {
            font-style: italic;
            font-size: 14px;
            color: dimgrey;
            /* Italic placeholder text */
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus,
        input[type="date"]:focus,
        input[type="time"]:focus {
            border-color: #002366;
            /* Change border color on focus */
            outline: none;
            /* Remove default outline on focus */
        }

        .notes {
            width: calc(100% - 20px);
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            resize: none;
            font-family: "Montserrat", sans-serif;
            /* Disable resizing */
            height: 100px;
            /* Set a fixed height */
        }

        .book-button {
            background-color: #002366;
            /* Button color */
            color: white;
            /* Button text color */
            padding: 12px 20px;
            /* Padding inside book-button */
            border-radius: 5px;
            /* Rounded corners for book-button */
            border: none;
            /* Remove default border */
            cursor: pointer;
            /* Pointer cursor on hover */
            font-size: 16px;
            letter-spacing: 2px;
            /* Font size for book-button text */
            transition: background-color 0.3s ease;
            margin-top: 20px;
            margin-bottom: 10px;
            display: inline-block;

            /* Transition effect on hover */
        }

        .clear-button {
            background-color: #BFC6D5FF;
            /* Button color */
            color: black;
            /* Button text color */
            padding: 10px 16px;
            /* Padding inside book-button */
            border-radius: 5px;
            /* Rounded corners for book-button */
            border: none;
            /* Remove default border */
            cursor: pointer;
            /* Pointer cursor on hover */
            font-size: 15px;
            letter-spacing: 2px;
            /* Font size for book-button text */
            transition: background-color 0.3s ease;
            margin-top: 20px;
            margin-left: 8px;
            margin-bottom: 10px;
            display: inline-block;

            /* Transition effect on hover */
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .book-button:hover {
            background-color: #033BA2FF;
            /* Darker shade on hover */
        }

        .title {
            text-align: center;
            margin-bottom: 40px;
            margin-top: 20px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
        }

        .form-column {
            flex-basis: 48%;
        }

        .three-column-row {
            display: flex;
            justify-content: space-between;
        }

        .three-column-row>div {
            flex-basis: 30%;
        }

        .required-dot {
            color: red;
            margin-left: 10px;

        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="#" class="active">Book Appointment<span class="dot"></span></a>
        <a href="#">My Appointments<span class="dot"></span></a>
        <a href="#">Edit Appointment<span class="dot"></span></a>
        <a href="#">Service History<span class="dot"></span></a>
        <a href="#">Spare Parts Warranty<span class="dot"></span></a>
    </nav>

    <div class="appointment-form">
        <h2 class="title">Book Your Appointment</h2>

        <form action="/submit-appointment" method="POST">
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="fname">First Name<span class="required-dot">*</span></label>
                        <input type="text" id="fname" name="fname" required placeholder="Enter your first name">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="lname">Last Name<span class="required-dot">*</span></label>
                        <input type="text" id="lname" name="lname" required placeholder="Enter your last name">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="email">Email<span class="required-dot">*</span></label>
                        <input type="email" id="email" name="email" required placeholder="Enter your email">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="phone">Contact Number<span class="required-dot">*</span></label>
                        <input type="text" id="phone" name="phone" required placeholder="Enter your phone number">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="vehicle-type">Vehicle Type<span class="required-dot">*</span></label>
                        <select id="vehicle-type" name="vehicle_type" required>
                            <option value="">Select Vehicle Type</option>
                            <option value="car">Car</option>
                            <option value="motorcycle">Motorcycle</option>
                            <option value="truck">Truck</option>
                            <!-- Add more vehicle types as needed -->
                        </select>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="service-type">Service Type<span class="required-dot">*</span></label>
                        <select id="service-type" name="service_type" required>
                            <option value="">Select Service Type</option>
                            <option value="oil_change">Oil Change</option>
                            <option value="tire_rotation">Tire Rotation</option>
                            <option value="brake_service">Brake Service</option>
                            <!-- Add more service types as needed -->
                        </select>
                    </div>
                </div>
            </div>

            <!-- Garage, Date, and Time selection in one row -->
            <div class='three-column-row'>
                <!-- Garage Field -->
                <div class='form-group'>
                    <label for='garage'>Garage<span class="required-dot">*</span></label>
                    <!-- Garage selection -->
                    <select id='garage' name='garage' required>
                        <option value="">Select a Garage</option>
                        <!-- Add garage options here -->
                        <option value='G1'>G1</option>
                        <option value='G2'>G2</option>
                        <option value='G3'>G3</option>
                    </select>
                </div>

                <!-- Date Field -->
                <div class='form-group'>
                    <label for='date'>Date<span class="required-dot">*</span></label>
                    <!-- JavaScript will set min attribute dynamically -->
                    <input type='date' id='date' name='date' required min='' onchange='updateTimeOptions()'>
                </div>

                <!-- Time Field -->
                <div class='form-group'>
                    <label for='time'>Time<span class="required-dot">*</span></label>
                    <!-- JavaScript will set available times dynamically -->
                    <select id='time' name='time' required></select>
                </div>
            </div>
            <!-- Other notes text area -->

            <div class='form-group'>
                <label for='notes'>Other Notes</label>
                <textarea id='notes' class="notes" name='notes' placeholder='Enter any additional notes here'></textarea>
            </div>
            <!-- Submit Button -->
            <div class="button-container">
                <button type='reset' class='clear-button'>Clear Form</button>
                <button type='submit' class='book-button'>Book Appointment</button>
            </div>

        </form>
    </div>

    <!-- JavaScript to handle date and time logic -->
    <script>
        // Function to set minimum date to today +5 days
        function setMinDate() {
            const today = new Date();
            today.setDate(today.getDate() + 5);
            const minDate = today.toISOString().split('T')[0];
            document.getElementById('date').setAttribute('min', minDate);
        }

        // Function to update time options based on selected date
        function updateTimeOptions() {
            const timeSelect = document.getElementById('time');
            timeSelect.innerHTML = ''; // Clear previous options

            const availableTimes = [
                "09:00", "09:30", "10:00", "10:30", "11:00", "11:30",
                "12:00", "12:30", "13:00", "13:30", "14:00", "14:30",
                "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
                "18:00"
            ];

            availableTimes.forEach(time => {
                const option = document.createElement('option');
                option.value = time;
                option.textContent = time;
                timeSelect.appendChild(option);
            });
        }

        // Initialize min date and time options when the page loads
        window.onload = function() {
            setMinDate();
            updateTimeOptions();
        };
    </script>

</body>

</html>