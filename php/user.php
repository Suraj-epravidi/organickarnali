<?php


// Check if the cookie is set
if (isset($_COOKIE['user_login'])) {
    $cookie_value = $_COOKIE['user_login'];
} else {
    $cookie_value = null;
}

// Return the cookie value as a JSON response
echo json_encode(['cookieValue' => $cookie_value]);
?>
