<?php
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
        if (filter_var($memberId, FILTER_VALIDATE_EMAIL)) {
            $user->email = $memberId;
        } else {
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

                if ($user->role === 'admin') {
                    header("Location: /dashboard");
                } else {
                    header("Location: /partner");
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
require_once __DIR__ . '/../includes/header.php';
?>
<?php if ($isLoggedIn ?? false): ?>
    <section class="partner-dashboard-section">
        <div class="container">
            <div class="partner-dashboard-wrapper">
                <div class="partner-welcome">
                    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
                    <p>Select your partner type to get started</p>
                </div>

                <div class="partner-type-grid">
                    <div class="partner-type-card">
                        <div class="partner-type-icon">🏋️</div>
                        <h3>Gym Partner</h3>
                        <p>Access gym management tools and equipment integration features</p>
                    </div>

                    <div class="partner-type-card">
                        <div class="partner-type-icon">🏃</div>
                        <h3>Trainer Partner</h3>
                        <p>Manage clients, create workout plans, and track progress</p>
                    </div>

                    <div class="partner-type-card">
                        <div class="partner-type-icon">⚙️</div>
                        <h3>Equipment Partner</h3>
                        <p>Integrate your fitness equipment with our platform</p>
                    </div>

                    <div class="partner-type-card">
                        <div class="partner-type-icon">📱</div>
                        <h3>App Developer</h3>
                        <p>Build apps using our API and SDK for sports and fitness</p>
                    </div>

                    <div class="partner-type-card">
                        <div class="partner-type-icon">🏢</div>
                        <h3>Enterprise Partner</h3>
                        <p>Large-scale solutions for corporate wellness programs</p>
                    </div>

                    <div class="partner-type-card">
                        <div class="partner-type-icon">🎯</div>
                        <h3>Sports Club</h3>
                        <p>Team management and performance tracking solutions</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>

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
                                required>
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
                                required>
                        </div>

                        <button type="submit" class="btn-primary btn-partner">
                            <?php echo SiteContent::getValue($db, 'partner.submit_button', 'Login'); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>