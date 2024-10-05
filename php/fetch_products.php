<?php
header('Access-Control-Allow-Origin: *');

// Allow only specific methods if needed
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// Allow only specific headers if needed
header('Access-Control-Allow-Headers: Content-Type');

// Database connection
$servername = "localhost";
$username = "karnalio_admin"; // replace with your database username
$password = "NATRqydFf-EX"; // replace with your database password
$dbname = "karnalio_data"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from database
$sql = "SELECT name, price, thumbnail FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($products);
?>
