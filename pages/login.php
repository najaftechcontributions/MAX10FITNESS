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
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        
        $user->email = $email;
        
        if ($user->emailExists()) {
            if ($user->verifyPassword($password)) {
                setUserSession($user->id, $user->username, $user->email, $user->role);

                // Redirect based on role
                if ($user->role === 'admin') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            } else {
                $error = 'Invalid email or password';
            }
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SiteContent::getValue($db, 'login.page.title', 'Login - MAX1ON1FITNESS'); ?></title>
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
                    <div class="feature-icon">📱</div>
                    <h3>Integrated Bluetooth Apps</h3>
                    <p>Seamless connectivity across all your devices</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⌚</div>
                    <h3>Wearable Heart Rate Monitors</h3>
                    <p>Track your performance in real-time</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🚴</div>
                    <h3>Cycling & Workout Trackers</h3>
                    <p>Comprehensive metrics for every activity</p>
                </div>
            </div>
        </div>
        
        <div class="auth-right">
            <div class="auth-form-wrapper">
                <div class="auth-header">
                    <h2><?php echo SiteContent::getValue($db, 'login.form.heading', 'Welcome Back'); ?></h2>
                    <p><?php echo SiteContent::getValue($db, 'login.form.subheading', 'Login to your account'); ?></p>
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
                        <label for="email"><?php echo SiteContent::getValue($db, 'login.form.email_label', 'Email Address'); ?></label>
                        <input type="email" id="email" name="email" placeholder="your@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password"><?php echo SiteContent::getValue($db, 'login.form.password_label', 'Password'); ?></label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn-primary">
                        <span><?php echo SiteContent::getValue($db, 'login.form.submit_button', 'Login'); ?></span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>

                <div class="auth-footer">
                    <p><?php echo SiteContent::getValue($db, 'login.form.signup_link_text', 'Don\'t have an account?'); ?> <a href="signup.php"><?php echo SiteContent::getValue($db, 'login.form.signup_link', 'Sign Up'); ?></a></p>
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
