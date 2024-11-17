<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Forum</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8fafc;
            font-family: "Inter", sans-serif;
            color: #334155;
            line-height: 1.6;
            padding: 20px;
        }

        .navMenu {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            padding: 1rem;
            margin: 0 auto 2rem;
            position: sticky;
            top: 20px;
            z-index: 100;
            width: 65%;
            justify-content: center;
        }

        .nav-links {
            display: flex;
            gap: 1rem;

        }

        .navMenu a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navMenu a.active {
            color: #2563eb;
            background: #eff6ff;
        }

        .new-post-button {
            background: #2563eb;
            color: white !important;
            padding: 0.75rem 1.5rem;

        }

        .new-post-button:hover {
            background: #1d4ed8;
        }

        .main-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .forum-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
            justify-content: center;
            align-items: center;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;

        }

        .post {
            border-bottom: 1px solid #e2e8f0;
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
            color: #031947FF;
            font-size: 1.125rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .post-title:hover {
            color: #002685FF;
        }

        .post-meta {
            font-size: 0.875rem;
            color: #64748b;
        }

        .post-content {
            color: #475569;
            margin-bottom: 1rem;
            text-align: justify;
        }

        .post-actions {
            display: flex;
            gap: 1rem;
        }

        .action-button {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-button:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .answers-container {
            margin-left: 2rem;
            margin-top: 1rem;
            padding-left: 1rem;
            border-left: 2px solid #e2e8f0;
        }

        .answer {
            background: #f8fafc;
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
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-family: inherit;
            resize: vertical;
        }

        .submit-answer {
            background: #2563eb;
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
            background: white;
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
        }

        .modal-form input,
        .modal-form textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
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
            <a href="#">New Posts</a>
            <a href="#">My Posts</a>
        </div>
        <!-- <a href="#" class="new-post-button" onclick="showNewPostModal()">New Discussion</a> -->
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
                title: "Best resources for learning web development in 2024",
                content: "I'm looking to start learning web development. What resources would you recommend for a complete beginner?",
                author: "NewbieDev",
                timestamp: "5 hours ago",
                answers: []
            }
        ];

        // Function to create post HTML
        function createPostHTML(post) {
            return `
                <div class="post" data-post-id="${post.id}">
                    <div class="post-header">
                        <h3 class="post-title" onclick="toggleAnswers(${post.id})">${post.title}</h3>
                        <span class="post-meta">Posted by ${post.author} · ${post.timestamp}</span>
                    </div>
                    <p class="post-content">${post.content}</p>
                    <div class="post-actions">
                        <button class="action-button" onclick="toggleAnswerForm(${post.id})">Post Answer</button>
                    </div>
                    <div class="answers-container" id="answers-${post.id}" style="display: none;">
                        <div class="answers-list">
                            ${post.answers.map(answer => createAnswerHTML(answer)).join('')}
                        </div>
                        <form class="answer-form" id="answer-form-${post.id}">
                            <textarea class="answer-input" placeholder="Write your answer..." required></textarea>
                            <button type="submit" class="submit-answer">Submit Answer</button>
                        </form>
                    </div>
                </div>
            `;
        }

        // Function to create answer HTML
        function createAnswerHTML(answer) {
            return `
                <div class="answer">
                    <div class="post-meta">
                        ${answer.author} · ${answer.timestamp}
                    </div>
                    <p class="post-content">${answer.content}</p>
                </div>
            `;
        }

        // Function to toggle answers visibility
        function toggleAnswers(postId) {
            const answersContainer = document.getElementById(`answers-${postId}`);
            answersContainer.style.display = answersContainer.style.display === 'none' ? 'block' : 'none';
        }

        // Function to toggle answer form
        function toggleAnswerForm(postId) {
            const answersContainer = document.getElementById(`answers-${postId}`);
            const answerForm = document.getElementById(`answer-form-${postId}`);

            answersContainer.style.display = 'block';
            answerForm.style.display = answerForm.style.display === 'none' ? 'block' : 'none';
        }

        // Modal functions
        function showNewPostModal() {
            document.getElementById('newPostModal').style.display = 'block';
        }

        function hideNewPostModal() {
            document.getElementById('newPostModal').style.display = 'none';
        }

        // Initialize page
        function renderPosts() {
            const postsContainer = document.getElementById('posts-container');
            postsContainer.innerHTML = posts.map(createPostHTML).join('');

            // Add submit handlers for answer forms
            posts.forEach(post => {
                const form = document.getElementById(`answer-form-${post.id}`);
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const textarea = form.querySelector('textarea');
                    const newAnswer = {
                        author: "CurrentUser", // In a real app, this would come from user session
                        content: textarea.value,
                        timestamp: "Just now"
                    };
                    post.answers.push(newAnswer);
                    renderPosts();
                });
            });
        }

        // Handle new post submission
        document.getElementById('newPostForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const title = this.querySelector('input').value;
            const content = this.querySelector('textarea').value;

            const newPost = {
                id: posts.length + 1,
                title: title,
                content: content,
                author: "CurrentUser", // In a real app, this would come from user session
                timestamp: "Just now",
                answers: []
            };

            posts.unshift(newPost);
            renderPosts();
            hideNewPostModal();
            this.reset();
        });

        // Initialize
        window.onload = function() {
            renderPosts();

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target === document.getElementById('newPostModal')) {
                    hideNewPostModal();
                }
            };
        };
    </script>
</body>

</html>