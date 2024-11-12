<?php
?>

<?php
use app\core\Application;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Simple Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        section {
            padding: 20px;
        }
        footer {
            background-color: #333;
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
            color: #0f5132; /* Dark green text */
            background-color: #d1e7dd; /* Light green background */
            border-color: #badbcc; /* Green border */
        }


    </style>
</head>
<body>

<header>
    <h1>Welcome to My Homepage</h1>
    <nav>
        <a href="/">Home</a>
        <a href="/contact">Contact</a>
        <a href="/register">Register</a>
        <a href="/login">Login</a>
    </nav>
</header>

<div class = "container">
    <?php if (app\core\Application::$app->session->getFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo app\core\Application::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    {{content}}
</div>

<footer>
    <p>&copy; 2024 My Simple Homepage</p>
</footer>

</body>
</html>
