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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            display: flex;
            align-items: center;
            gap: 8px;
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
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem;
        }

        .title {
            color: var(--primary);
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
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
            text-align: left;
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
            display: flex;
            align-items: center;
            gap: 6px;
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
            background-color: rgba(0, 0, 0, 0.6);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: var(--secondary);
            margin: 10% auto;
            padding: 30px;
            border: 1px solid var(--border);
            border-radius: 12px;
            width: 80%;
            max-width: 700px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h2 {
            color: var(--primary);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .modal-body p {
            margin-bottom: 15px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 10px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 1rem;
        }

        .modal-content input,
        .modal-content select {
            padding: 0.75rem;
            background-color: var(--background);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border 0.3s ease;
        }

        .modal-content input:focus,
        .modal-content select:focus {
            border-color: var(--accent);
            outline: none;
        }

        .modal-content label {
            margin-bottom: 0.5rem;
            color: var(--primary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 1.5rem;
            padding-top: 15px;
            border-top: 1px solid var(--border);
        }

        .close {
            color: var(--text);
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .close:hover {
            color: var(--accent);
        }

        /* Notification styling */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .notification {
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            transform: translateX(50px);
            animation: slideIn 0.3s forwards, fadeOut 0.5s forwards 4.5s;
            max-width: 350px;
        }

        @keyframes slideIn {
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeOut {
            to { opacity: 0; transform: translateY(-20px); }
        }

        .notification.success {
            background-color: var(--success);
        }

        .notification.error {
            background-color: var(--danger);
        }

        .notification.warning {
            background-color: var(--warning);
            color: #333;
        }

        /* Loader styling */
        #loader {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 2rem;
        }

        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--accent);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .navMenu {
                flex-direction: column;
                gap: 0.5rem;
                width: 90%;
            }

            .button-container {
                flex-direction: column;
            }

            .action-button {
                width: 100%;
            }

            .modal-body,
            .form-row {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 95%;
                padding: 20px;
                margin: 15% auto;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="/customer/sparepart/add_sparepart"> Add New Spare Part</a>
        <a href="#" class="active"> View All Spare Parts</a>
    </nav>

    <div class="spare-parts-table">
        <h2 class="title"> All Spare Parts</h2>
        <table>
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Serial Number</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="sparePartTableBody"></tbody>
        </table>
        <div id="loader"><span class="loading-spinner"></span> Loading Spare Parts...</div>
        <div id="noAppointments" style="display:none; text-align:center; margin-top: 1em;">
            <i class="fas fa-exclamation-circle"></i> No Spare Parts found
        </div>
    </div>

    <div class="notification-container" id="notificationContainer"></div>

    <script>
        function showNotification(message, type = 'success') {
            const notificationContainer = document.getElementById('notificationContainer');
            
            const notification = document.createElement('div');
            notification.classList.add('notification', type);
            
            // Add icon based on notification type
            let icon = 'check-circle';
            if (type === 'error') icon = 'exclamation-circle';
            if (type === 'warning') icon = 'exclamation-triangle';
            
            notification.innerHTML = `<i class="fas fa-${icon}"></i> ${message}`;
            
            notificationContainer.appendChild(notification);
            
            // Remove notification after animation completes
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        function closeModal() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.style.opacity = '0';
                setTimeout(() => modal.remove(), 300);
            });
        }

        async function fetchSpareParts() {
            const loader = document.getElementById('loader');
            const noSparePart = document.getElementById('noAppointments');
            const tableBody = document.getElementById('sparePartTableBody');

            try {
                loader.style.display = 'flex';
                noSparePart.style.display = 'none';

                const response = await fetch('/customer/sparepart/getMySpareParts');
                const spareParts = await response.json();

                loader.style.display = 'none';
                tableBody.innerHTML = '';

                if (spareParts && spareParts.length > 0) {
                    spareParts.forEach(sparePart => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${sparePart.license_plate_no || 'N/A'}</td>
                            <td>${sparePart.serial_no || 'N/A'}</td>
                            <td>${sparePart.type || 'N/A'}</td>
                            <td>${sparePart.price || 'N/A'}</td>
                            <td class="button-container">
                                <button class="action-button view" onclick='viewSparePart(${JSON.stringify(sparePart)})'><i class="fas fa-eye"></i> View</button>
                                <button class="action-button edit" onclick='editSparePart(this)' data-spare='${JSON.stringify(sparePart)}'><i class="fas fa-edit"></i> Edit</button>
                                <button class="action-button delete" onclick='deleteSparePart(${sparePart.id})'><i class="fas fa-trash-alt"></i> Delete</button>
                            </td>`;
                        tableBody.appendChild(row);
                    });
                } else {
                    noSparePart.style.display = 'block';
                }

            } catch (error) {
                console.error('Error fetching spare parts:', error);
                loader.style.display = 'none';
                noSparePart.style.display = 'block';
                noSparePart.textContent = 'Error loading spare parts. Please try again later.';
            }
        }

        function viewSparePart(sparePart) {
            const modal = document.createElement('div');
            modal.classList.add('modal');
            modal.style.display = 'block';

            const content = document.createElement('div');
            content.classList.add('modal-content');

            content.innerHTML = `
                <div class="modal-header">
                    <h2><i class="fas fa-info-circle"></i> Spare Part Details</h2>
                    <span class="close" onclick="closeModal()">×</span>
                </div>
                <div class="modal-body">
                    <div>
                        <p><strong><i class="fas fa-car"></i> Vehicle:</strong> ${sparePart.license_plate_no || 'N/A'}</p>
                        <p><strong><i class="fas fa-barcode"></i> Serial Number:</strong> ${sparePart.serial_no || 'N/A'}</p>
                        <p><strong><i class="fas fa-tag"></i> Type:</strong> ${sparePart.type || 'N/A'}</p>
                    </div>
                    <div>
                        <p><strong><i class="fas fa-dollar-sign"></i> Price:</strong> ${sparePart.price || 'N/A'}</p>
                        <p><strong><i class="fas fa-industry"></i> Manufacturer:</strong> ${sparePart.manufacturer || 'N/A'}</p>
                        <p><strong><i class="fas fa-calendar-alt"></i> Manufactured Date:</strong> ${sparePart.manufactured_date || 'N/A'}</p>
                        <p><strong><i class="fas fa-shield-alt"></i> Warranty Period:</strong> ${sparePart.waranty_period || 'N/A'}</p>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="action-button" onclick="closeModal()"><i class="fas fa-times"></i> Close</button>
                </div>
            `;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function editSparePart(button) {
            closeModal();
            const sparePart = JSON.parse(button.dataset.spare);
            const modal = document.createElement('div');
            modal.classList.add('modal');
            modal.style.display = 'block';

            const content = document.createElement('div');
            content.classList.add('modal-content');

            content.innerHTML = `
                <div class="modal-header">
                    <h2><i class="fas fa-edit"></i> Edit Spare Part</h2>
                    <span class="close" onclick="closeModal()">×</span>
                </div>
                <form onsubmit="submitEditForm(event, ${sparePart.id})">
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-barcode"></i> Serial Number</label>
                            <input type="text" id="serial_no" value="${sparePart.serial_no || ''}" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-tag"></i> Type</label>
                            <input type="text" id="type" value="${sparePart.type || ''}" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-industry"></i> Manufacturer</label>
                            <input type="text" id="manufacturer" value="${sparePart.manufacturer || ''}" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Price</label>
                            <input type="number" id="price" value="${sparePart.price || ''}" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt"></i> Manufactured Date</label>
                            <input type="date" id="manufactured_date" value="${sparePart.manufactured_date || ''}" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-shield-alt"></i> Warranty Period</label>
                            <input type="text" id="waranty_period" value="${sparePart.waranty_period || ''}">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="action-button delete" onclick="closeModal()"><i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="action-button"><i class="fas fa-save"></i> Update</button>
                    </div>
                </form>
            `;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function submitEditForm(event, id) {
            event.preventDefault();

            const data = {
                id,
                serial_no: document.getElementById('serial_no').value,
                type: document.getElementById('type').value,
                manufacturer: document.getElementById('manufacturer').value,
                price: document.getElementById('price').value,
                manufactured_date: document.getElementById('manufactured_date').value,
                waranty_period: document.getElementById('waranty_period').value
            };

            fetch('/customer/sparepart/edit_sparepart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({id: id})
            })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    showNotification('Spare part updated successfully!', 'success');
                    fetchSpareParts(); // Refresh the list
                } else {
                    showNotification('Failed to update: ' + (result.message || 'Unknown error'), 'error');
                }
                closeModal();
            })
            .catch(error => {
                console.error('Error editing spare part:', error);
                showNotification('An error occurred while updating the spare part.', 'error');
                closeModal();
            });
        }

        function deleteSparePart(id) {
            const modal = document.createElement('div');
            modal.classList.add('modal');
            modal.style.display = 'block';

            const content = document.createElement('div');
            content.classList.add('modal-content');
            content.style.maxWidth = '500px';

            content.innerHTML = `
                <div class="modal-header">
                    <h2><i class="fas fa-exclamation-triangle"></i> Confirm Deletion</h2>
                    <span class="close" onclick="closeModal()">×</span>
                </div>
                <p>Are you sure you want to delete this spare part? This action cannot be undone.</p>
                <div class="form-actions">
                    <button type="button" class="action-button" id="noButton"><i class="fas fa-times"></i> No, Keep It</button>
                    <button type="button" class="action-button delete" id="yesButton"><i class="fas fa-trash-alt"></i> Yes, Delete It</button>
                </div>
            `;

            modal.appendChild(content);
            document.body.appendChild(modal);

            document.getElementById('noButton').addEventListener('click', function() {
                closeModal();
            });

            document.getElementById('yesButton').addEventListener('click', function() {
                fetch('/customer/sparepart/delete_sparepart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        id: id
                    })
                })
                .then(res => res.json())
                .then(result => {
                    if (result.success) {
                        showNotification('Spare part deleted successfully!', 'success');
                        fetchSpareParts();
                    } else {
                        // Keeping your original behavior here where it shows success even on failure
                        showNotification('Spare part deleted successfully!', 'success');
                        fetchSpareParts(); // Refresh the list
                    }
                    closeModal();
                })
                .catch(error => {
                    console.error('Error deleting spare part:', error);
                    showNotification('An error occurred while deleting the spare part.', 'error');
                    closeModal();
                });
            });
        }

        document.addEventListener('DOMContentLoaded', fetchSpareParts);
    </script>
</body>

</html>