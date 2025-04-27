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
            --error-color: #eb4034;
            --success-color: #34eb77;
            --warning-color: #eba834;
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
            color: var(--text-primary);
            letter-spacing: -1px;
        }

        .dashboard-subtitle {
            color: var(--text-secondary);
            font-size: 1.2rem;
            margin-top: 0.5rem;
        }

        .stats-bar {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            background-color: var(--background-card);
            border-radius: 8px;
            padding: 1rem;
            flex: 1;
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent-primary);
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
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
            height: 100%;
            display: flex;
            flex-direction: column;
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
            flex-grow: 1;
        }

        .highlight {
            color: var(--accent-secondary);
            font-weight: 600;
        }

        .warning {
            color: var(--warning-color);
            font-weight: 600;
        }

        .error {
            color: var(--error-color);
            font-weight: 600;
        }

        .success {
            color: var(--success-color);
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

        .card-footer {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
        }

        .btn {
            background-color: var(--accent-primary);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .btn:hover {
            background-color: var(--accent-secondary);
        }

        .btn-sm {
            padding: 0.3rem 0.7rem;
            font-size: 0.8rem;
        }

        .loading-spinner {
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            border-top: 3px solid var(--accent-primary);
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        .card-placeholder {
            color: var(--text-secondary);
            font-style: italic;
            text-align: center;
            padding: 2rem 0;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 992px) {
            .stats-bar {
                flex-wrap: wrap;
            }

            .stat-item {
                min-width: calc(50% - 1rem);
            }
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

            .stats-bar {
                flex-direction: column;
            }

            .stat-item {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Welcome, <span id="username">User</span></h1>
                <div class="card-content" id="maintenanceTipContent">
                    <div class="loading-spinner"></div>
                </div>
            </div>
        </div>

        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value" id="vehicleCount">--</div>
                <div class="stat-label">Vehicles</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="upcomingServices">--</div>
                <div class="stat-label">Upcoming Appointments</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="warrantyItems">--</div>
                <div class="stat-label">Active Warranties</div>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Next Appointment Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt card-icon"></i>
                    <h2 class="card-title">Next Appointment</h2>
                </div>
                <div class="card-content" id="nextAppointmentContent">
                    <div class="loading-spinner"></div>
                </div>

            </div>

            <!-- Warranty Expiration Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-shield-alt card-icon"></i>
                    <h2 class="card-title">Closest Warranty Expiration</h2>
                </div>
                <div class="card-content" id="warrantyContent">
                    <div class="loading-spinner"></div>
                </div>

            </div>

            <!-- Latest Service Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <i class="fas fa-wrench card-icon"></i>
                    <h2 class="card-title">Latest Service</h2>
                </div>
                <div class="card-content" id="latestServiceContent">
                    <div class="loading-spinner"></div>
                </div>

            </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Load user name from API
            fetch('/customer/logedinUser')
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        document.getElementById('username').textContent = data[0].full_name;
                    } else {
                        document.getElementById('username').textContent = 'User';
                    }
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                    document.getElementById('username').textContent = 'User';
                });

            // Load vehicle count from API
            fetch('/customer/vehicleCount')
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        document.getElementById('vehicleCount').textContent = data[0].vehicle_count;
                    } else {
                        document.getElementById('vehicleCount').textContent = '0';
                    }
                })
                .catch(error => {
                    console.error('Error fetching vehicle count:', error);
                    document.getElementById('vehicleCount').textContent = '0';
                });

            // Load upcoming services count from API
            fetch('/customer/upcomingServices')
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        document.getElementById('upcomingServices').textContent = data[0].upcoming_services_count;
                    } else {
                        document.getElementById('upcomingServices').textContent = '0';
                    }
                })
                .catch(error => {
                    console.error('Error fetching upcoming services count:', error);
                    document.getElementById('upcomingServices').textContent = '0';
                });

            // Load warranty items count from API
            fetch('/customer/nonExpire')
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        document.getElementById('warrantyItems').textContent = data[0].valid_spareparts_count;
                    } else {
                        document.getElementById('warrantyItems').textContent = '0';
                    }
                })
                .catch(error => {
                    console.error('Error fetching warranty items count:', error);
                    document.getElementById('warrantyItems').textContent = '0';
                });


            // Load next appointment data
            fetch('/customer/viewappointment')
                .then(response => response.json())
                .then(data => {
                    const appointmentContent = document.getElementById('nextAppointmentContent');
                    if (data && data.length > 0) {
                        const appointment = data[0];
                        const appointmentDate = new Date(appointment.date);
                        const today = new Date();
                        const diffTime = Math.abs(appointmentDate - today);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        appointmentContent.innerHTML = `
                            <p><span class="highlight">In ${diffDays} days</span></p>
                            <p>Date: ${formatDate(appointmentDate)}</p>
                            <p>Time: ${appointment.time}</p>
                            <p>Garage: ${appointment.garage_name}</p>
                            <p>Service: ${appointment.service_type}</p>
                            <p>Vehicle: ${appointment.manufacturer} ${appointment.vehicle_model} (${appointment.license_plate_no})</p>
                        `;

                    } else {
                        appointmentContent.innerHTML = `<p class="card-placeholder">No upcoming appointments scheduled.</p>`;
                    }
                })
                .catch(error => {
                    document.getElementById('nextAppointmentContent').innerHTML = `
                        <p class="error">Could not load appointment data</p>
                        <p>Please try refreshing the page</p>
                    `;
                    console.error('Error fetching appointment data:', error);
                });

            // Load warranty data
            fetch('/customer/viewWarrenty')
                .then(response => response.json())
                .then(data => {
                    const warrantyContent = document.getElementById('warrantyContent');
                    if (data && data.length > 0) {
                        const warranty = data[0];
                        const daysRemaining = parseInt(warranty.days_remaining);
                        const progressPercentage = 100 - (daysRemaining / 365 * 100);

                        let statusClass = 'highlight';
                        if (daysRemaining <= 30) statusClass = 'error';
                        else if (daysRemaining <= 90) statusClass = 'warning';

                        warrantyContent.innerHTML = `
                            <p>Part: ${warranty.part_name}</p>
                            <p>Expires in: <span class="${statusClass}">${daysRemaining} days</span></p>
                            <div class="progress-bar">
                                <div class="progress" style="width: ${progressPercentage}%;"></div>
                            </div>
                        `;

                    } else {
                        warrantyContent.innerHTML = `<p class="card-placeholder">No warranty information available.</p>`;
                    }
                })
                .catch(error => {
                    document.getElementById('warrantyContent').innerHTML = `
                        <p class="error">Could not load warranty data</p>
                        <p>Please try refreshing the page</p>
                    `;
                    console.error('Error fetching warranty data:', error);
                });

            // Load latest service data
            fetch('/customer/viewService')
                .then(response => response.json())
                .then(data => {
                    const latestServiceContent = document.getElementById('latestServiceContent');
                    if (data && data.length > 0) {
                        const service = data[0];
                        const serviceDate = new Date(service.service_date);

                        latestServiceContent.innerHTML = `
                            <p>Date: ${formatDate(serviceDate)}</p>
                            <p>Service: ${service.service_type}</p>
                            <p>Garage: ${service.garage_name}</p>
                            <p>Vehicle: ${service.license_plate_no}</p>
                        `;

                    } else {
                        latestServiceContent.innerHTML = `<p class="card-placeholder">No service history available.</p>`;
                    }
                })
                .catch(error => {
                    document.getElementById('latestServiceContent').innerHTML = `
                        <p class="error">Could not load service data</p>
                        <p>Please try refreshing the page</p>
                    `;
                    console.error('Error fetching service data:', error);
                });

            // Load maintenance tip
            fetch('/customer/tips')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('maintenanceTipContent').innerHTML = `<p>${data}</p>`;
                    document.getElementById('nextTip').style.display = 'block';
                })
                .catch(error => {
                    document.getElementById('maintenanceTipContent').innerHTML = `
                        <p>Regular tire pressure checks can improve fuel efficiency and extend tire life.</p>
                    `;
                    document.getElementById('nextTip').style.display = 'block';
                    console.error('Error fetching maintenance tip:', error);
                });
                

            // Load pending payments (would typically come from a backend API)
            const pendingPayments = [{
                    service: 'Oil Change',
                    amount: 4000,
                    dueIn: '5 days'
                },
                {
                    service: 'Tire Rotation',
                    amount: 9050,
                    dueIn: '2 weeks'
                }
            ];

            const pendingPaymentsList = document.getElementById('pendingPaymentsList');
            if (pendingPayments.length > 0) {
                pendingPayments.forEach(payment => {
                    pendingPaymentsList.innerHTML += `
                        <p>${payment.service}: <span class="highlight">Rs.${payment.amount.toLocaleString()} due in ${payment.dueIn}</span></p>
                    `;
                });
            } else {
                document.getElementById('noPendingPayments').style.display = 'block';
            }

            // Load recommended services (would typically come from a backend API)
            const recommendedServices = [{
                    service: 'Air Filter Replacement',
                    due: '500 km'
                },
                {
                    service: 'Brake Fluid Change',
                    due: '2 months'
                },
                {
                    service: 'Spark Plugs',
                    due: '5,000 km'
                }
            ];

            const recommendedServicesList = document.getElementById('recommendedServicesList');
            if (recommendedServices.length > 0) {
                recommendedServices.forEach(service => {
                    recommendedServicesList.innerHTML += `
                        <p>${service.service}: <span class="highlight">Due in ${service.due}</span></p>
                    `;
                });
            } else {
                document.getElementById('noRecommendedServices').style.display = 'block';
            }


            // Helper function to format dates
            function formatDate(date) {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return date.toLocaleDateString('en-US', options);
            }

            // Function to load a new maintenance tip
            function loadNewMaintenanceTip() {
                document.getElementById('maintenanceTipContent').innerHTML = '<div class="loading-spinner"></div>';
                fetch('/customer-dashboard/get-maintenance-tip')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('maintenanceTipContent').innerHTML = `<p>${data}</p>`;
                    })
                    .catch(error => {
                        document.getElementById('maintenanceTipContent').innerHTML = `
                            <p>Check your brake pads regularly and replace them when they're worn down to 3-4mm thickness.</p>
                        `;
                        console.error('Error fetching maintenance tip:', error);
                    });
            }
        });
    </script>
</body>

</html>