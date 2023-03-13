<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Retrieve form data
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Connect to MySQL database
	$servername = "localhost";
	$username_db = "your_username";
	$password_db = "your_password";
	$dbname = "your_database_name";

	$conn = new mysqli($servername, $username_db, $password_db, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Check if username or email already exists in database
	$sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// Username or email already exists
		header('Location: signup.php');
	} else {
		// Hash password using Bcrypt algorithm
		$password_hashed = password_hash($password, PASSWORD_BCRYPT);

		// SQL query to insert new user
		$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hashed')";

		// Execute query
		if ($conn->query($sql) === TRUE) {
			// Signup successful
			$_SESSION['username'] = $username;
			header('Location: homepage.html');
		} else {
			// Signup failed
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	$conn->close();
} else {
	// Invalid request
	header('Location: signup.php');
}
?>
