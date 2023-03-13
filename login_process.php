<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	// Database connection
	$conn = new mysqli('localhost', 'username', 'password', 'database_name');

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// SQL query
	$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

	// Execute query
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// Login successful
		$row = $result->fetch_assoc();
		$_SESSION['username'] = $row['username'];
		header('Location: homepage.html');
	} else {
		// Login failed
		header('Location: login.php');
	}

	$conn->close();
} else {
	// Invalid request
	header('Location: login.php');
}
?>
