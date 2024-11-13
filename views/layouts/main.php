<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fbfbfe;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #fbfbfe;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 50px;
            width: auto;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            margin-left: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #555;
            font-weight: bold;
        }

        .nav-links a:hover {
            color: #333;
        }

        .login-button {
            background-color: #002366;
            color: white;
            border: none;
            padding: 9px 25px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            margin-right: 10px;
        }

        .login-button:hover {
            background-color: #fff;
            color: #002366;
            border: 2px solid #002366;
        }

        .register-button {
            background-color: #fff;
            color: #002366;
            border: 2px solid #002366;
            padding: 9px 25px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            margin-right: 20px;
        }

        .register-button:hover {
            background-color: #002366;
            color: #fff;
        }

        footer {
            background-color: #002366;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .alert {
            position: relative;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }
    </style>
</head>

<body>

    <header>
        <nav>
            <div class="logo">
                <img src="/assets/logo.png" alt="Logo">
                <div class="nav-links">
                    <a href="/">Home</a>
                    <a href="/service">Services</a>
                    <a href="/contact">Contact Us</a>
                </div>
            </div>
            <div>
                <a href="/register" class="register-button">Register</a>
                <a href="/login" class="login-button">Login</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <?php if (app\core\Application::$app->session->getFlash('success')): ?>
            <div class="alert alert-success">
                <?php echo app\core\Application::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
        {{content}}
    </div>

    <footer>
        <p>&copy; 2024 GearGuard</p>
    </footer>

</body>

</html>