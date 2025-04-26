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
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>
<nav class="navMenu">
    <a href="/appointment/appointments" target="_self">All Appointments<span class="dot"></span></a>
    <a href="#" class="active">Search Appointment<span class="dot"></span></a>
    <a href="/garage/appointment/delete" target="_self">Delete Appointment<span class="dot"></span></a>
</nav>

<div class="search-container">
    <h2 class="search-title">Search Appointments</h2>
    <form id="searchForm" onsubmit="handleSearch(event)">
        <input type="text" id="firstname" class="search-input"
               placeholder="Enter First Name"/>
		<input name="textfield" type="text" class="search-input" id="lastname" placeholder="Enter Last Name">
		<input name="textfield" type="text" class="search-input" id="numberplate" placeholder="Enter Number Plate">
		<input name="tel" type="tel" class="search-input" id="contact" placeholder="Enter Contact Number">
		<input name="date" type="date" class="search-input" id="date" placeholder="Enter Date">
		<select name="select" class="search-input" id="condition">
            <option value="">Select a condition for date</option>
			<option value="before">Before</option>
			<option value="after">After</option>
			<option value="on">On</option>
			<option value="on or before">On or Before</option>
			<option value="on or after">On or After</option>
		</select>
		<select name="select" class="search-input" id="status">
            <option value="">Select a status</option>
			<option value="accepted">Accepted</option>
			<option value="rejected">Rejected</option>
			<option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
		</select>
        <button type="submit" class="search-button">Search</button>
    </form>
</div>

<div class="results-container" id="resultsContainer" style="display: none;">
    <table class="results-table">
        <thead>
        <tr>
            <th>Vehicle Type</th>
            <th>Client's Name</th>
            <th>Contact Number</th>
            <th>Number Plate</th>
            <th>Service Type</th>
            <th>Date & Time</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody id="resultsBody">
        <!-- Results will be injected dynamically -->
        </tbody>
    </table>
    <p class="no-results" id="loader" style="display: none;">No results found.</p>
</div>

<script>
    let page = 1;
    let isLoading = false;
    let hasMoreData = true;
    let loadedResults = 0;
    const limit = 25;
    const loader = document.getElementById('loader');

    function resetVariables() {
        page = 1;
        isLoading = false;
        hasMoreData = true;
        loadedResults = 0;
    }

    document.querySelectorAll('#searchForm input, #searchForm select').forEach(a => addEventListener("input", (event) => resetVariables()));

    async function handleSearch(event) {
        if (event !== null) {
            event.preventDefault();
            document.getElementById('resultsBody').innerHTML = '';
        }

        const firstname = document.getElementById('firstname').value.trim();
		const lastname = document.getElementById('lastname').value.trim();
		const numberplate = document.getElementById('numberplate').value.trim();
		const contact = document.getElementById('contact').value.trim();
		const date = document.getElementById('date').value.trim();
		const condition = document.getElementById('condition').value.trim();
        const status = document.getElementById('status').value.trim();
        const resultsContainer = document.getElementById('resultsContainer');
        const resultsBody = document.getElementById('resultsBody');
        const noResultsMessage = document.getElementById('noResultsMessage');

        if (isLoading || !hasMoreData) return false;

        isLoading = true;
        loader.textContent = 'Loading...';
        loader.style.display = 'block';

        try {
            const response = await fetch(`/api/garage/getAppointmentsFiltered?firstname=${firstname}&lastname=${lastname}&numberplate=${numberplate}&contact=${contact}&date=${date}&condition=${condition}&status=${status}&page=${page}`);

            if (!response.ok) {
                alert('Something went wrong. Please try again later.');
                return;
            }

            const data = await response.json();

            if (!data) {
                alert('Something went wrong. Please try again later.');
                return;
            }

            if (data.length === 0 && loadedResults === 0) {
                loader.textContent = 'No appointments found.';
                hasMoreData = false;
            } else if (data.length < limit) {
               loader.textContent = '--- End of Search Results ---';
               hasMoreData = false;
            } else {
                page++;
            }
            data.forEach(item => {
                let tablerow = `<tr id='table-row-id-${item.id}' onclick='viewDetails(${JSON.stringify(item)})' onmouseover='addBackground(this)' onmouseout='removeBackground(this)' style='cursor:pointer'>
                    <td>${item.vehicle_type}</td>
                    <td>${item.first_name} ${item.last_name}</td>
                    <td>${item.contact_no}</td>
                    <td>${item.license_plate_no}</td>
                    <td>${item.service_type}</td>
                    <td>${item.date} ${item.time}</td>`;

                if (item.status_id === 1) {
                    tablerow += `<td class='status-column'><button class="view-more-button" onclick="handleAcceptance(event, ${item.id}, 2)">Accept</button><button class="view-more-button" onclick="handleAcceptance(event, ${item.id}, 3)">Reject</button></td>`;
                }

                tablerow += `</tr>`;

                resultsBody.innerHTML += tablerow;
                loadedResults++;
            });
            resultsContainer.style.display = 'block';
            resultsContainer.scrollIntoView();
        } catch (error) {
            console.log('Error:', error);
        }
        return false;
    }

    function addBackground(element) {
        element.style.backgroundColor = '#33363f';
    }

    function removeBackground(element) {
        element.style.backgroundColor = '';
    }

    function viewDetails(appointment) {
        const modal = document.createElement('div');
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
        modal.style.display = 'flex';
        modal.style.justifyContent = 'center';
        modal.style.alignItems = 'center';
        modal.style.zIndex = '1000';

        const content = document.createElement('div');
        content.style.backgroundColor = '#25272d';
        content.style.padding = '20px';
        content.style.borderRadius = '8px';
        content.style.color = '#f5f5f5';

        content.innerHTML = `<h2>${appointment.license_plate_no}</h2>
                         <p>Vehicle Mode: ${appointment.vehicle_model}</p>
                         <p>Notes: ${appointment.notes}</p>
                         <button onclick='this.parentElement.parentElement.remove()' style='padding: 10px; background: var(--accent); color: var(--text); border: none; border-radius: 5px; cursor: pointer;'>Close</button>`;

        modal.appendChild(content);
        document.body.appendChild(modal);
    }

    async function handleAcceptance(event, appointment_id, status_id) {
        event.stopPropagation();

        try {
            const response = await fetch('/appointment/update_status', {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({appointment_id: appointment_id, status_id: status_id})
            });

            if (!response.ok) {
                alert('An error occurred. Please try again later.');
                return;
            }

            result = await response.text();

            if (!result === 'success') {
                alert('An error occurred. Please try again later.');
                return;
            }

            alert('Appointment status updated successfully.');
            let status;
            if (status_id === 2) {
                status = 'Accepted';
            } else if (status_id === 3) {
                status = 'Rejected';
            } else if (status_id === 4) {
                status = 'Completed';
            } else if (status_id === 5) {
                status = 'Cancelled';
            }
            document.querySelector('#table-row-id-' + appointment_id + '>.status-column').textContent = status;
        } catch (error) {
            console.log('Error:', error);
            alert('An error occurred. Please try again later.');
        }
    }

    function handleScroll() {
        const { scrollTop, clientHeight, scrollHeight } = document.documentElement;
        if ((scrollTop + clientHeight >= scrollHeight - 5) && hasMoreData) {
            handleSearch(null);
        }
    }

    window.addEventListener('scroll', handleScroll);

</script>
</body>

</html>