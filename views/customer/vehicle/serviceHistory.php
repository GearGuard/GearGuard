<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service History</title>
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
        }

        .header-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .filter-select {
            background-color: var(--secondary);
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-family: "Inter", sans-serif;
            cursor: pointer;
        }

        .btn {
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-family: "Inter", sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            background-color: #1a56c7;
        }

        .btn-outline {
            background-color: transparent;
            color: var(--accent);
            border: 1px solid var(--accent);
        }

        .btn-outline:hover {
            background-color: var(--hover-bg);
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
            position: relative;
        }

        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-header {
            padding: 1rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--secondary);
            font-weight: 600;
            color: var(--primary);
            position: relative;
        }

        .accordion-header:hover {
            background-color: var(--hover-bg);
        }

        .accordion-header .left {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .accordion-header .right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .accordion-title {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .accordion-subtitle {
            color: var(--text);
            font-size: 0.85rem;
            font-weight: 400;
            margin-top: 0.25rem;
        }

        .accordion-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s ease;
        }

        .accordion-icon.rotate {
            transform: translateY(-50%) rotate(180deg);
        }

        .accordion-content {
            padding: 1rem;
            display: none;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 0 0 8px 8px;
        }

        .accordion-content.active {
            display: block;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .service-info-group {
            margin-bottom: 1rem;
        }

        .service-info-heading {
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .service-info-item {
            display: flex;
            margin-bottom: 0.5rem;
        }

        .service-info-item strong {
            min-width: 130px;
            font-weight: 500;
        }

        .service-info-span {
            grid-column: span 2;
        }

        .service-notes {
            background-color: var(--secondary);
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .service-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1rem;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .badge-active {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        .badge-expired {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 0;
        }

        .empty-state p {
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: var(--secondary);
            margin: 10% auto;
            padding: 0;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            width: 80%;
            max-width: 700px;
            animation: modalopen 0.3s;
        }

        @keyframes modalopen {
            from {
                opacity: 0;
                transform: translateY(-60px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            background-color: var(--accent);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.2rem;
        }

        .modal-close {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            cursor: pointer;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            border-top: 1px solid var(--border);
        }

        /* Loading state */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            border-top-color: var(--accent);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navMenu {
                width: 90%;
                flex-wrap: wrap;
            }

            .navMenu a {
                width: auto;
                flex: 1 1 auto;
                text-align: center;
                padding: 0.5rem;
                font-size: 0.85rem;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .header-controls {
                width: 100%;
                flex-wrap: wrap;
            }

            .service-grid {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 95%;
                margin: 5% auto;
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
            <div class="header-controls">
                <select id="filterVehicle" class="filter-select">
                    <option value="all">All Vehicles</option>
                    <!-- Vehicle options will be populated dynamically -->
                </select>
                <button id="btnPrint" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg>
                    Print History
                </button>
            </div>
        </div>

        <div id="serviceAccordion" class="accordion">
            <div class="loading">
                <div class="spinner"></div>
            </div>
        </div>
    </div>

    <!-- Service Details Modal -->
    <div id="serviceDetailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Service Details</h3>
                <span class="modal-close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="service-grid">
                    <div class="service-info-group">
                        <p><strong>Vehicle:</strong> <span id="modal-vehicle"></span></p>
                        <p><strong>Number Plate:</strong> <span id="modal-plate"></span></p>
                        <p><strong>Service Type:</strong> <span id="modal-service"></span></p>
                    </div>
                    <div class="service-info-group">
                        <p><strong>Garage:</strong> <span id="modal-garage"></span></p>
                        <p><strong>Cost:</strong> <span id="modal-cost"></span></p>
                        <p><strong>Replaced Part:</strong> <span id="modal-part"></span></p>
                    </div>
                </div>
                <div class="service-info-group">
                    <p><strong>Service Start:</strong> <span id="modal-start"></span></p>
                    <p><strong>Service End:</strong> <span id="modal-end"></span></p>
                    <p><strong>Warranty Expiry:</strong> <span id="modal-warranty"></span></p>
                </div>
                <div class="service-notes">
                    <h4 class="service-info-heading">Service Notes</h4>
                    <p id="modal-notes">No notes available.</p>
                </div>
                <div class="service-notes">
                    <h4 class="service-info-heading">Service Description</h4>
                    <p id="modal-description">No description available.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="closeModalBtn">Close</button>
                <button type="button" class="btn" id="printDetailsBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg>
                    Print Details
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load service history data from API
            fetchServiceHistory();

            // Event listeners for modal
            document.querySelector('.modal-close').addEventListener('click', closeModal);
            document.getElementById('closeModalBtn').addEventListener('click', closeModal);
            document.getElementById('printDetailsBtn').addEventListener('click', printServiceDetails);
            document.getElementById('btnPrint').addEventListener('click', printHistory);

            // Filter change event
            document.getElementById('filterVehicle').addEventListener('change', function() {
                filterServices(this.value);
            });

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target == document.getElementById('serviceDetailsModal')) {
                    closeModal();
                }
            };
        });

        // Fetch service history data from the API
        async function fetchServiceHistory() {
            try {
                const response = await fetch('/customer/vehicle/service_history_all');
                if (!response.ok) {
                    throw new Error('Failed to fetch service history');
                }

                const data = await response.json();
                displayServiceHistory(data);
                populateVehicleFilter(data);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('serviceAccordion').innerHTML = `
                    <div class="empty-state">
                        <p>Failed to load service history. Please try again later.</p>
                        <button class="btn" onclick="fetchServiceHistory()">Retry</button>
                    </div>
                `;
            }
        }

        // Populate the service accordion with data
        function displayServiceHistory(services) {
            const accordionElement = document.getElementById('serviceAccordion');

            if (!services || services.length === 0 || (services.error && services.error.length > 0)) {
                accordionElement.innerHTML = `
                    <div class="empty-state">
                        <p>No service records found for your vehicles.</p>
                        <a href="/customer/appointment/appoint" class="btn">Schedule a Service</a>
                    </div>
                `;
                return;
            }

            // Sort services by date descending (newest first)
            services.sort((a, b) => new Date(b['Service Start Date']) - new Date(a['Service Start Date']));

            let accordionHTML = '';

            services.forEach((service, index) => {
                const serviceDate = new Date(service['Service Start Date']).toLocaleDateString();
                const servicePart = service['Replaced Part'] || 'No parts replaced';
                const warrantyDate = service['Warranty Expiry Date'] ?
                    new Date(service['Warranty Expiry Date']).toLocaleDateString() :
                    'N/A';

                // Check if warranty is active
                let warrantyStatus = '';
                if (service['Warranty Expiry Date']) {
                    const today = new Date();
                    const expiry = new Date(service['Warranty Expiry Date']);
                    warrantyStatus = today <= expiry ?
                        '<span class="badge badge-active">Active</span>' :
                        '<span class="badge badge-expired">Expired</span>';
                }

                accordionHTML += `
                    <div class="accordion-item" data-vehicle="${service['Vehicle Model']}">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <div class="left">
                                <span class="accordion-title">${service['Vehicle Model']}</span>
                                <span class="accordion-subtitle">${service['Number Plate']}</span>
                            </div>
                            <div class="right">
                                <span class="accordion-title">${service['Service Done']}</span>
                                <span class="accordion-subtitle">${serviceDate}</span>
                            </div>
                            <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                        <div class="accordion-content">
                            <div class="service-grid">
                                <div class="service-info-group">
                                    <h4 class="service-info-heading">Vehicle Details</h4>
                                    <div class="service-info-item">
                                        <strong>Model:</strong>
                                        <span>${service['Vehicle Model']}</span>
                                    </div>
                                    <div class="service-info-item">
                                        <strong>Number Plate:</strong>
                                        <span>${service['Number Plate']}</span>
                                    </div>
                                </div>
                                <div class="service-info-group">
                                    <h4 class="service-info-heading">Service Details</h4>
                                    <div class="service-info-item">
                                        <strong>Service Type:</strong>
                                        <span>${service['Service Done']}</span>
                                    </div>
                                    <div class="service-info-item">
                                        <strong>Garage:</strong>
                                        <span>${service['Garage Name']}</span>
                                    </div>
                                    <div class="service-info-item">
                                        <strong>Cost:</strong>
                                        <span>Rs${service['Cost']}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="service-info-group">
                                <h4 class="service-info-heading">Timeline</h4>
                                <div class="service-info-item">
                                    <strong>Start Date:</strong>
                                    <span>${new Date(service['Service Start Date']).toLocaleString()}</span>
                                </div>
                                <div class="service-info-item">
                                    <strong>End Date:</strong>
                                    <span>${new Date(service['Service End Date']).toLocaleString()}</span>
                                </div>
                            </div>
                            
                            <div class="service-info-group">
                                <h4 class="service-info-heading">Parts & Warranty</h4>
                                <div class="service-info-item">
                                    <strong>Replaced Part:</strong>
                                    <span>${servicePart}</span>
                                </div>
                                <div class="service-info-item">
                                    <strong>Warranty Expiry:</strong>
                                    <span>${warrantyDate} ${warrantyStatus}</span>
                                </div>
                            </div>
                            
                            <div class="service-actions">
                                <button class="btn btn-outline" onclick="showDetails(
                                    '${service.id}',
                                    '${service['Vehicle Model']}',
                                    '${service['Number Plate']}',
                                    '${service['Service Done']}',
                                    '${service['Garage Name']}',
                                    '$${service['Cost']}',
                                    '${servicePart}',
                                    '${new Date(service['Service Start Date']).toLocaleString()}',
                                    '${new Date(service['Service End Date']).toLocaleString()}',
                                    '${warrantyDate}', 
                                    '${service['Service Notes'] || 'No notes available.'}',
                                    '${service['Service Description'] || 'No description available.'}'
                                )">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            accordionElement.innerHTML = accordionHTML;
        }

        // Populate vehicle filter dropdown
        function populateVehicleFilter(services) {
            if (!services || services.length === 0) return;

            const filterElement = document.getElementById('filterVehicle');
            const uniqueVehicles = [...new Set(services.map(service => service['Vehicle Model']))];

            let optionsHTML = '<option value="all">All Vehicles</option>';
            uniqueVehicles.forEach(vehicle => {
                optionsHTML += `<option value="${vehicle}">${vehicle}</option>`;
            });

            filterElement.innerHTML = optionsHTML;
        }

        // Filter services by vehicle
        function filterServices(vehicle) {
            const accordionItems = document.querySelectorAll('.accordion-item');

            accordionItems.forEach(item => {
                if (vehicle === 'all' || item.dataset.vehicle === vehicle) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Toggle accordion visibility
        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('.accordion-icon');

            // Close all accordions
            document.querySelectorAll('.accordion-content').forEach(item => {
                if (item !== content) {
                    item.style.maxHeight = null;
                    item.style.display = 'none';
                    item.previousElementSibling.querySelector('.accordion-icon').classList.remove('rotate');
                }
            });

            // Toggle current accordion
            if (content.style.display === 'block') {
                content.style.maxHeight = null;
                content.style.display = 'none';
                icon.classList.remove('rotate');
            } else {
                content.style.display = 'block';
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.classList.add('rotate');
            }
        }

        // Show service details modal
        function showDetails(id, vehicle, plate, service, garage, cost, part, start, end, warranty, notes, description) {
            document.getElementById('modal-vehicle').textContent = vehicle;
            document.getElementById('modal-plate').textContent = plate;
            document.getElementById('modal-service').textContent = service;
            document.getElementById('modal-garage').textContent = garage;
            document.getElementById('modal-cost').textContent = cost;
            document.getElementById('modal-part').textContent = part;
            document.getElementById('modal-start').textContent = start;
            document.getElementById('modal-end').textContent = end;
            document.getElementById('modal-warranty').textContent = warranty;
            document.getElementById('modal-notes').textContent = notes;
            document.getElementById('modal-description').textContent = description;

            document.getElementById('serviceDetailsModal').style.display = 'block';
        }

        // Close the modal
        function closeModal() {
            document.getElementById('serviceDetailsModal').style.display = 'none';
        }

        // Print service history
        function printHistory() {
            const filterValue = document.getElementById('filterVehicle').value;
            const filterText = document.getElementById('filterVehicle').options[document.getElementById('filterVehicle').selectedIndex].text;

            // Get all visible service items
            const accordionItems = document.querySelectorAll('.accordion-item');
            let printContent = `<h2>${filterValue === 'all' ? 'All Vehicles' : filterText} - Service History</h2>`;

            accordionItems.forEach(item => {
                if (filterValue === 'all' || item.dataset.vehicle === filterValue) {
                    const header = item.querySelector('.accordion-header');
                    const content = item.querySelector('.accordion-content');

                    const vehicleModel = header.querySelector('.left .accordion-title').textContent;
                    const plateNumber = header.querySelector('.left .accordion-subtitle').textContent;
                    const serviceType = header.querySelector('.right .accordion-title').textContent;
                    const serviceDate = header.querySelector('.right .accordion-subtitle').textContent;

                    printContent += `
                        <div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <div>
                                    <h3 style="margin: 0;">${vehicleModel}</h3>
                                    <p style="margin: 0; color: #666;">${plateNumber}</p>
                                </div>
                                <div style="text-align: right;">
                                    <h3 style="margin: 0;">${serviceType}</h3>
                                    <p style="margin: 0; color: #666;">${serviceDate}</p>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });

            const originalContent = document.body.innerHTML;
            document.body.innerHTML = `
                <div style="padding: 20px; font-family: Arial, sans-serif;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h1>Vehicle Service History</h1>
                        <p>Generated on ${new Date().toLocaleDateString()}</p>
                    </div>
                    ${printContent}
                </div>
            `;

            window.print();
            document.body.innerHTML = originalContent;

            // Reattach event listeners
            document.querySelector('.modal-close').addEventListener('click', closeModal);
            document.getElementById('closeModalBtn').addEventListener('click', closeModal);
            document.getElementById('printDetailsBtn').addEventListener('click', printServiceDetails);
            document.getElementById('btnPrint').addEventListener('click', printHistory);
            document.getElementById('filterVehicle').addEventListener('change', function() {
                filterServices(this.value);
            });
        }

        // Print service details
        function printServiceDetails() {
            const vehicle = document.getElementById('modal-vehicle').textContent;
            const plate = document.getElementById('modal-plate').textContent;
            const service = document.getElementById('modal-service').textContent;
            const garage = document.getElementById('modal-garage').textContent;
            const cost = document.getElementById('modal-cost').textContent;
            const part = document.getElementById('modal-part').textContent;
            const start = document.getElementById('modal-start').textContent;
            const end = document.getElementById('modal-end').textContent;
            const warranty = document.getElementById('modal-warranty').textContent;
            const notes = document.getElementById('modal-notes').textContent;
            const description = document.getElementById('modal-description').textContent;

            const originalContent = document.body.innerHTML;

            document.body.innerHTML = `
                <div style="padding: 20px; font-family: Arial, sans-serif;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h1>Service Details Report</h1>
                        <p>Generated on ${new Date().toLocaleDateString()}</p>
                    </div>
                    
                    <div style="max-width: 800px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px;">
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
                            <div>
                                <h2 style="margin: 0;">${vehicle}</h2>
                                <p style="margin: 5px 0; color: #666;">${plate}</p>
                            </div>
                            <div style="text-align: right;">
                                <h3 style="margin: 0;">${service}</h3>
                                <p style="margin: 5px 0; color: #666;">${start}</p>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <h3 style="border-bottom: 1px solid #eee; padding-bottom: 5px;">Service Information</h3>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px;">
                                <p><strong>Garage:</strong> ${garage}</p>
                                <p><strong>Cost:</strong> ${cost}</p>
                                <p><strong>Start Date:</strong> ${start}</p>
                                <p><strong>End Date:</strong> ${end}</p>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <h3 style="border-bottom: 1px solid #eee; padding-bottom: 5px;">Parts & Warranty</h3>
                            <div style="margin-top: 10px;">
                                <p><strong>Replaced Part:</strong> ${part}</p>
                                <p><strong>Warranty Expiry:</strong> ${warranty}</p>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <h3 style="border-bottom: 1px solid #eee; padding-bottom: 5px;">Service Notes</h3>
                            <div style="margin-top: 10px; background-color: #f9f9f9; padding: 10px; border-radius: 5px;">
                                <p>${notes}</p>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <h3 style="border-bottom: 1px solid #eee; padding-bottom: 5px;">Service Description</h3>
                            <div style="margin-top: 10px; background-color: #f9f9f9; padding: 10px; border-radius: 5px;">
                                <p>${description}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div style="text-align: center; margin-top: 30px; font-size: 12px; color: #666;">
                        <p>This is a computer-generated document. No signature is required.</p>
                    </div>
                </div>
            `;

            window.print();
            document.body.innerHTML = originalContent;

            // Reattach event listeners
            document.querySelector('.modal-close').addEventListener('click', closeModal);
            document.getElementById('closeModalBtn').addEventListener('click', closeModal);
            document.getElementById('printDetailsBtn').addEventListener('click', printServiceDetails);
            document.getElementById('btnPrint').addEventListener('click', printHistory);
            document.getElementById('filterVehicle').addEventListener('change', function() {
                filterServices(this.value);
            });

            // Show modal again after printing
            document.getElementById('serviceDetailsModal').style.display = 'block';
        }
    </script>
</body>

</html>