<?php

/** @var $this \gearguard\phpmvc\View */
$this->title = 'Appointment';
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
            padding: 20px;
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
        }

        .navMenu a.active {
            color: #2563eb;
            background: #eff6ff;
        }

        .navMenu a:hover {
            color: #2563eb;
            background: #f8fafc;
        }

        .navMenu .dot {
            width: 4px;
            height: 4px;
            background: #2563eb;
            border-radius: 50%;
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .navMenu a:hover .dot,
        .navMenu a.active .dot {
            opacity: 1;
        }

        .appointment-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .title {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: #f8fafc;
            transition: all 0.2s ease;
        }

        .button-container {
            display: flex;
            gap: 2rem;
            justify-content: center;

        }

        .action-button {
            background: #6186D6FF;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .action-button:active {
            transform: translateY(0);
        }

        /* View button styling */
        .action-button[onclick^="viewAppointment"] {
            background: #f8fafc;
            color: #2563eb;
            border: 1px solid #e2e8f0;
        }

        .action-button[onclick^="viewAppointment"]:hover {
            background: #eff6ff;
            border-color: #2563eb;
        }

        /* Responsive design */
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

            .appointment-table {
                padding: 1rem;
            }

            th,
            td {
                padding: 0.75rem;
            }

            .button-container {
                flex-direction: column;
            }

            .action-button {
                width: 100%;

            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="#">Book Appointment<span class="dot"></span></a>
        <a href="#" class="active">My Appointments<span class="dot"></span></a>
        <a href="#">Service History<span class="dot"></span></a>
        <a href="#">Spare Parts Warranty<span class="dot"></span></a>
    </nav>

    <div class="appointment-table">
        <h2 class="title">Upcoming Scheduled Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>Service Type</th>
                    <th>Garage</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Oil Change</td>
                    <td>G1</td>
                    <td>2024-11-20</td>
                    <td class="button-container">
                        <button class="action-button" onclick="viewAppointment(1)">View More</button>
                        <button class="action-button" onclick="editAppointment(1)">Edit Reservation</button>
                    </td>
                </tr>
                <tr>
                    <td>Tire Rotation</td>
                    <td>G2</td>
                    <td>2024-11-22</td>
                    <td class="button-container">
                        <button class="action-button" onclick="viewAppointment(2)">View More</button>
                        <button class="action-button" onclick="editAppointment(2)">Edit Reservation</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function viewAppointment(id) {
            alert('Viewing appointment ID ' + id);
        }

        function editAppointment(id) {
            alert('Editing appointment ID ' + id);
        }
    </script>
</body>

</html>