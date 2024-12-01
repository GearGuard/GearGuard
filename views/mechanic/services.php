<?php
// Database Configuration
$host = "localhost"; 
$dbname = "gearguard"; 
$username = "root"; 
$password = ""; 

try {
    // Establish database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
$message = "";
$type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceType = trim($_POST['type']);
    $servicePrice = trim($_POST['price']);
    $garageId = trim($_POST['garage_id']);

    // Validate input
    if (empty($serviceType) || empty($servicePrice) || empty($garageId)) {
        $message = "All fields are required.";
        $type = "error";
    } else {
        try {
            // Insert data into gg_garage_service table
            $stmt = $pdo->prepare("INSERT INTO gg_garage_service (type, price, garage_id) VALUES (:type, :price, :garage_id)");
            $stmt->bindParam(':type', $serviceType);
            $stmt->bindParam(':price', $servicePrice);
            $stmt->bindParam(':garage_id', $garageId);

            if ($stmt->execute()) {
                $message = "Service added successfully.";
                $type = "success";
            } else {
                $message = "Failed to add service.";
                $type = "error";
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
            $type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Vehicle Service</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
      body {
        font-family: "Inter", sans-serif;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }
.form-container {
    width: 60%;
    margin: 0 auto;
    padding: 20px;
    background: #25272d;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius:5px;
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
}

        .form-container h2 {
            text-align: center;
            color: #f5f5f5;
             margin: 50px auto;
        }
        
        label {
    font-size: 16px;
    color: #f5f5f5;
    display: inline-block;
    margin: 8px;
    width: 150px 4px;
}
    input[type="text"],
input[type="number"],
select {
    width: 250px;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
    background-color: #25272d;
    color: #f5f5f5;
    display: inline-block;
    vertical-align: middle;

}        
input[type="text"],
input[type="number"],
select,
button {
    transition: all 0.3s ease;
    background-color:#25272d;
    color: #f5f5f5;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
}

input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="password"]:focus, input[type="number"]:focus, input[type="tel"]:focus {
    border-color: #007bff;
    background-color: #181a20;
    color: #007bff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
       button {
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    display: block;
    margin: 20px  auto;
}
        button:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Vehicle Service</h2>
        <?php if (!empty($message)): ?>
            <p class="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="type">Service Type</label>
<input type="text" id="type" name="type" required>
<br>

<label for="price">Service Price</label>
<input type="text" id="price" name="price" step="0.01" required>
<br>

<label for="garage_id">Select Garage</label>
<select id="garage_id" name="garage_id" required>
    <option value="" disabled selected>Select a garage</option>label             <?php
                // Fetch all garages
                try {
                    $stmt = $pdo->query("SELECT id, name FROM gg_garage WHERE status_id = 1"); // Only active garages
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value=\"\" disabled>Error loading garages</option>";
                }
                ?>
            </select>

            <button type="submit">Add Service</button>
        </form>
    </div>
</body>
</html>
