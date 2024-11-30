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
            <h1 class="dashboard-title">Welcome, John</h1>
            <span class="last-login">Last login: 2 days ago</span>
        </div>

        <div class="dashboard-grid">
            <!-- Next Appointment Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt card-icon"></i>
                    <h2 class="card-title">Next Appointment</h2>
                </div>
                <div class="card-content">
                    <p><span class="highlight">In 5 days</span></p>
                    <p>Date: November 5, 2024</p>
                    <p>Time: 2:00 PM</p>
                    <p>Garage: AutoCare Center</p>
                    <p>Service: Annual Maintenance</p>
                    <p>Vehicle: Toyota Camry</p>
                </div>
            </div>

            <!-- Warranty Expiration Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-shield-alt card-icon"></i>
                    <h2 class="card-title">Closest Warranty Expiration</h2>
                </div>
                <div class="card-content">
                    <p>Part: Brake Pads</p>
                    <p>Expires in: <span class="highlight">30 days</span></p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 75%;"></div>
                    </div>
                </div>
            </div>

            <!-- Latest Service Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-wrench card-icon"></i>
                    <h2 class="card-title">Latest Service</h2>
                </div>
                <div class="card-content">
                    <p>Date: October 15, 2024</p>
                    <p>Service: Oil Change & Tire Rotation</p>
                    <p>Mileage: 45,000 km</p>
                    <p>Garage: QuickFix Auto Shop</p>
                </div>
            </div>

            <!-- Vehicle Health Score Card -->
            <!-- <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-heartbeat card-icon"></i>
                    <h2 class="card-title">Vehicle Health Score</h2>
                </div>
                <div class="card-content">
                    <p>Current Score: <span class="highlight">85/100</span></p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 85%;"></div>
                    </div>
                    <p>Last Updated: 3 days ago</p>
                </div>
            </div> -->

            <!-- Fuel Efficiency Card -->
            <!-- <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-gas-pump card-icon"></i>
                    <h2 class="card-title">Fuel Efficiency</h2>
                </div>
                <div class="card-content">
                    <p>Average: <span class="highlight">7.5 L/100km</span></p>
                    <p>Last Trip: 7.2 L/100km</p>
                    <p>Improvement: <span class="highlight">+4%</span></p>
                </div>
            </div> -->

            <!-- Maintenance Tips Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-lightbulb card-icon"></i>
                    <h2 class="card-title">Maintenance Tip</h2>
                </div>
                <div class="card-content">
                    <p>Regular tire pressure checks can improve fuel efficiency and extend tire life.</p>
                </div>
            </div>

            <!-- Financial Overview Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-chart-line card-icon"></i>
                    <h2 class="card-title">Financial Overview</h2>
                </div>
                <div class="card-content">
                    <p>Total Expenses YTD: <span class="highlight">Rs.86,000</span></p>
                    <p>Budget Remaining: <span class="highlight">Rs.14,000</span></p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 81%;"></div>
                    </div>
                </div>
            </div>

            <!-- Service Expenses Trend Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-money-bill-wave card-icon"></i>
                    <h2 class="card-title">Service Expenses Trend</h2>
                </div>
                <div class="card-content">
                    <p>Last 3 Months: <span class="highlight">Rs.5,750</span></p>
                    <p>Last 6 Months: <span class="highlight">Rs.31,200</span></p>
                    <p>Last 12 Months: <span class="highlight">Rs.92,100</span></p>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-exclamation-circle card-icon"></i>
                    <h2 class="card-title">Pending Payments</h2>
                </div>
                <div class="card-content">
                    <p>Oil Change: <span class="highlight">Rs.4000 due in 5 days</span></p>
                    <p>Tire Rotation: <span class="highlight">Rs.9050 due in 2 weeks</span></p>
                </div>
            </div>

            <!-- Maintenance Cost Tracker Card -->
            <!-- <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-calculator card-icon"></i>
                    <h2 class="card-title">Maintenance Cost Tracker</h2>
                </div>
                <div class="card-content">
                    <p>Estimated Monthly: <span class="highlight">$150</span></p>
                    <p>Estimated Yearly: <span class="highlight">$1,800</span></p>
                    <p>YTD Actual: <span class="highlight">$1,650</span></p>
                </div>
            </div> -->

            <!-- Recommended Services Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-tools card-icon"></i>
                    <h2 class="card-title">Recommended Services</h2>
                </div>
                <div class="card-content">
                    <p>Air Filter Replacement: <span class="highlight">Due in 500 km</span></p>
                    <p>Brake Fluid Change: <span class="highlight">Due in 2 months</span></p>
                    <p>Spark Plugs: <span class="highlight">Due in 5,000 km</span></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>