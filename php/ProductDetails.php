<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');

// Allow only specific methods if needed
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// Allow only specific headers if needed
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "karnalio_admin";
$password = "NATRqydFf-EX";
$dbname = "karnalio_data";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

$productName = $_GET['name'];

// Prepare and execute SQL query
$sql = $conn->prepare("SELECT subHeading, description, price, stock, thumbnail FROM products WHERE name = ?");
if ($sql === false) {
    echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
    exit();
}

$sql->bind_param("s", $productName);
$sql->execute();

// Bind result variables
$sql->bind_result($subHeading, $description, $price, $stock, $thumbnail);

// Fetch result
if ($sql->fetch()) {
    $result = [
        "subHeading" => $subHeading,
        "description" => $description,
        "price" => $price,
        "stock" => $stock,
        "thumbnail" => $thumbnail
    ];
    echo json_encode($result);
} else {
    echo json_encode(["error" => "No product found"]);
}

$sql->close();
$conn->close();
?>
