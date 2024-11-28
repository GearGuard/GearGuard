<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Problem</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0FF;
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

        .page-title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary);
        }

        .navMenu {
            background-color: var(--secondary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
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

        .main-container {
            max-width: 57%;
            margin: 0 auto;
        }

        .problem-form {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 0.5rem;
            text-align: left;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            color: var(--text);
            transition: border-color 0.2s ease;
            background-color: var(--secondary);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent);
        }

        .form-group textarea {
            min-height: 200px;
            resize: vertical;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-clear {
            background: #f1f5f9;
            color: var(--accent);
        }

        .btn-clear:hover {
            background: var(--hover-bg);
        }

        .btn-post {
            background: var(--accent);
            color: var(--text);
        }

        .btn-post:hover {
            background: #1d4ed8;
        }

        /* Responsive design */
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

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <div class="nav-links">
            <a href="#">Discussion</a>
            <a href="#" class="active">New Posts</a>
            <a href="#">My Posts</a>
        </div>
    </nav>

    <div class="page-title-container">
        <h1 class="page-title">Post a Problem</h1>
    </div>

    <div class="main-container">
        <form class="problem-form" action="submit_problem.php" method="POST" id="problemForm">
            <div class="form-group">
                <label for="topic">Topic</label>
                <input type="text" id="topic" name="topic" required placeholder="Enter the topic">
            </div>

            <div class="form-group">
                <label for="problem">Problem Description</label>
                <textarea id="problem" name="problem" required placeholder="Describe your problem in detail"></textarea>
            </div>

            <div class="button-group">
                <button type="button" class="btn btn-clear" onclick="clearForm()">Clear</button>
                <button type="submit" class="btn btn-post">Post Problem</button>
            </div>
        </form>
    </div>

    <script>
        function clearForm() {
            document.getElementById('problemForm').reset();
        }

        // Form submission handling
        document.getElementById('problemForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const topic = document.getElementById('topic').value;
            const problem = document.getElementById('problem').value;

            // Here you can add client-side validation if needed
            if (topic.trim() === '' || problem.trim() === '') {
                alert('Please fill in all fields');
                return;
            }

            // Submit the form
            this.submit();
        });
    </script>
</body>

</html>