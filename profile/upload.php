<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Logging function
function logError($message) {
    error_log($message, 3, 'file.log');
}

// Database configuration
$servername = "localhost";
$username_db = "karnalio_admin";
$password_db = "NATRqydFf-EX";
$dbname = "karnalio_data";

// Define the upload directory
$uploadDir = 'pfp/';
$allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
$maxFileSize = 5 * 1024 * 1024; // 5MB

// Create the upload directory if it doesn't exist
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        logError("Error: Failed to create upload directory.");
        die("Error: Failed to create upload directory.");
    }
}

// Function to fetch username from fetchUser.php
function fetchUsername($sessionId) {
    $url = 'http://karnaliorganics.com/php/fetchUser.php?sessionId=' . urlencode($sessionId);
    $response = @file_get_contents($url);

    if ($response === FALSE) {
        logError("Error: Unable to fetch user details. Please check the URL or network connectivity.");
        die("Error: Unable to fetch user details. Please check the URL or network connectivity.");
    }

    $data = json_decode($response, true);

    if ($data === NULL) {
        logError("Error: Invalid JSON response.");
        die("Error: Invalid JSON response.");
    }

    if (isset($data['error'])) {
        logError("Error: " . $data['error']);
        die("Error: " . $data['error']);
    }

    return $data['username'] ?? '';
}

// Get session ID from cookie
$sessionId = isset($_COOKIE['user_login']) ? $_COOKIE['user_login'] : '';

if (empty($sessionId)) {
    logError("Error: User is not logged in.");
    die("Error: User is not logged in.");
}

// Fetch the username
$username = fetchUsername($sessionId);

if (empty($username)) {
    logError("Error: Unable to fetch username.");
    die("Error: Unable to fetch username.");
}

// Connect to the database
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    logError("Connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

// Check if a file was uploaded
if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profilePic']['tmp_name'];
    $fileName = $_FILES['profilePic']['name'];
    $fileSize = $_FILES['profilePic']['size'];
    $fileType = $_FILES['profilePic']['type'];
    
    // Validate file type
    if (!in_array($fileType, $allowedTypes)) {
        logError("Error: Invalid file type. Only JPEG, PNG, and JPG files are allowed.");
        die("Error: Invalid file type. Only JPEG, PNG, and JPG files are allowed.");
    }

    // Validate file size
    if ($fileSize > $maxFileSize) {
        logError("Error: File size exceeds the maximum allowed size of 5MB.");
        die("Error: File size exceeds the maximum allowed size of 5MB.");
    }

    // Create a new file name based on the username
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = $username . '_pfp.' . $fileExtension;
    $uploadFilePath = $uploadDir . $newFileName;

    // Move the uploaded file to the destination directory
    if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
        // Check if the username exists in the database
        $checkSql = "SELECT COUNT(*) FROM address_details WHERE username = ?";
        $stmt = $conn->prepare($checkSql);
        if ($stmt === FALSE) {
            logError("Error: " . $conn->error);
            die("Error: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            // Update the existing record
            $updateSql = "UPDATE address_details SET pfp = ? WHERE username = ?";
            $stmt = $conn->prepare($updateSql);
            if ($stmt === FALSE) {
                logError("Error: " . $conn->error);
                die("Error: " . $conn->error);
            }
            $stmt->bind_param("ss", $uploadFilePath, $username);
        } else {
            // Insert a new record
            $insertSql = "INSERT INTO address_details (username, pfp) VALUES (?, ?)";
            $stmt = $conn->prepare($insertSql);
            if ($stmt === FALSE) {
                logError("Error: " . $conn->error);
                die("Error: " . $conn->error);
            }
            $stmt->bind_param("ss", $username, $uploadFilePath);
        }

        if ($stmt->execute()) {
            header("Location: profile.php");
        } else {
            logError("Error: " . $stmt->error);
            die("Error: " . $stmt->error);
        }

        $stmt->close();
    } else {
        logError("Error: There was a problem uploading the file.");
        die("Error: There was a problem uploading the file.");
    }
} else {
    logError("Error: No file was uploaded or there was an upload error.");
    die("Error: No file was uploaded or there was an upload error.");
}

// Close the database connection
$conn->close();
?>
