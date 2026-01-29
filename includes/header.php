<?php
if (!isset($db)) {
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/SiteContent.php';
    $database = new Database();
    $db = $database->getConnection();
}

$pageTitle = $pageTitle ?? 'MAX1ON1FITNESS - Multi-Device Sports & Fitness Solutions';
$pageDescription = $pageDescription ?? 'Multi-device software and hardware solutions for the sports industry';
$currentPage = $currentPage ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="/" class="logo"><?php echo SiteContent::getValue($db, 'header.brand', 'MAX1ON1'); ?><span>FITNESS</span></a>

                <ul class="nav-menu">
                    <li><a href="/" class="nav-link <?php echo $currentPage === 'home' ? 'active' : ''; ?>"><?php echo SiteContent::getValue($db, 'header.nav.home', 'Home'); ?></a></li>
                    <li><a href="/about" class="nav-link <?php echo $currentPage === 'about' ? 'active' : ''; ?>"><?php echo SiteContent::getValue($db, 'header.nav.about', 'About'); ?></a></li>
                    <li><a href="/partner" class="nav-link <?php echo $currentPage === 'partner' ? 'active' : ''; ?>"><?php echo SiteContent::getValue($db, 'header.nav.partner', 'Partner'); ?></a></li>
                    <li><a href="/contact" class="nav-link <?php echo $currentPage === 'contact' ? 'active' : ''; ?>"><?php echo SiteContent::getValue($db, 'header.nav.contact', 'Contact'); ?></a></li>
                </ul>

                <div class="nav-actions">
                    <?php if ($isLoggedIn ?? false): ?>
                        <span class="user-greeting">Hi, <?php echo htmlspecialchars($username ?? 'User'); ?>!</span>
                        <?php if (isAdmin()): ?>
                            <a href="/dashboard" class="btn-outline">Admin</a>
                        <?php endif; ?>
                        <a href="/logout" class="btn-outline">Logout</a>
                    <?php else: ?>
                        <a href="/login" class="btn-outline"><?php echo SiteContent::getValue($db, 'header.login_button', 'Login'); ?></a>
                        <a href="/signup" class="btn-gradient"><?php echo SiteContent::getValue($db, 'header.signup_button', 'Get Started'); ?></a>
                    <?php endif; ?>
                </div>

                <div class="mobile-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <div id="main-content">
