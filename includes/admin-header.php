<?php
/**
 * Admin Header File
 * Contains HTML head, body start, and admin navigation
 */

// Ensure session is available
if (!isset($currentUsername)) {
    $currentUsername = getCurrentUsername();
}

// Get page-specific variables
$pageTitle = $pageTitle ?? 'Admin Dashboard - MAX1ON1FITNESS';
$currentAdminPage = $currentAdminPage ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <h2>MAX1ON1FITNESS</h2>
                <p>Admin Panel</p>
            </div>
            <nav>
                <ul class="admin-menu">
                    <li>
                        <a href="/dashboard" class="<?php echo $currentAdminPage === 'dashboard' ? 'active' : ''; ?>">
                            <span class="admin-menu-icon">📊</span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/users" class="<?php echo $currentAdminPage === 'users' ? 'active' : ''; ?>">
                            <span class="admin-menu-icon">👥</span>
                            <span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/content" class="<?php echo $currentAdminPage === 'content' ? 'active' : ''; ?>">
                            <span class="admin-menu-icon">📝</span>
                            <span>Content</span>
                        </a>
                    </li>
                    <li>
                        <a href="/">
                            <span class="admin-menu-icon">🏠</span>
                            <span>View Site</span>
                        </a>
                    </li>
                    <li>
                        <a href="/logout">
                            <span class="admin-menu-icon">🚪</span>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <h1><?php echo $pageHeading ?? 'Dashboard'; ?></h1>
                <div class="admin-user-info">
                    <div class="admin-user-avatar"><?php echo strtoupper(substr($currentUsername, 0, 1)); ?></div>
                    <span><?php echo htmlspecialchars($currentUsername); ?></span>
                </div>
            </div>

            <!-- Admin Main Content Container -->
            <div id="admin-main-content">
