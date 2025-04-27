<!DOCTYPE html>
<html lang="en">
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

        .table-container {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        h1 {
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

        .btn {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: var(--accent);
            color: var(--text);
        }

        .btn-secondary {
            background: var(--primary);
            color: var(--secondary);
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
    <div class="table-container">
        <h1>All Vehicle Services</h1>

        <?php if (isset($serviceRecords) && count($serviceRecords) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
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
                            <!-- <td><?= htmlspecialchars($row['id']) ?></td> -->
                            <td><?= htmlspecialchars($row['license_plate_no']) ?></td>
                            <td><?= htmlspecialchars($row['service_type']) ?></td>
                            <td><?= htmlspecialchars($row['mechanic_name']) ?></td>
                            <td><?= htmlspecialchars($row['begin_timestamp']) ?></td>
                            <td><?= htmlspecialchars($row['end_timestamp']) ?></td>
                            <td><?= htmlspecialchars($row['duration']) ?></td>
                            <td><?= htmlspecialchars($row['notes']) ?></td>
                            <td>
                                <button onclick='viewServiceDetails(<?= json_encode($row) ?>)' class="btn btn-primary">View</button>
                                <button onclick='editServiceDetails(<?= json_encode($row) ?>)' class="btn btn-secondary">Edit</button>
                                <a href="/mechanic/serviceHistory/delete/<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger">Delete</a>
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

    function editServiceDetails(record) {
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
        content.style.minWidth = '500px';
        content.style.color = 'var(--text)';
        content.style.position = 'relative';

        content.innerHTML = `
            <h2 style="color: var(--primary); margin-bottom: 1.5rem; text-align: center;">Edit Service Record</h2>
            <form id="editForm" method="POST">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Vehicle</label>
                    <input type="text" value="${record.license_plate_no}" disabled 
                           style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Service Type</label>
                    <input type="text" value="${record.service_type}" disabled 
                           style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Begin Time</label>
                    <input type="datetime-local" name="begin_timestamp" value="${record.begin_timestamp.replace(' ', 'T')}" required 
                           style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">End Time</label>
                    <input type="datetime-local" name="end_timestamp" value="${record.end_timestamp.replace(' ', 'T')}" required 
                           style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Notes</label>
                    <textarea name="notes" rows="4" style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">${record.notes}</textarea>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" style="flex: 1; background: var(--accent); color: var(--text); border: none; padding: 0.75rem; border-radius: 4px; cursor: pointer;">Update</button>
                    <button type="button" onclick="this.closest('.modal-container').remove()" 
                            style="flex: 1; background: var(--border); color: var(--text); border: none; padding: 0.75rem; border-radius: 4px; cursor: pointer;">Cancel</button>
                </div>
            </form>
        `;

        modal.classList.add('modal-container');
        modal.appendChild(content);
        document.body.appendChild(modal);

        // Add form submit handler
        const form = content.querySelector('#editForm');
        form.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const formDataObj = {};
            formData.forEach((value, key) => formDataObj[key] = value);

            try {
                const response = await fetch(`/mechanic/serviceHistory/update/${record.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formDataObj)
                });

                const data = await response.json();
                
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to update record');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while updating');
            }
        };

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }
    </script>
</body>
</html>
