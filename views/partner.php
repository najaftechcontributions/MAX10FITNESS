<?php
/**
 * Partner Login Page View
 * Technical partnership login page
 */

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once __DIR__ . '/../models/User.php';
    
    $memberId = $_POST['member_id'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($memberId) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $user = new User($db);
        // Check if member_id is email or username
        if (filter_var($memberId, FILTER_VALIDATE_EMAIL)) {
            $user->email = $memberId;
        } else {
            // Try to find user by username
            $stmt = $db->prepare("SELECT email FROM users WHERE username = ?");
            $stmt->execute([$memberId]);
            $result = $stmt->fetch();
            if ($result) {
                $user->email = $result['email'];
            } else {
                $error = 'Invalid member ID or password';
            }
        }
        
        if (!$error && $user->emailExists()) {
            if ($user->verifyPassword($password)) {
                setUserSession($user->id, $user->username, $user->email, $user->role);

                // Redirect based on role
                if ($user->role === 'admin') {
                    header("Location: /dashboard");
                } else {
                    header("Location: /");
                }
                exit();
            } else {
                $error = 'Invalid member ID or password';
            }
        } else if (!$error) {
            $error = 'Invalid member ID or password';
        }
    }
}

$pageTitle = SiteContent::getValue($db, 'partner.page.title', 'Partner Login - MAX1ON1FITNESS');
$currentPage = 'partner';

// Include header
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Partner Login Section -->
<section class="partner-login-section">
    <div class="container">
        <div class="partner-login-wrapper">
            <div class="partner-header">
                <h1 class="partner-heading">
                    <?php echo SiteContent::getValue($db, 'partner.heading', 'Welcome MAX1ON1FITNESS Technical Partnership Page'); ?>
                </h1>
                <p class="partner-subheading">
                    <?php echo SiteContent::getValue($db, 'partner.subheading', 'Please log in below'); ?>
                </p>
            </div>

            <div class="partner-form-container">
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <span>⚠️</span> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <span>✓</span> <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="partner-form">
                    <div class="form-group">
                        <label for="member_id" class="form-label-partner">
                            <?php echo SiteContent::getValue($db, 'partner.member_id_label', 'MEMBER ID'); ?>
                        </label>
                        <input 
                            type="text" 
                            id="member_id" 
                            name="member_id" 
                            class="form-control" 
                            placeholder="Enter your member ID" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label-partner">
                            <?php echo SiteContent::getValue($db, 'partner.password_label', 'PASSWORD'); ?>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control" 
                            placeholder="Enter your password" 
                            required
                        >
                    </div>

                    <button type="submit" class="btn-primary btn-partner">
                        <?php echo SiteContent::getValue($db, 'partner.submit_button', 'Login'); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
require_once __DIR__ . '/../includes/footer.php';
?>
