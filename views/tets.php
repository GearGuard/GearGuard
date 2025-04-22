<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GearGuard Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Poppins font and FontAwesome icons -->
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
        }

        body {
            background: var(--background);
            color: var(--text);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chatbox {
            background: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 6px 32px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 1500px;
            margin-top:100px;
            min-height: 580px
        }

        .chatbox-header {
            background: var(--background);
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chatbox-header .fa-comments {
            color: var(--accent);
            font-size: 1.5rem;
        }

        .chatbox-header span {
            font-weight: 600;
            color: var(--primary);
            font-size: 1.15rem;
        }

        .chatbox-messages {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 18px;
            background: var(--secondary);
        }

        .message {
            max-width: 75%;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 1rem;
            word-break: break-word;
            position: relative;
            box-shadow: 0 2px 8px rgba(36, 99, 235, 0.03);
        }

        .message.user {
            margin-left: auto;
            background: var(--accent);
            color: #fff;
            border-bottom-right-radius: 1px;
        }

        .message.agent {
            background: var(--background);
            color: var(--primary);
            border-bottom-left-radius: 2px;
            border: 1px solid var(--border);
        }

        .message-time {
            display: block;
            font-size: 0.75rem;
            color: var(--primary);
            margin-top: 6px;
            text-align: right;
            opacity: 0.7;
        }

        .chatbox-input-area {
            display: flex;
            align-items: center;
            background: var(--background);
            border-top: 1px solid var(--border);
            padding: 18px 16px;
            gap: 10px;
        }

        .chatbox-input-area input {
            flex: 1;
            background: var(--secondary);
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }

        .chatbox-input-area input:focus {
            border-color: var(--accent);
        }

        .chatbox-input-area button {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .chatbox-input-area button:hover {
            background: #1b4ebd;
        }

        @media (max-width: 500px) {
            .chatbox {
                width: 100vw;
                min-height: 100vh;
                border-radius: 0;
            }

            .chatbox-header,
            .chatbox-input-area {
                padding-left: 10px;
                padding-right: 10px;
            }

            .chatbox-messages {
                padding: 12px 8px;
            }
        }
    </style>
</head>

<body>
    <div class="chatbox">
        <div class="chatbox-header">
            <i class="fas fa-comments"></i>
            <span>GearGuard Support</span>
        </div>
        <div class="chatbox-messages" id="chatMessages">
            <div class="message agent">
                Hi! 👋 How can we help you with your vehicle today?
                <span class="message-time">09:30 AM</span>
            </div>
        </div>
        <form class="chatbox-input-area" id="chatForm" autocomplete="off">
            <input type="text" id="chatInput" placeholder="Type your message..." required />
            <button type="submit">
                <span>Send</span>
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
    <script>
        // Simple chat simulation part
        const chatForm = document.getElementById('chatForm');
        const chatInput = document.getElementById('chatInput');
        const chatMessages = document.getElementById('chatMessages');

        function getTime() {
            const now = new Date();
            let h = now.getHours();
            let m = now.getMinutes();
            const ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12 || 12;
            return `${h}:${m.toString().padStart(2, '0')} ${ampm}`;
        }

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const text = chatInput.value.trim();
            if (!text) return;
            // addd user message
            const userMsg = document.createElement('div');
            userMsg.className = 'message user';
            userMsg.innerHTML = `${text}<span class="message-time">${getTime()}</span>`;
            chatMessages.appendChild(userMsg);
            chatInput.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;

            //dummy message (@PasinduRavimal meka epa neda)
            setTimeout(() => {
                const agentMsg = document.createElement('div');
                agentMsg.className = 'message agent';
                agentMsg.innerHTML = `Thank you for your message! We'll get back to you shortly.<span class="message-time">${getTime()}</span>`;
                chatMessages.appendChild(agentMsg);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 1000);
        });
    </script>
</body>

</html>