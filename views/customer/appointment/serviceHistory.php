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
    <!-- Adding FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navMenu {
            background-color: var(--secondary);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            border-radius: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 85%;
            padding: 0.8rem;
            margin: 0 auto 2.5rem;
            position: sticky;
            top: 20px;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        .navMenu a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
            font-weight: 600;
        }

        .navMenu a.active::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background-color: var(--accent);
            border-radius: 50%;
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
            transform: translateY(-2px);
        }

        .page-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text);
            opacity: 0.7;
            font-size: 1rem;
        }

        .spare-parts-table {
            background: var(--secondary);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .title {
            color: var(--primary);
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }

        .title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
        }

        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            margin-top: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        th {
            background: var(--secondary);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1.2rem 1rem;
            border-bottom: 2px solid var(--border);
            text-align: left;
        }

        td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            font-size: 0.95rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr {
            transition: all 0.2s ease;
        }

        tr:hover {
            background: var(--hover-bg);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .button-container {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-start;
        }

        .action-button {
            background: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .action-button:hover {
            background: #1b4ebd;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(36, 99, 235, 0.2);
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
            background: #30414F;
        }

        .action-button.delete {
            background: #FF6357;
        }

        .action-button i {
            margin-right: 5px;
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
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background-color: var(--secondary);
            margin: 10% auto;
            padding: 2rem;
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.4s ease;
            position: relative;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h2 {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .modal-body {
            margin-bottom: 1.5rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .modal-body .detail-item {
            margin-bottom: 0.5rem;
        }

        .modal-body .detail-label {
            font-weight: 500;
            color: var(--primary);
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
            display: block;
        }

        .modal-body .detail-value {
            font-size: 1rem;
            color: var(--text);
            padding: 0.5rem;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            display: block;
        }

        /* For longer text content like notes */
        .modal-body .full-width {
            grid-column: 1 / -1;
        }

        .modal-body .full-width .detail-value {
            min-height: 60px;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content input,
        .modal-content select {
            margin-bottom: 1.2rem;
            padding: 0.75rem;
            background-color: var(--background);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .modal-content input:focus,
        .modal-content select:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 2px rgba(36, 99, 235, 0.2);
        }

        .modal-content label {
            margin-bottom: 0.5rem;
            color: var(--primary);
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
            border-top: 1px solid var(--border);
            padding-top: 1.5rem;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            color: var(--text);
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .close:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        #loader {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2rem auto;
            gap: 10px;
        }

        #loader::before {
            content: '';
            width: 20px;
            height: 20px;
            border: 3px solid var(--border);
            border-top-color: var(--accent);
            border-radius: 50%;
            animation: spin 1s infinite linear;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        #noService {
            padding: 2rem;
            text-align: center;
            color: var(--text);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin: 2rem auto;
        }

        @media (max-width: 900px) {
            .navMenu {
                width: 95%;
                padding: 0.5rem;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .navMenu a {
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
                margin: 0.2rem;
            }

            .title {
                font-size: 1.5rem;
            }

            .spare-parts-table {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .navMenu {
                flex-direction: column;
                gap: 0.5rem;
                padding: 1rem;
            }

            .navMenu a {
                width: 100%;
                text-align: center;
            }

            .button-container {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-button {
                width: 100%;
            }

            .modal-content {
                width: 95%;
                padding: 1.5rem;
                margin: 15% auto;
            }

            .modal-body {
                grid-template-columns: 1fr;
            }

            th,
            td {
                padding: 0.8rem 0.5rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navMenu">
            <a href="/customer/appointment/appoint" target='_self'>Book Appointment</a>
            <a href="/customer/appointment/my_appointment" target='_self'>My Appointments</a>
            <a href="#" class="active" target='_self'>Service History</a>
            <a href="/customer/appointment/spareparts_warranty" target='_self'>Spare Parts Warranty</a>
        </nav>

        <div class="page-header">
            <h1 class="page-title">Service History</h1>
            <p class="page-subtitle">View your vehicle's past service records</p>
        </div>

        <div class="spare-parts-table">
            <div class="table-container">
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
            </div>
            <div id="loader">Loading Past Appointment Details...</div>
            <div id="noService" style="display:none;">No Service History found</div>
        </div>
    </div>

    <script>
        async function fetchServicePerform() {
            const loader = document.getElementById('loader');
            const noService = document.getElementById('noService');
            const tableBody = document.getElementById('serviceHistoryBody');

            try {
                loader.style.display = 'flex';
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
                                <button class="action-button view" onclick="viewServicePerform(${JSON.stringify(service).replace(/"/g, '&quot;')})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="action-button delete" onclick="deleteServicePerform(${service.id})">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
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
            modal.style.display = 'block'; // Make modal visible

            const content = document.createElement('div');
            content.classList.add('modal-content');

            content.innerHTML = `
                <span class="close" onclick="closeModal(this)"><i class="fas fa-times"></i></span>
                <div class="modal-header">
                    <h2><i class="fas fa-car"></i>  Service Details</h2>
                </div>
                <div class="modal-body">
                    <div class="detail-item">
                        <span class="detail-label">Vehicle Number Plate</span>
                        <span class="detail-value">${service['Vehicle Number Plate'] || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Service Date</span>
                        <span class="detail-value">${service['Service Date'] || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Garage Name</span>
                        <span class="detail-value">${service['Garage Name'] || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Service Duration</span>
                        <span class="detail-value">${service['Service Duration'] || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Service Cost</span>
                        <span class="detail-value">${service['Service Cost'] || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Mechanic Name</span>
                        <span class="detail-value">${service['Mechanic Name'] || 'N/A'}</span>
                    </div>
                    <div class="detail-item full-width">
                        <span class="detail-label">Service Notes</span>
                        <span class="detail-value">${service['Service Notes'] || 'N/A'}</span>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="action-button" onclick="closeModal(this)">
                        <i class="fas fa-times-circle"></i> Close
                    </button>
                </div>
            `;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function closeModal(element) {
            const modal = element.closest('.modal');
            if (modal) {
                modal.style.opacity = '0';
                modal.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    document.body.removeChild(modal);
                }, 300);
            }
        }

        function deleteServicePerform(id) {
            const modal = document.createElement('div');
            modal.classList.add('modal');
            modal.style.display = 'block'; // Make modal visible

            const content = document.createElement('div');
            content.classList.add('modal-content');
            content.style.maxWidth = '450px';

            content.innerHTML = `
                <span class="close" onclick="closeModal(this)"><i class="fas fa-times"></i></span>
                <div class="modal-header">
                    <h2><i class="fas fa-exclamation-triangle"></i> Delete Service Record</h2>
                </div>
                <div class="modal-body" style="display: block;">
                    <p>Are you sure you want to delete this service record? This action cannot be undone.</p>
                </div>
                <div class="form-actions">
                    <button class="action-button" onclick="closeModal(this)">
                        <i class="fas fa-ban"></i> Cancel
                    </button>
                    <button class="action-button delete" onclick="confirmDelete(${id}, this)">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </div>
            `;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function confirmDelete(id, element) {
            // First close the modal
            closeModal(element);

            // Then submit the form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/customer/appointment/delete_service_history';
            form.innerHTML = `<input type="hidden" name="id" value="${id}">`;
            document.body.appendChild(form);
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', fetchServicePerform);
    </script>
</body>

</html>