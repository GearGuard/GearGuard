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
            /* Darker blue on hover */
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
                            <p class="vehicle-nickname"><?= htmlspecialchars($vehicle->nickname ?? '') ?></p>
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
                    </div>
                    <div class="vehicle-actions">
                        <button class="action-button edit-btn" onclick="editVehicle(<?= $vehicle->id ?>)">Edit</button>
                        <button class="action-button delete-btn" onclick="deleteVehicle(<?= $vehicle->id ?>)">Delete
                        </button>
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
<script>
    function editVehicle(id) {
        // Redirect or open modal for editing
        window.location.href = '/customer/vehicle/edit?id=' + id;
    }

    function deleteVehicle(id) {
        if (confirm('Are you sure you want to delete this vehicle?')) {
            // Implement AJAX or redirect for deletion
            window.location.href = '/customer/vehicle/delete?id=' + id;
        }
    }
</script>
</body>
</html>
</html>
