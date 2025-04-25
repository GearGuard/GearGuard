<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service Record</title>
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

        .form-container {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            color: var(--primary);
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        input, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--background);
            color: var(--text);
        }

        .btn {
            background: var(--accent);
            color: var(--text);
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Edit Service Record</h1>
        <form action="/mechanic/serviceHistory/update/<?= htmlspecialchars($record['id']) ?>" method="POST">
            <div class="form-group">
                <label for="vehicle">Vehicle</label>
                <input type="text" id="vehicle" value="<?= htmlspecialchars($record['license_plate_no']) ?>" disabled>
            </div>
            
            <div class="form-group">
                <label for="service">Service Type</label>
                <input type="text" id="service" value="<?= htmlspecialchars($record['service_type']) ?>" disabled>
            </div>
            
            <div class="form-group">
                <label for="mechanic">Mechanic</label>
                <input type="text" id="mechanic" value="<?= htmlspecialchars($record['mechanic_name']) ?>" disabled>
            </div>
            
            <div class="form-group">
                <label for="begin_timestamp">Begin Time</label>
                <input type="datetime-local" id="begin_timestamp" name="begin_timestamp" 
                       value="<?= htmlspecialchars(str_replace(' ', 'T', $record['begin_timestamp'])) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="end_timestamp">End Time</label>
                <input type="datetime-local" id="end_timestamp" name="end_timestamp" 
                       value="<?= htmlspecialchars(str_replace(' ', 'T', $record['end_timestamp'])) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="4"><?= htmlspecialchars($record['notes']) ?></textarea>
            </div>
            
            <button type="submit" class="btn">Update Record</button>
        </form>
    </div>
</body>
</html>
