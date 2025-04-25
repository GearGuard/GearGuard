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

        .action-button:active {
            transform: translateY(0);
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
        }

        .close:hover,
        .close:focus {
            color: var(--accent);
            text-decoration: none;
            cursor: pointer;
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

            .spare-parts-table {
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
        <a href="/customer/sparepart/add_sparepart" target="_self">Add New Spare Part<span class="dot"></span></a>
        <a href="#" class="active">View All Spare Parts<span class="dot"></span></a>
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
            <!-- Spare parts will be loaded here via JavaScript -->

            </tbody>
        </table>
        <div id="loader" style="text-align: center; display: block; margin-top: 0.3em;">Loading Spare Parts...</div>
        <div id="noAppointments" style="text-align: center; display: none; margin-top: 1em;">No Spare Parts found</div>
    </div>
    <script>
        async function fetchSpareParts() {
            const loader = document.getElementById('loader');
            const noSparePart = document.getElementById('noSparePart');
            const tableBody = document.getElementById('sparePartTableBody');

            try {
                loader.style.display = 'block';
                noSparePart.style.display = 'none';

                const response = await fetch('/customer/sparepart/getMySpareParts');
                const spareParts = await response.json();

                loader.style.display = 'none';
                tableBody.innerHTML = '';

                if (spareParts && spareParts.length > 0) {
                    spareParts.forEach(spareParts => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${spareParts.vehicle || 'N/A'}</td>
                            <td>${spareParts.serial_number || 'N/A'}</td>
                            <td>${spareParts.type || 'N/A'}</td>
                            <td>${spareParts.price || 'N/A'}</td>
                            <td class="button-container">
                                <button class="action-button" onclick='viewSparePart(${JSON.stringify(spareParts)})'>View More</button>
                                <button class="action-button" onclick='editSparePart(${JSON.stringify(spareParts)})'><i class="fas fa-pencil"></i></button>
                                <button class="action-button" onclick='deleteSparePart(${spareParts.id})'><i class="fas fa-trash"></i></button>
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

        function viewSparePart(spareParts) {
            const modal = document.createElement('div');
            modal.classList.add('modal');

            const content = document.createElement('div');
            content.classList.add('modal-content');

            content.innerHTML = `
                <span class="close" onclick="closeModal()">×</span>
                <h2>Spare Part Details</h2>
                <p><strong>Vehicle:</strong> ${spareParts.vehicle}</p>
                <p><strong>Serial Number:</strong> ${spareParts.serial_number}</p>
                <p><strong>Type:</strong> ${spareParts.type}</p>
                <p><strong>Price:</strong> ${spareParts.price}</p>
                <p><strong>Manufacturer:</strong> ${spareParts.manufacturer}</p>
                <p><strong>Manufactured Date:</strong> ${spareParts.manufactured_date}</p>
                <p><strong>Warranty Period:</strong> ${spareParts.warranty_period}</p>
            `;
            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function editSparePart(spareParts) {
            const model = document.createElement('div');
            model.classList.add('modal');

            const content = document.createElement('div');
            content.classList.add('modal-content');

            content.innerHTML = `
                <span class="close" onclick="closeModal()">×</span>
                <h2>Edit Spare Part</h2>
                <form action="/customer/sparepart/edit_sparepart" method="post">
                    <label for="serial_no">Serial Number:</label>
                    <input type="text" id="serial_no" name="serial_no" value="${spareParts.serial_number}" required>
                    <label for="type">Type:</label>
                    <input type="text" id="type" name="type" value="${spareParts.type}" required>
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" value="${spareParts.price}" required>
                    <div class="form-actions">
                        <button type="submit" class="action-button">Save Changes</button>
                        <button type="button" class="action-button delete" onclick="deleteSparePart(${spareParts.id})">Delete</button>
                    </div>
                </form>`;
            modal.appendChild(content);
            document.body.appendChild(modal);
        }

        function deleteSparePart(spareParts) {
            const modal = document.createElement('div');
            modal.classList.add('modal');

            const content = document.createElement('div');
            content.classList.add('modal-content');

            content.innerHTML = `
                <span class="close" onclick="closeModal()">×</span>
                <h2>Delete Spare Part</h2>
                <p>Are you sure you want to delete this spare spareParts?</p>
                <div class="form-actions">
                    <button type="button" class="action-button delete" onclick="confirmDelete(${spareParts.id})">Delete</button>
                    <button type="button" class="action-button" onclick="closeModal()">Cancel</button>
                </div>`;
            modal.appendChild(content);
            document.body.appendChild(modal);

            document.getElementById('noButton').addEventListener('click', function() {
                modal.remove();
            });

            document.getElementById('yesButton').addEventListener('click', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/customer/sparepart/delete`;
                form.innerHTML = `<input type="hidden" name="id" value="${id}">`;
                form.style.display = 'none';
                document.body.appendChild(form);
                form.submit();
                modal.remove();
                // Optionally, refresh the appointments list after deletion
                setTimeout(fetchSpareParts, 500);
            });
        }
        document.addEventListener('DOMContentLoaded', fetchSpareParts);
    </script>
</body>

</html>