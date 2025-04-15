<?php

use gearguard\phpmvc\Application;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/favicon.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?php echo $this->title ?></title>

    <style>
        /* Root variables for theme */
        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0;
            --secondary: #25272d;
            --accent: #2463eb;
            --hover-bg: rgba(36, 99, 235, 0.1);
            --border: #33363f;
        }

        /* General styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar styles */
        .navbar {
            background-color: transparent;
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo img {
            margin-top: 10px;
            height: 35px;
            /* Adjust the height of the logo */
        }

        .welcome-message {
            color: var(--text);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .welcome-message:hover {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--primary);
            font-weight: 500;
            transition: color 0.3s ease, transform 0.2s ease;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .mobile-menu-btn {
            display: none;
            /* Adjust this for mobile responsiveness */
        }
    </style>
</head>

<body>

    <header>
        <nav>
            <nav class="navbar">
                <div class="container navbar-content">

                    <!-- Logo and Welcome Message -->
                    <div class="logo-container">
                        <div class="logo">
                            <img src="assets/img/favicon.png" alt="GearGuard Logo">
                        </div>
                        <?php if (!Application::isGuest()): ?>
                            <a class="nav-link welcome-message" href="/login">
                                Welcome <?php echo Application::$app->user->getDisplayName() ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Navigation Links -->
                    <div class="nav-links">
                        <a href="#home">Home</a>
                        <a href="#about">About</a>
                        <a href="#services">Services</a>
                        <a href="#feedback">Feedback</a>
                        <a href="#contact">Contact</a>
                        <?php if (Application::isGuest()): ?>
                            <a href="/login">Login</a>
                        <?php else: ?>
                            <a href="/home">Dashboard</a>
                            <a href="/logout">Logout</a>
                        <?php endif; ?>
                    </div>

                    <button class="mobile-menu-btn">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </nav>
        </nav>
    </header>

    <div class="container">
        <?php if (gearguard\phpmvc\Application::$app->session->getFlash('success')): ?>
            <div class="alert alert-success">
                <?php echo gearguard\phpmvc\Application::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
        {{content}}
    </div>

</body>

</html>