<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/favicon.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?php echo $this->title ?></title>

    <style>
        /* Root variables for theme */
        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0;
            --secondary: #25272d;
            --accent: #2463eb;
            --hover-bg: rgba(36, 99, 235, 0.1);
            --border: #33363f;
            --popup-btn-color: #EF4444FF;
        }

        /* General styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar styles */
        .navbar {
            background-color: transparent;
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo img {
            margin-top: 10px;
            height: 35px;
            /* Adjust the height of the logo */
        }

        .welcome-message {
            color: var(--text);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .navbar.hidden {
            display: none;
        }

        .welcome-message:hover {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--primary);
            font-weight: 500;
            transition: color 0.3s ease, transform 0.2s ease;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .mobile-menu-btn {
            display: none;
            /* Adjust this for mobile responsiveness */
        }

        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: var(--secondary);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            max-width: 400px;
            width: 90%;
        }

        .popup-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .popup-message {
            margin-bottom: 1.5rem;
        }

        .popup-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .popup-button {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: none;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .popup-button-confirm {
            background-color: var(--accent);
            color: var(--text);
        }

        .popup-button-cancel {
            background-color: var(--popup-btn-color);
            color: var(--text);
        }

        .popup-button:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
<div class="container">
    <?php if (gearguard\phpmvc\Application::$app->session->getFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo gearguard\phpmvc\Application::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    {{content}}

    <div class="popup-overlay" id="popupOverlay">
        <div class="popup" id="popup">
            <h3 class="popup-title" id="popupTitle"></h3>
            <p class="popup-message" id="popupMessage"></p>
            <div class="popup-buttons">
                <button class="popup-button popup-button-cancel" id="popupCancel">Cancel</button>
                <button class="popup-button popup-button-confirm" id="popupConfirm">Confirm</button>
            </div>
        </div>
    </div>

    <script>
        function showPopup(title, message, hideCancel = false) {
            document.getElementById('popupTitle').textContent = title;
            document.getElementById('popupMessage').textContent = message;
            document.getElementById('popupOverlay').style.display = 'block';

            document.getElementById('popupConfirm').style.display = 'none';
            if (hideCancel) {
                document.getElementById('popupCancel').style.display = 'none';
            } else {
                document.getElementById('popupCancel').style.display = 'inline-block';
            }

            document.getElementById('popupCancel').onclick = hidePopup;
        }

        function hidePopup() {
            document.getElementById('popupOverlay').style.display = 'none';
        }
    </script>
</div>
</body>

</html>