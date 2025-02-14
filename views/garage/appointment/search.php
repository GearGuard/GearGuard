<?php

/** @var $this \gearguard\phpmvc\View */
$this->title = 'Search Appointments';
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

        .search-container {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            margin: 0 auto 2rem;
            padding: 2rem;
            text-align: center;
        }

        .search-title {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--background);
            color: var(--text);
            font-size: 1rem;
            margin-bottom: 1rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 5px var(--accent);
        }

        .search-button {
            background: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .search-button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        .search-button:active {
            transform: translateY(0);
        }

        .results-container {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }

        th {
            color: var(--primary);
            background: var(--secondary);
            text-transform: uppercase;
        }

        tr:hover {
            background: var(--hover-bg);
            transition: all 0.2s ease;
        }

        .no-results {
            color: var(--primary);
            font-size: 1rem;
            text-align: center;
            margin-top: 1rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {

            .search-container,
            .results-container {
                padding: 1rem;
            }

            th,
            td {
                padding: 0.75rem;
                font-size: 0.875rem;
            }

            .search-button {
                font-size: 0.875rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="/appointment/appointments" target="_self">All Appointments<span class="dot"></span></a>
        <a href="#" class="active">Search Appointment<span class="dot"></span></a>
        <a href="/appointment/delete" target="_self">Delete Appointment<span class="dot"></span></a>
    </nav>

    <div class="search-container">
        <h2 class="search-title">Search Appointments</h2>
        <form id="searchForm" onsubmit="return handleSearch()">
            <input type="text" id="searchInput" class="search-input" placeholder="Enter Customer Name, Number Plate, or Contact Number" />
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    <div class="results-container" id="resultsContainer" style="display: none;">
        <table class="results-table">
            <thead>
                <tr>
                    <th>Vehicle Type</th>
                    <th>Owner's Name</th>
                    <th>Contact Number</th>
                    <th>Number Plate</th>
                    <th>Vehicle Model</th>
                    <th>Model Year</th>
                    <th>Service Type</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody id="resultsBody">
                <!-- Results will be injected dynamically -->
            </tbody>
        </table>
        <p class="no-results" id="noResultsMessage" style="display: none;">No results found.</p>
    </div>

    <script>
        function handleSearch() {
            const query = document.getElementById('searchInput').value.trim();
            const resultsContainer = document.getElementById('resultsContainer');
            const resultsBody = document.getElementById('resultsBody');
            const noResultsMessage = document.getElementById('noResultsMessage');

            if (query === '') {
                alert('Please enter a search term.');
                return false;
            }

            // Dummy data for demonstration
            const data = [{
                    type: 'SUV',
                    name: 'John Doe',
                    contact: '+123456789',
                    plate: 'XYZ-1234',
                    model: 'Toyota Highlander',
                    year: 2022,
                    service: 'Oil Change',
                    datetime: '2024-11-20 10:30 AM'
                },
                {
                    type: 'Sedan',
                    name: 'Jane Smith',
                    contact: '+987654321',
                    plate: 'ABC-5678',
                    model: 'Honda Accord',
                    year: 2020,
                    service: 'Tire Rotation',
                    datetime: '2024-11-22 02:00 PM'
                }
            ];

            // Filter results
            const filteredResults = data.filter(item =>
                item.name.toLowerCase().includes(query.toLowerCase()) ||
                item.plate.toLowerCase().includes(query.toLowerCase()) ||
                item.contact.includes(query)
            );

            resultsBody.innerHTML = '';
            if (filteredResults.length > 0) {
                filteredResults.forEach(item => {
                    resultsBody.innerHTML += `
                        <tr>
                            <td>${item.type}</td>
                            <td>${item.name}</td>
                            <td>${item.contact}</td>
                            <td>${item.plate}</td>
                            <td>${item.model}</td>
                            <td>${item.year}</td>
                            <td>${item.service}</td>
                            <td>${item.datetime}</td>
                        </tr>
                    `;
                });
                noResultsMessage.style.display = 'none';
            } else {
                noResultsMessage.style.display = 'block';
            }

            resultsContainer.style.display = 'block';
            return false;
        }
    </script>
</body>

</html>