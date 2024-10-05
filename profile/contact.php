<?php
// Database configuration
$servername = "localhost";
$username = "karnalio_admin";
$password = "NATRqydFf-EX";
$dbname = "karnalio_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get session ID from cookie
$sessionId = isset($_COOKIE['user_login']) ? $_COOKIE['user_login'] : '';

// URL to the fetchUser.php script
$url = 'http://karnaliorganics.com/php/fetchUser.php?sessionId=' . urlencode($sessionId);

// Fetch the response from fetchUser.php
$response = file_get_contents($url);

if ($response === FALSE) {
    die("Error: Unable to fetch user details.");
}

// Decode the JSON response
$data = json_decode($response, true);

// Check if JSON decoding was successful
if ($data === NULL) {
    die("Error: Invalid JSON response.");
}

// Check if there's an error in the response
if (isset($data['error'])) {
    die("Error: " . $data['error']);
} else {
    // Access the username from the response
    $username = $data['username'];
}

// Collecting form data
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$altPhone = isset($_POST['altPhone']) ? $_POST['altPhone'] : '';


// Insert or update data
$sql = "INSERT INTO address_details (username, phone, altPhone)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
        phone = VALUES(phone), altPhone = VALUES(altPhone)";

// Using prepared statements to avoid SQL injection
$stmt = $conn->prepare($sql);

if ($stmt === FALSE) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("sss", $username, $phone, $altPhone);

if ($stmt->execute()) {
    header("Location: profile.php");
} else {
    echo "Error executing statement: " . $stmt->error;
}

// Closing connection
$stmt->close();
$conn->close();
?>
