<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Garage Service - GearGuard</title>
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
        }

        .navMenu a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .service-form {
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

        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-column {
            flex: 1;
        }

        .form-group {
            margin-bottom: 1.5rem;
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
        input[type="number"],
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #33363f;
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        input[type="text"]:hover,
        input[type="number"]:hover,
        textarea:hover {
            border-color: var(--accent);
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        input::placeholder,
        textarea::placeholder {
            color: #c7c7c7;
        }

        .description {
            height: 120px;
            resize: vertical;
            min-height: 120px;
            font-family: "Inter", sans-serif;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .edit-button,
        .search-button {
            background: var(--accent);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .edit-button:hover,
        .search-button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        .clear-button {
            background: var(--secondary);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .clear-button:hover {
            background: var(--hover-bg);
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

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .service-form {
                padding: 1rem;
            }

            .button-container {
                flex-direction: column-reverse;
            }

            .edit-button,
            .clear-button,
            .search-button {
                width: 100%;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<nav class="navMenu">
    <a href="/garage/services/add" target="_self">Add New Service</a>
    <a href="/garage/services/view" target="_self">All Services</a>
    <a href="#" class="active">Edit Services</a>
    <a href="/garage/services/delete" target="_self">Delete Services</a>
</nav>
<div class="service-form">
    <h2 class="title">Edit Garage Service</h2>
    <?php

    use gearguard\phpmvc\form\Form;
    use gearguard\phpmvc\form\TextAreaField;

    $form = Form::begin('', "post");
    ?>

    <div class="form-row">
        <div class="form-column">
            <input type="text" name="search_type" placeholder="Please enter the type of the service"/>
        </div>
        <div class="form-column" style="display: flex; align-items: flex-end;">
            <button type="button" class="search-button" onclick="searchService()">Search</button>
        </div>
    </div>

    <div id="editForm" style="display: none;">
        <input type="hidden" name="id" value="">

        <div class="form-row">
            <div class="form-column">
                <?php echo $form->field($model, 'type') ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-column">
                <?php echo $form->field = new \gearguard\phpmvc\form\NumberField($model, 'price') ?>
            </div>
            <div class="form-column">
                <?php echo $form->field = new \gearguard\phpmvc\form\NumberField($model, 'duration') ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo new TextAreaField($model, 'description'); ?>
        </div>
        <div class="button-container">
            <button type="reset" class="clear-button">Clear</button>
            <button type="submit" class="edit-button">Update Service</button>
        </div>
    </div>

    <?php echo Form::end(); ?>
</div>

<script>
    function searchService() {
        const searchType = document.querySelector('input[name="search_type"]').value;

        if (!searchType) {
            alert('Please enter the type of the service');
            return;
        }

        $.ajax({
            url: '/garage/services/search',
            type: 'GET',
            data: {
                searchQuery: searchType
            },
            success: function (response) {
                    document.getElementById('editForm').style.display = 'block';

                    // Populate form fields with dummy data (replace this with actual data from your backend)
                    document.querySelector('input[name="id"]').value = response.id;
                    document.querySelector('input[name="type"]').value = response.type;
                    document.querySelector('input[name="price"]').value = response.price;
                    document.querySelector('input[name="duration"]').value = response.duration;
                    document.querySelector('textarea[name="description"]').value = response.description;
            },
            error: function (xhr, status, error) {
                console.log('Error:', error);
            }
        });
    }
</script>
</body>

</html>