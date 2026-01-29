<?php
/**
 * Main Entry Point
 * Loads the router for proper routing
 */

// If accessed directly via index.php, extract route from REQUEST_URI
if (!isset($_GET['route']) && isset($_SERVER['REQUEST_URI'])) {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $requestUri = str_replace('/index.php', '', $requestUri);
    $requestUri = trim($requestUri, '/');
    $_GET['route'] = $requestUri;
}

require_once __DIR__ . '/router.php';
?>
