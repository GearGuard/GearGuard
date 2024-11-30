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
            padding: 30px;
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
                <a href="dashboard.php" class="nav-link active">
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
                <a href="../community" class="nav-link">
                    <i class="fas fa-comments"></i>
                    <span class="nav-text">Community</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="profile.php" class="nav-link">
                    <i class="fas fa-user-circle"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="settings.php" class="nav-link">
                    <i class="fas fa-gear"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <iframe id="content-iframe" location="relative" style="border: transparent; scroll-behavior: auto; width: inherit; height: 100vh;"></iframe>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

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
    </script>
</body>

</html>