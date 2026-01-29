<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/models/SiteContent.php';

$route = $_GET['route'] ?? '';
$route = trim($route, '/');

$database = new Database();
$db = $database->getConnection();

$isLoggedIn = isLoggedIn();
$username = getCurrentUsername();
$userRole = getCurrentUserRole();

$routes = [
    '' => ['view' => 'views/home.php', 'auth' => false],
    'home' => ['view' => 'views/home.php', 'auth' => false],
    'about' => ['view' => 'views/about.php', 'auth' => false],
    'partner' => ['view' => 'views/partner.php', 'auth' => false],
    'contact' => ['view' => 'views/contact.php', 'auth' => false],
    'login' => ['view' => 'views/login.php', 'auth' => false, 'guest_only' => true],
    'signup' => ['view' => 'views/signup.php', 'auth' => false, 'guest_only' => true],
    'logout' => ['view' => 'views/logout.php', 'auth' => true],

    'dashboard' => ['view' => 'views/admin/dashboard.php', 'auth' => true, 'role' => 'admin'],
    'dashboard/users' => ['view' => 'views/admin/users.php', 'auth' => true, 'role' => 'admin'],
    'dashboard/content' => ['view' => 'views/admin/content.php', 'auth' => true, 'role' => 'admin'],
];

if (!array_key_exists($route, $routes)) {
    http_response_code(404);
    require_once __DIR__ . '/pages/404.php';
    exit();
}

$currentRoute = $routes[$route];

if ($currentRoute['auth'] && !$isLoggedIn) {
    header("Location: /login");
    exit();
}

if (isset($currentRoute['guest_only']) && $currentRoute['guest_only'] && $isLoggedIn) {
    header("Location: /");
    exit();
}

if (isset($currentRoute['role'])) {
    if ($userRole !== $currentRoute['role']) {
        http_response_code(403);
        header("Location: /");
        exit();
    }
}

$viewFile = __DIR__ . '/' . $currentRoute['view'];
if (file_exists($viewFile)) {
    require_once $viewFile;
} else {
    http_response_code(500);
    require_once __DIR__ . '/pages/500.php';
    exit();
}
?>
