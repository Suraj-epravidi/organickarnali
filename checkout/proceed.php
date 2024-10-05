<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$firstName = $input['firstName'];
$lastName = $input['lastName'];
$country = $input['country'];
$address1 = $input['address1'];
$address2 = $input['address2'];
$suburb = $input['suburb'];
$state = $input['state'];
$postcode = $input['postcode'];
$phone = $input['phone'];
$altPhone = $input['altPhone'];
$orderNotes = $input['orderNotes'];
$paymentMethod = $input['paymentMethod'];

// Set default status (e.g., 'Pending')
$status = 'Pending';

// Obtain session ID from the input
$sessionId = $_COOKIE['user_login'];

// Fetch username from fetchUser.php
$fetchUserUrl = "../php/fetchUser.php?sessionId=" . urlencode($sessionId);
$userData = file_get_contents($fetchUserUrl);
$userDataJson = json_decode($userData, true);

if (isset($userDataJson['username'])) {
    $username = $userDataJson['username'];
    $cartID = $username . '_cart';
} else {
    echo json_encode(["error" => "Failed to fetch username"]);
    exit();
}

// Generate a new table name with a random 4-digit number
$newTableSuffix = sprintf('%04d', rand(0, 9999));
$newCartID = $newTableSuffix . '_kar';

// Database connection
$servername = "localhost";
$usernameDB = "karnalio_admin";
$passwordDB = "NATRqydFf-EX";
$dbname = "karnalio_data";

// Create connection
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

// Rename the cart table
$renameQuery = "RENAME TABLE $cartID TO $newCartID";
if (!$conn->query($renameQuery)) {
    echo json_encode(["error" => "Failed to rename cart table"]);
    exit();
}

// Prepare and execute insert statement
$stmt = $conn->prepare("INSERT INTO orders (first_name, last_name, country, address1, address2, suburb, state, postcode, phone, alt_phone, order_notes, payment_method, status, cartID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    echo json_encode(["error" => "Failed to prepare statement for inserting data"]);
    exit();
}

// Bind parameters including cartID
$stmt->bind_param("ssssssssssssss", $firstName, $lastName, $country, $address1, $address2, $suburb, $state, $postcode, $phone, $altPhone, $orderNotes, $paymentMethod, $status, $newCartID);

if ($stmt->execute()) {
    // Call updateStock.php to update stock
    $updateStockUrl = "./updateStock.php";
    $updateStockData = json_encode(['cartName' => $newCartID]);

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => $updateStockData,
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($updateStockUrl, false, $context);
    $response = json_decode($result, true);

    if (isset($response['error'])) {
        echo json_encode(["error" => $response['error']]);
        exit();
    }

    // Always include a redirect URL in the response
    echo json_encode(['redirect' => 'https://karnaliorganics.com/']);
} else {
    echo json_encode(["error" => "Failed to execute insert statement"]);
}

$stmt->close();
$conn->close();
?>
