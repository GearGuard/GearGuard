<!DOCTYPE html>
<html lang="en">
<!-- [Previous head and style sections remain the same] -->
<head>
    <meta charset="UTF-8">
    <title>Vehicle Service Assignments</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0FF;
            --secondary: #25272d;
            --accent: #2463eb;
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

        .table-container {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            /* padding: 1.5rem; */
        }

        h2 {
            color: var(--primary);
            text-align: center;
            margin-bottom: 2rem;
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

        .no-data {
            text-align: center;
            color: #f87171;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            th, td {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            th, td {
                font-size: 0.75rem;
            }
            .navMenu a {
                padding: 0.5rem 1rem;
            }
        }

        .btn {
            padding: 0.5rem 1rem;
            margin: 0;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 0.875rem;
            min-width: 50px;
            text-align: center;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-start;
            align-items: center;
        }

        .btn-primary {
            background: var(--accent);
            color: var(--text);
        }

        .btn-secondary {
            background: #30414FFF;
            color: var(--text);
        }

        .btn-danger {
            background: #dc3545;
            color: var(--text);
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<nav class="navMenu">
        <!-- <a href="/mechanic/services/addService" target="_self">Assign New Service</a> -->
        <a href="#" class="active">All Services</a>
        <a href="/mechanic/serviceHistory/editService" target="_self">Edit Services</a>
        <a href="/mechanic/serviceHistory/delete" target="_self">Delete Services</a>
    </nav>
    <div class="table-container">
        <h2>All Vehicle Services</h2>

        <?php if (isset($serviceRecords) && count($serviceRecords) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Service</th>
                        <th>Mechanic</th>
                        <th>Begin</th>
                        <th>End</th>
                        <th>Duration</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($serviceRecords as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['license_plate_no']) ?></td>
                            <td><?= htmlspecialchars($row['service_type']) ?></td>
                            <td><?= htmlspecialchars($row['mechanic_name']) ?></td>
                            <td><?= htmlspecialchars($row['begin_timestamp']) ?></td>
                            <td><?= htmlspecialchars($row['end_timestamp']) ?></td>
                            <td><?= htmlspecialchars($row['duration']) ?></td>
                            <td><?= htmlspecialchars($row['notes']) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button onclick='viewServiceDetails(<?= json_encode($row) ?>)' class="btn btn-primary">View</button>
                                    <a href="/mechanic/serviceHistory/edit?license_plate_no=<?= urlencode($row['license_plate_no']) ?>" class="btn btn-secondary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">❌ No service assignments found.</p>
        <?php endif; ?>
    </div>

    <script>
    function viewServiceDetails(record) {
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
        content.style.backgroundColor = 'var(--secondary)';
        content.style.padding = '2rem';
        content.style.borderRadius = '12px';
        content.style.minWidth = '400px';
        content.style.color = 'var(--text)';
        content.style.position = 'relative';

        content.innerHTML = `
            <h2 style="color: var(--primary); margin-bottom: 1.5rem; text-align: center;">Service Details</h2>
            <div style="margin-bottom: 1rem;">
                <p><strong>Vehicle:</strong> ${record.license_plate_no}</p>
                <p><strong>Service Type:</strong> ${record.service_type}</p>
                <p><strong>Mechanic:</strong> ${record.mechanic_name}</p>
                <p><strong>Begin Time:</strong> ${record.begin_timestamp}</p>
                <p><strong>End Time:</strong> ${record.end_timestamp}</p>
                <p><strong>Duration:</strong> ${record.duration}</p>
                <p><strong>Notes:</strong> ${record.notes}</p>
                <p><strong>Cost:</strong> ${record.cost}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" 
                    style="background: var(--accent); 
                           color: var(--text); 
                           border: none; 
                           padding: 0.5rem 1rem; 
                           border-radius: 6px; 
                           cursor: pointer;
                           width: 100%;">
                Close
            </button>
        `;

        modal.appendChild(content);
        document.body.appendChild(modal);

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }
    </script>
</body>
</html>
