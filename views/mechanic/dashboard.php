<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/favicon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>GearGuard - Vehicle Dashboard</title>
    <style>
        :root {
            --text-primary: #e6e6e6;
            --text-secondary: #a0a0a0;
            --background-dark: #121418;
            --background-card: #1e2329;
            --accent-primary: #2463eb;
            --accent-secondary: #4a7fff;
            --border-color: #2c3036;
            --hover-overlay: rgba(36, 99, 235, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-dark);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .dashboard {
            max-width: 1400px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        s .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-secondary);
            letter-spacing: -1px;
        }

        .last-login {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .dashboard-card {
            background-color: var(--background-card);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 1.5rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            background-color: color-mix(in srgb, var(--background-card) 95%, var(--accent-primary));
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.2rem;
        }

        .card-icon {
            font-size: 1.8rem;
            margin-right: 0.8rem;
            color: var(--accent-primary);
            opacity: 0.8;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-content {
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .highlight {
            color: var(--accent-secondary);
            font-weight: 600;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background-color: color-mix(in srgb, var(--border-color) 50%, transparent);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 1rem;
        }

        .progress {
            height: 100%;
            background: linear-gradient(45deg, var(--accent-primary), var(--accent-secondary));
            transition: width 0.8s cubic-bezier(0.25, 0.1, 0.25, 1);
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .last-login {
                margin-top: 0.5rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Welcome to Mechanic Dashboard</h1>
            <span class="last-login">Last login: 2 days ago</span>
        </div>

        <div class="dashboard-grid">
    <div class="dashboard-grid">
    <!-- Upcoming Services Card -->
    <div class="dashboard-card" style="flex-basis: 32%; margin: 10px;">
        <div class="card-header">
            <i class="fas fa-calendar-alt card-icon"></i>
            <h2 class="card-title">Upcoming Services</h2>
        </div>
        <div class="card-content">
            <p><span class="highlight">Today</span></p>
            <p>Service 1: Oil Change </p>
            <p>Service 2: Tire Rotation </p>
            <p>Service 3: Brake Pad Replacement </p>
            <p>Service 4: Battery Replacement </p>
            <p>Service 5: Air Filter Replacement </p>
            
        </div>
    </div>

    <!-- Service Schedule Card -->
    <div class="dashboard-card" style="flex-basis: 32%; margin: 10px;">
        <div class="card-header">
            <i class="fas fa-clock card-icon"></i>
            <h2 class="card-title">Service Schedule</h2>
        </div>
        <div class="card-content">
            <p>Today:<span class="highlight"> 3 Services</span> </p>
<p>Tomorrow:<span class="highlight"> 4 Services</span> </p>
<p>This Week:<span class="highlight"> 10 Services</span> </p>
        </div>
    </div>

    <!-- Customer Requests Card -->
    <div class="dashboard-card" style="flex-basis: 32%; margin: 10px;">
        <div class="card-header">
            <i class="fas fa-envelope card-icon"></i>
            <h2 class="card-title">Customer Requests</h2>
        </div>
        <div class="card-content">
            <p>Unread Messages: 5</p>
            <p>Unresolved Issues: 2</p>
        </div>
        <div class="progress-bar">
                        <div class="progress" style="width: 75%;"></div>
                    </div>
    </div>

    <!-- Vehicle Inspection Card -->
    <div class="dashboard-card" style="flex-basis: 32%; margin: 10px;">
        <div class="card-header">
            <i class="fas fa-car card-icon"></i>
            <h2 class="card-title">Vehicle Inspection</h2>
        </div>
        <div class="card-content">
<p>Due Today: <span class="highlight">2 vehicles</span></p>
<p>Due This Week: <span class="highlight">5 vehicles</span></p>
        </div>
    </div>

    <div class="dashboard-card" style="flex-basis: 32%; margin: 10px;">
        <div class="card-header">
            <i class="fas fa-boxes card-icon"></i>
            <h2 class="card-title">Parts Inventory</h2>
        </div>
        <div class="card-content">
            <p>Low Stock: 3 items</p>
            <p>Out of Stock: 1 item</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>
        <div class="progress-bar">
                        <div class="progress" style="width: 50%;"></div>
                    </div>
    </div>

    <div class="dashboard-card" style="flex-basis: 32%; margin: 10px;">
        <div class="card-header">
            <i class="fas fa-wrench card-icon"></i>
            <h2 class="card-title">Vehicle Maintenance</h2>
        </div>
        <div class="card-content">
           <p>Due Today: <span class="highlight">2 vehicles</span></p>
            <p>Due This Week: <span class="highlight">5 vehicles</span></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>
    </div>

    <div class="dashboard-card" style="flex-basis: 32%; margin: 10px;">
        <div class="card-header">
            <i class="fas fa-history card-icon"></i>
            <h2 class="card-title">Repair History</h2>
        </div>
        <div class="card-content">
            <p>Total Repairs: <span class="highlight">100</span></p>
            <p>Average Repair Time: <span class="highlight">2 hours</span></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>
    </div>

    <div class="dashboard-card" style="flex-basis: 32%; margin: 10px;">
        <div class="card-header">
            <i class="fas fa-star card-icon"></i>
            <h2 class="card-title">Customer Reviews</h2>
        </div>
        <div class="card-content">
            <p>Average Rating: 4.5/5</p>
            <p>Total Reviews: 50</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <div class="progress-bar">
                        <div class="progress" style="width: 80%;"></div>
                    </div>
        </div>
    </div>
</div>

</div>
    </div>
</body>

</html>