<?php
// Database connection
$servername = "localhost";
$username = "karnalio_admin"; // replace with your database username
$password = "NATRqydFf-EX"; // replace with your database password
$dbname = "karnalio_data"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form data
$user_email = $_POST['email'];
$user_password = $_POST['password'];

// Validate form data
if (empty($user_email) || empty($user_password)) {
    die("Both email and password are required.");
}

if ($user_email == 'admin@karnali.com' && $user_password == 'adminkarnali') {
    $cookie_name = "admin_login";
    $cookie_value = 'adminkarnali';
    setcookie($cookie_name, $cookie_value, time() + (1 * 60 * 60), "/", ".karnaliorganics.com", true, true);
    header("Location: https://panel.karnaliorganics.com");
    exit;
}

// Check if email exists
$sql = "SELECT id, email, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    die("Invalid email.");
}

$stmt->bind_result($id, $email, $hashed_password);
$stmt->fetch();

// Verify password
if (password_verify($user_password, $hashed_password)) {
    // Start a new session and set session variables
    session_start();
    $_SESSION['user_id'] = $id;
    $_SESSION['email'] = $email;

    // Generate a new session ID if it doesn't exist and set the cookie value
    if (!isset($_COOKIE['user_login'])) {
        session_regenerate_id();
        $session_id = session_id();
        setcookie('user_login', $session_id, time() + (1 * 60 * 60), "/", ".karnaliorganics.com", true, true);
    } else {
        $session_id = $_COOKIE['user_login'];
    }

    // Insert or update the user's session_id in the cookie table
    $insert_sql = "INSERT INTO cookie (session_id, email) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ss", $session_id, $user_email);
    $insert_stmt->execute();
    $insert_stmt->close();

    header("Location: https://karnaliorganics.com");
    exit;
} else {
    echo "Invalid password.";
}

$stmt->close();
$conn->close();
?>
