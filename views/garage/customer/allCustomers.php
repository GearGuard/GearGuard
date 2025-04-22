<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Customers - GearGuard</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #c7adad;
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

        .customers-container {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
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
            border-radius: 8px;
            width: 80%;
            max-width: 60%;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1rem;
        }

        .title {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .no-results {
            color: var(--primary);
            font-size: 1rem;
            text-align: center;
            margin-top: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid var(--border);
        }

        th {
            background-color: #33363f;
            color: var(--text);
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #25272d;
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

            .customers-container {
                padding: 1rem;
            }

            table,
            th,
            td {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="#" class="active">All Customers</a>
        <a href="/garage/customers/search" target="_self">Search Customers</a>
        <a href="/garage/customers/send_message" target="_self">Send Messages</a>
    </nav>
    <div class="customers-container">
        <h2 class="title">All Customers</h2>
        <table id="customersTable">
            <thead>
                <tr>
                    <th>Fist Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table body will be populated by JavaScript -->
            </tbody>
        </table>
        <p id="loader" class="no-results">Loading...</p>
    </div>

    <div id="vehicleListModal" class="modal">
        <div id="modal-content" class="modal-content">
            <!-- Modal data will be loaded by JavaScript -->
        </div>
    </div>

    <script>
        let page = 1;
        let isLoading = false;
        let hasMoreData = true;
        let loadedResults = 0;
        const limit = 25;
        const loader = document.getElementById('loader');

        async function fetchCustomers() {
            if (isLoading || !hasMoreData) return;

            isLoading = true;
            loader.textContent = 'Loading...';

            try {
                const response = await fetch(`/api/garage/getCustomers?page=${page}`);

                if (!response.ok) {
                    console.error('Error fetching customers:', error);
                    loader.textContent = 'Error loading customers. Please try again.';
                }

                const result = await response.json();

                if (!result) {
                    console.error('Error fetching customers:', error);
                    loader.textContent = 'Error loading customers. Please try again.';
                }

                appendRows(result);

                if (result.length < limit) {
                    loader.textContent = '--- End of Customers Table ---';
                    hasMoreData = false;
                    window.removeEventListener('scroll', handleScroll);
                } else if (result.length === 0 && loadedResults === 0) {
                    loader.textContent = 'No customers found.';
                    hasMoreData = false;
                    window.removeEventListener('scroll', handleScroll);
                } else {
                    page++;
                }
            } catch (error) {
                console.error('Error fetching customers:', error);
                loader.textContent = 'Error loading customers. Please try again.';
            } finally {
                isLoading = false;
            }
        }

    function appendRows(data) {
        const tableBody = document.querySelector('#customersTable tbody');
        data.forEach(customer => {
            const row = document.createElement('tr');
            row.addEventListener('click', () => {
                showVehicleDetails(customer);
            });
            row.style.cursor = "pointer";
            row.onmouseover = function () {
                this.style.backgroundColor = "#33363f";
            };
            row.onmouseout = function () {
                this.style.backgroundColor = "";
            };
            row.innerHTML = `
                <td>${customer.first_name}</td>
                <td>${customer.last_name}</td>
                <td>${customer.contact_no}</td>
                <td>${customer.email}</td>
                <td>${customer.address}</td>
            `;
            tableBody.appendChild(row);
            loadedResults++;
        });
    }

    function handleScroll() {
        const { scrollTop, clientHeight, scrollHeight } = document.documentElement;
        if (scrollTop + clientHeight >= scrollHeight - 5) {
            fetchCustomers();
        }
    }

    fetchCustomers();

    window.addEventListener('scroll', handleScroll);

    function showVehicleDetails(customer) {
        modal = document.getElementById('modal-content');
        modal.innerHTML = `<i>Give us a second, we are getting vehicle info.</i>
                          <div class="modal-buttons">
                              <button type="button" class="search-button" onclick="closeVehicleDetailsModal()">Cancel</button>
                          </div>`;
        openVehicleDetailsModal(customer);
        fetchVehicleDetails(customer);
    }

    async function fetchVehicleDetails(customer) {
        try {
            const response = await fetch(`/api/garage/getCustomerVehicles?customerID=${customer.id}`);

            if (!response.ok) {
                console.error('Error fetching vehicle details:', error);
                alert('Could not load vehicle details!');
                return;
            }

            const vehicles = await response.json();

            if (!vehicles) {
                console.error('Error fetching vehicle details:', error);
                alert('Could not load vehicle details!');
                return;
            }

            if (vehicles.length === 0) {
                document.getElementById('modal-content').innerHTML = `<p>No vehicles found for this customer.</p>
                                <div class="modal-buttons">
                                    <button type="button" class="search-button" onclick="closeVehicleDetailsModal()">Close</button>
                                </div>`;
                return;
            }

            let vehicleList = `<h3>Vehicle list of ${customer.first_name} ${customer.last_name}:</h3><table><thead>
                <tr>
                    <th>License Plate No</th>
                    <th>Vehicle Type</th>
                    <th>Model</th>
                    <th>Year Manufactured</th>
                </tr></thead><tbody>`;
            vehicles.forEach(vehicle => {
                vehicleList += `<tr><td>${vehicle.license_plate_no}</td><td>${vehicle.type}</td><td>${vehicle.model}</td><td>${vehicle.year_manufactured}</td></tr>`;
            });
            vehicleList += '</tbody></table>';

            document.getElementById('modal-content').innerHTML = vehicleList + `
                <div class="modal-buttons">
                    <button type="button" class="search-button" onclick="closeVehicleDetailsModal()">Close</button>
                </div>`;
        } catch (error) {
            console.error('Error fetching vehicle details:', error);
            alert('Could not load vehicle details!');
        }
    }

    function openVehicleDetailsModal(vehicleId) {
        document.getElementById('vehicleListModal').style.display = 'block';
    }

    function closeVehicleDetailsModal() {
        document.getElementById('vehicleListModal').style.display = 'none';
    }

    </script>
</body>

</html>