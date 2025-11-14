<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Save Vehicle Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            --box-shadow: 0 6px 24px rgba(36, 99, 235, 0.10), 0 1.5px 6px rgba(0,0,0,0.22);
        }

        body {
            background: var(--background);
            font-family: "Inter", sans-serif;
            color: var(--text);
            line-height: 1.6;
            padding: 32px;
        }

        .admin-panel-title {
            color: var(--primary);
            font-size: 2.4rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2.5rem;
            letter-spacing: 1px;
        }

        .admin-fields-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 2.5rem;
            max-width: 1300px;
            margin: 0 auto;
        }

        .admin-box {
            background: var(--secondary);
            border-radius: 18px;
            box-shadow: var(--box-shadow);
            padding: 2.5rem 2.2rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 260px;
            position: relative;
            transition: transform 0.18s, box-shadow 0.18s;
        }
        .admin-box:hover {
            transform: translateY(-3px) scale(1.015);
            box-shadow: 0 12px 32px rgba(36,99,235,0.14), 0 2px 8px rgba(0,0,0,0.28);
        }

        .box-icon {
            font-size: 2.2rem;
            color: var(--accent);
            margin-bottom: 0.7rem;
        }

        .box-title {
            color: var(--primary);
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 1.3rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-input-row {
            width: 100%;
            display: flex;
            gap: 1.2rem;
            align-items: center;
            margin-top: auto;
        }

        input[type="text"] {
            flex: 1;
            padding: 1.15rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background-color: #33363f;
            color: var(--text);
            font-size: 1.12rem;
            font-weight: 500;
            transition: all 0.22s;
            box-shadow: 0 1.5px 6px rgba(36,99,235,0.03);
        }
        input[type="text"]:hover,
        input[type="text"]:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 4px rgba(36, 99, 235, 0.13);
        }

        .save-btn {
            background: var(--accent);
            color: var(--text);
            padding: 1.08rem 2.1rem;
            border-radius: 10px;
            border: none;
            font-size: 1.08rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(36,99,235,0.09);
            transition: background 0.18s, transform 0.15s;
            letter-spacing: 0.2px;
        }
        .save-btn:hover {
            background: #1b4ebd;
            transform: translateY(-2px) scale(1.03);
        }

        /* Popup styles */
        .popup-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(24,26,32,0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .popup-content {
            background: var(--secondary);
            color: var(--primary);
            border-radius: 12px;
            padding: 2.5rem 3.2rem;
            font-size: 1.25rem;
            font-weight: 600;
            box-shadow: 0 8px 32px rgba(36,99,235,0.18);
            text-align: center;
        }
        .popup-content button {
            margin-top: 2rem;
            background: var(--accent);
            color: var(--text);
            border: none;
            border-radius: 8px;
            padding: 0.85rem 2.2rem;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(36,99,235,0.08);
        }
        .popup-content button:hover {
            background: #1b4ebd;
        }

        @media (max-width: 900px) {
            .admin-fields-grid {
                grid-template-columns: 1fr;
                gap: 1.4rem;
            }
            .admin-box {
                padding: 1.6rem 1rem;
                min-height: 180px;
            }
        }
    </style>
</head>
<body>
    <h2 class="admin-panel-title">Admin Panel: Save Vehicle Data</h2>
    <div class="admin-fields-grid">
        <div class="admin-box">
            <div class="box-title"><span class="box-icon">🚗</span>Vehicle Model</div>
            <div class="admin-input-row">
                <input type="text" id="vehicle_model" placeholder="Enter Vehicle Model">
                <button class="save-btn" onclick="saveField('vehicle_model')">Save</button>
            </div>
        </div>
        <div class="admin-box">
            <div class="box-title"><span class="box-icon">⛽</span>Fuel Type</div>
            <div class="admin-input-row">
                <input type="text" id="fuel_type" placeholder="Enter Fuel Type">
                <button class="save-btn" onclick="saveField('fuel_type')">Save</button>
            </div>
        </div>
        <div class="admin-box">
            <div class="box-title"><span class="box-icon">🚙</span>Vehicle Type</div>
            <div class="admin-input-row">
                <input type="text" id="vehicle_type" placeholder="Enter Vehicle Type">
                <button class="save-btn" onclick="saveField('vehicle_type')">Save</button>
            </div>
        </div>
        <div class="admin-box">
            <div class="box-title"><span class="box-icon">🚘</span>Body Type</div>
            <div class="admin-input-row">
                <input type="text" id="body_type" placeholder="Enter Body Type">
                <button class="save-btn" onclick="saveField('body_type')">Save</button>
            </div>
        </div>
        <div class="admin-box">
            <div class="box-title"><span class="box-icon">🛠️</span>Engine Capacity</div>
            <div class="admin-input-row">
                <input type="text" id="engine_capacity" placeholder="Enter Engine Capacity">
                <button class="save-btn" onclick="saveField('engine_capacity')">Save</button>
            </div>
        </div>
        <div class="admin-box">
            <div class="box-title"><span class="box-icon">🏷️</span>Vehicle Class</div>
            <div class="admin-input-row">
                <input type="text" id="vehicle_class" placeholder="Enter Vehicle Class">
                <button class="save-btn" onclick="saveField('vehicle_class')">Save</button>
            </div>
        </div>
    </div>

    <!-- Popup -->
    <div class="popup-overlay" id="popupOverlay">
        <div class="popup-content">
            <div id="popupMessage">Successfully saved to the database!</div>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>

    <script>
        function saveField(field) {
            const value = document.getElementById(field).value.trim();
            if (!value) {
                showPopup('Please enter a value before saving.');
                return;
            }

            fetch('/admin/save-field', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ field, value })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showPopup('Successfully saved to the database!');
                    document.getElementById(field).value = '';
                } else {
                    showPopup('Failed to save. ' + (data.message || 'Please try again.'));
                }
            })
            .catch(() => {
                showPopup('An error occurred. Please try again.');
            });
        }

        function showPopup(message) {
            document.getElementById('popupMessage').textContent = message;
            document.getElementById('popupOverlay').style.display = 'flex';
        }
        function closePopup() {
            document.getElementById('popupOverlay').style.display = 'none';
        }
    </script>
</body>
</html>
