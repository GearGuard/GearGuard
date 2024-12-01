<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/favicon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>GearGuard - Garage Dashboard</title>
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

        .dashboard-title {
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
            <h1 class="dashboard-title">AutoCare Garage Dashboard</h1>
            <span class="last-login">Last updated: Just now</span>
        </div>

        <div class="dashboard-grid">
            <!-- Weekly Services Overview Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-calendar-week card-icon"></i>
                    <h2 class="card-title">Weekly Services Overview</h2>
                </div>
                <div class="card-content">
                    <p>Upcoming Week Services: <span class="highlight">12</span></p>
                    <p>Services Completed Last Week: <span class="highlight">18</span></p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 60%;"></div>
                    </div>
                </div>
            </div>

            <!-- Service Types Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-tools card-icon"></i>
                    <h2 class="card-title">Service Types</h2>
                </div>
                <div class="card-content">
                    <p>Oil Changes: <span class="highlight">8</span></p>
                    <p>Tire Rotations: <span class="highlight">6</span></p>
                    <p>Brake Inspections: <span class="highlight">4</span></p>
                    <p>Major Repairs: <span class="highlight">2</span></p>
                </div>
            </div>

            <!-- Revenue Tracker Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-chart-line card-icon"></i>
                    <h2 class="card-title">Revenue Tracker</h2>
                </div>
                <div class="card-content">
                    <p>This Week Revenue: <span class="highlight">Rs.125,000</span></p>
                    <p>Last Week Revenue: <span class="highlight">Rs.98,500</span></p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 70%;"></div>
                    </div>
                </div>
            </div>

            <!-- Pending Services Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-clock card-icon"></i>
                    <h2 class="card-title">Pending Services</h2>
                </div>
                <div class="card-content">
                    <p>Waiting for Parts: <span class="highlight">3</span></p>
                    <p>Scheduled Diagnostics: <span class="highlight">5</span></p>
                    <p>Urgent Repairs: <span class="highlight">2</span></p>
                </div>
            </div>

            <!-- Service Offers Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-percent card-icon"></i>
                    <h2 class="card-title">Current Service Offers</h2>
                </div>
                <div class="card-content">
                    <p>Winter Tire Changeover: <span class="highlight">20% Off</span></p>
                    <p>Brake System Inspection: <span class="highlight">Rs.500 Flat Rate</span></p>
                    <p>Full Service Package: <span class="highlight">Rs.2,999</span></p>
                </div>
            </div>

            <!-- Customer Feedback Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-star card-icon"></i>
                    <h2 class="card-title">Customer Feedback</h2>
                </div>
                <div class="card-content">
                    <p>Average Rating: <span class="highlight">4.7/5</span></p>
                    <p>Total Reviews: <span class="highlight">42</span></p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 94%;"></div>
                    </div>
                </div>
            </div>

            <!-- Inventory Alert Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-boxes card-icon"></i>
                    <h2 class="card-title">Inventory Alerts</h2>
                </div>
                <div class="card-content">
                    <p>Low Stock Items: <span class="highlight">5</span></p>
                    <p>Critical Parts: <span class="highlight">2</span></p>
                    <p>Reorder Recommended: <span class="highlight">Oil Filters, Brake Pads</span></p>
                </div>
            </div>

            <!-- Team Performance Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-users card-icon"></i>
                    <h2 class="card-title">Team Performance</h2>
                </div>
                <div class="card-content">
                    <p>Mechanic of the Week: <span class="highlight">Alex Rodriguez</span></p>
                    <p>Services Completed: <span class="highlight">7</span></p>
                    <p>Efficiency Rating: <span class="highlight">95%</span></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>