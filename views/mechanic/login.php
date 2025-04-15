<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #FFFFFFFF;
            --background: #181a20;
            --primary: #FFFFFFFF;
            --secondary: #25272d;
            --accent: #2463eb;
        }

        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        .left-panel {
            flex: 1;
            background-color: var(--secondary);
            color: var(--text);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            text-align: center;
        }

        .left-panel img {
            max-width: 80%;
            height: auto;
            margin-bottom: 2rem;
            border-radius: 12px;
            box-shadow: 0 0px 0px rgba(0, 0, 0, 0.1);
        }

        .left-panel h2 {
            font-size: 1.75rem;
            margin-bottom: 1rem;
            font-weight: 600;
            color: var(--primary);
        }

        .left-panel p {
            max-width: 400px;
            opacity: 0.9;
            line-height: 1.6;
            color: var(--primary);
        }

        .right-panel {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background-color: var(--background);
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            background-color: var(--secondary);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .login-form h1 {
            text-align: center;
            color: var(--primary);
            margin-bottom: 2rem;
            font-size: 1.75rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--primary);
            background-color: var(--background);
            border-radius: 8px;
            font-size: 0.95rem;
            color: var(--text);
            transition: all 0.2s ease-in-out;
        }

        .form-group input:hover {
            border-color: var(--accent);
        }

        .form-group input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.1);
        }

        .login-button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--accent);
            color: var(--text);
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s ease-in-out;
        }

        .login-button:hover {
            background-color: #1b4ebd;
            transform: translateY(-1px);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .additional-links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .additional-links a {
            color: var(--accent);
            text-decoration: none;
            font-size: .875rem;
            transition: color .2s ease-in-out;
        }

        .additional-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                min-height: 50vh;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="left-panel">
            <img src="/assets/img/favicon.png" alt="Our Logo">
            <h2>GearGuard11111111</h2>
            <p>Streamline your vehicle maintenance with our comprehensive service booking platform. Easy scheduling, professional care, and transparent service tracking.</p>
        </div>
        <div class="right-panel">
            <form class="login-form" id="loginForm">
                <h1>Welcome Back</h1>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required placeholder="Enter your Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="login-button">Sign In</button>
                <div class="additional-links">
                    <a href="#">Forgot Password?</a> |
                    <a href="#">Create Account</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (username && password) {
                alert('Login successful! 🚗 (Demo mode)');
            } else {
                alert('Please fill in all fields');
            }
        });
    </script>
</body>

</html>