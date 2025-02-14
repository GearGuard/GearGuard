<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message - GearGuard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .message-form {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .form-title {
            color: var(--primary);
            font-size: 1.8rem;
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

        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: var(--background);
            color: var(--text);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(36, 99, 235, 0.2);
        }

        textarea {
            resize: vertical;
            min-height: 150px;
        }

        .send-button {
            display: block;
            width: 100%;
            padding: 0.75rem 1.5rem;
            background-color: var(--accent);
            color: var(--text);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .send-button:hover {
            background-color: #1b4ebd;
            transform: translateY(-2px);
        }

        .send-button:active {
            transform: translateY(0);
        }

        .success-message {
            display: none;
            background-color: #10B981;
            color: var(--text);
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }


        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .message-form {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="/customers/view" target="_self">All Customers</a>
        <a href="/customers/search" target="_self">Search Customers</a>
        <a href="#" class="active">Send Messages</a>
    </nav>
    <div class="container">
        <form class="message-form" id="messageForm">
            <h1 class="form-title">Send Message to Customer</h1>
            <div class="form-group">
                <label for="customerName">Customer Name</label>
                <input type="text" id="customerName" name="customerName" required placeholder="Enter customer's name">
            </div>
            <div class="form-group">
                <label for="messageTitle">Message Title</label>
                <input type="text" id="messageTitle" name="messageTitle" required placeholder="Enter message title">
            </div>
            <div class="form-group">
                <label for="messageDescription">Message Description</label>
                <textarea id="messageDescription" name="messageDescription" required placeholder="Type your message here..."></textarea>
            </div>
            <button type="submit" class="send-button">
                <i class="fas fa-paper-plane"></i> Send Message
            </button>
        </form>
        <div class="success-message" id="successMessage">
            Message sent successfully!
        </div>
    </div>

    <script>
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Simulated message sending - replace with actual API call in production
            setTimeout(() => {
                document.getElementById('successMessage').style.display = 'block';
                document.getElementById('messageForm').reset();

                // Hide success message after 3 seconds
                setTimeout(() => {
                    document.getElementById('successMessage').style.display = 'none';
                }, 3000);
            }, 1000);
        });
    </script>
</body>

</html>