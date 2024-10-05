<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

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

// Get cart name from the input
$cartName = $input['cartName'];

// Fetch cart items
$cartItems = [];
$query = "SELECT product_name, quantity FROM $cartName";
$result = $conn->query($query);

if ($result === false) {
    echo json_encode(["error" => "Failed to fetch cart items"]);
    exit();
}

while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

// Update stock for each product in the cart
foreach ($cartItems as $item) {
    $productName = $item['product_name'];
    $quantity = $item['quantity'];

    // Fetch current stock
    $stmt = $conn->prepare("SELECT stock FROM products WHERE name = ?");
    if ($stmt === false) {
        echo json_encode(["error" => "Failed to prepare statement for fetching product stock"]);
        exit();
    }

    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $stmt->bind_result($currentStock);
    $stmt->fetch();
    $stmt->close();

    // Calculate new stock
    $newStock = $currentStock - $quantity;

    // Update stock
    $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE name = ?");
    if ($stmt === false) {
        echo json_encode(["error" => "Failed to prepare statement for updating product stock"]);
        exit();
    }

    $stmt->bind_param("is", $newStock, $productName);
    if (!$stmt->execute()) {
        echo json_encode(["error" => "Failed to update product stock for product $productName"]);
        exit();
    }
    $stmt->close();
}

$conn->close();
echo json_encode(["success" => "Stock updated successfully"]);
?>
