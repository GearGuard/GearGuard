<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | GearGuard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f6fa;
            overflow-x: hidden;
            display: flex;
            font-family: 'Inter', sans-serif;
            /* Ensure font is applied */
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            background: #ffffff;
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
            padding: 20px 0;
            border-bottom: 1px solid #eee;
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
            color: black;
            white-space: nowrap;
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
            color: #424242;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .nav-link.active {
            background-color: rgba(37, 99, 235, 0.1);
            color: black;
            font-weight: 550;
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
            margin-left: 200px;
            padding: 30px;
            flex-grow: 1;
            transition: all 0.3s ease;
            width: 100%;

        }

        .main-content.collapsed {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        .content-wrapper {
            background: #ffffff;
            padding: 100p;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            min-height: calc(100vh - 60px);
            opacity: 1;
            transition: opacity 0.3s ease;

        }

        /* Loading Animation */
        .loading {
            opacity: 0.6;
        }

        /* Error State */
        .error-container {
            text-align: center;
            padding: 40px;
            color: #d32f2f;
        }

        .error-container h2 {
            margin-bottom: 15px;
        }

        /* Responsive Design */
        @media (max-width :768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .content-wrapper {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
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
                <a href="dashboard.php" class="nav-link active" data-page="dashboard">
                    <i class="fas fa-gauge"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="appointments.php" class="nav-link" data-page="appointments">
                    <i class="fas fa-calendar-check"></i>
                    <span class="nav-text">Appointments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="vehicles.php" class="nav-link" data-page="vehicles">
                    <i class="fas fa-car-side"></i>
                    <span class="nav-text">My Vehicles</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="community.php" class="nav-link" data-page="community">
                    <i class="fas fa-comments"></i>
                    <span class="nav-text">Community</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="profile.php" class="nav-link" data-page="profile">
                    <i class="fas fa-user-circle"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="settings.php" class="nav-link" data-page="settings">
                    <i class="fas fa-gear"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
       
    <h1></h1>
    </div>

    <script>
        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        const mainContent = document.getElementById('mainContent');
        const contentWrapper = document.getElementById('contentWrapper');
        const navLinks = document.querySelectorAll('.nav-link');

        // Toggle Sidebar function
        function toggleSidebar() {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                sidebar.classList.toggle('mobile-open');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
            }

            // Update toggle button icon
            const icon = toggleBtn.querySelector('i');
            if (isMobile) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            } else {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-chevron-right');
            }

            // Store sidebar state in localStorage (only for desktop)
            if (!isMobile) {
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            }
        }

        // Load saved sidebar state
        document.addEventListener('DOMContentLoaded', () => {
            const isMobile = window.innerWidth <= 768;

            if (!isMobile) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('collapsed');
                    toggleBtn.querySelector('i').classList.replace('fa-bars', 'fa-chevron-right');
                }
            }

            // Load initial content based on current URL or default to dashboard
            const currentPath = window.location.pathname || 'dashboard.php';
            loadContent(currentPath);

            // Set initial active state
            const currentLink = document.querySelector(`[href="/${currentPath}"]`);
            if (currentLink) {
                currentLink.classList.add('active');
            }
        });

        // Event Listeners
        toggleBtn.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && !sidebar.contains(e.target) && sidebar.classList.contains('mobile-open')) {
                toggleSidebar();
            }
        });

        // Handle Navigation and Content Loading
        function loadContent(url) {
            contentWrapper.classList.add('loading');

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(html => setTimeout(() => {
                    contentWrapper.innerHTML = html;

                    contentWrapper.classList.remove('loading');

                    // Update active state
                    navLinks.forEach(link => link.classList.toggle('active', link.getAttribute('href') === url));

                    // Update page title
                    const activeLink = document.querySelector(`.nav-link[href="${url}"]`);
                    if (activeLink) document.title = `${activeLink.querySelector('.nav-text').textContent} | GearGuard`;

                    // Update URL without page reload
                    history.pushState({}, '', url);
                }, 300))
                .catch(error => {
                    contentWrapper.innerHTML = `
                      <div class='error-container'>
                          <h2>Error Loading Content</h2>
                          <p>Failed to load the page. Please try again later.</p>
                          <p>Error:${error.message}</p>  
                      </div>`;
                    contentWrapper.classList.remove('loading');
                });
        }

        // Handle Navigation Clicks
        navLinks.forEach(link => link.addEventListener('click', (e) => {
            e.preventDefault();
            loadContent(link.getAttribute('href'));

            // Close sidebar on mobile after navigation
            if (window.innerWidth <= 768 && sidebar.classList.contains('mobile-open')) toggleSidebar();
        }));

        // Handle Browser Back/Forward
        window.addEventListener('popstate', () => loadContent(window.location.pathname));

        // Handle Window Resize
        window.addEventListener('resize', () => {
            const isMobile = window.innerWidth <= 768;

            if (!isMobile) {
                sidebar.classList.remove('mobile-open');

                const icon = toggleBtn.querySelector('i');
                if (icon.classList.contains('fa-times')) icon.classList.replace('fa-times', 'fa-bars');
            }
        });
    </script>
</body>

</html>