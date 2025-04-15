<?php
$this->title = 'Customer Appointment';
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
            width: fit-content;
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

        .appointment-form {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1200px;
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
        input[type="email"],
        input[type="date"],
        select,
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
        input[type="email"]:hover,
        input[type="date"]:hover,
        select:hover,
        textarea:hover {
            border-color: var(--accent);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        input::placeholder,
        textarea::placeholder {
            color: #c7c7c7;
        }

        .notes {
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

        .book-button {
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

        .book-button:hover {
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

            .appointment-form {
                padding: 1rem;
            }

            .button-container {
                flex-direction: column-reverse;
            }

            .book-button,
            .clear-button {
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="/assets/css/admin-user.css">
</head>

<body>
    <nav class="navMenu">
        <a href="/admin/viewservices" class="active">View Services</a>
        <a href="/admin/addservice">Add New Service</a>
        <a href="/admin/editservice">Edit Service</a>
    </nav>

    <div class="appointment-form">
        <h2 class="title">View Services</h2>
        <div class="view-users-section">
            <h2>View Services</h2>
            <table>
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Vehicle Owner</th>
                        <th>Garage</th>
                        <th>Vehicle</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Oil Change</td>
                        <td>Replacing old oil with new oil to ensure engine efficiency.</td>
                        <td>$50</td>
                        <td>30 minutes</td>
                        <td>Arishana Chandimal</td>
                        <td>Downtown Garage</td>
                        <td>Toyota Camry</td>
                        <td>
                            <div class="action-buttons">
                                <button>Edit</button>
                                <button>Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Tire Rotation</td>
                        <td>Rotating tires to ensure even wear and prolong tire life.</td>
                        <td>$40</td>
                        <td>45 minutes</td>
                        <td>Kavinda Dewmith</td>
                        <td>Main Street Garage</td>
                        <td>Honda Accord</td>
                        <td>
                            <div class="action-buttons">
                                <button>Edit</button>
                                <button>Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>General Checkup</td>
                        <td>Comprehensive inspection of vehicle systems and components.</td>
                        <td>$100</td>
                        <td>1 hour</td>
                        <td>Isuru Naveen</td>
                        <td>City Auto Repair</td>
                        <td>Ford Focus</td>
                        <td>
                            <div class="action-buttons">
                                <button>Edit</button>
                                <button>Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Brake Inspection</td>
                        <td>Checking brake pads, rotors, and fluid levels for safety.</td>
                        <td>$30</td>
                        <td>20 minutes</td>
                        <td>Malith Kariyawasam</td>
                        <td>Quick Fix Garage</td>
                        <td>Chevrolet Malibu</td>
                        <td>
                            <div class="action-buttons">
                                <button>Edit</button>
                                <button>Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>