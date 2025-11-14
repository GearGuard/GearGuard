<?php
	session_start(); // Start the session if not already started

// Unset all session variables
	$_SESSION = array();

// If a session cookie is used, destroy it
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time() - 42000, '/');
	}

// Destroy the session
	session_destroy();

// Redirect to login page or home page
	header('Location: typelogin.php'); // or index.php, depending on your setup
	exit(); // Terminate script execution
