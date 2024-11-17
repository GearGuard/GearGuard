<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8fafc;
            font-family: "Inter", sans-serif;
            color: #334155;
            line-height: 1.6;
            padding: 10px;
        }

        .navMenu {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 67.5%;
            padding: 1rem;
            margin: 0 auto 2rem;
            position: sticky;
            top: 20px;
            z-index: 100;
        }

        .navMenu a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 2.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            white-space: nowrap;
        }

        .navMenu a.active {
            color: #2563eb;
            background: #eff6ff;
        }

        .navMenu a:hover {
            color: #2563eb;
            background: #f8fafc;
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
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .add-vehicle-btn {
            background: #2563eb;
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
            transform: translateY(-1px);
        }

        .vehicles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .vehicle-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
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
            color: #1e293b;
        }

        .vehicle-nickname {
            font-size: 0.875rem;
            color: #64748b;
        }

        .vehicle-badges {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .badge-green {
            background: #f0fdf4;
            color: #16a34a;
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
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 0.875rem;
            color: #1e293b;
            font-weight: 500;
        }

        .vehicle-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: auto;
        }

        .action-button {
            flex: 1;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            text-decoration: none;
        }

        .edit-btn {
            background: #f1f5f9;
            color: #475569;
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

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow-y: auto;
            padding: 20px;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 40px auto;
            padding: 2rem;
            position: relative;
            animation: modalSlideIn 0.3s ease;
        }

        .submit-button {
            background: #2563eb;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .submit-button:hover {
            background: #1d4ed8;
        }

        .clear-button {
            background: #f1f5f9;
            color: #475569;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .clear-button:hover {
            background: #e2e8f0;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
        }

        .close-button {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #64748b;
            cursor: pointer;
            padding: 0.5rem;
            margin: -0.5rem;
            transition: color 0.2s ease;
        }

        .close-button:hover {
            color: #1e293b;
        }

        .modal .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .modal .form-column {
            flex: 1;
        }

        .modal .form-group {
            margin-bottom: 1.5rem;
        }

        .modal label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .modal input[type="text"],
        .modal input[type="date"],
        .modal select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #fff;
            color: #1e293b;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .modal input[type="text"]:hover,
        .modal input[type="date"]:hover,
        .modal select:hover {
            border-color: #94a3b8;
        }

        .modal input[type="text"]:focus,
        .modal input[type="date"]:focus,
        .modal select:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .modal .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        @media (max-width: 768px) {
            .navMenu {
                flex-direction: column;
                padding: 0.5rem;
                width: 90%;
            }

            .navMenu a {
                width: 100%;
                text-align: center;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .vehicles-grid {
                grid-template-columns: 1fr;
            }

            .vehicle-details {
                grid-template-columns: 1fr;
            }

            .modal-content {
                margin: 20px;
                padding: 1rem;
            }

            .modal .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="#">New Vehicle</a>
        <a href="#" class="active">My Vehicle</a>
        <a href="#">Service History</a>
    </nav>

    <div class="container">
        <div class="header">
            <h1 class="title">My Vehicles</h1>
            <a href="/new-vehicle" class="add-vehicle-btn">+ Add New Vehicle</a>
        </div>

        <div class="vehicles-grid" id="vehiclesGrid">
            <!-- Vehicle cards will be populated here -->
        </div>
    </div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Vehicle Details</h2>
                <button class="close-button" onclick="closeModal()">&times;</button>
            </div>
            <form id="editVehicleForm" onsubmit="updateVehicle(event)">
                <input type="hidden" id="editVehicleId">

                <div class="form-row">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="editBrand">Vehicle Brand<span class="required-dot">*</span></label>
                            <input type="text" id="editBrand" name="brand" required>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="editVehicleType">Vehicle Type<span class="required-dot">*</span></label>
                            <select id="editVehicleType" name="vehicle_type" required>
                                <option value="">Select Vehicle Type</option>
                                <option value="car">Car</option>
                                <option value="motorcycle">Motorcycle</option>
                                <option value="truck">Truck</option>
                                <option value="van">Van</option>
                                <option value="suv">SUV</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="editYear">Manufactured Year<span class="required-dot">*</span></label>
                            <select id="editYear" name="year" required>
                                <option value="">Select Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="editPlateNumber">Number Plate<span class="required-dot">*</span></label>
                            <input type="text" id="editPlateNumber" name="plate_number" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="editNic">Registered NIC<span class="required-dot">*</span></label>
                            <input type="text" id="editNic" name="nic" required>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="editNickname">Vehicle Nickname</label>
                            <input type="text" id="editNickname" name="nickname">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="editBoughtDate">Vehicle Bought Date<span class="required-dot">*</span></label>
                            <input type="date" id="editBoughtDate" name="bought_date" required>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="editFuelType">Fuel Type<span class="required-dot">*</span></label>
                            <select id="editFuelType" name="fuel_type" required>
                                <option value="">Select Fuel Type</option>
                                <option value="petrol">Petrol</option>
                                <option value="diesel">Diesel</option>
                                <option value="electric">Electric</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="editIsHybrid" name="is_hybrid">
                        <label for="editIsHybrid">This is a hybrid vehicle</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="clear-button" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="submit-button">Update Vehicle</button>
                </div>
            </form>
        </div>
    </div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Vehicle Details</h2>
                <button class="close-button" onclick="closeModal()">&times;</button>
            </div>
            <form id="editVehicleForm" onsubmit="updateVehicle(event)">
                <input type="hidden" id="editVehicleId">
                <div class="form-group">
                    <label for="editBrand">Vehicle Brand</label>
                    <input type="text" id="editBrand" name="brand" required>
                </div>
                <div class="form-group">
                    <label for="editYear">Manufactured Year</label>
                    <select id="editYear" name="year" required>
                        <option value="">Select Year</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="clear-button" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="submit-button">Update Vehicle</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sample data
        const vehicles = [{
                id: 1,
                brand: "Toyota",
                model: "Camry",
                nickname: "Daily Commuter",
                year: 2020,
                plateNumber: "ABC-1234",
                nic: "123456789V",
                boughtDate: "2020-06-15",
                fuelType: "Petrol",
                isHybrid: true,
                vehicleType: "Car"
            },
            {
                id: 2,
                brand: "Honda",
                model: "CBR",
                nickname: "Weekend Rider",
                year: 2021,
                plateNumber: "XYZ-5678",
                nic: "987654321V",
                boughtDate: "2021-03-10",
                fuelType: "Petrol",
                isHybrid: false,
                vehicleType: "Motorcycle"
            }
        ];

        // Populate years in the select dropdown
        function populateYears() {
            const yearSelect = document.getElementById('editYear');
            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year >= 1990; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            }
        }

        function createVehicleCard(vehicle) {
            return `
                <div class="vehicle-card">
                    <div class="vehicle-header">
                        <div>
                            <h2 class="vehicle-title">${vehicle.brand}</h2>
                            ${vehicle.nickname ? `<p class="vehicle-nickname">${vehicle.nickname}</p>` : ''}
                        </div>
                    </div>
                    <div class="vehicle-badges">
                        <span class="badge badge-blue">${vehicle.vehicleType}</span>
                        ${vehicle.isHybrid ? '<span class="badge badge-green">Hybrid</span>' : ''}
                    </div>
                    <div class="vehicle-details">
                        <div class="detail-item">
                            <span class="detail-label">Plate Number</span>
                            <span class="detail-value">${vehicle.plateNumber}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Year</span>
                            <span class="detail-value">${vehicle.year}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Fuel Type</span>
                            <span class="detail-value">${vehicle.fuelType}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Bought Date</span>
                            <span class="detail-value">${new Date(vehicle.boughtDate).toLocaleDateString()}</span>
                        </div>
                    </div>
                    <div class="vehicle-actions">
                        <button onclick="openEditModal(${vehicle.id})" class="action-button edit-btn">Edit</button>
                        <button onclick="deleteVehicle(${vehicle.id})" class="action-button delete-btn">Delete</button>
                    </div>
                </div>
            `;
        }

        function openEditModal(vehicleId) {
            const vehicle = vehicles.find(v => v.id === vehicleId);
            if (vehicle) {
                document.getElementById('editVehicleId').value = vehicle.id;
                document.getElementById('editBrand').value = vehicle.brand;
                document.getElementById('editYear').value = vehicle.year;
                document.getElementById('editModal').style.display = 'block';
            }
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function updateVehicle(event) {
            event.preventDefault();
            const vehicleId = parseInt(document.getElementById('editVehicleId').value);
            const newBrand = document.getElementById('editBrand').value;
            const newYear = parseInt(document.getElementById('editYear').value);

            // Update the vehicle in the array
            const vehicleIndex = vehicles.findIndex(v => v.id === vehicleId);
            if (vehicleIndex !== -1) {
                vehicles[vehicleIndex].brand = newBrand;
                vehicles[vehicleIndex].year = newYear;

                // Refresh the display and close the modal
                loadVehicles();
                closeModal();
            }
        }

        function deleteVehicle(id) {
            if (confirm('Are you sure you want to delete this vehicle?')) {
                const index = vehicles.findIndex(v => v.id === id);
                if (index !== -1) {
                    vehicles.splice(index, 1);
                    loadVehicles();
                }
            }
        }

        function loadVehicles() {
            const vehiclesGrid = document.getElementById('vehiclesGrid');

            if (vehicles.length === 0) {
                vehiclesGrid.innerHTML = `
                    <div class="no-vehicles">
                        <p class="no-vehicles-text">You haven't added any vehicles yet.</p>
                        <a href="/new-vehicle" class="add-vehicle-btn">Add Your First Vehicle</a>
                    </div>
                `;
                return;
            }

            vehiclesGrid.innerHTML = vehicles.map(vehicle => createVehicleCard(vehicle)).join('');
        }

        // Initialize the page
        window.onload = function() {
            populateYears();
            loadVehicles();
        };

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</body>

</html>