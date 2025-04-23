<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View All Appointments</title>
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

        .navMenu .dot {
            width: 4px;
            height: 4px;
            background: var(--accent);
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
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .title {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .SearchBar {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .radioContainer {
            background-color: var(--secondary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6rem;
            width: 40%;
            padding: 1.5rem;
            margin: 0 auto 2rem;
        }

        #searchBox {
            width: 20rem;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background: var(--secondary);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem;
            border-bottom: 2px solid var(--border);
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: var(--hover-bg);
            transition: all 0.2s ease;
        }

        .no-results {
            text-align: center;
            color: var(--primary);
            margin-top: 1rem;
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

            .appointment-table {
                padding: 1rem;
            }

            th, td {
                padding: 0.75rem;
            }
        }
    </style>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
</head>
<body>
<nav class="navMenu">
        <a href="/mechanic/services/addService" target="_self">Assign New Service</a>
        <a href="#" class="active">All Services</a>
        <a href="/mechanic/services/editService" target="_self">Edit Services</a>
        <a href="/mechanic/services/deleteService" target="_self">Delete Services</a>
    </nav>

        <!-- <div class="SearchBar">
        <label for="searchBox">Search:</label>
        <input type="text" id="searchBox" onkeyup="search()"> -->
        <div class="radioContainer">
            <label><input type="radio" name="searchType" value="appointment"> Appointment</label>
            <label><input type="radio" name="searchType" value="customer"> Direct Customer</label>
        </div>
        <!-- </div> -->

    <div class="appointment-table" id="appointmentTableContainer" style="display: none;">
        <h2 class="title">All Appointments</h2>
        <table id="appointmentTable">
            <thead>
                <tr>
                    <th>Vehicle Type</th>
                    <th>Client's Name</th>
                    <th>Contact Number</th>
                    <th>Number Plate</th>
                    <th>Service Type</th>
                    <th>Date & Time</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <p id="loader" class="no-results">Loading...</p>
    </div>

    <div class="appointment-table" id="timeTableContainer" style="display: none;">
        <div class="title">Vehicle Service Assignments</div>
        <table id="timeTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vehicle</th>
                    <th>Service</th>
                    <th>Mechanic</th>
                    <th>Begin</th>
                    <th>End</th>
                    <th>Duration</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Removed direct DB connection and query to fit framework usage
                // Assuming $serviceAssignments is passed from the controller

                if (!empty($serviceAssignments)) {
                    foreach ($serviceAssignments as $assignment) {
                        echo "<tr>
                                <td>" . htmlspecialchars($assignment['id']) . "</td>
                                <td>" . htmlspecialchars($assignment['license_plate_no']) . "</td>
                                <td>" . htmlspecialchars($assignment['service_type']) . "</td>
                                <td>" . htmlspecialchars($assignment['mechanic_name']) . "</td>
                                <td>" . htmlspecialchars($assignment['begin_timestamp']) . "</td>
                                <td>" . htmlspecialchars($assignment['end_timestamp']) . "</td>
                                <td>" . htmlspecialchars($assignment['duration']) . "</td>
                                <td>" . htmlspecialchars($assignment['notes']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='no-results'>❌ No service assignments found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('input[name="searchType"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const appointmentTable = document.getElementById('appointmentTableContainer');
                const timeTable = document.getElementById('timeTableContainer');
                if (this.value === 'appointment') {
                    appointmentTable.style.display = 'block';
                    timeTable.style.display = 'none';
                } else {
                    appointmentTable.style.display = 'none';
                    timeTable.style.display = 'block';
                }
            });
        });

        // Initialize table visibility based on selected radio button on page load
        window.addEventListener('DOMContentLoaded', () => {
            const selectedValue = document.querySelector('input[name="searchType"]:checked')?.value;
            const appointmentTable = document.getElementById('appointmentTableContainer');
            const timeTable = document.getElementById('timeTableContainer');
            if (selectedValue === 'appointment') {
                appointmentTable.style.display = 'block';
                timeTable.style.display = 'none';
            } else if (selectedValue === 'customer') {
                appointmentTable.style.display = 'none';
                timeTable.style.display = 'block';
            } else {
                // Default: hide both tables if no radio button is selected
                appointmentTable.style.display = 'none';
                timeTable.style.display = 'none';
            }

            // Load data for both tables
            loadAppointments();
            loadServiceAssignments();
        });

        function search() {
            const input = document.getElementById("searchBox").value.toLowerCase();
            const rows = document.querySelectorAll("#appointmentTable tbody tr");
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        }

        let page = 1;
        let isLoading = false;
        let hasMoreData = true;
        const limit = 25;
        const loader = document.getElementById('loader');

        function viewDetails(appointment) {
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            modal.style.zIndex = '1000';

            const content = document.createElement('div');
            content.style.backgroundColor = '#25272d';
            content.style.padding = '20px';
            content.style.borderRadius = '8px';
            content.style.color = '#f5f5f5';

            content.innerHTML = `<h2>${appointment.license_plate_no}</h2>
                                 <p>Vehicle Model: ${appointment.vehicle_model}</p>
                                 <p>Notes: ${appointment.notes}</p>
                                 <button onclick="this.parentElement.parentElement.remove()">Close</button>`;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function loadAppointments() {
            fetch('/mechanic/services/loadAppointments')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#appointmentTable tbody');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8" class="no-results">❌ No appointments found.</td></tr>';
                        return;
                    }
                    data.forEach(appointment => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${appointment.vehicle_type}</td>
                            <td>${appointment.client_name}</td>
                            <td>${appointment.contact_number}</td>
                            <td>${appointment.license_plate_no}</td>
                            <td>${appointment.service_type}</td>
                            <td>${appointment.date_time}</td>
                            <td><button onclick='viewDetails(${JSON.stringify(appointment)})'>View</button></td>
                            <td></td>
                        `;
                        tbody.appendChild(tr);
                    });
                    loader.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error loading appointments:', error);
                    loader.textContent = 'Error loading appointments.';
                });
        }

        function loadServiceAssignments() {
            fetch('/mechanic/services/loadServiceAssignments')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#timeTable tbody');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8" class="no-results">❌ No service assignments found.</td></tr>';
                        return;
                    }
                    data.forEach(assignment => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${assignment.id}</td>
                            <td>${assignment.license_plate_no}</td>
                            <td>${assignment.service_type}</td>
                            <td>${assignment.mechanic_name}</td>
                            <td>${assignment.begin_timestamp}</td>
                            <td>${assignment.end_timestamp}</td>
                            <td>${assignment.duration}</td>
                            <td>${assignment.notes}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => {
                    console.error('Error loading service assignments:', error);
                    const tbody = document.querySelector('#timeTable tbody');
                    tbody.innerHTML = '<tr><td colspan="8" class="no-results">Error loading service assignments.</td></tr>';
                });
        }
    </script>
   
</body>
</html>
