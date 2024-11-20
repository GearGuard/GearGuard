<?php
$this->title = 'Customer Appointment';
?>
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
            padding: 0.75rem 1.25rem;
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

        .appointment-form {
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
        input[type="email"],
        input[type="date"],
        select,
        textarea {
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
        input[type="email"]:hover,
        input[type="date"]:hover,
        select:hover,
        textarea:hover {
            border-color: #94a3b8;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        input::placeholder,
        textarea::placeholder {
            color: #94a3b8;
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

        .book-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .book-button:active {
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

        /* Time slots styling */
        .time-slot {
            padding: 0.5rem;
            margin: 0.25rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .time-slot:hover {
            background: #eff6ff;
            border-color: #2563eb;
        }

        .time-slot.selected {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navMenu {
                flex-direction: column;
                padding: 0.5rem;
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
        <a href="#" class="active">Book Appointment</a>
        <a href="#">My Appointments</a>
        <a href="#">Service History</a>
        <a href="#">Spare Parts Warranty</a>
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
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="garage">Garage<span class="required-dot">*</span></label>
                        <select id="garage" name="garage" required>
                            <option value="">Select a Garage</option>
                            <option value="G1">G1</option>
                            <option value="G2">G2</option>
                            <option value="G3">G3</option>
                        </select>
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="date">Date<span class="required-dot">*</span></label>
                        <input type="date" id="date" name="date" required min="" onchange="updateTimeOptions()">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="time">Time<span class="required-dot">*</span></label>
                        <select id="time" name="time" required></select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Additional Notes</label>
                <textarea id="notes" class="notes" name="notes" placeholder="Enter any additional notes or special requests here"></textarea>
            </div>

            <div class="button-container">
                <button type="reset" class="clear-button">Clear Form</button>
                <button type="submit" class="book-button">Book Appointment</button>
            </div>
        </form>
    </div>

    <script>
        function setMinDate() {
            const today = new Date();
            today.setDate(today.getDate() + 5);
            const minDate = today.toISOString().split('T')[0];
            document.getElementById('date').setAttribute('min', minDate);
        }

        function updateTimeOptions() {
            const timeSelect = document.getElementById('time');
            timeSelect.innerHTML = '<option value="">Select Time</option>';

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

        window.onload = function() {
            setMinDate();
            updateTimeOptions();
        };
    </script>
</body>

</html>