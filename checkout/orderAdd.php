<?php
header('Content-Type: application/json');

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

// Database connection details
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

// Retrieve address details for the user
$addressStmt = $conn->prepare("SELECT * FROM address_details WHERE username = ?");
$addressStmt->bind_param("s", $username);
$addressStmt->execute();
$addressResult = $addressStmt->get_result();

if ($addressResult->num_rows === 0) {
    echo json_encode(["error" => "No address details found for user"]);
    exit();
}

$addressData = $addressResult->fetch_assoc();
$addressStmt->close();

// Extract input data
$firstName = $addressData['first_name'];
$lastName = $addressData['last_name'];
$country = $addressData['country'];
$address1 = $addressData['address1'];
$address2 = $addressData['address2'];
$suburb = $addressData['suburb'];
$state = $addressData['state'];
$postcode = $addressData['postcode'];
$phone = $addressData['phone'];
$altPhone = $addressData['alt_phone'];
$orderNotes = isset($input['orderNotes']) ? $input['orderNotes'] : '';
$paymentMethod = isset($input['paymentMethod']) ? $input['paymentMethod'] : '';

// Generate cartID
$cartID = $username . '_cart';
$newTableSuffix = sprintf('%04d', rand(0, 9999));
$newCartID = $newTableSuffix . '_kar';
// Set default status (e.g., 'P' for Pending)
$status = 'Pending';

// Prepare and execute insert statement
$stmt = $conn->prepare("INSERT INTO orders (first_name, last_name, country, address1, address2, suburb, state, postcode, phone, alt_phone, order_notes, payment_method, status, cartID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    echo json_encode(["error" => "Failed to prepare statement for inserting data"]);
    exit();
}

$stmt->bind_param("ssssssssssssss", $firstName, $lastName, $country, $address1, $address2, $suburb, $state, $postcode, $phone, $altPhone, $orderNotes, $paymentMethod, $status, $cartID);

if ($stmt->execute()) {
    // Rename the table
    $renameTableQuery = "RENAME TABLE $cartID TO $newCartID"; // Adjust as needed
    if ($conn->query($renameTableQuery) === false) {
        echo json_encode(["error" => "Failed to rename the table"]);
        exit();
    }

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

    $response = [];
    // Always include a redirect URL in the response
    $response['redirect'] = 'https://karnaliorganics.com/';

    echo json_encode($response);
} else {
    echo json_encode(["error" => "Failed to execute insert statement"]);
}

$stmt->close();
$conn->close();
?>
