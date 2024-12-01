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

// Fetch user data from gg_garage_mechanic table
$user_id = 1; // Replace with a session variable or dynamic ID
$sql = "SELECT * FROM gg_garage_mechanic WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

// Initialize success message
$successMessage = "";
$errorMessage = "";

// Handle form submission to update user data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Update query to modify user details
    $stmt = $conn->prepare(
        "UPDATE gg_garage_mechanic SET first_name=?, last_name=?, nic=?, address=?, email=?, contact_no=?, date_employeed=?, garage_id=? WHERE id=?"
    );
    $stmt->bind_param(
        "ssssssssi",
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['nic'],
        $_POST['address'],
        $_POST['email'],
        $_POST['contact_no'],
        $_POST['date_employeed'],
        $_POST['garage_id'],
        $user_id
    );

    if ($stmt->execute()) {
        $successMessage = "Profile updated successfully!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
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

body {
    font-family:"Inter", sans-serif;
    color:#f5f5f5;
    line-height: 1.6;
    padding: 10px;
}

.form-container {
    width: 80%;
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

input[type="text"], input[type="email"], input[type="date"], input[type="password"], input[type="number"], input[type="tel"] {
    width: 100%;
    height: 40px;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #33363f;
    background-color: #181a20;
    color: #C0C0C0FF;
}

input[type="text"]:hover, input[type="email"]:hover, input[type="date"]:hover, input[type="password"]:hover, input[type="number"]:hover, input[type="tel"]:hover {
    border-color: #007bff;
    background-color: #181a20;
    color: #C0C0C0FF;
}

input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="password"]:focus, input[type="number"]:focus, input[type="tel"]:focus {
    border-color: #007bff;
    background-color: #181a20;
    color: #007bff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.save, .back {
    padding: 10px;
    margin:0 5px;
    background-color: #2463eb;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 8px;

}

.save:hover, .back:hover {
    background-color: #0056b3;
}

.footer {
    background-color: #333;
    color: #fff;
    padding: 1em;
    text-align: center;
    clear: both;
}

</style>
</head>
<body>
<div class="form-container">
    <?php if ($successMessage): ?>
        <div class="message success-message" style="color: green; text-align: center;"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="message error-message" style="color: red; text-align: center;"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>
</div>
       <div class="form-container">
    <div class="top">
    <h2>Edit Profile</h2>
    <!-- <div style="display: flex; justify-content: space-between;"> -->

    <!-- </div> -->
</div>
    <form method="POST">
        <div style="display: flex; justify-content: space-between;">
        <div style="width: 45%;">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
            </div>
            <div style="width: 45%;">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between;">
        <div style="width: 45%;">
                <label for="nic">NIC</label>
                <input type="text" id="nic" name="nic" value="<?= htmlspecialchars($user['nic']) ?>" required>
            </div>
            <div style="width: 45%;">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between;">
        <div style="width: 45%;">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div style="width: 45%;">
                <label for="contact_no">Contact Number</label>
                <input type="text" id="contact_no" name="contact_no" value="<?= htmlspecialchars($user['contact_no']) ?>" required>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div style="width: 45%;">
                <label for="date_employeed">Date Employed</label>
                <input type="date" id="date_employeed" name="date_employeed" value="<?= htmlspecialchars($user['date_employeed']) ?>" required>
            </div>
            <div style="width: 45%;">
                <label for="garage_id">Garage ID</label>
                <input type="text" id="garage_id" name="garage_id" value="<?= htmlspecialchars($user['garage_id']) ?>" required>
            </div>
        </div>
        <button class="back" type="button" onclick="location.href='profile_form.php'">Back</button>
        
<!-- <?php if ($successMessage): ?>
    <div class="message success-message" style="color: green; text-align: center;"><?= htmlspecialchars($successMessage) ?></div> -->
    <script>
        setTimeout(function(){
            window.location.href = 'profile_form.php';
        }, 2000);
    </script>
<?php else: ?>
    <form method="POST">
        <!-- form fields -->
        <!-- <button class="back" type="button" onclick="location.href='profile_form.php'">Back</button> -->
        <button class="save" type="submit" >Save</button>
    </form>
<?php endif; ?>    </form>
</div>
    </div>
</body>
</html>