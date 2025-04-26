<?php
    /** @var $model \app\models\Mechanic */
    use app\models\Mechanic;
?>
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
        input[type="date"],
        input[type="tel"] {
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
    <nav class="navMenu"><a href="/garage/mechanic/manage">Manage Mechanic</a> <a href="#" class="active">Register New Mechanic</a> </nav>
    <div class="manage-form">
        <h2 class="title">Manage Mechanic</h2>
        <?php $this->form = gearguard\phpmvc\form\Form::begin('', 'post', 'mechanicForm'); ?>
            <div class="form-row">
                <div class="form-column">
                <?php echo $this->fname = $this->form->field($model, 'first_name')->required(true); ?>
                </div>
                <div class="form-column">
                    <?php echo $this->lname = $this->form->field($model, 'last_name')->required(true); ?>
                </div>
            </div>
        <div class="form-row">
            <div class="form-column">
                <?php echo $this->username = $this->form->field($model, 'username')->required(true); ?>
            </div>
        </div>
            <div class="form-row">
                <div class="form-column">
                    <?php echo $this->nic = $this->form->field($model, 'nic')->required(true); ?>
                </div>
                <div class="form-column">
                    <?php echo $this->contact = $this->form->field($model, 'contact_no')->required(true)->type('tel'); ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <?php echo $this->email = $this->form->field($model, 'email')->required(true)->type('email'); ?>
                </div>
                <div class="form-column">
                    <?php $this->demployed = new gearguard\phpmvc\form\DateField($model, "date_employeed");
                    echo $this->demployed->required(true)->max(date('Y-m-d'));
                    ?>
                </div>
            </div>
            <?php $this->address = new gearguard\phpmvc\form\TextAreaField($model, 'address');
                echo $this->address->required(true)->rows(3);
            ?>
            <div class="button-container"> <button type="button" class="clear-button" onclick="clearForm()">Clear</button> <button type="button" class="edit-button" onclick="confirmAdd()">Add</button></div>
        </form>
        <script>
            document.querySelectorAll('.form-group textarea').forEach(e => e.parentElement.classList.add('full-width'))
            address = document.getElementById('address');
            address.classList.add('form-textarea');
            document.getElementById('contact_no').setAttribute('pattern', '^[0-9\\s\\-\\+\\(\\)]*$')
        </script>
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

        function confirmAdd() {
            const form = document.getElementById('mechanicForm');
            if (form.reportValidity()) {
                showPopup('Please wait...', 'We are adding the mechanic to your garage.', true);
                addMechanic();
            }
        }

        async function addMechanic() {
            const form = document.getElementById('mechanicForm');
            const formData = new FormData(form);

            const data = {};

            formData.forEach((value, key) => {
                data[key] = value;
            });

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(data),
                });

                if (!response.ok) {
                    alert('We encountered an error while adding the mechanic. Please try again.');
                    return;
                }

                const result = await response.json();

                if (result.success) {
                    showPopup('Success', 'Mechanic added successfully!');
                    clearForm();
                } else {
                    showPopup('Error', result.message);
                }
            } catch (error) {
                alert('We encountered an error while adding the mechanic. Please try again.');
                console.error('There was a problem with the fetch operation:', error);
            }
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
            document.getElementById('mechanicForm').reset();
        }
    </script>
</body>

</html>