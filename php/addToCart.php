<?php
header('Access-Control-Allow-Origin: *');

// Allow only specific methods if needed
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// Allow only specific headers if needed
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
if (!$_COOKIE['user_login']) {
    echo json_encode(["error" => "Please Sign in First"]);
    exit();
}
// Database connection
$servername = "localhost";
$username = "karnalio_admin"; // replace with your database username
$password = "NATRqydFf-EX"; // replace with your database password
$dbname = "karnalio_data"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$sessionId = $_COOKIE['user_login'] ?? null;

if ($sessionId) {
    // Prepare and execute query to fetch email
    $stmt = $conn->prepare("SELECT email FROM cookie WHERE session_id = ?");
    if ($stmt === false) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
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
            echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
            exit();
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();

        if ($username) {
            // Fetch and sanitize form data
            $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : null;
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : null;
            $user = $username;

            // Check for null values
            if ($product_name === null || $quantity === null || $user === null) {
                echo json_encode(["success" => false, "message" => "Missing product name, quantity, or user."]);
                exit();
            }

            // Sanitize email to use in table name
            $table_name = $conn->real_escape_string($user) . "_cart";

            // Create table if it doesn't exist
            $sql_create_table = "CREATE TABLE IF NOT EXISTS `$table_name` (
                ID INT AUTO_INCREMENT PRIMARY KEY,
                product_name VARCHAR(255) NOT NULL,
                quantity INT NOT NULL
            )";

            if (!$conn->query($sql_create_table)) {
                echo json_encode(["success" => false, "message" => "Error creating table: " . $conn->error]);
                exit();
            }

            // Check if product already exists in cart
            $sql_check = "SELECT quantity FROM `$table_name` WHERE product_name = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("s", $product_name);
            $stmt_check->execute();
            $stmt_check->bind_result($existing_quantity);
            $stmt_check->fetch();
            $stmt_check->close();

            if ($existing_quantity !== null) {
                // Product exists, update quantity
                $new_quantity = $existing_quantity + $quantity;
                $sql_update = "UPDATE `$table_name` SET quantity = ? WHERE product_name = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("is", $new_quantity, $product_name);

                if ($stmt_update->execute()) {
                    echo json_encode(["success" => true, "message" => "Product quantity updated successfully."]);
                } else {
                    echo json_encode(["success" => false, "message" => "Error updating product quantity: " . $stmt_update->error]);
                }

                $stmt_update->close();
            } else {
                // Product doesn't exist, insert new record
                $sql_insert = "INSERT INTO `$table_name` (product_name, quantity) VALUES (?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("si", $product_name, $quantity);

                if ($stmt_insert->execute()) {
                    echo json_encode(["success" => true, "message" => "Product added to cart successfully."]);
                } else {
                    echo json_encode(["success" => false, "message" => "Error adding product to cart: " . $stmt_insert->error]);
                }

                $stmt_insert->close();
            }
        } else {
            echo json_encode(["error" => "No user found with email: " . $email]);
        }
    } else {
        echo json_encode(["error" => "No email found for session ID: " . $sessionId]);
    }
} else {
    echo json_encode(["error" => "Invalid session ID"]);
}

// Close connection
$conn->close();
?>
