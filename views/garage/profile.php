<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Profile - GearGuard</title>
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
            color: var(--text);
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
                <h1>Garage Profile</h1>
                <p>View and edit your garage details</p>
            </div>
            <?php $form = \gearguard\phpmvc\form\Form::begin('', 'post', 'garageProfileForm') ?>
            <form id="garageProfileForm" novalidate>
                <div class="form-grid">
                    <?php
                    echo $this->garage_name = $form->field($model, 'name')->required();
                    echo $this->brn = $form->field($model, 'registration_no')->required();
                    echo $this->email = $form->field($model, 'email')->required()->type(\gearguard\phpmvc\form\FieldTypes::TYPE_EMAIL);
                    $this->address = new \gearguard\phpmvc\form\TextAreaField($model, 'address');
                    echo $this->address->required()->rows(3)->placeholder('Enter the address');
                    $this->description = new \gearguard\phpmvc\form\TextAreaField($model, 'description');
                    echo $this->description->rows(4);
                    echo $this->tel = $form->field($model, 'contact_no')->required()->type(\gearguard\phpmvc\form\FieldTypes::TYPE_TEL);
                    ?>
                    <script>
                        document.querySelectorAll('.form-group textarea').forEach(e => e.parentElement.classList.add('full-width'))
                        address = document.getElementById('address');
                        address.classList.add('form-textarea');
                        description = document.getElementById('description');
                        description.classList.add('form-textarea');
                    </script>

                    <div class="form-group" style="grid-column: 3/4;">
                        <button class="edit-button" style="background-color: #ef4444;">Change username and password</button>
                    </div>

                </div>
                <button class="edit-button">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="confirmation-modal">
        <div class="modal-content">
            <h2>Confirm Changes</h2>
            <p>Are you sure you want to save the changes to your garage profile?</p>
            <div class="modal-buttons">
                <button id="confirmButton" class="modal-btn modal-btn-confirm">Confirm</button>
                <button id="cancelButton" class="modal-btn modal-btn-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('garageProfileForm');
            const confirmationModal = document.getElementById('confirmationModal');
            const confirmButton = document.getElementById('confirmButton');
            const cancelButton = document.getElementById('cancelButton');

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
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                $.ajax({
                    url: '/garage/profile/update',
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    success: function(response) {
                        if (response.success) {
                            alert('Profile updated successfully!');
                        } else {
                            alert('Error updating profile: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });

                // Close the modal
                confirmationModal.style.display = 'none';

                // Show success message
                alert('Profile updated successfully!');
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
        });
    </script>
</body>

</html>