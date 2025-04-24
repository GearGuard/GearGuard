<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - No Vehicle Access - GearGuard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --text: #FFFFFFFF;
            --background: #181a20;
            --primary: #c7adad;
            --secondary: #25272d;
            --accent: #2463eb;
            --border: #33363f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow: hidden;
        }

        .error-container {
            position: relative;
            width: 100%;
            max-width: 600px;
            min-height: 100px;
            border-radius: 20px;
            padding: 4rem 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border);
            background: linear-gradient(135deg, var(--secondary), var(--background));
            overflow: hidden;
        }

        .error-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .error-icon {
            font-size: 8rem;
            color: var(--accent);
            margin-bottom: 2rem;
            animation: float 3s ease-in-out infinite;
        }

        .error-code {
            font-size: 5rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 30px rgba(36, 99, 235, 0.3);
        }

        .error-message {
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 3rem;
            text-align: center;
            max-width: 80%;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 1rem 2.5rem;
            background: var(--accent);
            color: var(--text);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(36, 99, 235, 0.3);
        }

        .back-button i {
            margin-right: 0.5rem;
        }

        .back-button:hover {
            background: #1b4ebd;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(36, 99, 235, 0.4);
        }

        .background-shape {
            position: absolute;
            background: var(--accent);
            opacity: 0.1;
            border-radius: 50%;
        }

        .shape1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
        }

        .shape2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 3rem 1.5rem;
                min-height: 400px;
            }

            .error-icon {
                font-size: 6rem;
            }

            .error-code {
                font-size: 2.5rem;
            }

            .error-message {
                font-size: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="background-shape shape1"></div>
        <div class="background-shape shape2"></div>
        <div class="error-content">
            <i class="fas fa-car-slash error-icon"></i>
            <div class="error-code">Sorry</div>
            <div class="error-message">You do not own or have access to any vehicle</div>
            <a href="/" class="back-button">
                <i class="fas fa-home"></i>
                Back to Homepage
            </a>
        </div>
    </div>
</body>

</html>