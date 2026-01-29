<?php
require_once '../includes/session.php';
require_once '../config/Database.php';
require_once '../models/User.php';

// Require admin access
requireAdmin();

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Get statistics
$stats = [
    'total_users' => 0,
    'admin_users' => 0,
    'regular_users' => 0,
    'recent_users' => 0
];

try {
    // Total users
    $stmt = $db->query("SELECT COUNT(*) as count FROM users");
    $stats['total_users'] = $stmt->fetch()['count'];
    
    // Admin users
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
    $stats['admin_users'] = $stmt->fetch()['count'];
    
    // Regular users
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
    $stats['regular_users'] = $stmt->fetch()['count'];
    
    // Recent users (last 7 days)
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stats['recent_users'] = $stmt->fetch()['count'];
    
    // Recent users list
    $stmt = $db->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 5");
    $recent_users = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

$currentUsername = getCurrentUsername();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MAX1ON1FITNESS</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
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
                        <a href="dashboard.php" class="active">
                            <span class="admin-menu-icon">📊</span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="users.php">
                            <span class="admin-menu-icon">👥</span>
                            <span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="content.php">
                            <span class="admin-menu-icon">📝</span>
                            <span>Content</span>
                        </a>
                    </li>
                    <li>
                        <a href="../pages/home.php">
                            <span class="admin-menu-icon">🏠</span>
                            <span>View Site</span>
                        </a>
                    </li>
                    <li>
                        <a href="../pages/logout.php">
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
                <h1>Dashboard</h1>
                <div class="admin-user-info">
                    <div class="admin-user-avatar"><?php echo strtoupper(substr($currentUsername, 0, 1)); ?></div>
                    <span><?php echo htmlspecialchars($currentUsername); ?></span>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Total Users</span>
                        <div class="stat-card-icon blue">👥</div>
                    </div>
                    <div class="stat-card-value"><?php echo $stats['total_users']; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Admin Users</span>
                        <div class="stat-card-icon purple">👑</div>
                    </div>
                    <div class="stat-card-value"><?php echo $stats['admin_users']; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Regular Users</span>
                        <div class="stat-card-icon green">👤</div>
                    </div>
                    <div class="stat-card-value"><?php echo $stats['regular_users']; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">New (Last 7 Days)</span>
                        <div class="stat-card-icon orange">📈</div>
                    </div>
                    <div class="stat-card-value"><?php echo $stats['recent_users']; ?></div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="content-card">
                <div class="content-card-header">
                    <h2 class="content-card-title">Recent Users</h2>
                    <a href="users.php" class="btn btn-primary btn-sm">View All</a>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php else: ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_users)): ?>
                                <?php foreach ($recent_users as $u): ?>
                                    <tr>
                                        <td>#<?php echo $u['id']; ?></td>
                                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $u['role']; ?>">
                                                <?php echo ucfirst($u['role']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($u['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 2rem; color: #666;">
                                        No users found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
