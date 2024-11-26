<?php

use gearguard\phpmvc\Application;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/favicon.png">
    <link rel="stylesheet" href="/assets/css/common.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?php echo $this->title ?></title>
</head>

<body>

    <header>
        <nav>
            <?php if (Application::isGuest()): ?>
                <!-- <div class="logo">
                    <img src="/assets/img/favicon.png" alt="Logo">
                    <div class="nav-links">
                        <a href="/">Home</a>
                        <a href="/service">Services</a>
                        <a href="/contact">Contact Us</a>
                    </div>
                </div>
                <div>
                    <a href="/register" class="register-button">Register</a>
                    <a href="/login" class="login-button">Login</a>
                </div> -->
            <?php else: ?>
                <!-- <div class="nav-links">
                   
                </div>
                <div class="user-nav">
                    <a href="/notifications" class="notification-icon" title="Notifications">
                        <i class="fas fa-bell"></i> 
                    </a>
                    <a href="/profile" class="profile-button" title="Profile">
                        <i class="fas fa-user-circle avatar"></i> 
                    </a>
                </div> -->
            <?php endif; ?>
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