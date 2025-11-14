<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Select Account Type - GearGuard</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    :root {
      --text: #f5f5f5;
      --background: #181a20;
      --primary: #c0c0c0;
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
      font-family: "Inter", sans-serif;
      background-color: var(--background);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }

    .selection-container {
      background-color: var(--background);
      border-radius: 20px;
      padding: 3rem;
      width: 100%;
      max-width: 900px;
      /* box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); */
    }

    .header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .header img {
      width: 80px;
      height: 80px;
      margin-bottom: 1.5rem;
    }

    .header h1 {
      font-size: 2.2rem;
      margin-bottom: 1rem;
      color: var(--text);
    }

    .header p {
      color: var(--primary);
      font-size: 1.1rem;
    }

    .options-container {
      display: flex;
      gap: 2rem;
      justify-content: center;
    }

    .option-card {
      background-color: var(--secondary);
      border: 2px solid var(--border);
      border-radius: 15px;
      padding: 2rem;
      width: 300px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .option-card:hover {
      border-color: var(--primary);
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(36, 99, 235, 0.2);
    }

    .option-card i {
      font-size: 3rem;
      color: var(--accent);
      margin-bottom: 1.5rem;
    }

    .option-card h2 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: var(--text);
    }

    .option-card p {
      color: var(--primary);
      font-size: 0.95rem;
      margin-bottom: 1.5rem;
    }

    .select-btn {
      background-color: transparent;
      border: 2px solid var(--accent);
      color: var(--accent);
      padding: 0.8rem 1.5rem;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .select-btn:hover {
      background-color: var(--accent);
      color: var(--text);
    }

    @media (max-width: 768px) {
      .options-container {
        flex-direction: column;
        align-items: center;
      }

      .option-card {
        width: 100%;
        max-width: 300px;
      }
    }
  </style>
</head>

<body>
  <div class="selection-container">
    <div class="header">
      <img src="/assets/img/favicon.png" alt="GearGuard Logo" />
      <h1>Log In</h1>
      <p>Choose your account type to get started with GearGuard</p>
    </div>

    <div class="options-container">
      <div class="option-card" onclick="window.location.href='/login'">
        <i class="fas fa-user"></i>
        <h2>Customer</h2>
        <p>
          Login as a vehicle owner or user to manage your vehicles and access
          services
        </p>
        <a>
          <button class="select-btn">Login as Customer</button>
        </a>
      </div>

      <div
        class="option-card"
        onclick="window.location.href='/garage/login'">
        <i class="fas fa-warehouse"></i>
        <h2>Garage</h2>
        <p>
          Login your garage to offer services and connect with vehicle owners
        </p>
        <button class="select-btn">Login as Garage</button>
      </div>

      <div class="option-card" onclick="window.location.href='/mechanic/login'">
                <i class="fas fa-wrench"></i>
                <h2>Mechanic</h2>
                <p>Login as a mechanic to offer your expertise and connect with vehicle owners</p>
                <button class="select-btn">Login as Mechanic</button>
            </div>
    </div>
  </div>
</body>

</html>