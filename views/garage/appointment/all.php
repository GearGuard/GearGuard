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
</head>

<body>
    <nav class="navMenu">
        <a href="#" class="active">All Appointments<span class="dot"></span></a>
        <a href="/appointment/search" target="_self">Search Appointment<span class="dot"></span></a>
        <a href="/appointment/delete" target="_self">Delete Appointment<span class="dot"></span></a>
    </nav>

    <div class="appointment-table">
        <h2 class="title">All Appointments</h2>
        <table>
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
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($appointment['vehicle_type']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['first_name'] . " " . $appointment['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['contact_no']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['license_plate_no']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['service_type']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['date'] . " " . $appointment['time']); ?></td>
                    <td><button onclick='viewDetails(<?php echo json_encode($appointment); ?>)' class="view-more-button">View More</button></td>
                    <?php if ($appointment['status_id'] == 1): ?>
                        <td><button class="view-more-button">Accept</button><button class="view-more-button">Reject</button></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
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
                             <p>Notes: ${appointment.notes} hours</p>
                             <button onclick='this.parentElement.parentElement.remove()' style='padding: 10px; background: var(--accent); color: var(--text); border: none; border-radius: 5px; cursor: pointer;'>Close</button>`;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }
    </script>
</body>

</html>