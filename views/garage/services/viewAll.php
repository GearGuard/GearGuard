<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Services - GearGuard</title>
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

        .services-container {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .title {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid var(--border);
        }

        th {
            background-color: #33363f;
            color: var(--text);
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #25272d;
        }

        .view-more-button {
            background: var(--accent);
            color: var(--text);
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .view-more-button:hover {
            background-color: #1b4ebd;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navMenu {
                flex-direction: column;
                gap: 0.5rem;
            }

            .navMenu a {
                width: 100%;
                text-align: center;
            }

            .services-container {
                padding: 1rem;
            }

            table,
            th,
            td {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="#">Add New Service</a>
        <a href="#" class="active">Manage Services</a>
        <a href="#">Service History</a>
        <a href="#">Dashboard</a>
    </nav>
    <div class="services-container">
        <h2 class="title">All Garage Services</h2>
        <table>
            <tr>
                <th>Service Type</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?php echo htmlspecialchars($service->type); ?></td>
                    <td>$<?php echo htmlspecialchars($service->price); ?></td>
                    <td><button onclick='viewDetails(<?php echo json_encode($service); ?>)' class="view-more-button">View More</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        function viewDetails(service) {
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            modal.style.zIndex = '1000';

            const content = document.createElement('div');
            content.style.backgroundColor = '#25272d';
            content.style.padding = '20px';
            content.style.borderRadius = '8px';
            content.style.color = '#f5f5f5';

            content.innerHTML = `<h2>${service.type}</h2>
                             <p>Price: $${service.price}</p>
                             <p>Duration: ${service.duration} hours</p>
                             <p>Description: ${service.description}</p>
                             <button onclick='this.parentElement.parentElement.remove()' style='padding: 10px; background: var(--accent); color: var(--text); border: none; border-radius: 5px; cursor: pointer;'>Close</button>`;

            modal.appendChild(content);
            document.body.appendChild(modal);
        }
    </script>
</body>

</html>