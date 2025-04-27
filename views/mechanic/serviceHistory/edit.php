<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Vehicle Service</title>
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

        form {
            background: var(--secondary);
            padding: 2rem;
            border-radius: 12px;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--primary);
        }

        input[type="text"],
        input[type="datetime-local"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            background: var(--background);
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 4px;
            margin-bottom: 1rem;
            font-family: "Inter", sans-serif;
            font-size: 1rem;
        }

        textarea {
            resize: vertical;
        }

        button {
            background: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #1a4ed8;
        }
    </style>
</head>
<body>
<nav class="navMenu">
    <a href="/mechanic/serviceHistory/viewAll" >All Services</a>
    <a href="#" class="active">Edit Service</a>
    <a href="/mechanic/serviceHistory/delete" >Delete Services</a>
</nav>

<?php if (isset($record)): ?>
<form id="editServiceForm" method="POST" action="/mechanic/serviceHistory/update">
    <input type="hidden" name="id" value="<?= htmlspecialchars($record['id']) ?>">
    <label for="license_plate_no_display">Vehicle</label>
    <input type="text" id="license_plate_no_display" value="<?= htmlspecialchars($record['license_plate_no']) ?>" disabled>

    <label for="service_type">Service Type</label>
    <input type="text" id="service_type" value="<?= htmlspecialchars($record['service_type']) ?>" disabled>

    <label for="cost">Cost</label>
    <input type="text" id="cost" name="cost" value="<?= htmlspecialchars($record['cost']) ?>">

    <label for="begin_timestamp">Begin Time</label>
    <input type="datetime-local" id="begin_timestamp" name="begin_timestamp" value="<?= str_replace(' ', 'T', htmlspecialchars($record['begin_timestamp'])) ?>" required>

    <label for="end_timestamp">End Time</label>
    <input type="datetime-local" id="end_timestamp" name="end_timestamp" value="<?= str_replace(' ', 'T', htmlspecialchars($record['end_timestamp'])) ?>" required>

    <label for="notes">Notes</label>
    <textarea id="notes" name="notes" rows="4"><?= htmlspecialchars($record['notes']) ?></textarea>

    <div style="display: flex; gap: 1rem; margin-top: 1rem;">
        <button type="button" onclick="window.location.href='/mechanic/serviceHistory/viewAll'" style="background: var(--secondary); border: 1px solid var(--border);">Back</button>
        <button type="submit">Update</button>
    </div>
</form>

<script>
document.getElementById('editServiceForm').onsubmit = function(e) {
    e.preventDefault();
    
    fetch('/mechanic/serviceHistory/update', {
        method: 'POST',
        body: new FormData(this),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Service history updated successfully');
            window.location.href = '/mechanic/serviceHistory/viewAll';
        } else {
            alert('Error: ' + (data.error || 'Failed to update service history'));
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
};
</script>

<?php elseif (isset($_GET['license_plate_no'])): ?>
<p>No service record found for license plate number: <?= htmlspecialchars($_GET['license_plate_no']) ?></p>
<?php else: ?>
<form id="searchForm" method="GET" action="/mechanic/serviceHistory/edit">
    <label for="license_plate_no">Search by License Plate Number:</label>
    <input type="text" id="license_plate_no" name="license_plate_no" required>
    <button type="submit">Search</button>
</form>
<?php endif; ?>

</body>
</html>
