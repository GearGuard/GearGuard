<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Error - GearGuard</title>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
		}

		.error-container {
			width: 100%;
			max-width: 800px;
			min-width: 600px;
			border-radius: 20px;
			padding: 4rem 2rem;
			text-align: center;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
			border: 1px solid var(--border);
			animation: fadeIn 0.6s ease-out;
		}

		.error-code {
			font-size: 7rem;
			font-weight: 700;
			color: var(--accent);
			line-height: 1;
			margin-bottom: 1.5rem;
			text-shadow: 0 0 30px rgba(36, 99, 235, 0.3);
		}

		.error-message {
			font-size: 1.5rem;
			color: var(--primary);
			margin-bottom: 2.5rem;
			padding: 0 1rem;
		}

		.back-button {
			display: inline-block;
			padding: 1rem 2.5rem;
			background: #2a52be;
			color: var(--text);
			text-decoration: none;
			border-radius: 8px;
			font-weight: 600;
			transition: all 0.3s ease;
		}

		.back-button:hover {
			background: #1034A6;
			transform: translateY(-2px);
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: translateY(20px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		@media (max-width: 768px) {
			.error-container {
				margin: 1rem;
				padding: 2rem 1rem;
			}

			.error-code {
				font-size: 3rem;
			}

			.error-message {
				font-size: 1.2rem;
			}
		}
	</style>
</head>

<body>
	<div class="error-container">
		<div class="error-code"><?php echo $exception->getCode() ?></div>
		<div class="error-message"><?php echo $exception->getMessage() ?></div>
		<a href="/" class="back-button">Back to Homepage</a>
	</div>
</body>

</html>