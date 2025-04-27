<?php
// This view file does not require direct database connection or query execution.
// The data should be passed from the controller to the view for rendering.

// Handle form submission and data processing should be done in the controller.

// The form and UI logic remain unchanged below.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Appointments</title>
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
            --danger: #ef4444;
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
            padding: 20px;
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

        .appointment-form {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .manage-form {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto 2rem;
            padding: 2rem;
        }

        
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .required-dot {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        input[type="datetime-local"],
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

        textarea {
            resize: vertical;
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

        .view-button {
            background: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.4rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 5em;
            margin: 0.2rem;
            display: table;
        }

        .success-msg {
            color: #4ade80;
            text-align: center;
            margin-bottom: 1rem;
        }

        .error-msg {
            color: #f87171;
            text-align: center;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .appointment-table {
                padding: 1rem;
            }
        }
    </style>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
</head>
<body>

    <div class="radioContainer">
        <label><input type="radio" name="searchType" value="appointment" checked> Appointment</label>
        <label><input type="radio" name="searchType" value="customer"> Direct Customer</label>
    </div>

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

    <div class="appointment-form" id="directCustomerForm" style="display: block;">
        <div class="title">Vehicle Service Details</div>

        <?php if (!empty($message)) echo $message; ?>

        <form method="POST" action="/mechanic/services/viewService">
            <!-- Vehicle (Full width) -->
            <div class="form-row">
                <div class="form-column full-width">
                    <div class="form-group">
                        <label for="vehicle_id">Vehicle</label>
                        <select name="vehicle_id" required>
                            <option value=""> Select Vehicle </option>
                            <?php if (isset($vehicles) && $vehicles !== null): ?>
                                <?php foreach($vehicles as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['license_plate_no']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No vehicles available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Service & Mechanic -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="service_id">Service</label>
                    <select name="service_id" required>
                        <option value=""> Select Service </option>
                        <?php if (isset($services) && $services !== null): ?>
                            <?php foreach($services as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['type']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No services available</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mechanic_id">Mechanic</label>
                    <select name="mechanic_id" required>
                        <option value=""> Select Mechanic </option>
                        <?php if (isset($mechanics) && $mechanics !== null): ?>
                            <?php foreach($mechanics as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['full_name']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No mechanics available</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- Begin & End Timestamp -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                <div class="form-group">
                    <label for="begin_timestamp">Begin Time</label>
                    <input type="datetime-local" name="begin_timestamp" required>
                </div>
                <div class="form-group">
                    <label for="end_timestamp">End Time</label>
                    <input type="datetime-local" name="end_timestamp" required>
                </div>
            </div>

            <!-- Notes -->
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea name="notes" rows="4" placeholder="Optional notes..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="button-container">
                <button type="reset" class="clear-button">Clear</button>
                <button type="submit" class="add-button">Add Service</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('input[name="searchType"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const appointmentTable = document.getElementById('appointmentTableContainer');
                const directCustomerForm = document.getElementById('directCustomerForm');
                if (this.value === 'appointment') {
                    appointmentTable.style.display = 'block';
                    directCustomerForm.style.display = 'none';
                } else if (this.value === 'customer') {
                    appointmentTable.style.display = 'none';
                    directCustomerForm.style.display = 'block';
                }
            });
        });

        // Ensure the correct container is visible on page load based on selected radio button
        window.addEventListener('DOMContentLoaded', () => {
            const selectedValue = document.querySelector('input[name="searchType"]:checked')?.value;
            const appointmentTable = document.getElementById('appointmentTableContainer');
            const directCustomerForm = document.getElementById('directCustomerForm');
            if (selectedValue === 'appointment') {
                appointmentTable.style.display = 'block';
                directCustomerForm.style.display = 'none';
            } else if (selectedValue === 'customer') {
                appointmentTable.style.display = 'none';
                directCustomerForm.style.display = 'block';
            } else {
                // Default: hide all if no radio button is selected
                appointmentTable.style.display = 'none';
                directCustomerForm.style.display = 'none';
            }
        
            // Load data for appointment table only
            loadAppointments();
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
            // Hide appointment table and show the form
            document.getElementById('appointmentTableContainer').style.display = 'none';
            document.getElementById('directCustomerForm').style.display = 'block';

            // Set vehicle select field based on license_plate_no from appointment
            const vehicleSelect = document.querySelector('select[name="vehicle_id"]');
            if (vehicleSelect) {
                // Find option with text matching license_plate_no and select it
                let found = false;
                for (let option of vehicleSelect.options) {
                    if (option.text === appointment.license_plate_no) {
                        option.selected = true;
                        found = true;
                    } else {
                        option.selected = false;
                    }
                }
                if (!found) {
                    vehicleSelect.selectedIndex = 0; // default to first option
                }
            }

            // Set service select field based on service_type from appointment
            const serviceSelect = document.querySelector('select[name="service_id"]');
            if (serviceSelect) {
                let found = false;
                for (let option of serviceSelect.options) {
                    if (option.text === appointment.service_type) {
                        option.selected = true;
                        found = true;
                    } else {
                        option.selected = false;
                    }
                }
                if (!found) {
                    serviceSelect.selectedIndex = 0;
                }
            }

            // Clear other fields: mechanic, begin_timestamp, end_timestamp, notes
            const mechanicSelect = document.querySelector('select[name="mechanic_id"]');
            if (mechanicSelect) {
                mechanicSelect.selectedIndex = 0;
            }
            const beginInput = document.querySelector('input[name="begin_timestamp"]');
            if (beginInput) {
                beginInput.value = '';
            }
            const endInput = document.querySelector('input[name="end_timestamp"]');
            if (endInput) {
                endInput.value = '';
            }
            const notesTextarea = document.querySelector('textarea[name="notes"]');
            if (notesTextarea) {
                notesTextarea.value = '';
            }

            // Scroll to form
            document.getElementById('directCustomerForm').scrollIntoView({ behavior: 'smooth' });
        }
        // Function to load and display appointments from the server
        function loadAppointments() {
            fetch('/mechanic/services/loadAppointments')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#appointmentTable tbody');
                tbody.innerHTML = '';
                
                // Display message if no appointments found
                if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="no-results">❌ No appointments found.</td></tr>';
                return;
                }

                // Create table rows for each appointment
                data.forEach(appointment => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${appointment.vehicle_type}</td>
                    <td>${appointment.client_name}</td>
                    <td>${appointment.contact_number}</td>
                    <td>${appointment.license_plate_no}</td>
                    <td>${appointment.service_type}</td>
                    <td>${appointment.date_time}</td>
                    <td><button class="view-button" onclick='viewDetails(${JSON.stringify(appointment)})'>View</button></td>
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

        // Function to load and display service assignments from the server
        function loadServiceAssignments() {
            fetch('/mechanic/services/loadServiceAssignments')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#timeTable tbody');
                tbody.innerHTML = '';
                
                // Display message if no service assignments found
                if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="no-results">❌ No service assignments found.</td></tr>';
                return;
                }

                // Create table rows for each service assignment
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
