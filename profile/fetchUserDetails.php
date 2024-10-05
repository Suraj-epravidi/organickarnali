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
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Check if user_login cookie is set
if (!isset($_COOKIE['user_login'])) {
    // Redirect to homepage if the cookie is not set
    header("Location: http://karnaliorganics.com/login/login.html");
    exit();
}

// Get session ID from cookie
$sessionId = $_COOKIE['user_login'];

// URL to the fetchUser.php script
$url = 'http://karnaliorganics.com/php/fetchUser.php?sessionId=' . urlencode($sessionId);

// Fetch the response from fetchUser.php
$response = file_get_contents($url);

// Check if the response is false
if ($response === FALSE) {
    die(json_encode(['error' => 'Unable to fetch user details.']));
}

// Decode the JSON response
$data = json_decode($response, true);

// Check if JSON decoding was successful
if ($data === NULL) {
    die(json_encode(['error' => 'Invalid JSON response.']));
}

// Check if there's an error in the response
if (isset($data['error'])) {
    die(json_encode(['error' => $data['error']]));
} else {
    // Access the username from the response
    $username = $data['username'];
}

// Prepare SQL to fetch email, phone number, address, alternate phone number, and profile picture
$sql = "SELECT u.email, a.phone, a.altPhone, a.address1, a.address2, a.suburb, a.state, a.postcode, a.pfp
        FROM users u
        INNER JOIN address_details a ON u.username = a.username
        WHERE u.username = ?";

// Using prepared statements to avoid SQL injection
$stmt = $conn->prepare($sql);
if ($stmt === FALSE) {
    die(json_encode(['error' => 'Failed to prepare SQL statement.']));
}

$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email, $phone, $altPhone, $address1, $address2, $suburb, $state, $postcode, $pfp);

// Fetch the user’s details
$userDetails = [];
if ($stmt->fetch()) {
    $userDetails = [
        'email' => $email,
        'phone' => $phone,
        'altPhone' => $altPhone,
        'address1' => $address1,
        'address2' => $address2,
        'suburb' => $suburb,
        'state' => $state,
        'postcode' => $postcode,
        'pfp' => $pfp  // Include profile picture field
    ];
}

// Add username to the user details
$userDetails['username'] = $username;

// Closing connection
$stmt->close();
$conn->close();

// Return the user details as a JSON response
echo json_encode($userDetails);
?>
