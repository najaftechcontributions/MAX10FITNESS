<?php
/**
 * About Page View
 * Contains business concept and products/services information
 */

$pageTitle = SiteContent::getValue($db, 'about.page.title', 'About Us - MAX1ON1FITNESS');
$pageDescription = 'Learn about our AI & VR-based fitness application and business concept';
$currentPage = 'about';

// Include header
require_once __DIR__ . '/../includes/header.php';
?>

<!-- About Hero Section -->
<section class="about-hero-section">
    <div class="container">
        <div class="page-header-about">
            <h1 class="page-title-about">About MAX1ON1FITNESS</h1>
            <p class="page-subtitle-about">Revolutionizing fitness through AI and Virtual Reality</p>
        </div>
    </div>
</section>

<!-- Business Concept Section -->
<section class="business-concept-section">
    <div class="container">
        <div class="content-layout-about">
            <div class="content-text-about">
                <h2 class="section-heading-about">
                    <?php echo SiteContent::getValue($db, 'about.business.heading', 'Our Business Concept'); ?>
                </h2>
                <p class="section-description-about">
                    <?php echo SiteContent::getValue($db, 'about.business.description', 'Max 1ON1 Fitness is developing an AI & Virtual Reality-based fitness application (AV Fitness App) that enables remote fitness coaching through VR devices, combined with an AI assessment module for real-time monitoring, technique correction, and personalised programming. The product bridges immersive VR experiences with data-driven coaching to deliver scalable, engaging, and effective fitness training for individuals and organisations.'); ?>
                </p>
            </div>
            <div class="content-images-about">
                <div class="image-stack-about">
                    <div class="about-image-card">
                        <img src="/assets/images/aifitness.jpg" alt="Male athlete training" class="about-training-image">
                    </div>
                    <div class="about-image-card">
                        <img src="/assets/images/vrfitness.jpg" alt="Male fitness training session" class="about-training-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products/Services Section -->
<section class="products-services-section">
    <div class="container">
        <div class="content-layout-about reverse">
            <div class="content-images-about">
                <div class="image-stack-about">
                    <div class="about-image-card">
                        <img src="/assets/images/sportssoftware.webp" alt="Sports software interface" class="about-training-image">
                    </div>
                    <div class="about-image-card">
                        <img src="/assets/images/heartratemonitor.webp" alt="Female athlete in sportswear training" class="about-training-image">
                    </div>
                    <div class="about-image-card">
                        <img src="/assets/images/cyclingmonitor.webp" alt="Fitness device and technology" class="about-training-image">
                    </div>
                </div>
            </div>
            <div class="content-text-about">
                <h2 class="section-heading-about">
                    <?php echo SiteContent::getValue($db, 'about.products.heading', 'Our Products/Services'); ?>
                </h2>
                <p class="section-description-about">
                    <?php echo SiteContent::getValue($db, 'about.products.description', 'The AV Fitness App delivers multi-module fitness coaching (strength, cardio, mobility, sports-specific drills) via downloadable applications for PC, laptop, and mobile devices, with cloud and local storage options. Core features include VR coaching sessions, AI motion analysis and feedback, real-time correction prompts, session recording, performance analytics, and integration APIs for training centres and institutional use.'); ?>
                </p>
                
                <div class="features-list-about">
                    <div class="feature-item-about">
                        <div class="feature-icon-about">✓</div>
                        <div class="feature-text-about">
                            <h4>VR Coaching Sessions</h4>
                            <p>Immersive virtual reality training experiences</p>
                        </div>
                    </div>
                    <div class="feature-item-about">
                        <div class="feature-icon-about">✓</div>
                        <div class="feature-text-about">
                            <h4>AI Motion Analysis</h4>
                            <p>Real-time technique correction and feedback</p>
                        </div>
                    </div>
                    <div class="feature-item-about">
                        <div class="feature-icon-about">✓</div>
                        <div class="feature-text-about">
                            <h4>Performance Analytics</h4>
                            <p>Comprehensive session recording and reporting</p>
                        </div>
                    </div>
                    <div class="feature-item-about">
                        <div class="feature-icon-about">✓</div>
                        <div class="feature-text-about">
                            <h4>Integration APIs</h4>
                            <p>Seamless integration for training centres</p>
                        </div>
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
