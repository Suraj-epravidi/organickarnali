<?php
error_reporting(0); // Disable all error reporting
ini_set('display_errors', 0); // Disable error display
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
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
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

// Retrieve session ID from cookies
$sessionId = $_COOKIE['user_login'] ?? null;

if ($sessionId) {

    // Prepare and execute query to fetch email
    $stmt = $conn->prepare("SELECT email FROM cookie WHERE session_id = ?");
    if ($stmt === false) {
        echo json_encode(["error" => "Failed to prepare statement for email"]);
        exit();
    }
    $stmt->bind_param("s", $sessionId);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    if ($email) {

        // Prepare and execute query to fetch username using the email
        $stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
        if ($stmt === false) {
            echo json_encode(["error" => "Failed to prepare statement for username"]);
            exit();
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();

        if ($username) {

            // Retrieve cart items for the user
            $table_name = $username . '_cart';
            $sql_cart = "SELECT c.product_name, c.quantity, p.description, p.price, p.stock,
                                CONCAT('https://panel.karnaliorganics.com/', p.thumbnail) AS thumbnail
                         FROM `$table_name` c 
                         JOIN products p ON c.product_name = p.name";
            
            if ($result_cart = $conn->query($sql_cart)) {
                $cartItems = [];
                while ($row = $result_cart->fetch_assoc()) {
                    $cartItems[] = $row;
                }
                echo json_encode($cartItems);
                $result_cart->free(); // Free result set
            } else {
                echo json_encode(["error" => "Query failed"]);
            }
        } else {
            echo json_encode(["error" => "No user found with email"]);
        }
    } else {
        echo json_encode(["error" => "No email found for session ID"]);
    }
} else {
    echo json_encode(["error" => "Invalid session ID"]);
}

// Close connection
$conn->close();
?>
