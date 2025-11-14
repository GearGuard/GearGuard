<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New mechanic Service - GearGuard</title>
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

        .service-form {
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
        textarea {
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
        textarea:hover {
            border-color: var(--accent);
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        input::placeholder,
        textarea::placeholder {
            color: #c7c7c7;
        }

        .description {
            height: 120px;
            resize: vertical;
            min-height: 120px;
            font-family: "Inter", sans-serif;
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

        .popup-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--accent);
            color: var(--text);
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 1rem;
            }

            .popup-message span {
            font-size: 0.95rem;
            font-weight: 500;
            }

            .close-popup {
            background: none;
            border: none;
            color: var(--text);
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.2s ease;
            }

            .close-popup:hover {
            color: #f5f5f5;
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

            .service-form {
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
            <a href="#" class="active">Assign New Service</a>
            <a href="/mechanic/services/viewService" target="_self">All Services</a>
            <a href="/mechanic/services/editService" target="_self">Edit Services</a>
            <a href="/mechanic/services/deleteService" target="_self">Delete Services</a>
    </nav>
    <div class="service-form">
        <h2 class="title">Assign New Mechanic Service</h2>
        <?php

        use gearguard\phpmvc\form\Form;

        $form = Form::begin('/mechanic/services/addService', "post");
        ?>
        <div class="form-row">
            <div class="form-column">
            <label for="service_id">Service ID: <span class="required-dot">*</span></label>
            <input type="number" id="service_id" name="service_id" required>
            </div>
            <div class="form-column">
            <label for="mechanic_id">Mechanic ID: <span class="required-dot">*</span></label>
            <input type="number" id="mechanic_id" name="mechanic_id" required>
            </div>
        </div>
        <button type="reset" class="clear-button">Clear</button>
        <button type="submit" class="add-button">Assign</button>

        <?php echo Form::end(); ?>

        <?php if (!empty($message)): ?>
            <div class="popup-message">
            <span><?php echo htmlspecialchars($message); ?></span>
            <button class="close-popup" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>