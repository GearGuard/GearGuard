<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// The $spareParts variable is passed from the controller, no need to fetch again here
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/" />
    <title>Spare Parts Management</title>
    <link rel="icon" href="/assets/img/favicon.png" type="image/png">
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
            /* padding: 1rem; */
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

        .success-message {
            background-color: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            padding: 1rem;
            margin: 1rem auto 2rem;
            border-radius: 8px;
            text-align: center;
            width: 50%;
            border: 1px solid #22c55e;
            font-weight: 500;
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

    <a href="mechanic/sparepart/addNew">Add New Spare Part</a>
    <a href="mechanic/sparepart/viewAll"class="active">View All Spare Parts</a>


    </nav>


    <?php if (!empty($success)) : ?>
        <div class="success-message">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="spare-parts-table">
        <h2 class="title">All Spare Parts</h2>
        <table>
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Serial Number</th>
                    <th>Type</th>
                    <th>Manufacturer</th>
                    <th>Price</th>
                    <th>Manufactured Date</th>
                    <th>Warranty Period</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($spareParts as $part): ?>
                <tr>
                    <td><?= htmlspecialchars($part['vehicle_license_plate_no'] ?? '') ?></td>
                    <td><?= htmlspecialchars($part['serial_no']) ?></td>
                    <td><?= htmlspecialchars($part['type']) ?></td>
                    <td><?= htmlspecialchars($part['manufacturer']) ?></td>
                    <td>$<?= htmlspecialchars(number_format($part['price'], 2)) ?></td>
                    <td><?= htmlspecialchars($part['manufactured_date']) ?></td>
                    <td><?= htmlspecialchars($part['waranty_period']) ?></td>
                    <td class="button-container">
                        <button class="action-button view" onclick="viewSparePart(<?= $part['id'] ?>)">View</button>
                        <button class="action-button edit" onclick="editSparePart(<?= $part['id'] ?>)">Edit</button>
                        <button class="action-button delete" onclick="confirmDeleteSparePart(<?= $part['id'] ?>)">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Spare Part Details</h2>
            <div id="viewContent">
                <p><strong>Vehicle:</strong> <span id="viewVehicle"></span></p>
                <p><strong>Serial Number:</strong> <span id="viewSerial"></span></p>
                <p><strong>Type:</strong> <span id="viewType"></span></p>
                <p><strong>Manufacturer:</strong> <span id="viewManufacturer"></span></p>
                <p><strong>Price:</strong> <span id="viewPrice"></span></p>
                <p><strong>Manufactured Date:</strong> <span id="viewManufacturedDate"></span></p>
                <p><strong>Warranty Period:</strong> <span id="viewWarrantyPeriod"></span></p>
            </div>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Spare Part</h2>
            <form id="editForm">
                <input type="hidden" id="editId" name="id">
                <label for="editVehicle">Vehicle</label>
                <input type="text" id="editVehicle" name="vehicle" placeholder="Enter license plate number">
                <label for="editSerial">Serial Number</label>
                <input type="text" id="editSerial" name="serial_no" required>
                <label for="editType">Type</label>
                <input type="text" id="editType" name="type" required>
                <label for="editManufacturer">Manufacturer</label>
                <input type="text" id="editManufacturer" name="manufacturer" required>
                <label for="editPrice">Price</label>
                <input type="number" id="editPrice" name="price" step="0.01" required>
                <label for="editManufacturedDate">Manufactured Date</label>
                <input type="date" id="editManufacturedDate" name="manufactured_date">
                <label for="editWarrantyPeriod">Warranty Period</label>
                <input type="date" id="editWarrantyPeriod" name="waranty_period">
                <div class="form-actions">
                    <button type="button" class="action-button view" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="action-button edit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Confirm Deletion</h2>
            <p id="deleteContent">Are you sure you want to delete this spare part?</p>
            <div class="form-actions">
                <button class="action-button view" onclick="closeDeleteModal()">Cancel</button>
                <button class="action-button delete" onclick="deleteSparePart()">Delete</button>
            </div>
        </div>
    </div>

    <script>
        // Modal references
        const viewModal = document.getElementById("viewModal");
        const editModal = document.getElementById("editModal");
        const deleteModal = document.getElementById("deleteModal");
        const editForm = document.getElementById("editForm");
        let currentDeleteId = null;

        // Close buttons
        const closeButtons = document.getElementsByClassName("close");
        for (let button of closeButtons) {
            button.onclick = closeAllModals;
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target == viewModal ||
                event.target == editModal ||
                event.target == deleteModal) {
                closeAllModals();
            }
        }

        function closeAllModals() {
            viewModal.style.display = "none";
            editModal.style.display = "none";
            deleteModal.style.display = "none";
        }

        // Prepare spare parts data for JavaScript
        const spareParts = <?php
            $jsArray = [];
            foreach ($spareParts as $part) {
                $jsArray[$part['id']] = [
                    'vehicle_license_plate_no' => $part['vehicle_license_plate_no'] ?? '',
                    'serial' => $part['serial_no'],
                    'type' => $part['type'],
                    'manufacturer' => $part['manufacturer'],
                    'price' => '$' . number_format($part['price'], 2),
                    'manufacturedDate' => $part['manufactured_date'] ?? '',
                    'warrantyPeriod' => $part['waranty_period'] ?? ''
                ];
            }
            echo json_encode($jsArray);
        ?>;

        function viewSparePart(id) {
            viewModal.style.display = "block";

            const sparePart = spareParts[id];
            if (!sparePart) return;

            document.getElementById("viewSerial").textContent = sparePart.serial;
            document.getElementById("viewType").textContent = sparePart.type;
            document.getElementById("viewManufacturer").textContent = sparePart.manufacturer;
            document.getElementById("viewPrice").textContent = sparePart.price;
            document.getElementById("viewManufacturedDate").textContent = sparePart.manufacturedDate;
            document.getElementById("viewWarrantyPeriod").textContent = sparePart.warrantyPeriod;
            document.getElementById("viewVehicle").textContent = sparePart.vehicle_license_plate_no;
        }

        function editSparePart(id) {
            editModal.style.display = "block";

            const sparePart = spareParts[id];
            if (!sparePart) return;

            document.getElementById("editId").value = id;
            document.getElementById("editSerial").value = sparePart.serial;
            document.getElementById("editType").value = sparePart.type;
            document.getElementById("editManufacturer").value = sparePart.manufacturer;
            document.getElementById("editVehicle").value = sparePart.vehicle_license_plate_no;
            // Remove $ sign for price input
            document.getElementById("editPrice").value = sparePart.price.replace('$', '');
            document.getElementById("editManufacturedDate").value = sparePart.manufacturedDate;
            document.getElementById("editWarrantyPeriod").value = sparePart.warrantyPeriod;
        }

        function confirmDeleteSparePart(id) {
            deleteModal.style.display = "block";
            currentDeleteId = id;
        }

        function deleteSparePart() {
            if (!currentDeleteId) return;

            fetch('/mechanic/sparepart/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: currentDeleteId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to delete spare part');
                }
                return response.json();
            })
            .then(data => {
                alert(`Spare Part ${currentDeleteId} deleted successfully`);
                closeDeleteModal();
                location.reload();
            })
            .catch(error => {
                alert(error.message);
            });
        }

        function closeEditModal() {
            editModal.style.display = "none";
        }

        function closeDeleteModal() {
            deleteModal.style.display = "none";
            currentDeleteId = null;
        }

        // Handle form submission for editing
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Collect form data
            const formData = {
                id: document.getElementById("editId").value,
                vehicle: document.getElementById("editVehicle").value,
                serial_no: document.getElementById("editSerial").value,
                type: document.getElementById("editType").value,
                manufacturer: document.getElementById("editManufacturer").value,
                price: document.getElementById("editPrice").value,
                manufactured_date: document.getElementById("editManufacturedDate").value,
                waranty_period: document.getElementById("editWarrantyPeriod").value
            };

            fetch('/mechanic/sparepart/edit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update spare part');
                }
                return response.json();
            })
            .then(data => {
                alert(`Spare Part ${formData.id} updated successfully`);
                closeEditModal();
                location.reload();
            })
            .catch(error => {
                alert(error.message);
            });
        });
    </script>
</body>

</html>
