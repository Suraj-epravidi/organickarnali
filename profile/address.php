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

// Decode the JSON response
$data = json_decode($response, true);

// Check if there's an error in the response
if (isset($data['error'])) {
    die("Error: " . $data['error']);
} else {
    // Access the username from the response
    $username = $data['username'];
}

// Collecting form data
$country = isset($_POST['country']) ? $_POST['country'] : '';
$address1 = isset($_POST['address1']) ? $_POST['address1'] : '';
$address2 = isset($_POST['address2']) ? $_POST['address2'] : '';
$suburb = isset($_POST['suburb']) ? $_POST['suburb'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';
$postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';

// Inserting or updating data into the database
// Ensure you have a unique key (e.g., `postcode`) or primary key
$sql = "INSERT INTO address_details (username, country, address1, address2, suburb, state, postcode)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        country = VALUES(country), address1 = VALUES(address1), address2 = VALUES(address2), 
        suburb = VALUES(suburb), state = VALUES(state), postcode = VALUES(postcode)";

// Using prepared statements to avoid SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $username, $country, $address1, $address2, $suburb, $state, $postcode);

if ($stmt->execute()) {
    header("Location: profile.php");
} else {
    echo "Error: " . $stmt->error;
}

// Closing connection
$stmt->close();
$conn->close();
?>
