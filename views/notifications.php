<?php
    /** @var $notifications array */
    /** @var $notification Notification */
    use app\models\Notification;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notifications - GearGuard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0;
            --secondary: #25272d;
            --accent: #2463eb;
            --border: #33363f;
            --hover-bg: rgba(36, 99, 235, 0.07);
        }

        body {
            background: var(--background);
            color: var(--text);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .notifications-list-container {
            width: 410px;
            margin: 40px 0;
            background: var(--secondary);
            border-radius: 18px;
            box-shadow: 0 6px 32px rgba(0, 0, 0, 0.18);
            border: 1px solid var(--border);
            overflow: hidden;
            display: flex;
            min-width: 900px;
            flex-direction: column;
        }

        .notifications-list-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 28px 12px 28px;
            border-bottom: 1px solid var(--border);
            background: var(--background);
        }

        .notifications-list-header h2 {
            font-size: 1.08rem;
            font-weight: 600;
            color: var(--primary);
            letter-spacing: 1px;
            margin: 0;
            text-transform: uppercase;
        }

        .notifications-list-header .header-actions {
            display: flex;
            gap: 16px;
        }

        .notifications-list-header .header-actions i {
            color: var(--primary);
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .notifications-list-header .header-actions i:hover {
            color: var(--accent);
        }

        .notifications-list {
            display: flex;
            flex-direction: column;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .notification-item {
            display: flex;
            align-items: center;
            padding: 18px 28px;
            border-bottom: 1px solid var(--border);
            transition: background 0.18s;
            cursor: pointer;
            gap: 14px;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background: var(--hover-bg);
        }

        .notification-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
            background: var(--background);
            flex-shrink: 0;
        }

        .notification-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .notification-name {
            font-weight: 600;
            color: var(--text);
            font-size: 1.05rem;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notification-username {
            font-size: 0.92rem;
            color: var(--primary);
            opacity: 0.87;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notification-wrapper {
            text-decoration: none;
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .notification-actions {
            margin-left: 10px;
            color: var(--primary);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 6px;
            border-radius: 50%;
            transition: background 0.18s, color 0.18s;
        }

        .notification-actions:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .notification-read {
            cursor: default;
            background: var(--background);
        }

        .button {
            width: 20%;
            padding: 1rem;
            background-color: var(--background);
            color: var(--text);
            border: solid 1px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
            z-index: 100;
            position:fixed;
            right: 3.8rem;
            bottom: 2rem;
            font-family: 'Poppins', sans-serif;
        }

        .button:hover {
            background-color: #1b4ebd;
        }

        @media (max-width: 500px) {
            .notifications-list-container {
                width: 100vw;
                border-radius: 0;
                margin: 0;
            }

            .notifications-list-header,
            .notification-item {
                padding-left: 12px;
                padding-right: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="notifications-list-container">
        <div class="notifications-list-header">
            <h2>Notifications</h2>
        </div>
        <ul class="notifications-list">
        <?php foreach ($notifications as $notification): ?>
            <li class="notification-item" id="notification-item-<?php echo $notification->id;?>" notification-id="<?php echo $notification->id;?>" onclick="markAsRead(<?php echo $notification->id;?>)">
                <div class="notification-wrapper">
                    <div class="notification-info">
                        <div class="notification-name"><?php echo $notification->description; ?></div>
                        <div class="notification-username"><?php echo $notification->timestamp; ?></div>
                    </div>
                </div>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
    <form>
        <button type="button" class="button" onClick="markAllAsRead()">Mark All as Read</button>
    </form>

    <script>
        async function markAsRead(id) {
            const response = await fetch(`/notifications/markAsRead?id=${id}`);

            if (!response.ok) {
                console.error('Error marking notification as read:', response.statusText);
                return;
            }

            const result = await response.text();

            if (result && result.trim() === 'success') {
                const notificationItem = document.getElementById(`notification-item-${id}`);
                if (notificationItem) {
                    notificationItem.classList.add('notification-read');
                }
            } else {
                console.error('Failed to mark notification as read:', result);
            }
        }

        async function markAllAsRead() {
            const ids = [];
            document.querySelectorAll('.notification-item[notification-id]').forEach(e => ids.push(Number.parseInt(e.getAttribute('notification-id'))));

            if (ids.length === 0) {
                return;
            }

            const response = await fetch(`/notifications/markAllAsRead`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'ids': JSON.stringify(ids)
                })
            });

            if (!response.ok) {
                console.error('Error marking all notifications as read:', response.statusText);
                return;
            }

            const result = await response.text();

            if (result === 'success') {
                document.querySelectorAll('.notification-item').forEach(e => {
                    e.classList.add('notification-read');
                });
            } else {
                console.error('Failed to mark all notifications as read');
                alert('Failed to mark all notifications as read. Please reload the page.');
            }
        }
    </script>
</body>

</html>