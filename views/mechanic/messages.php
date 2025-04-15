<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sent Messages</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
        font-family: "Inter", sans-serif;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    
        h2 {
            text-align: center;
            color: #fff;
        }
        .message-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
       .message-card {
    width: 80%;
    background: #25272d;
    padding: 15px;
    border-radius: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
    margin: 0 auto;
}


        .message-card .topic {
            font-weight: bold;
            color: #2463eb;
            padding:5px;
        }
        .message-card .sender,
        .message-card .receiver,
        .message-card .vehicle {
            font-size: 0.9em;
            color: #f5f5f5;
            padding:6px;
        }
        .message-card .message-content {
    color: #f5f5f5;
    margin-top: 10px;
    white-space: pre-wrap; 
    font-style: italic; 
}       
        .message-card .timestamp {
    font-size: 0.8em;
    color: #f5f5f5;
    position: absolute;
    bottom: 10px;
    left: 15px;
}
        .message-card .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            justify-content: flex-end;
        }
        .message-card .action-buttons button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .message-card .action-buttons button:hover {
            background-color: #0056b3;
        }
        .message-card .unread {
            border-left: 5px solid #007bff;
            padding-left: 10px;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="password"]:focus, input[type="number"]:focus, input[type="tel"]:focus {
    border-color: #007bff;
    background-color: #181a20;
    color: #007bff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
    </style>
</head>
<body>

    <h2>Sent Messages</h2>

    <!-- Filters -->
    <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 30px;">
 <input type="text" placeholder="Search by vehicle or sender..." style="padding: 8px; width: 200px; background-color: #fff; color: #000;">
<select style="padding: 8px; background-color: #fff; color: #000;">
    <option value="">Filter by Topic</option>
    <option value="maintenance">Maintenance</option>
    <option value="repair">Repair</option>
    <option value="service">Service</option>
</select>
<input type="date" style="padding: 8px; background-color: #fff; color: #000;">
    </div>

    <!-- Message List -->
    <div class="message-list">
        <!-- Example message card -->
        <div class="message-card unread">
            <div class="topic">Scheduled Maintenance</div>
            <div class="sender">Mechanic John Doe</div>
            <div class="receiver">Vehicle Owner: Jane Smith</div>
            <div class="vehicle">License Plate: ABC123</div>
            <div class="message-content">
                We are scheduled for a maintenance checkup on your vehicle. Please confirm the time.
            </div>
            <div class="timestamp">Sent: 2024-11-30 10:00 AM</div>
            <div class="action-buttons">
                <button>Reply</button>
<button style="background-color: red; color: white;">Delete</button>            </div>
        </div>

        <!-- Repeat similar message cards dynamically with PHP or JavaScript -->
        <div class="message-card">
            <div class="topic">Repair Notification</div>
            <div class="sender">Mechanic Mike Johnson</div>
            <div class="receiver">Vehicle Owner: Mark Adams</div>
            <div class="vehicle">License Plate: XYZ789</div>
            <div class="message-content">
                Your vehicle's repair has been completed. Please pick it up.
            </div>
            <div class="timestamp">Sent: 2024-11-29 03:45 PM</div>
            <div class="action-buttons">
                <button>Reply</button>
<button style="background-color: red; color: white;">Delete</button>            </div>
        </div>
    </div>

</body>
</html>
