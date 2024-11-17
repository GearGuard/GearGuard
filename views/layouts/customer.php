<?php

/** @var $this \app\core\View  */
$this->title = 'Appointment';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #F2F6FCFF;
            font-family: "Montserrat", sans-serif;
        }

        .navMenu {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            top: 0;
            padding: 20px 0;
            /* Add some padding for spacing */
        }

        .navMenu a {
            color: #002366;
            text-decoration: none;
            font-size: 1em;
            text-transform: uppercase;
            font-weight: 500;
            display: inline-block;
            margin: 0 15px;
            /* Space between links */
            position: relative;
            /* Position relative for dot placement */
        }

        .navMenu a:hover {
            color: #002366;
        }

        .navMenu .dot {
            width: 6px;
            height: 6px;
            background: #002366;
            border-radius: 50%;
            position: absolute;
            /* Absolute positioning for dot */
            bottom: -10px;
            /* Position it below the text */
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            /* Initially hidden */
            transition: all 0.5s ease-in-out;
        }

        .navMenu a:hover .dot {
            opacity: 1;
            /* Show dot on hover */
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="customer/appointment">Book Appointment<span class="dot"></span></a>
        <a href="#">My Appointments<span class="dot"></span></a>
        <a href="#">Edit Appointment<span class="dot"></span></a>
        <a href="#">Service History<span class="dot"></span></a>
        <a href="#">Spare Parts Warranty<span class="dot"></span></a>
    </nav>
    {{content}}
</body>

</html>