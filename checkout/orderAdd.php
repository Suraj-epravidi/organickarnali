<?php
header('Content-Type: application/json');
// error_log("In Addorder.php",0);
// Fetch username from fetchUser.php
$sessionId = $_COOKIE['user_login'];
$fetchUserUrl = "https://karnaliorganics.com/php/fetchUser.php?sessionId=" . $sessionId;
$userData = file_get_contents($fetchUserUrl);
$userDataJson = json_decode($userData, true);

if (isset($userDataJson['username'])) {
    $username = $userDataJson['username'];
    $cartID = $username . '_cart';
} else {
    echo json_encode(["error" => "Failed to fetch username"]);
    exit();
}

// error_log("Taken username $username",0);

// Database connection details
$servername = "localhost";
$usernameDB = "karnalio_admin";
$passwordDB = "NATRqydFf-EX";
$dbname = "karnalio_data";

// Create connection
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Prepare the SQL statement to fetch address details for the user
$addressStmt = $conn->prepare("SELECT country, address1, address2, suburb, state, postcode, phone, altPhone FROM address_details WHERE username = ?");
if ($addressStmt === false) {
    echo json_encode(["error" => "Error preparing the SQL statement: " . $conn->error]);
    exit();
}

// Bind parameters to the prepared statement
if (!$addressStmt->bind_param("s", $username)) {
    echo json_encode(["error" => "Error binding parameters: " . $addressStmt->error]);
    exit();
}

// Execute the prepared statement
if (!$addressStmt->execute()) {
    echo json_encode(["error" => "Error executing the statement: " . $addressStmt->error]);
    exit();
}

// Bind the result variables to the selected columns
$addressStmt->bind_result($country, $address1, $address2, $suburb, $state, $postcode, $phone, $altPhone);

// Fetch the data into an array
$addresses = [];
while ($addressStmt->fetch()) {
    $addresses[] = [
        'country' => $country,
        'address1' => $address1,
        'address2' => $address2,
        'suburb' => $suburb,
        'state' => $state,
        'postcode' => $postcode,
        'phone' => $phone,
        'altPhone' => $altPhone
    ];
}

$addressStmt->close();

// Check if any address details were found
if (empty($addresses)) {
    echo json_encode(["error" => "No address details found for user"]);
    exit();
}

// Use the first address as $addressData
$addressData = $addresses[0];
// error_log("$addressData['country'], $addressData['address1'], $addressData['address2'],
//     $addressData['suburb'], $addressData['state'], $addressData['postcode'],
//     $addressData['phone'], $addressData['altPhone']",0);
// Extract input data
$orderNotes = isset($_POST['orderNotes']) ? $_POST['orderNotes'] : '';
$paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : '';

// Generate cartID and new table name
$newTableSuffix = sprintf('%04d', rand(0, 9999));
$newCartID = $newTableSuffix . '_kar';
$status = 'Pending';

// Prepare and execute insert statement for orders
$stmt = $conn->prepare("INSERT INTO orders (first_name, country, address1, address2, suburb, state, postcode, phone, alt_phone, order_notes, payment_method, status, cartID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");

if ($stmt === false) {
    echo json_encode(["error" => "Failed to prepare statement for inserting data: " . $conn->error]);
    exit();
}

$stmt->bind_param(
    "sssssssssssss",
    $username,$addressData['country'], $addressData['address1'], $addressData['address2'],
    $addressData['suburb'], $addressData['state'], $addressData['postcode'],
    $addressData['phone'], $addressData['altPhone'], $orderNotes,
    $paymentMethod, $status, $cartID
);

if ($stmt->execute()) {
    // Rename the cart table
    $renameTableQuery = "RENAME TABLE `$cartID` TO `$newCartID`";
    if ($conn->query($renameTableQuery) === false) {
        echo json_encode(["error" => "Failed to rename the table: " . $conn->error]);
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

    $context = stream_context_create($options);
    $result = file_get_contents($updateStockUrl, false, $context);
    $response = json_decode($result, true);

    if (isset($response['error'])) {
        echo json_encode(["error" => $response['error']]);
        exit();
    }

    // Always include a redirect URL in the response
    echo json_encode(["redirect" => 'https://karnaliorganics.com/']);
} else {
    echo json_encode(["error" => "Failed to execute insert statement: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
