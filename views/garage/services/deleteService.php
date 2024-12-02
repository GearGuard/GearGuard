<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Garage Service - GearGuard</title>
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
            --danger: #ef4444;
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

        input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: #33363f;
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        input[type="text"]:hover {
            border-color: var(--accent);
        }

        input[type="text"]:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .search-button,
        .delete-button {
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

        .search-button:hover,
        .delete-button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        .delete-button {
            background: var(--danger);
        }

        .delete-button:hover {
            background: #dc2626;
        }

        .service-details {
            background: var(--background);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .service-details p {
            margin-bottom: 0.5rem;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: var(--secondary);
            margin: 15% auto;
            padding: 20px;
            border: 1px solid var(--border);
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1rem;
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

            .search-button,
            .delete-button {
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
        <a href="/garage/services/update" target="_self">Edit Services</a>
        <a href="#" class="active">Delete Services</a>
    </nav>
    <div class="service-form">
        <h2 class="title">Delete Garage Service</h2>
        <div class="form-row">
            <div class="form-column">
                <label for="search_type">Search Service Type</label>
                <input type="text" id="search_type" name="search_type">
            </div>
            <div class="form-column" style="display: flex; align-items: flex-end;">
                <button type="button" class="search-button" onclick="searchService()">Search</button>
            </div>
        </div>

        <div id="serviceDetails" class="service-details" style="display: none;">
            <p><strong>Type:</strong> <span id="serviceType"></span></p>
            <p><strong>Description:</strong> <span id="serviceDescription"></span></p>
            <p><strong>Duration:</strong> <span id="serviceDuration"></span> hours</p>
            <p><strong>Price:</strong> $<span id="servicePrice"></span></p>
            <div class="button-container">
                <button type="button" class="delete-button" onclick="showDeleteConfirmation()">Delete Service</button>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to delete this service?</p>
            <br>
            <i>If there are any appointments associated with this service, they will not be deleted.</i>
            <div class="modal-buttons">
                <button type="button" class="search-button" onclick="closeModal()">Cancel</button>
                <button type="button" class="delete-button" onclick="deleteService()">Delete</button>
            </div>
        </div>
    </div>

    <script>
        var serviceId;
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
                    document.getElementById('serviceDetails').style.display = 'block';

                    // Populate form fields with dummy data (replace this with actual data from your backend)
                    serviceId = response.id;
                    document.getElementById('serviceType').textContent = response.type;
                    document.getElementById('serviceDescription').textContent = response.description;
                    document.getElementById('serviceDuration').textContent = response.duration;
                    document.getElementById('servicePrice').textContent = response.price;
                },
                error: function (xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        }

        function showDeleteConfirmation() {
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        function deleteService() {
            $.ajax({
                url: '/garage/services/delete',
                type: 'POST',
                data: {
                    serviceID: serviceId
                },
                success: function (response) {
                    alert('Service deleted successfully. But if there are any appointments associated with this service, they will not be deleted.');
                    closeModal();
                    document.getElementById('serviceDetails').style.display = 'none';
                    document.getElementById('search_type').value = '';
                },
                error: function (xhr, status, error) {
                    alert('We could not delete the service!');
                    closeModal();
                    document.getElementById('serviceDetails').style.display = 'none';
                    document.getElementById('search_type').value = '';
                }
            });
        }
    </script>
</body>

</html>