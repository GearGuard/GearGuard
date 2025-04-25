<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Forum</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

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

        .nav-links {
            display: flex;
            gap: 1rem;
        }

        .navMenu a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .main-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .forum-section {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            justify-content: center;
            align-items: center;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
        }

        .post {
            border-bottom: 1px solid var(--border);
            padding: 1.5rem 0;
        }

        .post:last-child {
            border-bottom: none;
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .post-title {
            color: var(--primary);
            font-size: 1.125rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .post-title:hover {
            color: var(--accent);
        }

        .post-meta {
            font-size: 0.875rem;
            color: var(--primary);
        }

        .post-content {
            color: var(--text);
            margin-bottom: 1rem;
            text-align: justify;
        }

        .post-actions {
            display: flex;
            gap: 1rem;
        }

        .action-button {
            background: var(--accent);
            color: var(--text);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-button:hover {
            background: #1b4ebd;
            transform: translateY(-1px);
        }

        .action-button:active {
            transform: translateY(0);
        }

        .answers-container {
            margin-left: 2rem;
            margin-top: 1rem;
            padding-left: 1rem;
            border-left: 2px solid var(--border);
        }

        .answer {
            background: var(--secondary);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .answer-form {
            margin-top: 1rem;
            display: none;
        }

        .answer-input {
            width: 100%;
            min-height: 100px;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-bottom: 1rem;
            font-family: inherit;
            resize: vertical;
        }

        .submit-answer {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .submit-answer:hover {
            background: #1d4ed8;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background: var(--secondary);
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        .modal-form input,
        .modal-form textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
        }

        .modal-form textarea {
            min-height: 150px;
            resize: vertical;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navMenu {
                width: 100%;
                flex-direction: column;
                gap: 1rem;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .answers-container {
                margin-left: 1rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <div class="nav-links">
            <a href="#" class="active">Discussions</a>
            <a href="/community/post" target="_self">New Posts</a>
            <a href="/community/my_posts" target="_self">My Posts</a>
        </div>
    </nav>

    <div class="main-container">
        <div class="forum-section">
            <div class="section-header">
                <h2 class="section-title">Recent Discussions</h2>
            </div>
            <div id="posts-container">
                <!-- Posts will be dynamically added here -->
            </div>
        </div>
    </div>

    <!-- New Post Modal -->
    <div id="newPostModal" class="modal">
        <div class="modal-content">
            <h3 class="modal-title">Start New Discussion</h3>
            <form class="modal-form" id="newPostForm">
                <input type="text" placeholder="Title" required>
                <textarea placeholder="What would you like to discuss?" required></textarea>
                <div class="modal-buttons">
                    <button type="button" class="action-button" onclick="hideNewPostModal()">Cancel</button>
                    <button type="submit" class="submit-answer">Post Discussion</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sample data structure
        let posts = [{
                id: 1,
                title: "What's your favorite programming language and why?",
                content: "I'm curious to hear everyone's preferred programming language and the reasons behind their choice. What makes it stand out for you?",
                author: "TechEnthusiast",
                timestamp: "2 hours ago",
                answers: [{
                    author: "CodeMaster",
                    content: "Python is my go-to language because of its readability and vast ecosystem of libraries.",
                    timestamp: "1 hour ago"
                }]
            },
            {
                id: 2,
                title: "How do you stay motivated during tough coding challenges?",
                content: "Sometimes it can be tough to keep going when solving a difficult problem. What are your strategies for staying focused and motivated?",
                author: "DevLife",
                timestamp: "5 hours ago",
                answers: [{
                    author: "CoderQueen",
                    content: "I usually take short breaks and come back with a fresh perspective.",
                    timestamp: "3 hours ago"
                }]
            }
        ];

        // Function to render posts
        function renderPosts() {
            const postsContainer = document.getElementById('posts-container');
            postsContainer.innerHTML = '';

            posts.forEach(post => {
                const postDiv = document.createElement('div');
                postDiv.classList.add('post');
                postDiv.innerHTML = `
                    <div class="post-header">
                        <a href="#" class="post-title">${post.title}</a>
                        <div class="post-meta">${post.timestamp} by ${post.author}</div>
                    </div>
                    <div class="post-content">${post.content}</div>
                    <div class="post-actions">
                        <button class="action-button" onclick="toggleAnswers(${post.id})">Show Answers</button>
                    </div>
                    <div class="answers-container" id="answers-${post.id}">
                        ${post.answers.map(answer => `
                            <div class="answer">
                                <div class="post-meta">${answer.timestamp} by ${answer.author}</div>
                                <p>${answer.content}</p>
                            </div>`).join('')}
                    </div>
                `;
                postsContainer.appendChild(postDiv);
            });
        }

        // Function to toggle answers visibility
        function toggleAnswers(postId) {
            const answersContainer = document.getElementById(`answers-${postId}`);
            answersContainer.style.display = answersContainer.style.display === 'block' ? 'none' : 'block';
        }

        // Function to show new post modal
        function showNewPostModal() {
            document.getElementById('newPostModal').style.display = 'block';
        }

        // Function to hide new post modal
        function hideNewPostModal() {
            document.getElementById('newPostModal').style.display = 'none';
        }

        // Handle new post submission
        document.getElementById('newPostForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const title = e.target[0].value;
            const content = e.target[1].value;
            posts.push({
                id: posts.length + 1,
                title,
                content,
                author: "NewUser",
                timestamp: "Just now",
                answers: []
            });
            renderPosts();
            hideNewPostModal();
        });

        // Initial render
        renderPosts();
    </script>
</body>

</html>