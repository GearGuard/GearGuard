<?php

/** @var $this \app\core\View */
$this->title = 'Spare Part Warranty';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8fafc;
            font-family: "Inter", sans-serif;
            color: #334155;
            line-height: 1.6;
            padding: 10px;
        }

        .navMenu {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
            color: #64748b;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navMenu a.active {
            color: #2563eb;
            background: #eff6ff;
        }

        .navMenu a:hover {
            color: #2563eb;
            background: #f8fafc;
        }

        .navMenu .dot {
            width: 4px;
            height: 4px;
            background: #2563eb;
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
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .title {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .warranty-card {
            border: 1px solid #e2e8f0;
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
            color: #1e293b;
            font-size: 1.1rem;
        }

        .part-brand {
            color: #64748b;
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
            color: #64748b;
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
            color: #64748b;
            font-weight: 500;
        }

        .detail-value {
            color: #334155;
            font-weight: 500;
        }

        .part-description {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .warranty-info {
            background: #eff6ff;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .price-tag {
            font-weight: 600;
            color: #1e293b;
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
        <a href="#">Book Appointment<span class="dot"></span></a>
        <a href="#">My Appointments<span class="dot"></span></a>
        <a href="#">Service History<span class="dot"></span></a>
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
                    <span class="detail-label">Supplier</span>
                    <span class="detail-value">Supreme Auto Parts</span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Installation Date</span>
                    <span class="detail-value">March 15, 2024</span>
                </div>
            </div>

            <div class="warranty-info">
                <h3 class="section-title">Warranty Details</h3>
                <div class="warranty-details">
                    <div class="detail-group">
                        <span class="detail-label">Coverage Period</span>
                        <span class="detail-value">24 Months</span>
                    </div>
                    <div class="detail-group">
                        <span class="detail-label">Expiry Date</span>
                        <span class="detail-value">March 15, 2026</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="warranty-card">
            <div class="warranty-header">
                <div class="part-info">
                    <span class="part-name">Air Filter System</span>
                    <span class="part-brand">by K&N</span>
                </div>
                <div class="status-container">
                    <span class="time-left-expire">Expired 4 months ago</span>
                    <span class="warranty-status expired">Warranty Expired</span>
                </div>
            </div>

            <h3 class="section-title">Part Information</h3>
            <div class="warranty-details">
                <div class="detail-group">
                    <span class="detail-label">Part Number</span>
                    <span class="detail-value">KN-2023-A456</span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Price</span>
                    <span class="detail-value price-tag">$89.99</span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Manufactured Date</span>
                    <span class="detail-value">June 2023</span>
                </div>
            </div>

            <div class="part-description">
                <h3 class="section-title">Description</h3>
                <p>High-flow washable air filter designed for maximum engine protection and improved performance. Features double-layered synthetic filter media and reinforced rubber seals for superior filtration.</p>
            </div>

            <h3 class="section-title">Installation Details</h3>
            <div class="warranty-details">
                <div class="detail-group">
                    <span class="detail-label">Installed At</span>
                    <span class="detail-value">BrakeMasters - G2</span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Supplier</span>
                    <span class="detail-value">AutoZone</span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Installation Date</span>
                    <span class="detail-value">July 10, 2023</span>
                </div>
            </div>

            <div class="warranty-info">
                <h3 class="section-title">Warranty Details</h3>
                <div class="warranty-details">
                    <div class="detail-group">
                        <span class="detail-label">Coverage Period</span>
                        <span class="detail-value">12 Months</span>
                    </div>
                    <div class="detail-group">
                        <span class="detail-label">Expiry Date</span>
                        <span class="detail-value">July 10, 2024</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>