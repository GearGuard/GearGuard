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
        <a href="/mechanic/sparepart/addNew">Add New Spare Part</a>
        <a href="#" class="active">View All Spare Parts</a>
    </nav>

    <div class="spare-parts-table">
        <h2 class="title">All Spare Parts</h2>
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
        <div id="loader" style="text-align:center; margin-top: 1em;">Loading Spare Parts...</div>
        <div id="noAppointments" style="display:none; text-align:center; margin-top: 1em;">No Spare Parts found</div>
    </div>

    <script>
        function closeModal() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => modal.remove());
        }

        async function fetchSpareParts() {
            const loader = document.getElementById('loader');
            const noSparePart = document.getElementById('noAppointments');
            const tableBody = document.getElementById('sparePartTableBody');

            try {
                loader.style.display = 'block';
                noSparePart.style.display = 'none';

                const response = await fetch('/mechanic/sparepart/getSpareParts');
                const result = await response.json();

                loader.style.display = 'none';
                tableBody.innerHTML = '';

                if (result.success && result.data && result.data.length > 0) {
                    result.data.forEach(sparePart => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${sparePart.license_plate_no || 'N/A'}</td>
                            <td>${sparePart.serial_no || 'N/A'}</td>
                            <td>${sparePart.type || 'N/A'}</td>
                            <td>${sparePart.price || 'N/A'}</td>
                            <td class="button-container">
                                <button class="action-button view" onclick='viewSparePart(${JSON.stringify(sparePart)})'>View</button>
                                <button class="action-button edit" onclick='editSparePart(this)' data-spare='${JSON.stringify(sparePart)}'>Edit</button>
                                <button class="action-button delete" onclick='deleteSparePart(${sparePart.id})'>Delete</button>
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
                <span class="close" onclick="closeModal()">×</span>
                <h2>Spare Part Details</h2>
                <p><strong>Vehicle:</strong> ${sparePart.license_plate_no }</p>
                <p><strong>Serial Number:</strong> ${sparePart.serial_no}</p>
                <p><strong>Type:</strong> ${sparePart.type}</p>
                <p><strong>Price:</strong> ${sparePart.price}</p>
                <p><strong>Manufacturer:</strong> ${sparePart.manufacturer}</p>
                <p><strong>Manufactured Date:</strong> ${sparePart.manufactured_date}</p>
                <p><strong>Warranty Period:</strong> ${sparePart.waranty_period}</p>
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
        <span class="close" onclick="closeModal()">×</span>
        <h2>Edit Spare Part</h2>
        <form onsubmit="submitEditForm(event, ${sparePart.id})">
            <label>Serial Number</label>
            <input type="text" id="serial_no" value="${sparePart.serial_no}" required>

            <label>Type</label>
            <input type="text" id="type" value="${sparePart.type}" required>

            <label>Manufacturer</label>
            <input type="text" id="manufacturer" value="${sparePart.manufacturer}" required>

            <label>Price</label>
            <input type="number" id="price" value="${sparePart.price}" required>

            <label>Manufactured Date</label>
            <input type="date" id="manufactured_date" value="${sparePart.manufactured_date}" required>

            <label>Warranty Period</label>
            <input type="text" id="waranty_period" value="${sparePart.waranty_period || ''}">

            <div class="form-actions">
                <button type="submit" class="action-button">Update</button>
                <button type="button" class="action-button delete" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    `;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        async function submitEditForm(event, id) {
            event.preventDefault();

            const data = {
                id: id,
                serial_no: document.getElementById('serial_no').value,
                type: document.getElementById('type').value,
                manufacturer: document.getElementById('manufacturer').value,
                price: document.getElementById('price').value,
                manufactured_date: document.getElementById('manufactured_date').value,
                waranty_period: document.getElementById('waranty_period').value
            };

            try {
                const response = await fetch('/mechanic/sparepart/edit_sparepart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams(data)
                });

                const result = await response.json();
                if (result.success) {
                    alert('Spare part updated successfully');
                    closeModal();
                    fetchSpareParts();
                } else {
                    alert('Failed to update: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to update spare part');
            }
        }

        function deleteSparePart(id) {
            const modal = document.createElement('div');
            modal.classList.add('modal');
            modal.style.display = 'block';

            const content = document.createElement('div');
            content.classList.add('modal-content');
            content.style.maxWidth = '400px';

            content.innerHTML = `
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this Spare Part?</p>
        <div class="form-actions">
            <button type="button" class="action-button" id="noButton">No</button>
            <button type="button" class="action-button delete" id="yesButton">Yes</button>
        </div>
    `;

            modal.appendChild(content);
            document.body.appendChild(modal);

            document.getElementById('noButton').addEventListener('click', function() {
                closeModal();
            });

            document.getElementById('yesButton').addEventListener('click', function() {
                fetch('/mechanic/sparepart/delete_sparepart', {
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
                            alert('Spare part deleted successfully.');
                            fetchSpareParts();
                        } else {
                            alert('Spare part deleted successfully.');
                            fetchSpareParts(); // Refresh the list
                        }
                        closeModal();
                    })
                    .catch(error => {
                        console.error('Error deleting spare part:', error);
                        alert('An error occurred while deleting the spare part.');
                        closeModal();
                    });
            });
        }


        document.addEventListener('DOMContentLoaded', fetchSpareParts);
    </script>
</body>

</html>