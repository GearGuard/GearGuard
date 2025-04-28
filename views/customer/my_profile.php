<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - GearGuard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #FFFFFFFF;
            --background: #181a20;
            --primary: #c7adad;
            --secondary: #25272d;
            --accent: #2463eb;
            --border: #33363f;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
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
            max-width: 1200px;
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

        /* Modal Styles */
        .modal {
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
            color: var(--text);
        }

        .modal-btn-cancel:hover {
            background-color: #4a4e57;
        }

        /* Flash Notification */
        .flash-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 400px;
            min-width: 300px;
            transform: translateX(150%);
            transition: transform 0.3s ease-in-out;
        }

        .flash-notification.visible {
            transform: translateX(0);
        }

        .flash-notification.success {
            background-color: var(--success);
        }

        .flash-notification.error {
            background-color: var(--error);
        }

        .flash-notification.warning {
            background-color: var(--warning);
        }

        .flash-notification .flash-content {
            flex-grow: 1;
        }

        .flash-notification .flash-close {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 18px;
            margin-left: 10px;
            outline: none;
        }

        /* Popup Window */
        .popup-window {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            background-color: var(--secondary);
            border-radius: 12px;
            padding: 2rem;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 1200;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .popup-window.active {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
            visibility: visible;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1100;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .popup-header {
            margin-bottom: 1rem;
        }

        .popup-header h3 {
            font-size: 1.5rem;
            color: var(--text);
        }

        .popup-body {
            margin-bottom: 1.5rem;
            color: var(--text);
            opacity: 0.9;
        }

        .popup-footer {
            display: flex;
            justify-content: flex-end;
        }

        .popup-button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            background-color: var(--accent);
            color: var(--text);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .popup-button:hover {
            background-color: #1b4ebd;
        }

        /* Additional styles for accessibility */
        .form-input:focus,
        .form-textarea:focus {
            outline: 2px solid #1b4ebd;
            /* Improved focus outline for accessibility */
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
    <!-- Flash Notification -->
    <div id="flashNotification" class="flash-notification">
        <div class="flash-content">
            <span id="flashMessage"></span>
        </div>
        <button class="flash-close" onclick="closeFlash()">×</button>
    </div>

    <!-- Popup Window -->
    <div id="popupOverlay" class="popup-overlay"></div>
    <div id="popupWindow" class="popup-window">
        <div class="popup-header">
            <h3 id="popupTitle">Notification</h3>
        </div>
        <div class="popup-body">
            <p id="popupMessage"></p>
        </div>
        <div class="popup-footer">
            <button id="popupClose" class="popup-button">OK</button>
        </div>
    </div>

    <div class="profile-wrapper">
        <div class="profile-form">
            <div class="form-title">
                <h1>User Profile</h1>
                <p>View and edit your personal information</p>
            </div>
            <?php $form = \gearguard\phpmvc\form\Form::begin('/customer/my_profile', 'post', 'userProfileForm') ?>
            <div class="form-grid">
                <?php
                echo $this->first_name = $form->field($model, 'first_name')->required();
                echo $this->last_name = $form->field($model, 'last_name')->required();
                echo $this->nic = $form->field($model, 'nic')->required();
                echo $this->email = $form->field($model, 'email')->required()->type('email');
                $this->address = new \gearguard\phpmvc\form\TextAreaField($model, 'address');
                echo $this->address->required()->rows(3)->placeholder('Enter your address');
                echo $this->tel = $form->field($model, 'contact_no')->required()->type('tel');
                echo $this->username = $form->field($model, 'username')->required();
                ?>
                <script>
                    document.querySelectorAll('.form-group textarea').forEach(e => e.parentElement.classList.add('full-width'))
                    address = document.getElementById('address');
                    address.classList.add('form-textarea');
                    document.getElementById('contact_no').setAttribute('pattern', '^[0-9\\s\\-\\+\\(\\)]*$')
                </script>

                <div class="form-group">
                    <button type="button" id="btnShowChangePassword" class="edit-button" style="background-color: #ef4444;">Change password</button>
                </div>
            </div>
            <button type="submit" class="edit-button">Save Changes</button>
            <?php \gearguard\phpmvc\form\Form::end(); ?>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Changes</h2>
            <p>Are you sure you want to save the changes to your profile?</p>
            <div class="modal-buttons">
                <button type="button" id="confirmButton" class="modal-btn modal-btn-confirm">Confirm</button>
                <button type="button" id="cancelButton" class="modal-btn modal-btn-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <h2>Change Password</h2>
            <div class="form-group">
                <label for="currentPassword" class="form-label">Current Password<span class="required-dot">*</span></label>
                <input type="password" id="currentPassword" name="currentPassword" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="newPassword" class="form-label">New Password<span class="required-dot">*</span></label>
                <input type="password" id="newPassword" name="newPassword" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword" class="form-label">Confirm Password<span class="required-dot">*</span></label>
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-input" required>
            </div>
            <div class="modal-buttons">
                <button type="button" id="btnConfirmPassword" class="modal-btn modal-btn-confirm">Confirm</button>
                <button type="button" id="btnCancelPassword" class="modal-btn modal-btn-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('userProfileForm');
            const confirmationModal = document.getElementById('confirmationModal');
            const changePasswordModal = document.getElementById('changePasswordModal');
            const confirmButton = document.getElementById('confirmButton');
            const cancelButton = document.getElementById('cancelButton');
            const btnShowChangePassword = document.getElementById('btnShowChangePassword');
            const btnConfirmPassword = document.getElementById('btnConfirmPassword');
            const btnCancelPassword = document.getElementById('btnCancelPassword');
            const popupWindow = document.getElementById('popupWindow');
            const popupOverlay = document.getElementById('popupOverlay');
            const popupTitle = document.getElementById('popupTitle');
            const popupMessage = document.getElementById('popupMessage');
            const popupClose = document.getElementById('popupClose');
            const flashNotification = document.getElementById('flashNotification');
            const flashMessage = document.getElementById('flashMessage');

            // Popup window functions
            function showPopup(title, message) {
                popupTitle.textContent = title;
                popupMessage.textContent = message;
                popupOverlay.classList.add('active');
                popupWindow.classList.add('active');
            }

            function closePopup() {
                popupOverlay.classList.remove('active');
                popupWindow.classList.remove('active');
            }

            // Flash notification functions
            function showFlash(message, type = 'success') {
                flashMessage.textContent = message;
                flashNotification.className = 'flash-notification ' + type;
                flashNotification.classList.add('visible');

                // Auto close after 5 seconds
                setTimeout(() => {
                    closeFlash();
                }, 5000);
            }

            function closeFlash() {
                flashNotification.classList.remove('visible');
            }

            // Add click event to popup close button
            popupClose.addEventListener('click', closePopup);
            popupOverlay.addEventListener('click', closePopup);

            // Make closeFlash function available globally
            window.closeFlash = closeFlash;

            btnShowChangePassword.addEventListener('click', function() {
                changePasswordModal.style.display = 'flex';
            });

            btnConfirmPassword.addEventListener('click', async function() {
                const currentPassword = document.getElementById('currentPassword');
                const newPassword = document.getElementById('newPassword');
                const confirmPassword = document.getElementById('confirmPassword');

                if (newPassword.value !== confirmPassword.value) {
                    showPopup('Wait!', 'New password and confirmation do not match.');
                    return;
                }

                try {
                    const result = await fetch('/customer/my_profile', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            currentPassword: currentPassword.value,
                            password: newPassword.value,
                            passwordConfirm: confirmPassword.value,
                            _action: 'changePassword'
                        })
                    });

                    if (!result.ok) {
                        showPopup('Sorry', 'Could not change your password. Please try again later.');
                        return;
                    }

                    const response = await result.json();

                    if (!response) {
                        showPopup('Sorry', 'Could not change your password. Please try again later.');
                        return;
                    }

                    if (response.success) {
                        showFlash('Password changed successfully!', 'success');
                        changePasswordModal.style.display = 'none';
                        currentPassword.value = '';
                        newPassword.value = '';
                        confirmPassword.value = '';
                    } else {
                        showPopup('Error', 'Error changing password: ' + response.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showPopup('Error', 'An error occurred while changing the password. Please try again later.');
                }
            });

            btnCancelPassword.addEventListener('click', function() {
                changePasswordModal.style.display = 'none';
            });

            // Prevent default form submission and show modal
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form before showing modal
                if (this.checkValidity()) {
                    confirmationModal.style.display = 'flex';
                } else {
                    this.classList.add('was-validated');
                    this.reportValidity();
                }
            });

            // Confirm button clicks
            confirmButton.addEventListener('click', async function(event) {
                event.stopPropagation();
                // Collect form data
                showPopup('Hold on!', 'Saving changes...');

                const formData = new FormData(form);
                const data = {};

                formData.forEach((value, key) => {
                    data[key] = value;
                });

                // Add action identifier
                data['_action'] = 'updateProfile';

                try {
                    const result = await fetch('/customer/my_profile', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    });

                    if (!result.ok) {
                        showPopup('Sorry', 'Could not update your profile. Please try again later.');
                        return;
                    }

                    const response = await result.json();

                    if (!response) {
                        showPopup('Sorry', 'Could not update your profile. Please try again later.');
                        return;
                    }

                    closePopup();

                    if (response.success) {
                        showFlash('Profile updated successfully!', 'success');
                    } else {
                        showFlash('Error updating profile: ' + response.message, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    closePopup();
                    showFlash('An error occurred while updating the profile', 'error');
                }

                // Close the modal
                confirmationModal.style.display = 'none';
            });

            // Cancel button closes the modal
            cancelButton.addEventListener('click', function() {
                confirmationModal.style.display = 'none';
            });

            // Close modal if clicking outside of it
            confirmationModal.addEventListener('click', function(e) {
                if (e.target === confirmationModal) {
                    confirmationModal.style.display = 'none';
                }
            });

            changePasswordModal.addEventListener('click', function(e) {
                if (e.target === changePasswordModal) {
                    changePasswordModal.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>