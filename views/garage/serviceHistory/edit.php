<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Spare Part Details - GearGuard</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0FF;
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

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--background);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--primary);
        }

        h1 {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary);
            font-weight: 500;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            background-color: var(--background);
            border-radius: 8px;
            color: var(--text);
            font-family: inherit;
            font-size: 1rem;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--hover-bg);
        }

        button {
            background: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: block;
            width: 100%;
            margin-top: 1rem;
        }

        button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        #sparePartForm {
            display: none;
        }

        .details-group {
            background: var(--background);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--text);
        }

        #deleteRecord {
            background: #eb4034;
            margin-bottom: 1rem;
        }

        #deleteRecord:hover {
            background: #c5352b;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Spare Part Details</h1>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="plateNumber">Vehicle Plate Number:</label>
            <input type="text" id="plateNumber" name="plateNumber" required>
        </div>

        <button onclick="searchRecord()">Search</button>

        <form id="sparePartForm">
            <button type="button" id="deleteRecord" onclick="deleteRecord()">Delete Record</button>

            <div class="details-group">
                <div class="form-group">
                    <label for="serialNumber">Serial Number:</label>
                    <input type="text" id="serialNumber" name="serialNumber">
                </div>
                <div class="form-group">
                    <label for="partType">Type:</label>
                    <input type="text" id="partType" name="partType">
                </div>
                <div class="form-group">
                    <label for="manufacturer">Manufacturer:</label>
                    <input type="text" id="manufacturer" name="manufacturer">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price">
                </div>
                <div class="form-group">
                    <label for="manufacturedDate">Manufactured Date:</label>
                    <input type="date" id="manufacturedDate" name="manufacturedDate">
                </div>
                <div class="form-group">
                    <label for="installedDate">Installed Date:</label>
                    <input type="date" id="installedDate" name="installedDate">
                </div>
                <div class="form-group">
                    <label for="expireDate">Expire Date:</label>
                    <input type="date" id="expireDate" name="expireDate">
                </div>
            </div>

            <button type="submit">Save Record</button>
        </form>
    </div>

    <script>
        function searchRecord() {
            const username = document.getElementById('username').value;
            const plateNumber = document.getElementById('plateNumber').value;

            if (username === 'abc' && plateNumber === '123') {
                // Simulating an API call to fetch spare part details
                setTimeout(() => {
                    // Populate form fields with mock data
                    document.getElementById('serialNumber').value = 'SP12345';
                    document.getElementById('partType').value = 'Brake Pad';
                    document.getElementById('manufacturer').value = 'BrakeCo';
                    document.getElementById('price').value = '89.99';
                    document.getElementById('manufacturedDate').value = '2023-01-15';
                    document.getElementById('installedDate').value = '2023-06-20';
                    document.getElementById('expireDate').value = '2025-06-20';

                    document.getElementById('sparePartForm').style.display = 'block';
                }, 1000);
            } else {
                alert('Please enter both username and plate number.');
            }
        }

        function deleteRecord() {
            if (confirm('Are you sure you want to delete this record?')) {
                // Here you would typically send a delete request to your server
                alert('Record deleted successfully!');
                document.getElementById('sparePartForm').style.display = 'none';
            }
        }

        document.getElementById('sparePartForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would typically send the updated form data to your server
            alert('Record updated successfully!');
        });
    </script>
</body>

</html>