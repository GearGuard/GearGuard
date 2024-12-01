<?php
$this->title = 'Register New Mechanic';
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
            width: 70%;
            padding: 1rem;
            margin: 0 auto 2rem;
            position: sticky;
            top: 20px;
            z-index: 100;
            gap: 15px;
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

        .register-form {
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
            margin-bottom: 1rem;
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
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #33363f;
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        input:hover {
            border-color: var(--accent);
        }

        input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        input::placeholder {
            color: #c7c7c7;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .register-button {
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

        .register-button:hover {
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
            .form-row {
                flex-direction: column;
            }

            .button-container {
                flex-direction: column-reverse;
            }

            .register-button,
            .clear-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="#" class="active">New Mechanic</a>
        <a href="#">Manage Mechanic</a>
    </nav>

    <div class="register-form">
        <h2 class="title">Register New Mechanic</h2>
        <form action="/register-mechanic" method="POST">
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="first_name">First Name<span class="required-dot">*</span></label>
                        <input type="text" id="first_name" name="first_name" required placeholder="Enter first name">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="last_name">Last Name<span class="required-dot">*</span></label>
                        <input type="text" id="last_name" name="last_name" required placeholder="Enter last name">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="nic">NIC<span class="required-dot">*</span></label>
                        <input type="text" id="nic" name="nic" required placeholder="Enter NIC">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="contact">Contact Number<span class="required-dot">*</span></label>
                        <input type="text" id="contact" name="contact" required placeholder="Enter contact number">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="email">Email<span class="required-dot">*</span></label>
                        <input type="email" id="email" name="email" required placeholder="Enter email">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="date_employed">Date Employed<span class="required-dot">*</span></label>
                        <input type="date" id="date_employed" name="date_employed" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address<span class="required-dot">*</span></label>
                <input type="text" id="address" name="address" required placeholder="Enter address">
            </div>

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="username">Username<span class="required-dot">*</span></label>
                        <input type="text" id="username" name="username" required placeholder="Enter username">
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="password">Password<span class="required-dot">*</span></label>
                        <input type="password" id="password" name="password" required placeholder="Enter password">
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button type="reset" class="clear-button">Clear</button>
                <button type="submit" class="register-button">Register Mechanic</button>
            </div>
        </form>
    </div>
</body>

</html>