<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Management System - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #181a20;
            color: #333;
            line-height: 1.6;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Summary Cards Styling */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: #181a20;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #1E90FF;
        }

        .card-value {
            font-size: 2rem;
            font-weight: bold;
            color:#f1f3f5;
        }

        .card-subtext {
            color: #777;
            font-size: 0.9rem;
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-container {
            background-color: #181a20;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Tables */
        .table-section {
            color:white;
            background-color: #181a20;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 20px;
        }

        .table-section h3{
            font-size: 2rem;
            margin-bottom: 20px;

        }

        table {
            width: 100%;
            background-color:transparent;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            color: #f1f3f5;
            border-bottom: 1px solid #f1f3f550;
        }

        table th {
            background-color:#181a20;;
            font-weight: 600;
        }

        /* Activity Feed */
        .activity-feed {
            background-color: #181a20;
            color: #f1f3f5;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .activity-feed h3{
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .activity-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f3f550;
        }

        
        .activity-item:last-child {
            border-bottom: none;
        }

      
        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .charts-section,
            .table-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="card">
                <div class="card-icon">📍</div>
                <div class="card-value">45 Garages</div>
                <div class="card-subtext">Active and Verified</div>
            </div>
            <div class="card">
                <div class="card-icon">🚗</div>
                <div class="card-value">1,250 Vehicles</div>
                <div class="card-subtext">Across all garages</div>
            </div>
            <div class="card">
                <div class="card-icon">👤</div>
                <div class="card-value">3,200 Users</div>
                <div class="card-subtext">Admin, Garage Owners, Customers</div>
            </div>
            
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-container">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="topGaragesChart"></canvas>
            </div>
            
        </div>

        <!-- Tables Section -->
        <div class="table-section">

        <h3>Active Garage</h3>
            
                <table>
                    <thead>
                        <tr>
                            <th>Garage Name</th>
                            <th>Location</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AutoFix Garage</td>
                            <td>Los Angeles</td>
                            <td>2024-11-28</td>
                            <td>Active</td>
                        </tr>
                        <tr>
                            <td>Speedy Repairs</td>
                            <td>New York</td>
                            <td>2024-11-27</td>
                            <td>Active</td>
                        </tr>
                    </tbody>
                </table>
           
            
        </div>

        <!-- Activity Feed -->
        <div class="activity-feed">
            <h3>Recent Activities</h3>
            <div class="activity-item">
                <strong>John Doe</strong> registered a new vehicle: <em>Toyota Corolla</em> (2 hours ago)
            </div>
            <div class="activity-item">
                <strong>Urban Mechanics</strong> garage registration is pending approval (4 hours ago)
            </div>
            <div class="activity-item">
                <strong>Sarah Connor's</strong> vehicle service completed at <em>Speedy Repairs</em> (1 day ago)
            </div>
        </div>

       
    </div>

    <script>
        // Monthly Revenue Chart
        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        new Chart(monthlyRevenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Revenue',
                    data: [10000, 15000, 12000, 18000, 22000, 20000, 25000, 27000, 23000, 30000, 28000, 35000],
                    borderColor: '#1E90FF',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Revenue Trend'
                    }
                }
            }
        });

        // Top Performing Garages Chart
        const topGaragesCtx = document.getElementById('topGaragesChart').getContext('2d');
        new Chart(topGaragesCtx, {
            type: 'bar',
            data: {
                labels: ['AutoFix Garage', 'Speedy Repairs', 'Urban Mechanics', 'City Auto', 'Quick Service'],
                datasets: [{
                    label: 'Services Completed',
                    data: [120, 95, 80, 65, 50],
                    backgroundColor: '#1E90FF'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Top Performing Garages'
                    }
                }
            }
        });

       
    </script>
</body>
</html>