<?php
// Configure session settings
if (session_status() === PHP_SESSION_NONE) {
    // Set session cookie parameters for better compatibility
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => $cookieParams['lifetime'],
        'path' => '/',
        'domain' => '', // Empty to use current domain
        'secure' => false, // Set to true if using HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();

    // Regenerate session ID on login to prevent session fixation
    if (!isset($_SESSION['initiated'])) {
        session_regenerate_id(true);
        $_SESSION['initiated'] = true;
    }
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Get current user ID
function getCurrentUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

// Get current username
function getCurrentUsername() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

// Get current user role
function getCurrentUserRole() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}

// Check if current user is admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Set user session
function setUserSession($user_id, $username, $email, $role = 'user') {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;
}

// Destroy user session
function destroyUserSession() {
    session_unset();
    session_destroy();
}

// Require login
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: /login");
        exit();
    }
}

// Require admin
function requireAdmin() {
    if (!isLoggedIn()) {
        header("Location: /login");
        exit();
    }
    if (!isAdmin()) {
        header("Location: /");
        exit();
    }
}
?>
