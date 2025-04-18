<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Mechanic - GearGuard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #FFFFFFFF;
            --background: #181a20;
            --primary: #c7adad;
            --secondary: #25272d;
            --accent: #2463eb;
            --border: #33363f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            background-color: var(--background);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .profile-wrapper {
            width: 100%;
            max-width: 1400px;
            background-color: var(--secondary);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .profile-form {
            padding: 3rem;
            background-color: var(--background);
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-top: 2px solid var(--accent);
        }

        .form-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title h1 {
            font-size: 2.2rem;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .form-title p {
            color: var(--text);
            opacity: 0.7;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 0.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.25rem;
            font-size: 1rem;
            color: var(--primary);
            font-weight: 500;
        }

        .required-dot {
            color: #ef4444;
            margin-left: 4px;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            background-color: #33363f;
            border-radius: 8px;
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
            resize: vertical;
        }

        .form-input:hover,
        .form-textarea:hover {
            border-color: var(--accent);
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        .form-input.is-invalid,
        .form-textarea.is-invalid {
            border-color: #ef4444;
        }

        .form-input[type="password"] {
            letter-spacing: 0.2em;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .edit-button {
            width: 100%;
            padding: 1rem;
            background-color: var(--accent);
            color: var(--text);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
        }

        .edit-button:hover {
            background-color: #1b4ebd;
            transform: translateY(-2px);
        }

        /* Confirmation Modal Styles */
        .confirmation-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: var(--secondary);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal-btn-confirm {
            background-color: var(--accent);
            color: var(--text);
        }

        .modal-btn-confirm:hover {
            background-color: #1b4ebd;
        }

        .modal-btn-cancel {
            background-color: var(--border);
            color: var (--text);
        }

        .modal-btn-cancel:hover {
            background-color: #4a4e57;
        }

        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <div class="profile-wrapper">
        <div class="profile-form">
            <div class="form-title">
                <h1>Mechanic Profile</h1>
                <p>Manage and update mechanic details</p>
            </div>
            <form id="mechanicForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="first_name">First Name<span class="required-dot">*</span></label>
                        <input class="form-input" type="text" id="first_name" name="first_name" required value="<?= htmlspecialchars($mechanic->first_name ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="last_name">Last Name<span class="required-dot">*</span></label>
                        <input class="form-input" type="text" id="last_name" name="last_name" required value="<?= htmlspecialchars($mechanic->last_name ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nic">NIC<span class="required-dot">*</span></label>
                        <input class="form-input" type="text" id="nic" name="nic" required value="<?= htmlspecialchars($mechanic->nic ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="contact">Contact Number<span class="required-dot">*</span></label>
                        <input class="form-input" type="text" id="contact" name="contact" required value="<?= htmlspecialchars($mechanic->contact_no ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email<span class="required-dot">*</span></label>
                        <input class="form-input" type="email" id="email" name="email" required value="<?= htmlspecialchars($mechanic->email ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="date_employed">Date Employed<span class="required-dot">*</span></label>
                        <input class="form-input" type="date" id="date_employed" name="date_employed" required value="<?= htmlspecialchars($mechanic->date_employeed ?? '') ?>">
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label" for="address">Address<span class="required-dot">*</span></label>
                        <input class="form-input" type="text" id="address" name="address" required value="<?= htmlspecialchars($mechanic->address ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="username">Username<span class="required-dot">*</span></label>
                        <input class="form-input" type="text" id="username" name="username" required value="<?= htmlspecialchars($mechanic->username ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password<span class="required-dot">*</span></label>
                        <input class="form-input" type="password" id="password" name="password" required value="********">
                    </div>
                    <div class="form-group">
                        <button type="button" id="btnShowChangePassword" class="edit-button" style="background-color: #ef4444;">Change password</button>
                    </div>

                </div>
                <button type="button" class="edit-button" onclick="confirmEdit()">Save Changes</button>
            </form>
        </div>
    </div>

    <div class="confirmation-modal" id="confirmationModal">
        <div class="modal-content">
            <h3 id="modalTitle"></h3>
            <p id="modalMessage"></p>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-cancel" id="modalCancel">Cancel</button>
                <button class="modal-btn modal-btn-confirm" id="modalConfirm">Confirm</button>
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
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('confirmationModal').style.display = 'flex';

            document.getElementById('modalConfirm').onclick = () => {
                hidePopup();
                confirmCallback();
            };

            document.getElementById('modalCancel').onclick = hidePopup;
        }

        function hidePopup() {
            document.getElementById('confirmationModal').style.display = 'none';
        }

        function confirmEdit() {
            showPopup('Confirm Edit', 'Are you sure you want to edit this record?', () => {
                // Perform edit operation
                showPopup('Success', 'Record updated successfully', () => {});
            });
        }

        function clearForm() {
            document.getElementById('search_mechanic').value = '';
            document.getElementById('mechanicForm').reset();
        }
    </script>
</body>

</html>