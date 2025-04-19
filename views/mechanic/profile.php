<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Profile - GearGuard</title>
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
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="profile-wrapper">
        <div class="profile-form">
            <div class="form-title">
                <h1>Mechanic Profile</h1>
                <p>View and edit your mechanic details</p>
            </div>
            <?php $form = \gearguard\phpmvc\form\Form::begin('', 'post', 'mechanicProfileForm') ?>
                <div class="form-grid">
                    <?php
                    echo $form->first_name = $form->field($mechanic, 'first_name')->required();
                    echo $form->last_name = $form->field($mechanic, 'last_name')->required();
                    echo $form->nic = $form->field($mechanic, 'nic')->required();
                    echo $form->contact_no = $form->field($mechanic, 'contact_no')->required();
                    echo $form->email = $form->field($mechanic, 'email')->required();
                    echo $form->date_employeed = $form->field($mechanic, 'date_employeed')->required();
                    echo $form->address = $form->field($mechanic, 'address')->required();
                    echo $form->username = $form->field($mechanic, 'username')->required();
                    ?>

                    <script>
                        document.querySelectorAll('.form-group textarea').forEach(e => e.parentElement.classList.add('full-width'))
                        address = document.getElementById('address');
                        address.classList.add('form-textarea');
                        description = document.getElementById('description');
                        description.classList.add('form-textarea');
                        document.getElementById('contact_no').setAttribute('pattern', '^[0-9\\s\\-\\+\\(\\)]*$')
                    </script>
                        
                    
                    <div class="form-group">
                        <button type="button" id="btnShowChangePassword" class="edit-button" style="background-color: #ef4444;">Change password</button>
                    </div>
                </div>
                <button type="submit" class="edit-button">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="confirmation-modal">
        <div class="modal-content">
            <h2>Confirm Changes</h2>
            <p>Are you sure you want to save the changes to your mechanic profile?</p>
            <div class="modal-buttons">
                <button id="confirmButton" class="modal-btn modal-btn-confirm">Confirm</button>
                <button id="cancelButton" class="modal-btn modal-btn-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
     
    <div id="changePasswordModal" class="confirmation-modal">
        <div class="modal-content">
            <h2>Change Password</h2>
            <div class="form-group">
                <label for="password" class="form-label">Current Password<span class="required-dot">*</span></label>
                <input type="password" id="currentPassword" name="password" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">New Password<span class="required-dot">*</span></label>
                <input type="password" id="newPassword" name="password" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Confirm Password<span class="required-dot">*</span></label>
                <input type="password" id="confirmPassword" name="password" class="form-input" required>
            </div>
            <div class="modal-buttons">
                <button id="btnConfirmPassword" class="modal-btn modal-btn-confirm">Confirm</button>
                <button id="btnCancelPassword" class="modal-btn modal-btn-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('mechanicProfileForm');
            const confirmationModal = document.getElementById('confirmationModal');
            const changePasswordModal = document.getElementById('changePasswordModal');
            const confirmButton = document.getElementById('confirmButton');
            const cancelButton = document.getElementById('cancelButton');
            const btnShowChangePassword = document.getElementById('btnShowChangePassword');
            const btnConfirmPassword = document.getElementById('btnConfirmPassword');
            const btnCancelPassword = document.getElementById('btnCancelPassword');

            btnShowChangePassword.addEventListener('click', function() {
                changePasswordModal.style.display = 'flex';
            });

            btnConfirmPassword.addEventListener('click', function() {
                const currentPassword = document.getElementById('currentPassword');
                const newPassword = document.getElementById('newPassword');
                const confirmPassword = document.getElementById('confirmPassword');

                if (newPassword.value !== confirmPassword.value) {
                    alert('New password and confirmation do not match.');
                    return;
                }

                $.ajax({
                    url: '/mechanic/profile/update',
                    type: 'POST',
                    data: {
                        currentPassword: currentPassword.value,
                        password: newPassword.value,
                        passwordConfirm: confirmPassword.value,
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.success) {
                            alert('Password updated successfully!');
                            changePasswordModal.style.display = 'none';
                            currentPassword.value = '';
                            newPassword.value = '';
                            confirmPassword.value = '';
                        } else {
                            alert('Error updating password: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });

            btnCancelPassword.addEventListener('click', function() {
                changePasswordModal.style.display = 'none';
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                confirmationModal.style.display = 'flex';
            });

            confirmButton.addEventListener('click', function() {
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => data[key] = value);

                $.ajax({
                    url: '/mechanic/profile/update',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.success) {
                            alert('Profile updated successfully!');
                            confirmationModal.style.display = 'none';
                        } else {
                            alert('Error updating profile: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });

            cancelButton.addEventListener('click', function() {
                confirmationModal.style.display = 'none';
            });

            [confirmationModal, changePasswordModal].forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) this.style.display = 'none';
                });
            });
        });
    </script>
</body>

</html>