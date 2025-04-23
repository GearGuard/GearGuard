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
            margin-left: 450px;
        }

        .title {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .accordion {
            background-color: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .accordion-item {
            border-bottom: 1px solid var(--border);
        }

        .accordion-header {
            padding: 1rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--secondary);
            font-weight: 800;
            color: var(--primary);
        }

        .accordion-header:hover {
            background-color: var(--hover-bg);
        }

        .accordion-title {
            color: var(--primary);
        }

        .accordion-content {
            padding: 1rem;
            display: none;
            overflow: hidden;
            text-align: justify;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .accordion-content p {
            margin-bottom: 0.5rem;
        }

        .description {
            grid-column: span 2;
        }

        /* Responsive design */
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

            .container {
                padding: 0 1rem;
            }

            .title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="/customer/appointment/appoint" target="_self">New Vehicle<span class="dot"></span></a>
        <a href="/customer/vehicle/all" target="_self">My Vehicle<span class="dot"></span></a>
        <a href="#" class="active">Service History<span class="dot"></span></a>
    </nav>
    <div class="container">
        <div class="header">
            <h1 class="title">Service History</h1>
        </div>

        <div id="serviceAccordion" class="accordion">
            <!-- Service data will be populated here -->
        </div>
    </div>

    <script>
        // Sample service data - replace with your actual data
        const services = [{
                vehicleBrand: "Toyota",
                plateNumber: "ABC-1234",
                nickname: "Daily Commuter",
                vehicleType: "Car",
                garageName: "City Garage",
                serviceType: "Oil Change",
                cost: "$50",
                sparePartsReplaced: [{
                    part: "Oil Filter",
                    partNumber: "OF123",
                    supplierName: "AutoParts Co."
                }],
                sparePartsWarranty: {
                    expireDate: "2025-06-15",
                    timeLeft: "6 months"
                },
                description: "Regular oil change service.",
                serviceDate: "2024-06-15"
            },
            {
                vehicleBrand: "Honda",
                plateNumber: "XYZ-5678",
                nickname: "Weekend Rider",
                vehicleType: "Motorcycle",
                garageName: "Speedy Garage",
                serviceType: "Tire Replacement",
                cost: "$200",
                sparePartsReplaced: [{
                    part: "Front Tire",
                    partNumber: "FT456",
                    supplierName: "Tire Depot"
                }],
                sparePartsWarranty: {
                    expireDate: "2026-03-10",
                    timeLeft: "16 months"
                },
                description: "Changed front tire for better performance.",
                serviceDate: "2024-03-10"
            } // Add more services as needed
        ];

        function createAccordionItem(service) {
            return `
          <div class="accordion-item">
              <div class="accordion-header" onclick="toggleAccordion(this)">
                  <span class="accordion-title">${service.vehicleBrand} (${service.nickname})</span>
                  <span>${service.serviceType}</span>
                  <span>${service.serviceDate}</span>
              </div>
              <div class="accordion-content">
                  <p><strong>Plate Number:</strong> ${service.plateNumber}</p>
                  <p><strong>Vehicle Type:</strong> ${service.vehicleType}</p>
                  <p><strong>Garage Name:</strong> ${service.garageName}</p>
                  <p><strong>Cost:</strong> ${service.cost}</p>
                  <p><strong>Spare Parts Replaced:</strong></p>
                  ${service.sparePartsReplaced.map(part => `
                      <p>&nbsp;&nbsp;&nbsp;<strong>${part.part}</strong> (Part Number:${part.partNumber}, Supplier:${part.supplierName})</p>`).join('')}
                  <p><strong>Warranty Expiry:</strong> ${service.sparePartsWarranty.expireDate} (${service.sparePartsWarranty.timeLeft} left)</p>
                  <p class="description"><strong>Description:</strong> ${service.description}</p> <!-- Single row for description -->
              </div>
          </div>`;
        }

        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            const isVisible = content.style.display === 'block';

            // Hide all other accordion contents
            const allContents = document.querySelectorAll('.accordion-content');
            allContents.forEach(item => item.style.display = 'none');

            // Toggle the clicked accordion content
            content.style.display = isVisible ? 'none' : 'block';
        }

        function loadServices() {
            const serviceAccordion = document.getElementById('serviceAccordion');

            if (services.length === 0) {
                serviceAccordion.innerHTML = "<p>No service records found.</p>";
                return;
            }

            serviceAccordion.innerHTML = services.map(createAccordionItem).join('');
        }

        // Initialize the page
        window.onload = function() {
            loadServices();
        };
    </script>

</body>

</html>

<!-- This is another file -->

<?php

/** @var array $serviceHistory */
/** @var array $vehicles */
/** @var int $selectedVehicle */

use app\core\Application;

$this->title = 'Service History';
?>

<style>
    /* Custom CSS to replace Bootstrap */
    .container {
        width: 90%;
        margin: 0 auto;
        padding: 15px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #3498db;
        color: white;
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .card-body {
        padding: 15px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 15px;
    }

    .col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
        padding: 0 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 8px 12px;
        font-size: 16px;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 8px 12px;
        font-size: 16px;
        line-height: 1.5;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary {
        color: #fff;
        background-color: #3498db;
        border-color: #3498db;
    }

    .btn-outline-primary {
        color: #3498db;
        background-color: transparent;
        border-color: #3498db;
    }

    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .text-right {
        text-align: right;
    }

    .mb-4 {
        margin-bottom: 20px;
    }

    .alert {
        position: relative;
        padding: 12px 20px;
        margin-bottom: 16px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }

    .alert-heading {
        margin-top: 0;
    }

    .table {
        width: 100%;
        margin-bottom: 16px;
        color: #212529;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
        background-color: #343a40;
        color: white;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.075);
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
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 700px;
        border-radius: 5px;
    }

    .modal-header {
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
        background-color: #17a2b8;
        color: white;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 15px;
    }

    .modal-footer {
        padding: 10px 15px;
        border-top: 1px solid #ddd;
        display: flex;
        justify-content: flex-end;
    }

    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Vehicle Service History</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form id="vehicleFilterForm" method="get" action="/customer/appointment/service_history">
                                <div class="form-group">
                                    <label for="vehicle_id"><strong>Filter by Vehicle:</strong></label>
                                    <select class="form-control" id="vehicle_id" name="vehicle_id" onchange="this.form.submit()">
                                        <option value="">All Vehicles</option>
                                        <?php echo $form->field = new \gearguard\phpmvc\form\DropDownField($model, 'vehicle_id', $vehicles) ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-outline-primary" onclick="printHistory()">
                                <i class="fas fa-print"></i> Print History
                            </button>
                        </div>
                    </div>

                    <?php if (empty($serviceHistory)): ?>
                        <div class="alert alert-info">
                            <h5 class="alert-heading">No service history found!</h5>
                            <p>There are no completed services for your vehicles yet. Once your vehicle receives service, the history will appear here.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive" id="serviceHistoryTable">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Vehicle</th>
                                        <th>Service Type</th>
                                        <th>Garage</th>
                                        <th>Mechanic</th>
                                        <th>Service Date</th>
                                        <th>Duration</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($serviceHistory as $service): ?>
                                        <tr>
                                            <td><?= $service->license_plate_no ?></td>
                                            <td><?= $service->service_type ?></td>
                                            <td><?= $service->garage_name ?></td>
                                            <td><?= $service->mechanic_name ?: 'Not assigned' ?></td>
                                            <td><?= $service->formatTimestamp($service->begin_timestamp) ?></td>
                                            <td><?= $service->getFormattedDuration() ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info view-details"
                                                    onclick="showDetails(
                                                            '<?= $service->id ?>',
                                                            '<?= $service->license_plate_no ?>',
                                                            '<?= $service->service_type ?>',
                                                            '<?= $service->garage_name ?>',
                                                            '<?= $service->mechanic_name ?: 'Not assigned' ?>',
                                                            '<?= $service->formatTimestamp($service->begin_timestamp) ?>',
                                                            '<?= $service->formatTimestamp($service->end_timestamp) ?>',
                                                            '<?= $service->getFormattedDuration() ?>',
                                                            '<?= htmlspecialchars($service->notes ?: 'No notes available.') ?>'
                                                        )">
                                                    <i class="fas fa-eye"></i> Details
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service Details Modal -->
<div id="serviceDetailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Service Details</h5>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Vehicle:</strong> <span id="modal-vehicle"></span></p>
                    <p><strong>Service Type:</strong> <span id="modal-service"></span></p>
                    <p><strong>Garage:</strong> <span id="modal-garage"></span></p>
                    <p><strong>Mechanic:</strong> <span id="modal-mechanic"></span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Service Start:</strong> <span id="modal-start"></span></p>
                    <p><strong>Service End:</strong> <span id="modal-end"></span></p>
                    <p><strong>Duration:</strong> <span id="modal-duration"></span></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>Service Notes</h6>
                        </div>
                        <div class="card-body">
                            <p id="modal-notes">No notes available.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
            <button type="button" class="btn btn-primary" onclick="printServiceDetails()">
                <i class="fas fa-print"></i> Print Details
            </button>
        </div>
    </div>
</div>

<script>
    // Show the modal with service details
    function showDetails(id, vehicle, service, garage, mechanic, start, end, duration, notes) {
        document.getElementById('modal-vehicle').textContent = vehicle;
        document.getElementById('modal-service').textContent = service;
        document.getElementById('modal-garage').textContent = garage;
        document.getElementById('modal-mechanic').textContent = mechanic;
        document.getElementById('modal-start').textContent = start;
        document.getElementById('modal-end').textContent = end;
        document.getElementById('modal-duration').textContent = duration;
        document.getElementById('modal-notes').textContent = notes;

        document.getElementById('serviceDetailsModal').style.display = 'block';
    }

    // Close the modal
    function closeModal() {
        document.getElementById('serviceDetailsModal').style.display = 'none';
    }

    // Print service history
    function printHistory() {
        var printContent = document.getElementById('serviceHistoryTable').outerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = `
            <div style="padding: 20px;">
                <h1 style="text-align: center;">Vehicle Service History</h1>
                <p style="text-align: center;">Generated on ${new Date().toLocaleDateString()}</p>
                ${printContent}
            </div>
        `;

        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }

    // Print service details
    function printServiceDetails() {
        var vehicle = document.getElementById('modal-vehicle').textContent;
        var service = document.getElementById('modal-service').textContent;
        var garage = document.getElementById('modal-garage').textContent;
        var mechanic = document.getElementById('modal-mechanic').textContent;
        var start = document.getElementById('modal-start').textContent;
        var end = document.getElementById('modal-end').textContent;
        var duration = document.getElementById('modal-duration').textContent;
        var notes = document.getElementById('modal-notes').textContent;

        var originalContent = document.body.innerHTML;

        document.body.innerHTML = `
            <div style="padding: 20px;">
                <h1 style="text-align: center;">Service Details</h1>
                <p style="text-align: center;">Generated on ${new Date().toLocaleDateString()}</p>
                <div style="margin-top: 20px;">
                    <p><strong>Vehicle:</strong> ${vehicle}</p>
                    <p><strong>Service Type:</strong> ${service}</p>
                    <p><strong>Garage:</strong> ${garage}</p>
                    <p><strong>Mechanic:</strong> ${mechanic}</p>
                    <p><strong>Service Start:</strong> ${start}</p>
                    <p><strong>Service End:</strong> ${end}</p>
                    <p><strong>Duration:</strong> ${duration}</p>
                    <div style="margin-top: 20px; border: 1px solid #ccc; padding: 10px;">
                        <h3>Service Notes</h3>
                        <p>${notes}</p>
                    </div>
                </div>
            </div>
        `;

        window.print();
        document.body.innerHTML = originalContent;

        // Show modal again after printing
        document.getElementById('serviceDetailsModal').style.display = 'block';
    }

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        var modal = document.getElementById('serviceDetailsModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>