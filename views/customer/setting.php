<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0;
            --secondary: #25272d;
            --accent: #2463eb;
            --hover-bg: rgba(36, 99, 235, 0.1);
            --border: #33363f;
            --success: #4CAF50;
            --warning: #FF9800;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }

        .settings-grid {
            display: grid;
            gap: 1.5rem;
        }

        .settings-section {
            background-color: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.5rem;
        }

        .settings-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1rem;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-details {
            display: flex;
            flex-direction: column;
        }

        .setting-label {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .setting-description {
            color: var(--primary);
            font-size: 0.85rem;
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--primary);
            transition: .4s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .toggle-switch input:checked+.toggle-slider {
            background-color: var(--accent);
        }

        .toggle-switch input:checked+.toggle-slider:before {
            transform: translateX(26px);
        }

        /* Additional Styles */
        .action-button {
            background-color: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .action-button:hover {
            background-color: color-mix(in srgb, var(--accent) 80%, white);
        }

        .login-activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--background);
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 0.5rem;
        }

        .icon {
            margin-right: 0.75rem;
            color: var(--accent);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="settings-grid">
            <!-- Data & Privacy Section -->
            <div class="settings-section">
                <div class="settings-section-header">
                    <h2><i class="fas fa-shield-alt icon"></i> Data & Privacy</h2>
                </div>

                <div class="setting-item">
                    <div class="setting-details">
                        <div class="setting-label">Download Personal Data</div>
                        <div class="setting-description">Export all your personal information</div>
                    </div>
                    <button class="action-button">Export</button>
                </div>

                <div class="setting-item">
                    <div class="setting-details">
                        <div class="setting-label">Activity Logs Export</div>
                        <div class="setting-description">Download your recent activity history</div>
                    </div>
                    <button class="action-button">Export Logs</button>
                </div>

                <div class="setting-item">
                    <div class="setting-details">
                        <div class="setting-label">Cookie and Tracking Settings</div>
                        <div class="setting-description">Manage your data collection preferences</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <!-- Appearance & Themes Section -->
            <div class="settings-section">
                <div class="settings-section-header">
                    <h2><i class="fas fa-palette icon"></i> Appearance & Themes</h2>
                </div>

                <div class="setting-item">
                    <div class="setting-details">
                        <div class="setting-label">Dark Mode / Light Mode</div>
                        <div class="setting-description">Switch between dark and light themes</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <!-- Notification Preferences Section -->
            <div class="settings-section">
                <div class="settings-section-header">
                    <h2><i class="fas fa-bell icon"></i> Notification Preferences</h2>
                </div>

                <div class="setting-item">
                    <div class="setting-details">
                        <div class="setting-label">Email Notifications</div>
                        <div class="setting-description">Receive updates via email</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-details">
                        <div class="setting-label">SMS Notifications</div>
                        <div class="setting-description">Receive updates via SMS</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-details">
                        <div class="setting-label">Push Notifications</div>
                        <div class="setting-description">Receive real-time mobile notifications</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <!-- Login Activity Section -->
            <div class="settings-section">
                <div class="settings-section-header">
                    <h2><i class="fas fa-history icon"></i> Login Activity</h2>
                </div>

                <div class="login-activity-item">
                    <div>
                        <strong>Desktop - Chrome</strong>
                        <div style="color: var(--primary); font-size: 0.8rem;">
                            November 30, 2024 at 10:45 AM
                        </div>
                    </div>
                    <span style="color: var(--primary);">IP: 192.168.1.100</span>
                </div>

                <div class="login-activity-item">
                    <div>
                        <strong>Mobile - iOS App</strong>
                        <div style="color: var(--primary); font-size: 0.8rem;">
                            November 29, 2024 at 3:20 PM
                        </div>
                    </div>
                    <span style="color: var(--primary);">IP: 10.0.0.55</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>