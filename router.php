<?php
/**
 * Main Router
 * Handles all URL routing and access control
 */

// Start session
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/models/SiteContent.php';

// Get the route from the URL
$route = $_GET['route'] ?? '';
$route = trim($route, '/');

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Check authentication status
$isLoggedIn = isLoggedIn();
$username = getCurrentUsername();
$userRole = getCurrentUserRole();

// Define routes
$routes = [
    // Public routes
    '' => ['view' => 'views/home.php', 'auth' => false],
    'home' => ['view' => 'views/home.php', 'auth' => false],
    'about' => ['view' => 'views/about.php', 'auth' => false],
    'partner' => ['view' => 'views/partner.php', 'auth' => false],
    'contact' => ['view' => 'views/contact.php', 'auth' => false],
    'login' => ['view' => 'views/login.php', 'auth' => false, 'guest_only' => true],
    'signup' => ['view' => 'views/signup.php', 'auth' => false, 'guest_only' => true],
    'logout' => ['view' => 'views/logout.php', 'auth' => true],

    // Admin routes
    'dashboard' => ['view' => 'views/admin/dashboard.php', 'auth' => true, 'role' => 'admin'],
    'dashboard/users' => ['view' => 'views/admin/users.php', 'auth' => true, 'role' => 'admin'],
    'dashboard/content' => ['view' => 'views/admin/content.php', 'auth' => true, 'role' => 'admin'],
];

// Check if route exists
if (!array_key_exists($route, $routes)) {
    // 404 - Route not found
    http_response_code(404);
    require_once __DIR__ . '/pages/404.php';
    exit();
}

$currentRoute = $routes[$route];

// Check if route requires authentication
if ($currentRoute['auth'] && !$isLoggedIn) {
    header("Location: /login");
    exit();
}

// Check if route is guest only (redirect if already logged in)
if (isset($currentRoute['guest_only']) && $currentRoute['guest_only'] && $isLoggedIn) {
    header("Location: /");
    exit();
}

// Check if route requires specific role
if (isset($currentRoute['role'])) {
    if ($userRole !== $currentRoute['role']) {
        // Access denied
        http_response_code(403);
        header("Location: /");
        exit();
    }
}

// Load the view
$viewFile = __DIR__ . '/' . $currentRoute['view'];
if (file_exists($viewFile)) {
    require_once $viewFile;
} else {
    // View file not found
    http_response_code(500);
    require_once __DIR__ . '/pages/500.php';
    exit();
}
?>
