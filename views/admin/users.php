<?php
/**
 * Admin Users View
 * Contains only the main content
 */

require_once __DIR__ . '/../../models/User.php';

// Require admin access
requireAdmin();

$user = new User($db);

$success = '';
$error = '';

// Handle user deletion
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    
    // Prevent admin from deleting themselves
    if ($delete_id != getCurrentUserId()) {
        $user->id = $delete_id;
        if ($user->delete()) {
            $success = 'User deleted successfully';
        } else {
            $error = 'Failed to delete user';
        }
    } else {
        $error = 'You cannot delete your own account';
    }
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $user_id = (int)$_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    $user->id = $user_id;
    $user->username = $username;
    $user->email = $email;
    $user->role = $role;
    
    if ($user->update()) {
        $success = 'User updated successfully';
    } else {
        $error = 'Failed to update user';
    }
}

// Get all users
$all_users = $user->getAllUsers();

$pageTitle = 'User Management - MAX1ON1FITNESS';
$currentAdminPage = 'users';
$pageHeading = 'User Management';
$currentUsername = getCurrentUsername();

// Include admin header
require_once __DIR__ . '/../../includes/admin-header.php';
?>

<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    
    .modal.active {
        display: flex;
    }
    
    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        max-width: 500px;
        width: 90%;
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
</style>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<!-- Users Table -->
<div class="content-card">
    <div class="content-card-header">
        <h2 class="content-card-title">All Users (<?php echo count($all_users); ?>)</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($all_users)): ?>
                <?php foreach ($all_users as $u): ?>
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
                        <td>
                            <div class="action-buttons">
                                <button onclick="editUser(<?php echo htmlspecialchars(json_encode($u)); ?>)" class="btn btn-secondary btn-sm">Edit</button>
                                <?php if ($u['id'] != getCurrentUserId()): ?>
                                    <a href="?delete=<?php echo $u['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')" class="btn btn-danger btn-sm">Delete</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #666;">
                        No users found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Edit User Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit User</h2>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="user_id" id="edit_user_id">
            
            <div class="form-group">
                <label for="edit_username">Username</label>
                <input type="text" class="form-control" id="edit_username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="edit_email">Email</label>
                <input type="email" class="form-control" id="edit_email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="edit_role">Role</label>
                <select class="form-control" id="edit_role" name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editUser(user) {
        document.getElementById('edit_user_id').value = user.id;
        document.getElementById('edit_username').value = user.username;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('editModal').classList.add('active');
    }
    
    function closeModal() {
        document.getElementById('editModal').classList.remove('active');
    }
    
    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>

<?php
// Include admin footer
require_once __DIR__ . '/../../includes/admin-footer.php';
?>
