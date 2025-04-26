<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Mechanic - GearGuard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #c7adad;
            --secondary: #25272d;
            --accent: #2463eb;
            --hover-bg: rgba(36, 99, 235, 0.1);
            --border: #33363f;
            --edit-color: #10B981;
            --delete-color: #EF4444;
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
            padding: 20px;
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
            gap: 15px;
        }

        .navMenu a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .manage-form {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .title {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .search-section {
            margin-bottom: 2rem;
        }

        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-column {
            flex: 1;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .required-dot {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #33363f;
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        input:hover {
            border-color: var(--accent);
        }

        input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        input::placeholder {
            color: #c7c7c7;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .search-button,
        .edit-button,
        .delete-button,
        .clear-button {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .search-button {
            background: var(--accent);
            color: var(--text);
        }

        .edit-button {
            background: var(--edit-color);
            color: var(--text);
        }

        .delete-button {
            background: var(--delete-color);
            color: var(--text);
        }

        .clear-button {
            background: var(--secondary);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .search-button:hover,
        .edit-button:hover,
        .delete-button:hover,
        .clear-button:hover {
            transform: translateY(-1px);
            opacity: 0.9;
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
            background-color: var(--delete-color);
            color: var(--text);
        }

        .popup-button:hover {
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }

            .button-container {
                flex-direction: column;
            }

            .search-button,
            .edit-button,
            .delete-button,
            .clear-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu"><a href="#" class="active">Manage Mechanic</a> <a href="/garage/mechanic/add">Register New Mechanic</a> </nav>
    <div class="manage-form">
        <h2 class="title">Manage Mechanic</h2>
        <div class="search-section">
            <div class="form-group"> <label for="search_mechanic">Search Mechanic</label> <input type="text" id="search_mechanic" name="search_mechanic" placeholder="Enter mechanic name"> </div> <button type="button" class="search-button" onclick="searchMechanic()"> <i class="fas fa-search"></i> Search </button>
        </div>
        <form id="mechanicForm">
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group"> <label for="first_name">First Name<span class="required-dot">*</span></label> <input type="text" id="first_name" name="first_name" required placeholder="Enter first name"> </div>
                </div>
                <div class="form-column">
                    <div class="form-group"> <label for="last_name">Last Name<span class="required-dot">*</span></label> <input type="text" id="last_name" name="last_name" required placeholder="Enter last name"> </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group"> <label for="nic">NIC<span class="required-dot">*</span></label> <input type="text" id="nic" name="nic" required placeholder="Enter NIC"> </div>
                </div>
                <div class="form-column">
                    <div class="form-group"> <label for="contact">Contact Number<span class="required-dot">*</span></label> <input type="text" id="contact" name="contact" required placeholder="Enter contact number"> </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group"> <label for="email">Email<span class="required-dot">*</span></label> <input type="email" id="email" name="email" required placeholder="Enter email"> </div>
                </div>
                <div class="form-column">
                    <div class="form-group"> <label for="date_employed">Date Employed<span class="required-dot">*</span></label> <input type="date" id="date_employed" name="date_employed" required> </div>
                </div>
            </div>
            <div class="form-group"> <label for="address">Address<span class="required-dot">*</span></label> <input type="text" id="address" name="address" required placeholder="Enter address"> </div>
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group"> <label for="username">Username<span class="required-dot">*</span></label> <input type="text" id="username" name="username" required placeholder="Enter username"> </div>
                </div>
                <div class="form-column">
                    <div class="form-group"> <label for="password">Password<span class="required-dot">*</span></label> <input type="password" id="password" name="password" required placeholder="Enter password"> </div>
                </div>
            </div>
            <div class="button-container"> <button type="button" class="clear-button" onclick="clearForm()">Clear</button> <button type="button" class="edit-button" onclick="confirmEdit()">Edit</button> <button type="button" class="delete-button" onclick="confirmDelete()">Delete</button> </div>
        </form>
    </div>
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
        function searchMechanic() {
            const searchName = document.getElementById('search_mechanic').value;
            // Simulated API call - replace with actual API call in production
            if (searchName === 'sandhavi w') {
                document.getElementById('first_name').value = searchName.split(' ')[0];
                document.getElementById('last_name').value = searchName.split(' ')[1] || '';
                document.getElementById('nic').value = '123456789V';
                document.getElementById('contact').value = '0771234567';
                document.getElementById('email').value = searchName.toLowerCase().replace(' ', '.') + '@example.com';
                document.getElementById('date_employed').value = '2023-01-01';
                document.getElementById('address').value = '123 Main St, Colombo';
                document.getElementById('username').value = searchName.toLowerCase().replace(' ', '');
                document.getElementById('password').value = '********';
            }
        }

        function showPopup(title, message, confirmCallback) {
            document.getElementById('popupTitle').textContent = title;
            document.getElementById('popupMessage').textContent = message;
            document.getElementById('popupOverlay').style.display = 'block';

            document.getElementById('popupConfirm').onclick = () => {
                hidePopup();
                confirmCallback();
            };

            document.getElementById('popupCancel').onclick = hidePopup;
        }

        function hidePopup() {
            document.getElementById('popupOverlay').style.display = 'none';
        }

        function confirmEdit() {
            showPopup('Confirm Edit', 'Are you sure you want to edit this record?', () => {
                // Perform edit operation
                showPopup('Success', 'Record updated successfully', () => {});
            });
        }

        function confirmDelete() {
            showPopup('Confirm Delete', 'Are you sure you want to delete this record?', () => {
                // Perform delete operation
                showPopup('Success', 'Record deleted successfully', () => {
                    clearForm();
                });
            });
        }

        function clearForm() {
            document.getElementById('search_mechanic').value = '';
            document.getElementById('mechanicForm').reset();
        }
    </script>
</body>

</html>