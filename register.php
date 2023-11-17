<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get values from the registration form
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the email already exists in the database
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt_result = $stmt->get_result();

if ($stmt_result->num_rows > 0) {
    echo "<h2>Email already exists. Please choose a different email.</h2>";
} else {
    // Insert new user into the database
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    echo "Registration successful! You can now log in.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
