
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Friends List - GearGuard</title>
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

        .friends-list-container {
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

        .friends-list-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 28px 12px 28px;
            border-bottom: 1px solid var(--border);
            background: var(--background);
        }

        .friends-list-header h2 {
            font-size: 1.08rem;
            font-weight: 600;
            color: var(--primary);
            letter-spacing: 1px;
            margin: 0;
            text-transform: uppercase;
        }

        .friends-list-header .header-actions {
            display: flex;
            gap: 16px;
        }

        .friends-list-header .header-actions i {
            color: var(--primary);
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .friends-list-header .header-actions i:hover {
            color: var(--accent);
        }

        .friends-list {
            display: flex;
            flex-direction: column;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .friend-item {
            display: flex;
            align-items: center;
            padding: 18px 28px;
            border-bottom: 1px solid var(--border);
            transition: background 0.18s;
            cursor: pointer;
            gap: 14px;
        }

        .friend-item:last-child {
            border-bottom: none;
        }

        .friend-item:hover {
            background: var(--hover-bg);
        }

        .friend-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
            background: var(--background);
            flex-shrink: 0;
        }

        .friend-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .friend-name {
            font-weight: 600;
            color: var(--text);
            font-size: 1.05rem;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .friend-username {
            font-size: 0.92rem;
            color: var(--primary);
            opacity: 0.87;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat {
            text-decoration: none;
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .friend-actions {
            margin-left: 10px;
            color: var(--primary);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 6px;
            border-radius: 50%;
            transition: background 0.18s, color 0.18s;
        }

        .friend-actions:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        @media (max-width: 500px) {
            .friends-list-container {
                width: 100vw;
                border-radius: 0;
                margin: 0;
            }

            .friends-list-header,
            .friend-item {
                padding-left: 12px;
                padding-right: 12px;
            }
        }
    </style>
</head>

<body>
<div class="friends-list-container">
    <div class="friends-list-header">
        <h2>GearGuard</h2>
    </div>
    <ul class="friends-list">
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>

        </li>
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>
        </li>
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>
        </li>
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>
        </li>
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>
        </li>
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>
        </li>
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>
        </li>
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>
        </li>
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>
        </li>
        <li class="friend-item">
            <img class="friend-avatar" src="/assets/img/Gamage.png" alt="Saman Perera">
            <a class="chat" href="/views/friends.php" class="friend-actions">
                <div class="friend-info">
                    <div class="friend-name">Saman Perera</div>
                    <div class="friend-username">@saman.perera</div>
                </div>
            </a>

        </li>
    </ul>
</div>
</body>

</html>