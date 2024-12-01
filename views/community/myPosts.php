<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Questions</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #1e293b;
            /* Dark background */
            font-family: "Inter", sans-serif;
            color: #e2e8f0;
            /* Light text color */
            line-height: 1.6;
            padding: 20px;
        }

        .page-title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: #e2e8f0;
        }

        .navMenu {
            background-color: rgba(37, 99, 235, 0.1);
            /* Soft blue background */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 60%;
            padding: 1rem;
            margin: 0 auto 2rem;
            position: sticky;
            top: 20px;
            z-index: 100;
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
            max-width: 57%;
            margin: 0 auto;
        }

        .question-card {
            background: #2d3748;
            /* Darker card background */
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #4b5563;
        }

        .question-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #e2e8f0;
            /* Light text color */
            flex-grow: 1;
            text-align: justify;
            margin-right: 1rem;
        }

        .button-group {
            display: flex;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .edit-button,
        .delete-button {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .edit-button {
            background: #4b5563;
            color: #e2e8f0;
        }

        .edit-button:hover {
            background: #334155;
        }

        .delete-button {
            background: #fee2e2;
            color: #ef4444;
        }

        .delete-button:hover {
            background: #fecaca;
        }

        .question-meta {
            font-size: 0.875rem;
            color: #a1a1aa;
            margin-bottom: 1rem;
        }

        .question-content {
            color: #e2e8f0;
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .answers-section {
            margin-top: 1.5rem;
        }

        .answers-header {
            font-size: 1rem;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 1rem;
        }

        .answer {
            background: #2d3748;
            /* Dark background for answers */
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            text-align: justify;
            border: 1px solid #4b5563;
        }

        .answer:last-child {
            margin-bottom: 0;
        }

        .answer-meta {
            font-size: 0.875rem;
            color: #a1a1aa;
            margin-bottom: 0.5rem;
        }

        .answer-content {
            color: #e2e8f0;
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
            background: #1e293b;
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
            color: #e2e8f0;
        }

        .modal-form input,
        .modal-form textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #4b5563;
            border-radius: 8px;
            font-family: inherit;
            background: #2d3748;
            color: #e2e8f0;
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

            .card-header {
                flex-direction: column;
                gap: 1rem;
            }

            .button-group {
                width: 100%;
                justify-content: flex-end;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <div class="nav-links">
            <a href="#">Discussions</a>
            <a href="#">New Post</a>
            <a href="#" class="active">My Posts</a>
        </div>
    </nav>

    <div class="page-title-container">
        <h1 class="page-title">My Questions</h1>
    </div>

    <div class="main-container" id="questions-container">
        <!-- Questions will be dynamically added here -->
    </div>

    <!-- Edit Question Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3 class="modal-title">Edit Question</h3>
            <form class="modal-form" id="editForm">
                <input type="hidden" id="editQuestionId">
                <input type="text" id="editTitle" placeholder="Title" required>
                <textarea id="editContent" placeholder="Question content" required></textarea>
                <div class="modal-buttons">
                    <button type="button" class="edit-button" onclick="hideEditModal()">Cancel</button>
                    <button type="submit" class="new-post-button">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sample data
        let myQuestions = [{
                id: 1,
                title: "How to implement authentication in Node.js?",
                content: "I'm building a Node.js application and need help implementing user authentication. What's the best approach?",
                timestamp: "2 days ago",
                answers: [{
                        author: "SecurityExpert",
                        content: "I recommend using Passport.js for authentication. It's flexible and well-maintained.",
                        timestamp: "1 day ago"
                    },
                    {
                        author: "NodeDev",
                        content: "JWT (JSON Web Tokens) is also a great option for handling authentication.",
                        timestamp: "12 hours ago"
                    }
                ]
            },
            {
                id: 2,
                title: "Best practices for React state management",
                content: "What are the current best practices for managing state in a large React application?",
                timestamp: "1 week ago",
                answers: [{
                    author: "ReactPro",
                    content: "For large applications, I would recommend Redux Toolkit or Zustand.",
                    timestamp: "5 days ago"
                }]
            }
        ];

        // Function to create question card HTML
        function createQuestionCard(question) {
            return `
                <div class="question-card" data-question-id="${question.id}">
                    <div class="card-header">
                        <h2 class="question-title">${question.title}</h2>
                        <div class="button-group">
                            <button class="edit-button" onclick="editQuestion(${question.id})">Edit</button>
                            <button class="delete-button" onclick="deleteQuestion(${question.id})">Delete</button>
                        </div>
                    </div>
                    <div class="question-meta">Posted ${question.timestamp}</div>
                    <div class="question-content">${question.content}</div>
                    
                    <div class="answers-section">
                        <h3 class="answers-header">Answers (${question.answers.length})</h3>
                        ${question.answers.map(answer => ` 
                            <div class="answer">
                                <div class="answer-meta">
                                    ${answer.author} · ${answer.timestamp}
                                </div>
                                <div class="answer-content">${answer.content}</div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        // Function to render all questions
        function renderQuestions() {
            const container = document.getElementById('questions-container');
            container.innerHTML = myQuestions.map(createQuestionCard).join('');
        }

        // Edit question functions
        function editQuestion(questionId) {
            const question = myQuestions.find(q => q.id === questionId);
            if (question) {
                document.getElementById('editQuestionId').value = questionId;
                document.getElementById('editTitle').value = question.title;
                document.getElementById('editContent').value = question.content;
                document.getElementById('editModal').style.display = 'block';
            }
        }

        function hideEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Delete question function
        function deleteQuestion(questionId) {
            if (confirm('Are you sure you want to delete this question?')) {
                myQuestions = myQuestions.filter(q => q.id !== questionId);
                renderQuestions();
            }
        }

        // Initialize page
        window.onload = function() {
            renderQuestions();

            // Handle edit form submission
            document.getElementById('editForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const questionId = Number(document.getElementById('editQuestionId').value);
                const questionIndex = myQuestions.findIndex(q => q.id === questionId);

                if (questionIndex !== -1) {
                    myQuestions[questionIndex].title = document.getElementById('editTitle').value;
                    myQuestions[questionIndex].content = document.getElementById('editContent').value;
                    renderQuestions();
                    hideEditModal();
                }
            });

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target === document.getElementById('editModal')) {
                    hideEditModal();
                }
            };
        };
    </script>
</body>

</html>