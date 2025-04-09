<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Customers - GearGuard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .search-container {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .search-title {
            color: var(--primary);
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .search-form {
            display: flex;
            gap: 1rem;
        }

        .search-input {
            flex-grow: 1;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: var(--background);
            color: var(--text);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        .search-button {
            padding: 0.75rem 1.5rem;
            background-color: var(--accent);
            color: var(--text);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-button:hover {
            background-color: #1b4ebd;
        }

        .results-container {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            display: none;
        }

        .customer-info {
            margin-bottom: 2rem;
        }

        .customer-info h2 {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 1rem;
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

        .customer-info p {
            margin-bottom: 0.5rem;
        }

        .service-history {
            margin-top: 2rem;
        }

        .service-history h3 {
            color: var(--primary);
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .service-card {
            background: var(--background);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .service-card h4 {
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .service-card p {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
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
            .search-form {
                flex-direction: column;
            }

            .search-button {
                width: 100%;
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
        <a href="/customers/view" target="_self">All Customers</a>
        <a href="#" class="active">Search Customers</a>
        <a href="/customers/send_message" target="_self">Send Messages</a>
    </nav>
    <div class="container">
        <div class="search-container">
            <h1 class="search-title">Search Customers</h1>
            <form class="search-form" onsubmit="searchCustomer(event)">
                <input type="text" class="search-input" id="searchInput" placeholder="Enter customer name or email" required>
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <div class="results-container" id="customersContainer">
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

        <!-- <div class="results-container" id="resultsContainer">
            <div class="customer-info">
                <h2 id="customerName"></h2>
                <p id="customerEmail"></p>
                <p id="customerVehicle"></p>
            </div>
            <div class="service-history">
                <h3>Recent Service History</h3>
                <div id="serviceCards"></div>
            </div>
        </div> -->
    </div>

    <script>
        let page = 1;
        let isLoading = false;
        let hasMoreData = true;
        const limit = 25;
        const loader = document.getElementById('loader');

        async function searchCustomer(event) {
            if (event != null)
                event.preventDefault();
            const searchTerm = document.getElementById('searchInput').value;
            document.querySelector('.results-container').style.display = 'block';

            if (isLoading || !hasMoreData) return;

            isLoading = true;
            loader.textContent = 'Loading...';

            try {
                const response = await fetch(`/api/garage/getCustomers?page=${page}&firstname=${searchTerm}&lastname=${searchTerm}&email=${searchTerm}`);
                const result = await response.json();

                appendRows(result);

                if (result.length < limit) {
                    loader.textContent = '--- End of Search Results ---';
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
                document.getElementById('resultsContainer').style.display = 'none';
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
            });
        }

        function handleScroll() {
            const { scrollTop, clientHeight, scrollHeight } = document.documentElement;
            if (scrollTop + clientHeight >= scrollHeight - 5) {
                searchCustomer(null);
            }
        }

        window.addEventListener('scroll', handleScroll);

        /* function displayResults(data) {
            document.getElementById('resultsContainer').style.display = 'block';
            document.getElementById('customerName').textContent = data.name;
            document.getElementById('customerEmail').textContent = `Email: ${data.email}`;
            document.getElementById('customerVehicle').textContent = `Vehicle: ${data.vehicle}`;

            const serviceCardsContainer = document.getElementById('serviceCards');
            serviceCardsContainer.innerHTML = '';

            data.serviceHistory.forEach(service => {
                const serviceCard = document.createElement('div');
                serviceCard.className = 'service-card';
                serviceCard.innerHTML = `
                    <h4>${service.garageName} - ${service.date}</h4>
                    <p><strong>Description:</strong> ${service.description}</p>
                    <p><strong>Total Cost:</strong> $${service.totalCost}</p>
                    <p><strong>Spare Parts:</strong> ${service.spareParts}</p>
                `;
                serviceCardsContainer.appendChild(serviceCard);
            });
        } */
    </script>
</body>

</html>