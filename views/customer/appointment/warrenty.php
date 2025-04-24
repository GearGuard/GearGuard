<?php

/** @var $this \gearguard\phpmvc\View */
$this->title = 'Spare Part Warranty';
?>

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
            width: 70%;
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

        .warranty-container {
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

        .warranty-card {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.2s ease;
        }

        .warranty-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .warranty-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .part-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .part-name {
            font-weight: 600;
            color: var(--text);
            font-size: 1.1rem;
        }

        .part-brand {
            color: var(--primary);
            font-size: 0.9rem;
        }

        .warranty-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .time-left-active {
            font-size: 0.875rem;
            font-weight: 500;
            color: #008633FF
        }

        .time-left-expire {
            font-size: 0.875rem;
            font-weight: 500;
            color: #FF3F3FFF;
        }

        .active {
            background: #dcfce7;
            color: #166534;
        }

        .expired {
            background: #fee2e2;
            color: #991b1b;
        }

        .section-title {
            font-size: 0.875rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .warranty-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .detail-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
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

        .part-description {
            background: var(--secondary);
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .warranty-info {
            background: var(--hover-bg);
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .price-tag {
            font-weight: 600;
            color: var(--text);
            font-size: 1.1rem;
        }

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

            .warranty-container {
                padding: 1rem;
            }

            .warranty-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="/customer/appointment/appoint"  target='_self'>Book Appointment<span class="dot"></span></a>
        <a href="/customer/appointment/my_appointment" target='_self'>My Appointments<span class="dot"></span></a>
        <a href="/customer/appointment/service_history" target='_self'>Service History<span class="dot"></span></a>
        <a href="#" class="active">Spare Parts Warranty<span class="dot"></span></a>
    </nav>

    <div class="warranty-container">
        <h2 class="title">Spare Parts Warranty Information</h2>

        <div class="warranty-card">
            <div class="warranty-header">
                <div class="part-info">
                    <span class="part-name">Brake Pad Set</span>
                    <span class="part-brand">by Brembo</span>
                </div>
                <div class="status-container">
                    <span class="time-left-active">16 months left</span>
                    <span class="warranty-status active">Warranty Active</span>
                </div>
            </div>

            <h3 class="section-title">Part Information</h3>
            <div class="warranty-details">
                <div class="detail-group">
                    <span class="detail-label">Part Number</span>
                    <span class="detail-value">BRK-2024-X789</span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Price</span>
                    <span class="detail-value price-tag">$245.00</span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Manufactured Date</span>
                    <span class="detail-value">January 2024</span>
                </div>
            </div>

            <div class="part-description">
                <h3 class="section-title">Description</h3>
                <p>High-performance ceramic brake pad set designed for superior stopping power and reduced brake dust. Features wear indicators and noise reduction shims. Suitable for high-performance vehicles and daily driving.</p>
            </div>

            <h3 class="section-title">Installation Details</h3>
            <div class="warranty-details">
                <div class="detail-group">
                    <span class="detail-label">Installed At</span>
                    <span class="detail-value">AutoCare Plus - G1</span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Installation Date</span>
                    <span class="detail-value">March 15, 2024</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>