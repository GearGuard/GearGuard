<?php

/** @var $model \app\models\User */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Registration - GearGuard</title>
    <?php

    use app\models\RegisterModel;
    use gearguard\phpmvc\form\Form;
    ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #FFFFFFFF;
            --background: #181a20;
            --primary: #FFFFFFFF;
            --secondary: #25272d;
            --accent: #2463eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            background-color: var(--background);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .registration-wrapper {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background-color: var(--secondary);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .registration-info {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--secondary);
        }

        .registration-info img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 1.5rem;
            border-radius: 12px;
            align-items: center;
            justify-content: center;

        }

        .registration-info h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .registration-info p {
            color: var(--primary);
            opacity: 0.8;
            line-height: 1.6;
        }

        .registration-form {
            flex: 1.5;
            padding: 3rem;
            background-color: var(--background);
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 2px solid var(--secondary);
        }

        .form-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title h1 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .form-title p {
            color: var(--text);
            opacity: 0.7;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: var(--primary);
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--secondary);
            background-color: transparent;
            border-radius: 8px;
            color: var(--text);
            transition: all 0.3s ease;
            border: 1px solid white;
        }

        .form-group input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.1);
        }

        .full-width {
            grid-column: span 2;
        }

        .register-button {
            width: 100%;
            padding: 0.875rem;
            background-color: var(--accent);
            color: var(--text);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .register-button:hover {
            background-color: #1b4ebd;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: var(--accent);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .registration-wrapper {
                flex-direction: column;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <div class="registration-wrapper">
        <div class="registration-info">
            <img src="/assets/img/favicon.png" alt="GearGuard Logo">
            <h2>Welcome to GearGuard</h2>
            <p>your ultimate companion for hassle-free vehicle maintenance! By creating an account, you gain access to a comprehensive suite of professional services designed to keep your vehicle in top condition. With GearGuard, scheduling maintenance and repair services becomes a breeze, thanks to our intuitive platform that connects you with trusted professionals in your area.</p>
        </div>
        <div class="registration-form">
            <div class="form-title">
                <h1>Create Account</h1>
                <p>Join our platform and take control of your vehicle's health</p>
            </div>
            <?php $form = \gearguard\phpmvc\form\Form::begin('', "post") ?>
            <div class="form-grid">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" required placeholder="John">
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" required placeholder="Doe">
                </div>
                <div class="form-group full-width">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="johndoe@example.com">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required placeholder="+1 (234) 567-8900">
                </div>
                <div class="form-group">
                    <label for="nic">National Identity Card</label>
                    <input type="text" id="nic" name="nic" required placeholder="XXXX-XXXXXXX-X">
                </div>
                <div class="form-group full-width">
                    <label for="address">Full Address</label>
                    <input type="text" id="address" name="address" required placeholder="123 Vehicle Street, Maintenance City">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required placeholder="vehicleowner123">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group full-width">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
            </div>
            <button type="submit" class="register-button">Create Account</button>
            <div class="login-link">
                <a href="#">Already have an account? Sign In</a>
            </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Basic form validation
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }

            // Collect form data
            const formData = {
                firstName: document.getElementById('firstName').value.trim(),
                lastName: document.getElementById('lastName').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                nic: document.getElementById('nic').value.trim(),
                address: document.getElementById('address').value.trim(),
                username: document.getElementById('username').value.trim(),
                password: password
            };

            // Basic validation
            const requiredFields = Object.values(formData);
            if (requiredFields.some(field => field === '')) {
                alert('Please fill in all fields');
                return;
            }

            // Mock registration success
            alert('Registration Successful! 🚗 (Demo mode)');
        });
    </script>
</body>

</html>