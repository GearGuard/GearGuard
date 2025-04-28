<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | GearGuard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --background: #181a20;
            --text: #f5f5f5;
            --primary: #C0C0C0FF;
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
            font-family: 'Inter', sans-serif;
            color: var(--text);
            display: flex;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            background: var(--secondary);
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 70px;
            padding: 20px 10px;
        }

        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .nav-text {
            display: none;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .logo-text {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Toggle Button */
        .toggle-btn {
            position: fixed;
            bottom: 15px;
            left: 15px;
            background: var(--secondary);
            color: var(--text);
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .toggle-btn:hover {
            background: var(--primary);
            color: var(--background);
        }

        /* Navigation Menu */
        .nav-list {
            list-style: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            text-decoration: none;
            color: var(--primary);
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background-color: var(--hover-bg);
            color: var(--accent);
        }

        .nav-link.active {
            background-color: var(--hover-bg);
            color: var(--accent);
        }

        .nav-link i {
            width: 24px;
            margin-right: 10px;
            font-size: 1.2em;
            text-align: center;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .nav-text {
            white-space: nowrap;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            width: calc(100vw - 260px);
            transition: all 0.3s ease;
        }

        .main-content.collapsed {
            margin-left: 70px;
            width: calc(100vw - 70px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.collapsed {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Toggle Button -->
    <button class="toggle-btn" id="toggleBtn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="/assets/img/logo.png" alt="GearGuard Logo" class="logo-img">
                <span class="logo-text">GearGuard</span>
            </div>
        </div>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="customer/dashboard" class="nav-link active">
                    <i class="fas fa-gauge"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/customer/appointment/appoint" class="nav-link">
                    <i class="fas fa-calendar-check"></i>
                    <span class="nav-text">Appointments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/customer/vehicle/register" class="nav-link">
                    <i class="fas fa-car-side"></i>
                    <span class="nav-text">My Vehicles</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/customer/sparepart/add_sparepart" class="nav-link">
                    <i class="fa fa-compass" aria-hidden="true"></i>
                    <span class="nav-text">Spare Part</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/customer/vehicleTransfer/instruction" class="nav-link">
                    <i class="fa fa-exchange" aria-hidden="true"></i>
                    <span class="nav-text">Transfer Vehicle</span>
                </a>
            </li>

            <!-- <li class="nav-item">
                <a href="community" class="nav-link">
                    <i class="fas fa-comments"></i>
                    <span class="nav-text">Community</span>
                </a>
            </li> -->

            <li class="nav-item">
                <a href="/customer/my_profile" class="nav-link">
                    <i class="fas fa-user-circle"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="/customer/settings" class="nav-link">
                    <i class="fas fa-gear"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a href="/notifications" class="nav-link">
                    <span class="wrapper">
                        <i class="fas fa-bell"></i>
                        <span class="nav-text">Notifications</span>
                        <?php if (\gearguard\phpmvc\Application::$app->user->hasNotifications()) : ?>
                            <span id="notification-circle" class="notification-circle" style="position: relative;right: -0.8em;display: inline-block;width: 0.6em;height: 0.6em;border-radius: 50%;background-color: tomato;"></span>
                        <?php endif; ?>
                    </span>
                </a>
            </li>
            <li class='nav-item'>
                <a href='javascript:void(0)' onclick="window.location.href='/logout'" class='nav-link'>
                    <i class='fa fa-sign-out'></i>
                    <span class='nav-text'>Logout</span>
                </a>
            </li>


        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <iframe id="content-iframe" location="relative" style="border: transparent; scroll-behavior: auto; width: inherit; height: 100vh;"></iframe>
    </div>

    <div id="notification-wrapper" style="position: absolute;bottom: 1em;right: 2em;" hidden>
        <div style="width: 25em; height: 10em; background-color: #A3A3A3; border: none; border-radius: 1em; z-index: 999;position: relative;bottom: -11em;filter: blur(10px);right: -0.8em;" id="notification-card-shadow">
        </div>
        <div id="notification-card" style="width: 25em; height: 10em; background-color: #454545; border: none; border-radius: 1em; z-index: 1000;position: relative;display: flex;flex-direction: column;">
            <button style="position: relative;cursor: pointer;top: 0.5em;fill: transparent;background: transparent;border: transparent;color: white;text-align: right;right: 0.5em;">✖</button>
            <h3 id="notification-header" style="margin-top: 0.1em;margin-bottom: 0.1em;font-family: 'Calibri';padding-left: 0.5em;color: white;"></h3>
            <p id="notification-content" style="color: white;font-family: 'arial';padding-left: 1.1em;width: 23em;overflow-wrap: break-word;margin-top: 0.2em;"></p>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const notificationHeader = document.getElementById('notification-header');
        const notificationContent = document.getElementById('notification-content');
        const notificationCardWrapper = document.getElementById('notification-wrapper');
        let data;

        toggleBtn.addEventListener('click', () => {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                sidebar.classList.toggle('mobile-open');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
            }
        });

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', async function(e) {
                e.preventDefault();

                const href = link.getAttribute('href');

                try {
                    document.getElementById("content-iframe").setAttribute("src", href);

                    document.querySelectorAll('.nav-link').forEach(lnk => lnk.classList.remove('active'));

                    link.classList.add('active');

                } catch (error) {
                    console.error('There was a problem with the fetch operation:', error);
                    mainContent.innerHTML = '<p>There was an error loading the content. Please try again later.</p>';
                }
            });
        });

        document.getElementsByClassName('nav-link active')[0].click();

        const socket = new WebSocket('ws://localhost:56780?token=<?php echo \gearguard\phpmvc\Application::$app->user->getToken() ?>');
        socket.onmessage = (e) => {
            console.log(e);
            data = JSON.parse(e.data);
            showNotification(data.title, data.description);
            document.getElementById('notification-circle').style.display = 'inline-block';
        };

        function showNotification(title, message) {
            notificationHeader.innerText = title;
            notificationContent.innerText = message;
            notificationCardWrapper.removeAttribute("hidden");
            setTimeout(() => {
                notificationCardWrapper.setAttribute("hidden", true);
            }, 5000);
        }
    </script>
</body>

</html>