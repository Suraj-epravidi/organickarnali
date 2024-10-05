<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "karnalio_admin";
$password = "NATRqydFf-EX";
$dbname = "karnalio_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Retrieve data from POST request
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? null;
$productName = $input['product_name'] ?? null;
$newQuantity = $input['quantity'] ?? null;

if ($username && $productName && $newQuantity !== null) {
    error_log("Username: " . $username);

    // Update the quantity of the product in the cart
    $table_name = $username . '_cart';
    $stmt = $conn->prepare("UPDATE `$table_name` SET quantity = ? WHERE product_name = ?");
    if ($stmt === false) {
        error_log("Failed to prepare statement for updating quantity: " . $conn->error);
        echo json_encode(["error" => "Failed to prepare statement for updating quantity: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("is", $newQuantity, $productName);
    if ($stmt->execute()) {
        error_log("Quantity updated for product: " . $productName);
        echo json_encode(["success" => "Quantity updated"]);
    } else {
        error_log("Failed to update quantity: " . $stmt->error);
        echo json_encode(["error" => "Failed to update quantity: " . $stmt->error]);
    }
    $stmt->close();
} else {
    error_log("Invalid input data");
    echo json_encode(["error" => "Invalid input data"]);
}

// Close connection
$conn->close();
?>
