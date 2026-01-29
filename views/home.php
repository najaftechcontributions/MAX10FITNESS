<?php
/**
 * Home Page View
 * Contains only the main content - header and footer are included separately
 */

$pageTitle = SiteContent::getValue($db, 'home.page.title', 'MAX1ON1FITNESS - Multi-Device Sports & Fitness Solutions');
$pageDescription = SiteContent::getValue($db, 'home.hero.description', 'Multi-device software and hardware solutions for the sports industry');
$currentPage = 'home';

// Include header
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section-home">
    <div class="hero-background">
        <div class="hero-orb orb-1"></div>
        <div class="hero-orb orb-2"></div>
        <div class="hero-orb orb-3"></div>
    </div>
    
    <div class="container">
        <div class="hero-content-home">
            <div class="hero-text-home">
                <h1 class="hero-title-home">
                    <?php echo SiteContent::getValue($db, 'home.hero.title', 'MAX1ON1FITNESS'); ?>
                </h1>
                <p class="hero-description-home">
                    <?php echo SiteContent::getValue($db, 'home.hero.description', 'MAX1on1Fitness is a one-stop shop for multi-device software and hardware solutions for the sports industry, from integrated Bluetooth apps to multi-function full-workout apps that track a host of metrics across a variety of workouts, including weight training, boxing, and aerobics, and everything in between. From third-party product design to our own creations, we can build bespoke multi-device apps from scratch, tailored to any kind of sports or fitness training.'); ?>
                </p>
            </div>
            
            <div class="hero-images-home">
                <div class="image-grid-home">
                    <div class="home-image-card">
                        <img src="" alt="Sports Software Dashboard" class="home-product-image">
                        <p class="image-caption">Sports Software</p>
                    </div>
                    <div class="home-image-card">
                        <img src="" alt="Wearable Heart Rate Monitor" class="home-product-image">
                        <p class="image-caption">Heart Rate Monitor</p>
                    </div>
                    <div class="home-image-card">
                        <img src="" alt="Cycling Monitor Device" class="home-product-image">
                        <p class="image-caption">Cycling Monitor</p>
                    </div>
                    <div class="home-image-card">
                        <img src="" alt="Workout Tracker App" class="home-product-image">
                        <p class="image-caption">Workout Tracker</p>
                    </div>
                    <div class="home-image-card">
                        <img src="" alt="Fitness Tracking Device" class="home-product-image">
                        <p class="image-caption">Workout Monitor</p>
                    </div>
                    <div class="home-image-card">
                        <img src="" alt="Multi-Device Fitness App" class="home-product-image">
                        <p class="image-caption">Multi-Device App</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
require_once __DIR__ . '/../includes/footer.php';
?>
