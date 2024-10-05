<?php
// fetchUser.php

// Database connection details
$servername = "localhost";
$username = "karnalio_admin"; // replace with your database username
$password = "NATRqydFf-EX"; // replace with your database password
$dbname = "karnalio_data"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}


// Get sessionId from query parameters
$sessionId = isset($_GET['sessionId']) ? trim($_GET['sessionId']) : '';

if ($sessionId) {
    // Prepare and execute query to fetch email
    $stmt = $conn->prepare("SELECT email FROM cookie WHERE session_id = ?");
    
    if ($stmt === false) {
        die(json_encode(["error" => "Failed to prepare statement: " . $conn->error]));
    }
    
    $stmt->bind_param("s", $sessionId);
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($email);
    $stmt->fetch();

    // Check if email was fetched
    if ($email) {
        // Close the statement
        $stmt->close();
        
        // Prepare and execute query to fetch username using the email
        $stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
        
        if ($stmt === false) {
            die(json_encode(["error" => "Failed to prepare statement: " . $conn->error]));
        }
        
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($username);
        $stmt->fetch();

        // Check if username was fetched
        if ($username) {
            echo json_encode(["username" => $username]);
        } else {
            echo json_encode(["error" => "No user found"]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["error" => "No user found"]);
    }

    // Close the connection
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid session ID"]);
}
?>
