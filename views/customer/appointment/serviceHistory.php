<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #c7adad;
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
            font-family: "Inter", sans-serif;
            color: var(--text);
            line-height: 1.6;
            padding: 10px;
        }

        .navMenu {
            background-color: var(--secondary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 67.5%;
            padding: 1rem;
            margin: 0 auto 2rem;
            position: sticky;
            top: 20px;
            z-index: 100;
        }

        .navMenu a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu .dot {
            width: 4px;
            height: 4px;
            background: var(--accent);
            border-radius: 50%;
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .navMenu a:hover .dot,
        .navMenu a.active .dot {
            opacity: 1;
        }

        .service-history {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .title {
            color: var(--text);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .service-card {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
            background-color: var(--background);
        }

        .service-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .service-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }

        .service-type {
            font-weight: 600;
            color: var(--text);
            font-size: 1.1rem;
        }

        .service-date {
            color: var(--primary);
            font-size: 0.9rem;
        }

        .service-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;

        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.875rem;
            color: var(--primary);
            font-weight: 500;
        }

        .detail-value {
            color: var(--text);
            font-weight: 500;
        }

        .service-description {
            background: var(--secondary);
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            text-align: justify;
            color: var(--text);
        }

        .bill-amount {
            text-align: right;
            font-weight: 600;
            color: var(--text);
            font-size: 1.1rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navMenu {
                flex-direction: column;
                gap: 0.5rem;
            }

            .navMenu a {
                width: 100%;
                text-align: center;
            }

            .service-history {
                padding: 1rem;
            }

            .service-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="#">Book Appointment<span class="dot"></span></a>
        <a href="#">My Appointments<span class="dot"></span></a>
        <a href="#" class="active">Service History<span class="dot"></span></a>
        <a href="#">Spare Parts Warranty<span class="dot"></span></a>
    </nav>

    <div class="service-history">
        <h2 class="title">Service History</h2>

        <div class="service-card">
            <div class="service-header">
                <span class="service-type">Complete Engine Service</span>
                <span class="service-date">October 15, 2024</span>
            </div>
            <div class="service-details">
                <div class="detail-item">
                    <span class="detail-label">Garage</span>
                    <span class="detail-value">AutoCare Plus - G1</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Service Period</span>
                    <span class="detail-value">3 Days (Oct 15 - Oct 18)</span>
                </div>
            </div>
            <div class="service-description">
                <p>Full engine maintenance including oil change, filter replacement, timing belt inspection, and general tune-up. All fluids checked and topped up. Engine compression test performed.</p>
            </div>
            <div class="bill-amount">
                Total Bill: $450.00
            </div>
        </div>

        <div class="service-card">
            <div class="service-header">
                <span class="service-type">Brake System Overhaul</span>
                <span class="service-date">September 28, 2024</span>
            </div>
            <div class="service-details">
                <div class="detail-item">
                    <span class="detail-label">Garage</span>
                    <span class="detail-value">BrakeMasters - G2</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Service Period</span>
                    <span class="detail-value">1 Day (Sept 28)</span>
                </div>
            </div>
            <div class="service-description">
                <p>Complete brake system service including replacement of brake pads, rotor resurfacing, brake fluid flush, and calibration of the ABS system. All brake components inspected for wear.</p>
            </div>
            <div class="bill-amount">
                Total Bill: $325.00
            </div>
        </div>

        <div class="service-card">
            <div class="service-header">
                <span class="service-type">Annual Maintenance</span>
                <span class="service-date">August 5, 2024</span>
            </div>
            <div class="service-details">
                <div class="detail-item">
                    <span class="detail-label">Garage</span>
                    <span class="detail-value">AutoCare Plus - G1</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Service Period</span>
                    <span class="detail-value">2 Days (Aug 5 - Aug 6)</span>
                </div>
            </div>
            <div class="service-description">
                <p>Annual maintenance service including multi-point inspection, tire rotation, alignment check, battery test, and A/C system performance check. All filters replaced and fluids topped up.</p>
            </div>
            <div class="bill-amount">
                Total Bill: $275.00
            </div>
        </div>
    </div>
</body>

</html>