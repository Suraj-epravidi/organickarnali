<?php
// Database connection
$servername = "localhost";
$username = "karnalio_admin"; // replace with your database username
$password = "NATRqydFf-EX"; // replace with your database password
$dbname = "karnalio_data"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch and sanitize form data
$user_username = trim($_POST['username']);
$user_password = trim($_POST['password']);
$user_email = trim($_POST['email']);

// Validate form data
if (empty($user_username) || empty($user_password) || empty($user_email)) {
    die("All fields are required.");
}

if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

// Check if email or username already exists
$sql = "SELECT id FROM users WHERE email = ? OR username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_email, $user_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("Email or Username already exists.");
}

// Hash the password
$hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

// Insert user data into database
$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user_username, $hashed_password, $user_email);

if ($stmt->execute()) {
    header("Location: login.html");
    exit; // Ensure no further code is executed after redirection
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
