<?php

/** @var $this \gearguard\phpmvc\View */
$this->title = 'View All Appointments';
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

        .appointment-table {
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
		
		.SearchBar {
			text-align: center;
			margin-bottom: 1rem;
			font-size: 1.2rem;
		}
		
		#searchBox {
			width: 20rem;
		}

        .no-results {
            color: var(--primary);
            font-size: 1rem;
            text-align: center;
            margin-top: 1rem;
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
            padding: 1rem;
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

        .view-more-button {
            background: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.4rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 5em;
            margin: 0.2rem;
            display: table;
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

            .appointment-table {
                padding: 1rem;
            }

            th,
            td {
                padding: 0.75rem;
            }
        }
    </style>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>
    <nav class="navMenu">
        <a href="#" class="active">All Appointments<span class="dot"></span></a>
        <a href="/garage/appointment/search" target="_self">Search Appointment<span class="dot"></span></a>
        <a href="/garage/appointment/delete" target="_self">Delete Appointment<span class="dot"></span></a>
    </nav>
	<div class="SearchBar">
    	<label for="textfield">Search:</label>
    	<input type="text" name="textfield" id="searchBox" onKeyUp="search()">
	</div>
    <div class="appointment-table">
      <h2 class="title">All Appointments</h2>
        <table id="appointmentTable">
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
            <tbody>

            </tbody>
        </table>
        <p id="loader" class="no-results">Loading...</p>
    </div>

    <script>
        let page = 1;
        let isLoading = false;
        let hasMoreData = true;
        const limit = 25;
        const loader = document.getElementById('loader');

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
		
		function search() {
			$searchq = document.getElementById("searchBox").value.trim();
			$nodes = document.querySelectorAll("tbody tr");
			
			if ($searchq == "") {
				$nodes.forEach(n => {
					n.hidden = false;
				});
			}
			
			$nodes.forEach(n => {
				if (!n.innerHTML.includes($searchq)){
					n.hidden = true;
				} else {
					n.hidden = false;
				}
			});
		}

        async function fetchAppointments() {
            if (isLoading || !hasMoreData) return;

            isLoading = true;
            loader.textContent = 'Loading...';

            try {
                const response = await fetch(`/api/garage/getAppointments?page=${page}`);

                if (!response.ok) {
                    loader.textContent = 'Error loading appointments.';
                    hasMoreData = false;
                    return;
                }

                const result = await response.json();

                if (!result) {
                    loader.textContent = 'Error loading appointments.';
                    hasMoreData = false;
                    return;
                }

                appendRows(result);

                if (result.length < limit) {
                    loader.textContent = '--- End of Appointments Table ---';
                    hasMoreData = false;
                } else if (result.length === 0 && loadedResults === 0) {
                    loader.textContent = 'No Appointments found.';
                    hasMoreData = false;
                } else {
                    page++;
                }
            } catch (error) {
                console.error('Error fetching appointments:', error);
            } finally {
                isLoading = false;
            }
        }

        function appendRows(data) {
            const tableBody = document.querySelector('#appointmentTable tbody');
            data.forEach(appointment => {
                content = `
                              <td>${appointment.vehicle_type}</td>
                              <td>${appointment.first_name} ${appointment.last_name}</td>
                              <td>${appointment.contact_no}</td>
                              <td>${appointment.license_plate_no}</td>
                              <td>${appointment.service_type}</td>
                              <td>${appointment.date} ${appointment.time}</td>
                          `;

                if (appointment.status_id == 1) {
                    content += `<td class='status-column'><button class="view-more-button" onclick="handleAcceptance(event, ${appointment.id}, 2)">Accept</button><button class="view-more-button" onclick="handleAcceptance(event, ${appointment.id}, 3)">Reject</button></td>`;
                } else if (appointment.status_id == 2) {
                    content += `<td>Accepted</td>`;
                } else if (appointment.status_id == 3) {
                    content += `<td>Rejected</td>`;
                } else if (appointment.status_id == 4) {
                    content += `<td>Completed</td>`;
                } else if (appointment.status_id == 5) {
                    content += `<td>Cancelled</td>`;
                }

                row = document.createElement('tr');
                row.addEventListener('click', () => {
                    viewDetails(appointment);
                });
                row.id = 'table-row-id-' + appointment.id;
                row.style.cursor = "pointer";
                row.onmouseover = function () {
                    this.style.backgroundColor = "#33363f";
                };
                row.onmouseout = function () {
                    this.style.backgroundColor = "";
                };
                row.innerHTML = content;
                tableBody.appendChild(row);
            });
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
                fetchAppointments();
            }
        }

        fetchAppointments();

        window.addEventListener('scroll', handleScroll);

    </script>
</body>

</html>