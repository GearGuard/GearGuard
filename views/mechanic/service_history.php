<?php
// Include database connection
include('db.php');

// Handle search and fetch records
$license_plate_no = isset($_POST['license_plate_no']) ? $_POST['license_plate_no'] : '';
$records = [];
if (!empty($license_plate_no)) {
    $query = "
        SELECT 
            v.id AS vehicle_id,
            v.vin,
            v.license_plate_no,
            v.year_manufactured,
            v.engine_no,
            v.class_id,
            gs.type AS service_type,
            gs.price AS service_price,
            u.user_id AS owner_user_id,
            u.ownership_status_id,
            u.registration_date
        FROM 
            gearguard.gg_vehicle v
        LEFT JOIN 
            gearguard.gg_user_owner u ON v.id = u.vehicle_id
        LEFT JOIN 
            gearguard.gg_garage_service gs ON gs.garage_id = v.current_user_id
        WHERE 
            v.license_plate_no = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $license_plate_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $records = $result->fetch_all(MYSQLI_ASSOC);
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM gearguard.gg_vehicle WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $delete_id);
    if ($delete_stmt->execute()) {
        echo "<script>alert('Record deleted successfully.');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Failed to delete record.');</script>";
    }
}

// Handle view request
if (isset($_GET['view_id'])) {
    $view_id = intval($_GET['view_id']);
    $view_query = "
        SELECT 
            v.id AS vehicle_id,
            v.vin,
            v.license_plate_no,
            v.year_manufactured,
            v.engine_no,
            v.class_id,
            gs.type AS service_type,
            gs.price AS service_price,
            u.user_id AS owner_user_id,
            u.ownership_status_id,
            u.registration_date
        FROM 
            gearguard.gg_vehicle v
        LEFT JOIN 
            gearguard.gg_user_owner u ON v.id = u.vehicle_id
        LEFT JOIN 
            gearguard.gg_garage_service gs ON gs.garage_id = v.current_user_id
        WHERE 
            v.id = ?
    ";
    $view_stmt = $conn->prepare($view_query);
    $view_stmt->bind_param("i", $view_id);
    $view_stmt->execute();
    $view_result = $view_stmt->get_result();
    $view_record = $view_result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Dashboard</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-color:#fff;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    .container {
            max-width: 800px;
            margin: 0 auto;
            background: #181a20;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color:#f5f5f5;
        }
        
        form {
            margin-bottom: 20px;
        }

        label {
    display: block;
    margin-bottom: 10px;
    color: #25272d;
}
        input[type="text"] {
            width: 70%;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: #333;
            color:#f5f5f5;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="password"]:focus, input[type="number"]:focus, input[type="tel"]:focus {
    border-color: #007bff;
    background-color: #181a20;
    color: #007bff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    color: #fff;
}
        table th, table td {
            padding: 10px;
            text-align: left;
        }
        table td {
            background-color: #25272d;
        }
        table th {
    background-color: #333;
    color:#f5f5f5;
}
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .view-details {
            background-color: #25272d;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            color: #fff;
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

    <div class="container">
        <h2>Vehicle Service History</h2>
    
    <!-- Search Form -->
    <form method="POST" action="">
        <label for="license_plate_no" style="color: #fff;">Enter License Plate Number:</label><br>
        <input type="text" id="license_plate_no" name="license_plate_no" value="<?php echo htmlspecialchars($license_plate_no); ?>" required>
        <button type="submit">Search</button>
    </form>

    <!-- Display Results -->
    <?php if (!empty($license_plate_no)): ?>
        <?php if (count($records) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Vehicle ID</th>
                        <th>VIN</th>
                        <th>Service Type</th>
                        <th>Owner User ID</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?php echo $record['vehicle_id']; ?></td>
                            <td><?php echo $record['vin']; ?></td>
                            <td><?php echo $record['service_type']; ?></td>
                            <td><?php echo $record['owner_user_id']; ?></td>
                            <td><?php echo $record['registration_date']; ?></td>
                            <td class="actions">
                                <a href="?view_id=<?php echo $record['vehicle_id']; ?>">View</a>
<a href="?delete_id=<?php echo $record['vehicle_id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');" style="color: red;">Delete</a>                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
<p style="color: red;">No service history found for the given license plate number.</p>        <?php endif; ?>
    <?php endif; ?>

    <!-- View Details Section -->
    <?php if (isset($view_record)): ?>
        <div class="view-details">
            <h3>Service Details</h3>
            <p><strong>Vehicle ID:</strong> <?php echo $view_record['vehicle_id']; ?></p>
            <p><strong>VIN:</strong> <?php echo $view_record['vin']; ?></p>
            <p><strong>License Plate:</strong> <?php echo $view_record['license_plate_no']; ?></p>
            <p><strong>Year Manufactured:</strong> <?php echo $view_record['year_manufactured']; ?></p>
            <p><strong>Engine No:</strong> <?php echo $view_record['engine_no']; ?></p>
            <p><strong>Class ID:</strong> <?php echo $view_record['class_id']; ?></p>
            <p><strong>Service Type:</strong> <?php echo $view_record['service_type']; ?></p>
            <p><strong>Service Price:</strong> <?php echo $view_record['service_price']; ?></p>
            <p><strong>Owner User ID:</strong> <?php echo $view_record['owner_user_id']; ?></p>
            <p><strong>Ownership Status:</strong> <?php echo $view_record['ownership_status_id']; ?></p>
            <p><strong>Registration Date:</strong> <?php echo $view_record['registration_date']; ?></p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
