<?php
require_once '../includes/session.php';
require_once '../config/Database.php';
require_once '../models/User.php';
require_once '../models/SiteContent.php';

$error = '';
$success = '';

// Get database connection for content
$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long';
    } else {
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        
        $user->username = $username;
        $user->email = $email;
        
        if ($user->emailExists()) {
            $error = 'Email already registered';
        } else {
            $user->password = $password;
            if ($user->create()) {
                $success = 'Account created successfully! Redirecting to login...';
                header("refresh:2;url=login.php");
            } else {
                $error = 'Unable to create account. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SiteContent::getValue($db, 'signup.page.title', 'Sign Up - MAX1ON1FITNESS'); ?></title>
    <link rel="stylesheet" href="../assets/css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-left">
            <div class="brand-section">
                <h1 class="brand-logo">MAX1ON1<span>FITNESS</span></h1>
                <p class="brand-tagline">Multi-Device Sports & Fitness Solutions</p>
            </div>
            <div class="feature-showcase">
                <div class="feature-item">
                    <div class="feature-icon">💪</div>
                    <h3>Weight Training Tracker</h3>
                    <p>Monitor your strength gains</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🥊</div>
                    <h3>Boxing Metrics</h3>
                    <p>Track punches, speed, and power</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🏃</div>
                    <h3>Aerobics & Cardio</h3>
                    <p>Complete workout analytics</p>
                </div>
            </div>
        </div>
        
        <div class="auth-right">
            <div class="auth-form-wrapper">
                <div class="auth-header">
                    <h2><?php echo SiteContent::getValue($db, 'signup.form.heading', 'Create Account'); ?></h2>
                    <p><?php echo SiteContent::getValue($db, 'signup.form.subheading', 'Join MAX1ON1FITNESS today'); ?></p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <span>⚠️</span> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <span>✓</span> <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="auth-form">
                    <div class="form-group">
                        <label for="username"><?php echo SiteContent::getValue($db, 'signup.form.username_label', 'Username'); ?></label>
                        <input type="text" id="username" name="username" placeholder="Choose a username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="email"><?php echo SiteContent::getValue($db, 'signup.form.email_label', 'Email Address'); ?></label>
                        <input type="email" id="email" name="email" placeholder="your@email.com" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password"><?php echo SiteContent::getValue($db, 'signup.form.password_label', 'Password'); ?></label>
                        <input type="password" id="password" name="password" placeholder="Create a password (min. 6 characters)" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password"><?php echo SiteContent::getValue($db, 'signup.form.confirm_password_label', 'Confirm Password'); ?></label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" required>
                            <span>I agree to the Terms & Conditions</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary">
                        <span><?php echo SiteContent::getValue($db, 'signup.form.submit_button', 'Create Account'); ?></span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>

                <div class="auth-footer">
                    <p><?php echo SiteContent::getValue($db, 'signup.form.login_link_text', 'Already have an account?'); ?> <a href="login.php"><?php echo SiteContent::getValue($db, 'signup.form.login_link', 'Login'); ?></a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="animated-background">
        <div class="gradient-orb orb-1"></div>
        <div class="gradient-orb orb-2"></div>
        <div class="gradient-orb orb-3"></div>
    </div>
</body>
</html>
