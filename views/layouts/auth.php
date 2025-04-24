<?php
?>

<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GearGuard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        section {
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- <header>
        <h1>Welcome to My Homepage</h1>

    </header> -->

    <div class="container">
        {{content}}
    </div>

    <!-- <footer>
        <p>&copy; 2024 My Simple Homepage</p>
    </footer> -->

</body>

</html>