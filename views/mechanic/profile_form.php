<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "gearguard";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from gg_garage_user table
$user_id = 1; // Replace with a session variable or dynamic ID
$sql = "SELECT * FROM gg_garage_mechanic WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    <style>
    <style>

    {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow: hidden;
        }

    body {
        font-family:"Inter", sans-serif;
        color:#f5f5f5;
        line-height: 1.6;
        padding: 50px;
        
        
    }

    .form-container {
        background: #64748b;
        width: 90%;
        margin:  auto;
        padding: 20px;
        background-color: #181a20;
        border-radius: 10px;

    }

    
    .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        text-align: center;
    }

    .top h2 {
        font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
        color:#f5f5f5;
    }

    .update {
        background-color: #2463eb;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 8px;

    }

    .update:hover {
        background-color: #1b4ebd;
    }

    label {
        color:#f5f5f5;
        display: block;
        margin-bottom: 10px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    input[type="text"] {
        width: 100%;
        height: 40px;
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #33363f;
        color:#C0C0C0FF;
    }

    input[type="text"]:disabled {
        background-color: #181a20;
        cursor: not-allowed;
    }
</style>
</style>
</style>
</head>
<body>

<form>
    <div class="form-container">
<div class="top">
    <h2>Profile Details</h2>
    <button class="update" type="button" onclick="window.location.href='profile_update.php'">Update</button>
</div>
    <form>

        <div style="display: flex; justify-content: space-between;">
            <div style="width: 45%;">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" disabled>
            </div>
            <div style="width: 45%;">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" disabled>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div style="width: 45%;">
                <label for="nic">NIC</label>
                <input type="text" id="nic" value="<?= htmlspecialchars($user['nic']) ?>" disabled>
            </div>
            <div style="width: 45%;">
                <label for="address">Address</label>
                <input type="text" id="address" value="<?= htmlspecialchars($user['address']) ?>" disabled>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div style="width: 45%;">
                <label for="email">Email</label>
                <input type="text" id="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
            </div>
            <div style="width: 45%;">
                <label for="contact_number">Contact Number</label>
                <input type="text" id="contact_no" value="<?= htmlspecialchars($user['contact_no']) ?>" disabled>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div style="width: 45%;">
                <label for="date_employeed">Date Employed</label>
                <input type="text" id="date_employeed" value="<?= htmlspecialchars($user['date_employeed']) ?>" disabled>
            </div>
            <div style="width: 45%;">
                <label for="garage_id">Garage ID</label>
                <input type="text" id="garage_id" value="<?= htmlspecialchars($user['garage_id']) ?>" disabled>
            </div>
        </div>
    </form>
</div>
       
    
</body>
</html>