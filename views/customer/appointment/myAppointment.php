<?php

/** @var $this \gearguard\phpmvc\View */
$this->title = 'Appointment';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0FF;
            --secondary: #25272d;
            --accent: #2463eb;
            --canel: #f44336;
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

        .button-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .action-button {
            background: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        .action-button:active {
            transform: translateY(0);
        }

        .action-button[onclick^="viewAppointment"] {
            background: #4a4e59;
            color: #e6e6e6;
            border: 1px solid var(--border);
        }

        .action-button[onclick^="viewAppointment"]:hover {
            background: #555a66;
            border-color: var(--accent);
        }

        .action-button[onclick^="deleteAppointment"] {
            background: var(--canel);
            color: var(--primary);
            border: 1px solid var(--border);
        }

        .action-button[onclick^="deleteAppointment"]:hover {
            background: #C70039;
            border-color: var(--accent);
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: var(--secondary);
            padding: 2rem;
            border-radius: 12px;
            color: var(--text);
            max-width: 500px;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        .modal-form-group {
            margin-bottom: 1rem;
        }

        .modal-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .modal-input {
            width: 100%;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid var(--border);
            background-color: var(--background);
            color: var(--text);
        }

        .modal-textarea {
            width: 100%;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid var(--border);
            background-color: var(--background);
            color: var(--text);
            resize: vertical;
            min-height: 100px;
        }

        .modal-button {
            margin-top: 1rem;
            padding: 0.75rem 1rem;
            background: var(--accent);
            color: var(--text);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .modal-button:hover {
            background: #1b4ebd;
        }

        .modal-button.cancel {
            background: var(--secondary);
            border: 1px solid var(--border);
        }

        .modal-button.cancel:hover {
            background: var(--hover-bg);
            border-color: var(--accent);
        }

        .modal-button.delete {
            background: var(--canel);
            border: 1px solid var(--border);
        }

        .modal-button.delete:hover {
            background: #C70039;
            border-color: var(--accent);
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
        <a href="/customer/appointment/appoint" target='_self'>Book Appointment<span class="dot"></span></a>
        <a href="#" class="active">My Appointments<span class="dot"></span></a>
        <a href="/customer/appointment/service_history" target='_self'>Service History<span class="dot"></span></a>
        <a href="/customer/appointment/spareparts_warranty" target='_self'>Spare Parts Warranty<span class="dot"></span></a>
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
            <tbody id="appointmentTableBody">

            </tbody>
        </table>
        <div id="loader" style="text-align: center; display: block; margin-top: 0.3em;">Loading appointments...</div>
        <div id="noAppointments" style="text-align: center; display: none; margin-top: 1em;">No appointments found</div>
    </div>

    <script>
        function isFutureDate(dateStr) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const appointmentDate = new Date(dateStr);
            return appointmentDate >= today;
        }

        async function fetchAppointments() {
            const loader = document.getElementById('loader');
            const noAppointments = document.getElementById('noAppointments');
            const tableBody = document.getElementById('appointmentTableBody');

            try {
                loader.style.display = 'block';
                noAppointments.style.display = 'none';

                const response = await fetch('/customer/appointment/getMyAppointments');
                const appointments = await response.json();

                loader.style.display = 'none';
                tableBody.innerHTML = '';

                const upcomingAppointments = appointments.filter(app => isFutureDate(app.date));

                if (upcomingAppointments.length > 0) {
                    upcomingAppointments.forEach(appointment => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${appointment.service_type || 'N/A'}</td>
                            <td>${appointment.garage_name || 'N/A'}</td>
                            <td>${appointment.date || 'N/A'}</td>
                            <td class="button-container">
                                <button class="action-button" onclick='viewAppointment(${JSON.stringify(appointment)})'>View More</button>
                                <button class="action-button" onclick='editAppointment(${JSON.stringify(appointment)})'><i class="fas fa-pencil"></i></button>
                                <button class="action-button" onclick='deleteAppointment(${appointment.id})'><i class="fas fa-trash"></i></button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    noAppointments.style.display = 'block';
                }
            } catch (error) {
                console.error('Error fetching appointments:', error);
                loader.style.display = 'none';
                noAppointments.style.display = 'block';
                noAppointments.textContent = 'Error loading appointments. Please try again later.';
            }
        }

        function viewAppointment(appointment) {
            const modal = document.createElement('div');
            modal.classList.add('modal');

            const content = document.createElement('div');
            content.classList.add('modal-content');

            content.innerHTML = `
                <h2 class="modal-title">${appointment.service_type || 'Appointment Details'}</h2>
                <p><strong>Garage:</strong> ${appointment.garage_name || 'N/A'}</p>
                <p><strong>Date:</strong> ${appointment.date || 'N/A'}</p>
                <p><strong>Time:</strong> ${appointment.time || 'Not specified'}</p>
                <p><strong>Vehicle:</strong> ${appointment.vehicle_model || 'Not specified'}</p>
                <p><strong>Status:</strong> ${appointment.status || 'Pending'}</p>
                <p><strong>Notes:</strong> ${appointment.notes || 'None'}</p>
                <button class="modal-button" onclick='this.closest(".modal").remove()'>Close</button>
            `;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function editAppointment(appointment) {
            const modal = document.createElement('div');
            modal.classList.add('modal');

            const content = document.createElement('div');
            content.classList.add('modal-content');

            const customStyles = `
                <style>
                    .custom-date-input::-webkit-calendar-picker-indicator,
                    .custom-time-input::-webkit-calendar-picker-indicator {
                        filter: invert(100%);
                    }
                </style>
            `;

            content.innerHTML = customStyles + `
                <h2 class="modal-title">Edit Appointment</h2>
                <form action="/customer/appointment/update" method="post">
                    <input type="hidden" name="id" value="${appointment.id}">
                    <div class="modal-form-group">
                        <label class="modal-label" for="date">Date:</label>
                        <input class="modal-input custom-date-input" type="date" id="date" name="date" value="${appointment.date}" required>
                    </div>
                    <div class="modal-form-group">
                        <label class="modal-label" for="time">Time:</label>
                        <input class="modal-input custom-time-input" type="time" id="time" name="time" value="${appointment.time}" required>
                    </div>
                    <div class="modal-form-group">
                        <label class="modal-label" for="notes">Notes:</label>
                        <textarea class="modal-textarea" id="notes" name="notes">${appointment.notes || ''}</textarea>
                    </div>
                    <button type="submit" class="modal-button">Save Changes</button>
                    <button type="button" class="modal-button cancel" onclick='this.closest(".modal").remove()'>Cancel</button>
                </form>
            `;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function deleteAppointment(id) {
            const modal = document.createElement('div');
            modal.classList.add('modal');

            const content = document.createElement('div');
            content.classList.add('modal-content');
            content.style.maxWidth = '400px';

            content.innerHTML = `
                <h2 class="modal-title">Confirm Cancellation</h2>
                <p>Are you sure you want to delete this appointment?</p>
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 5px;">
                    <button type="button" class="modal-button cancel" id="noButton">No</button>
                    <button type="button" class="modal-button delete" id="yesButton">Yes</button>
                </div>
            `;

            modal.appendChild(content);
            document.body.appendChild(modal);

            document.getElementById('noButton').addEventListener('click', function() {
                modal.remove();
            });

            document.getElementById('yesButton').addEventListener('click', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/customer/appointment/delete`;
                form.innerHTML = `<input type="hidden" name="id" value="${id}">`;
                form.style.display = 'none';
                document.body.appendChild(form);
                form.submit();
                modal.remove();
                
                setTimeout(fetchAppointments, 500);
            });
        }

        document.addEventListener('DOMContentLoaded', fetchAppointments);
    </script>
</body>

</html>