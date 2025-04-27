<?php
use gearguard\phpmvc\Application;

// Fetch vehicles from the database
$vehicles = [];
try {
    $statement = Application::$app->db->pdo->query("SELECT id, license_plate_no FROM gg_vehicle ORDER BY license_plate_no ASC");
    $vehicles = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $vehicles = [];
    // Log error or handle as needed
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add New Spare Part</title>
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

        .spare-part-form {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .title {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-column {
            flex: 1;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .required-dot {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #33363f;
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        input[type="text"]:hover,
        input[type="number"]:hover,
        input[type="date"]:hover,
        select:hover {
            border-color: var(--accent);
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .add-button {
            background: var(--accent);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .add-button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        .clear-button {
            background: var(--secondary);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .clear-button:hover {
            background: var(--hover-bg);
        }

        #popup-message {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #ddffdd;
        color: #3c763d;
        border: 1px solid #3c763d;
        padding: 15px 25px;
        border-radius: 5px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        font-weight: 600;
        z-index: 1000;
        display: none;
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

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .spare-part-form {
                padding: 1rem;
            }

            .button-container {
                flex-direction: column-reverse;
            }

            .add-button,
            .clear-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">

        <a href="/mechanic/sparepart/addNew" class="active">Add New Spare Part</a>
        <a href="/mechanic/sparepart/viewAll">View All Spare Parts</a>

    </nav>

    <div class="spare-part-form">
        <h2 class="title">Add New Spare Part</h2>
        <?php if (!empty($errors)) : ?>
            <div style="background-color: #ffdddd; color: #a94442; border: 1px solid #a94442; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                <ul>
                    <?php foreach ($errors as $fieldErrors) : ?>
                        <?php foreach ($fieldErrors as $error) : ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)) : ?>
            <div style="background-color: #ddffdd; color: #3c763d; border: 1px solid #3c763d; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        <form action="/mechanic/sparepart/addNew" method="POST">
            <div class="form-column">
                <div class="form-group">
                    <label for="Vehicle">Vehicle<span class="required-dot">*</span></label>
                    <select id="Vehicle" name="Vehicle" required>
                        <option value="" disabled selected>Select a vehicle</option>
                        <?php foreach ($vehicles as $vehicle) : ?>
                            <option value="<?= htmlspecialchars($vehicle['license_plate_no']) ?>"><?= htmlspecialchars($vehicle['license_plate_no']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="serial-no">Serial Number<span class="required-dot">*</span></label>
                        <input type="text" id="serial-no" name="serial_no" required placeholder="Enter serial number" />
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="type">Type<span class="required-dot">*</span></label>
                        <input type="text" id="type" name="type" required placeholder="Enter spare part type" />
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="manufacturer">Manufacturer<span class="required-dot">*</span></label>
                        <input type="text" id="manufacturer" name="manufacturer" required placeholder="Enter manufacturer" />
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="price">Price<span class="required-dot">*</span></label>
                        <input type="number" id="price" name="price" step="0.01" required placeholder="Enter price" />
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="manufactured-date">Manufactured Date<span class="required-dot">*</span></label>
                        <input type="date" id="manufactured-date" name="manufactured_date" required />
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="waranty-period">Warranty Period<span class="required-dot">*</span></label>
                        <input type="date" id="waranty-period" name="waranty_period" required placeholder="Enter warranty period" />
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button type="reset" class="clear-button">Clear</button>
                <button type="submit" class="add-button">Add Spare Part</button>
            </div>
        </form>
    </div>

<div id="popup-message">Spare part added successfully </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === '1') {
            const popup = document.getElementById('popup-message');
            popup.style.display = 'block';
            setTimeout(() => {
                popup.style.display = 'none';
            }, 4000);
            // Remove success param from URL without reloading
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success');
                window.history.replaceState({}, document.title, url.toString());
            }
        }
    });
</script>
</body>

</html>
