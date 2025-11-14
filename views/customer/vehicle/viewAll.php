<?php

use gearguard\phpmvc\Application;

/** @var $vehicles array */
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
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .title {
            color: var(--text);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .add-vehicle-btn {
            background: var(--accent);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .add-vehicle-btn:hover {
            background: #1d4ed8;
        }

        .vehicles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .vehicle-card {
            color: var(--text);
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .vehicle-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .vehicle-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .vehicle-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
        }

        .vehicle-nickname {
            font-size: 0.875rem;
            color: var(--text);
        }

        .vehicle-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: .75rem;
            color: var(--primary);
            margin-bottom: .25rem;
        }

        .detail-value {
            font-size: .875rem;
            color: var(--text);
            font-weight: 500;
        }

        .vehicle-actions {
            display: flex;
            gap: .75rem;
            margin-top: auto;
        }

        .action-button {
            flex: 1;
            padding: .75rem;
            border-radius: 8px;
            font-size: .875rem;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .edit-btn {
            background: var(--primary);
            color: var(--background);
            border: 1px solid #e2e8f0;
        }

        .edit-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .delete-btn {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
        }

        .delete-btn:hover {
            background: #fee2e2;
        }

        .no-vehicles {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .no-vehicles-text {
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        /* Modal styles */
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

        .modal-select {
            width: 100%;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid var(--border);
            background-color: var(--background);
            color: var(--text);
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
    </style>
</head>

<body>
    <nav class='navMenu'>
        <a href='/customer/vehicle/register' target='_self'>New Vehicle</a>
        <a href='#' class='active'>My Vehicle</a>
        <a href='/customer/vehicle/service_history' target='_self'>Service History</a>
    </nav>
    <div class='container'>
        <div class='header'>
            <h1 class='title'>My Vehicles</h1>
            <a href='/customer/vehicle/register' class='add-vehicle-btn'>+ Add New Vehicle</a>
        </div>
        <div class='vehicles-grid' id='vehiclesGrid'>
            <?php if (!empty($vehicles)): ?>
                <?php foreach ($vehicles as $vehicle): ?>
                    <div class="vehicle-card">
                        <div class="vehicle-header">
                            <div>
                                <h2 class="vehicle-title"><?= htmlspecialchars($vehicle->model_name ?? 'Unknown Model') ?></h2>
                                <p class="vehicle-nickname"><?= htmlspecialchars($vehicle->license_plate_no ?? '') ?></p>
                            </div>
                        </div>
                        <div class="vehicle-details">
                            <div class="detail-item">
                                <span class="detail-label">Year:</span>
                                <span class="detail-value"><?= htmlspecialchars($vehicle->year_manufactured ?? '-') ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Plate Number:</span>
                                <span class="detail-value"><?= htmlspecialchars($vehicle->license_plate_no ?? '-') ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">NIC:</span>
                                <span class="detail-value"><?= htmlspecialchars($vehicle->nic ?? '-') ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Bought Date:</span>
                                <span class="detail-value"><?= htmlspecialchars($vehicle->bought_date ?? '-') ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Fuel Type:</span>
                                <span class="detail-value"><?= htmlspecialchars($vehicle->fuel_type ?? '-') ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Insurance No:</span>
                                <span class="detail-value"><?= htmlspecialchars($vehicle->insurance_no ?? '-') ?></span>
                            </div>
                        </div>
                        <div class="vehicle-actions">
                            <button class="action-button edit-btn" onclick="editVehicle(<?= $vehicle->id ?>, '<?= htmlspecialchars($vehicle->model_name ?? '') ?>', '<?= htmlspecialchars($vehicle->license_plate_no ?? '') ?>', '<?= htmlspecialchars($vehicle->insurance_no ?? '') ?>', <?= $vehicle->fuel_type_id ?? 1 ?>)">Edit</button>
                            <button class="action-button delete-btn" onclick="deleteVehicle(<?= $vehicle->id ?>)">Delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-vehicles">
                    <p class="no-vehicles-text">You have no vehicles registered yet.</p>
                    <a href="/customer/vehicle/register" class="add-vehicle-btn">+ Add New Vehicle</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="editModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2 class="modal-title">Edit Vehicle</h2>
            <form id="editForm" method="post" action="/customer/vehicle/update">
                <input type="hidden" id="vehicleId" name="id">

                <div class="modal-form-group">
                    <label class="modal-label" for="modelName">Model</label>
                    <input class="modal-input" type="text" id="modelName" disabled>
                </div>

                <div class="modal-form-group">
                    <label class="modal-label" for="licensePlateNo">License Plate Number</label>
                    <input class="modal-input" type="text" id="licensePlateNo" name="license_plate_no" required>
                </div>

                <div class="modal-form-group">
                    <label class="modal-label" for="insuranceNo">Insurance Number</label>
                    <input class="modal-input" type="text" id="insuranceNo" name="insurance_no">
                </div>

                <div class="modal-form-group">
                    <label class="modal-label" for="fuelTypeId">Fuel Type</label>
                    <select class="modal-select" id="fuelTypeId" name="fuel_type_id" required>
                        <?php

                        $fuelTypes = [];
                        try {
                            $stmt = Application::$app->db->prepare('SELECT id, fueltype FROM gg_vehicle_fueltype');
                            $stmt->execute();
                            $fuelTypes = $stmt->fetchAll(\PDO::FETCH_OBJ);
                        } catch (Exception $e) {
                        }

                        foreach ($fuelTypes as $fuelType):
                        ?>
                            <option value="<?= $fuelType->id ?>"><?= htmlspecialchars($fuelType->fueltype) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" class="modal-button cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="modal-button">Save Changes</button>
                </div>
            </form>
        </div>
    </div>


    <div id="deleteModal" class="modal" style="display: none;">
        <div class="modal-content" style="max-width: 400px;">
            <h2 class="modal-title">Confirm Deletion</h2>
            <p>Are you sure you want to delete this vehicle?</p>
            <form id="deleteForm" method="post" action="/customer/vehicle/delete">
                <input type="hidden" id="deleteVehicleId" name="id">

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" class="modal-button cancel" onclick="closeDeleteModal()">No</button>
                    <button type="submit" class="modal-button delete">Yes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editVehicle(id, model, license, insurance, fuelTypeId) {
            document.getElementById('vehicleId').value = id;
            document.getElementById('modelName').value = model;
            document.getElementById('licensePlateNo').value = license;
            document.getElementById('insuranceNo').value = insurance;
            document.getElementById('fuelTypeId').value = fuelTypeId;

            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function deleteVehicle(id) {
            document.getElementById('deleteVehicleId').value = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');

            if (event.target === editModal) {
                editModal.style.display = 'none';
            }

            if (event.target === deleteModal) {
                deleteModal.style.display = 'none';
            }
        }
    </script>
</body>

</html>