<?php
require_once __DIR__ . '/../../models/User.php';

requireAdmin();

$user = new User($db);

// Get statistics
$stats = [
    'total_users' => 0,
    'admin_users' => 0,
    'regular_users' => 0,
    'recent_users' => 0
];

try {
    $stmt = $db->query("SELECT COUNT(*) as count FROM users");
    $stats['total_users'] = $stmt->fetch()['count'];
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
    $stats['admin_users'] = $stmt->fetch()['count'];
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
    $stats['regular_users'] = $stmt->fetch()['count'];
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stats['recent_users'] = $stmt->fetch()['count'];
    
    $stmt = $db->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 5");
    $recent_users = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

$pageTitle = 'Admin Dashboard - MAX1ON1FITNESS';
$currentAdminPage = 'dashboard';
$pageHeading = 'Dashboard';
$currentUsername = getCurrentUsername();

require_once __DIR__ . '/../../includes/admin-header.php';
?>
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
<div class="content-card">
    <div class="content-card-header">
        <h2 class="content-card-title">Recent Users</h2>
        <a href="/dashboard/users" class="btn btn-primary btn-sm">View All</a>
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

<?php require_once __DIR__ . '/../../includes/admin-footer.php'; ?>
