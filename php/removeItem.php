<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
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
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize the input
$productName = $_POST['product_name'] ?? null;
$userName = $_POST['user_name'] ?? null;

if ($productName && $userName) {
    $table_name = $userName . '_cart';

    // SQL query to delete the item from the cart
    $sql = "DELETE FROM $table_name WHERE product_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $productName);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Item removed from cart."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to remove item from cart."]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid product name or email address."]);
}

$conn->close();
?>
