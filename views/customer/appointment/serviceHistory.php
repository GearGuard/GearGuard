<?php

/** @var $this \gearguard\phpmvc\View */
$this->title = 'Spare Parts Management';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spare Parts Management</title>
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
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .spare-parts-table {
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
            gap: 0.5rem;
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

        .action-button.view {
            background: var(--secondary);
            color: var(--accent);
            border: 1px solid var(--border);
        }

        .action-button.view:hover {
            background: var(--hover-bg);
            border-color: var(--accent);
        }

        .action-button.edit {
            background: #30414FFF;
        }

        .action-button.delete {
            background: #FF6357FF;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: var(--secondary);
            margin: 15% auto;
            padding: 20px;
            border: 1px solid var(--border);
            border-radius: 12px;
            width: 80%;
            max-width: 500px;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content input,
        .modal-content select {
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: var(--background);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 8px;
        }

        .modal-content label {
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }

        .close {
            color: var(--text);
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: var(--accent);
        }

        @media (max-width: 768px) {
            .navMenu {
                flex-direction: column;
                gap: 0.5rem;
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
        <a href="/customer/appointment/my_appointment" target='_self'>My Appointments</a>
        <a href="#" class="active" target='_self'>Service History<span class="dot"></span></a>
        <a href="/customer/appointment/spareparts_warranty" target='_self'>Spare Parts Warranty<span class="dot"></span></a>
    </nav>
    <div class="spare-parts-table">
        <h2 class="title">Service History</h2>
        <table>
            <thead>
                <tr>
                    <th>Vehicle Number Plate</th>
                    <th>Service Date</th>
                    <th>Garage Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="serviceHistoryBody"></tbody>
        </table>
        <div id="loader" style="text-align:center; margin-top: 1em;">Loading Past Appointment Details...</div>
        <div id="noService" style="display:none; text-align:center; margin-top: 1em;">No Service History found</div>
    </div>

    <script>
        async function fetchServicePerform() {
            const loader = document.getElementById('loader');
            const noService = document.getElementById('noService');
            const tableBody = document.getElementById('serviceHistoryBody');

            try {
                loader.style.display = 'block';
                noService.style.display = 'none';

                const response = await fetch('/customer/appointment/service_history_customer');
                const serviceHistory = await response.json();

                loader.style.display = 'none';
                tableBody.innerHTML = '';

                if (serviceHistory && serviceHistory.length > 0) {
                    serviceHistory.forEach(service => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${service['Vehicle Number Plate'] || 'N/A'}</td>
                    <td>${service['Service Date'] || 'N/A'}</td>
                    <td>${service['Garage Name'] || 'N/A'}</td>
                    
                    <td class="button-container">
                        <button class="action-button view" onclick="viewServicePerform(${JSON.stringify(service)})">View</button>
                        <button class="action-button delete" onclick="deleteServicePerform(${service.id})">Delete</button>
                    </td>
                `;
                        tableBody.appendChild(row);
                    });
                } else {
                    noService.style.display = 'block';
                }
            } catch (error) {

                loader.style.display = 'none';
                noService.style.display = 'block';
                noService.textContent = 'Error loading service history. Please try again later.';
            }
        }

        function viewServicePerform(service) {
            const modal = document.createElement('div');
            modal.classList.add('modal');


            const content = document.createElement('div');
            content.classList.add('modal-content');

            content.innerHTML = `
        <h2>Spare Part Details</h2>
        <p>License Plate: ${service['Vehicle Number Plate'] || 'N/A'}</p>
        <p>Service Date: ${service['Service Date'] || 'N/A'}</p>
        <p>Garage Name: ${service['Garage Name'] || 'N/A'}</p>
        <p>Service Duration: ${service['Service Duration'] || 'N/A'}</p>
        <p>Service Notes: ${service['Service Notes'] || 'N/A'}</p>
        <span class="close" onclick="document.body.removeChild(modal)">&times;</span>
        <button class="action-button" onclick="document.body.removeChild(modal)">Close</button>
        `;

            modal.innerHTML = `
        <div class="modal-content">
            <span class="close" onclick="document.body.removeChild(modal)">&times;</span>
            <h2>Service Details</h2>
            <p>Vehicle Number Plate: ${service['Vehicle Number Plate'] || 'N/A'}</p>
            <p>Service Date: ${service['Service Date'] || 'N/A'}</p>
            <p>Garage Name: ${service['Garage Name'] || 'N/A'}</p>
            <p>Service Duration: ${service['Service Duration'] || 'N/A'}</p>
            <p>Service Notes: ${service['Service Notes'] || 'N/A'}</p>
            <button class="action-button" onclick="document.body.removeChild(modal)">Close</button>
        `;
            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function deleteServicePerform(id) {
            if (confirm('Are you sure you want to delete this service history?')) {
                fetch(`/customer/appointment/delete_service_history/`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Service history deleted successfully!');
                            fetchServicePerform();
                        } else {
                            alert('Failed to delete service history. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting service history:', error);
                        alert('An error occurred while deleting the service history. Please try again.');
                    });
            }
        }
        document.addEventListener('DOMContentLoaded', fetchServicePerform);
    </script>
</body>

</html>