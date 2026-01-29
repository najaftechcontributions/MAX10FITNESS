<?php
/**
 * Home Page View
 * Contains only the main content - header and footer are included separately
 */

$pageTitle = SiteContent::getValue($db, 'home.hero.title', 'MAX1ON1FITNESS - Multi-Device Sports & Fitness Solutions');
$pageDescription = SiteContent::getValue($db, 'home.hero.subtitle', 'Multi-device software and hardware solutions for the sports industry');
$currentPage = 'home';

// Include header
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Hero Section -->
<section id="home" class="hero-section">
    <div class="hero-background">
        <div class="hero-orb orb-1"></div>
        <div class="hero-orb orb-2"></div>
        <div class="hero-orb orb-3"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    <?php echo SiteContent::getValue($db, 'home.hero.title', 'Multi-Device Sports & Fitness Solutions'); ?>
                </h1>
                <p class="hero-description">
                    <?php echo SiteContent::getValue($db, 'home.hero.subtitle', 'From integrated Bluetooth apps to multi-function full-workout trackers, we deliver bespoke software and hardware solutions for the sports industry.'); ?>
                </p>
                <div class="hero-cta">
                    <a href="#products" class="btn-primary"><?php echo SiteContent::getValue($db, 'home.hero.cta_button', 'Get Started'); ?></a>
                    <a href="#features" class="btn-secondary">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M8 5V19M8 19L12 15M8 19L4 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="16" cy="12" r="6" stroke="currentColor" stroke-width="2"/>
                            <path d="M16 10V14M14 12H18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <?php echo SiteContent::getValue($db, 'home.hero.learn_more_button', 'Learn More'); ?>
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <h3>50+</h3>
                        <p>Device Types</p>
                    </div>
                    <div class="stat-item">
                        <h3>100K+</h3>
                        <p>Active Users</p>
                    </div>
                    <div class="stat-item">
                        <h3>24/7</h3>
                        <p>Support</p>
                    </div>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="device-showcase">
                    <div class="device-card device-1">
                        <div class="device-icon">⌚</div>
                        <h4>Heart Rate Monitor</h4>
                        <div class="device-pulse"></div>
                    </div>
                    <div class="device-card device-2">
                        <div class="device-icon">📱</div>
                        <h4>Mobile App</h4>
                        <div class="device-pulse"></div>
                    </div>
                    <div class="device-card device-3">
                        <div class="device-icon">🚴</div>
                        <h4>Cycling Tracker</h4>
                        <div class="device-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="products-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge"><?php echo SiteContent::getValue($db, 'home.products.heading', 'Our Solutions'); ?></span>
            <h2 class="section-title"><?php echo SiteContent::getValue($db, 'home.products.subheading', 'Innovative Fitness Technology'); ?></h2>
            <p class="section-description">
                Comprehensive hardware and software solutions designed for every sport and fitness activity
            </p>
        </div>

        <div class="products-grid">
            <div class="product-card">
                <div class="product-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3>Wearable Heart Rate Monitor</h3>
                <p>Real-time heart rate tracking with Bluetooth connectivity. Monitor your cardiovascular performance across all activities.</p>
                <ul class="product-features">
                    <li>ANT+ & Bluetooth support</li>
                    <li>24-hour battery life</li>
                    <li>Water-resistant design</li>
                </ul>
                <a href="#" class="product-link">Learn More →</a>
            </div>

            <div class="product-card featured">
                <div class="featured-badge">Popular</div>
                <div class="product-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <rect x="5" y="2" width="14" height="20" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 18H12.01M9 6H15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3>Integrated Bluetooth Apps</h3>
                <p>Multi-platform mobile applications that seamlessly connect with all your fitness devices and track comprehensive metrics.</p>
                <ul class="product-features">
                    <li>iOS & Android compatible</li>
                    <li>Cloud sync & backup</li>
                    <li>Advanced analytics dashboard</li>
                </ul>
                <a href="#" class="product-link">Learn More →</a>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <circle cx="6" cy="19" r="3" stroke="currentColor" stroke-width="2"/>
                        <circle cx="18" cy="19" r="3" stroke="currentColor" stroke-width="2"/>
                        <path d="M6 19V11L8 5H16L18 11V19M10 5V11M14 5V11" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3>Cycling Monitor</h3>
                <p>Track speed, distance, cadence, and power output. Perfect for road cycling, mountain biking, and indoor training.</p>
                <ul class="product-features">
                    <li>GPS tracking</li>
                    <li>Power meter integration</li>
                    <li>Route planning & navigation</li>
                </ul>
                <a href="#" class="product-link">Learn More →</a>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Full-Workout Tracker</h3>
                <p>Complete workout tracking for weight training, boxing, aerobics, and more. Log sets, reps, and performance metrics.</p>
                <ul class="product-features">
                    <li>Multi-sport support</li>
                    <li>Exercise library (500+)</li>
                    <li>Progress tracking & goals</li>
                </ul>
                <a href="#" class="product-link">Learn More →</a>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M7 10H11M7 14H11M15 10H17M15 14H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3>Sports Software Suite</h3>
                <p>Customizable software platform for gyms, trainers, and sports facilities. Manage clients, schedules, and performance data.</p>
                <ul class="product-features">
                    <li>Client management</li>
                    <li>Scheduling system</li>
                    <li>Analytics & reporting</li>
                </ul>
                <a href="#" class="product-link">Learn More →</a>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <path d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Bespoke Development</h3>
                <p>Custom multi-device apps built from scratch. Tailored solutions for any sport, fitness training, or wellness application.</p>
                <ul class="product-features">
                    <li>Custom UI/UX design</li>
                    <li>API integrations</li>
                    <li>White-label solutions</li>
                </ul>
                <a href="#" class="product-link">Learn More →</a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="features-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge"><?php echo SiteContent::getValue($db, 'home.features.heading', 'Why Choose Us'); ?></span>
            <h2 class="section-title"><?php echo SiteContent::getValue($db, 'home.features.subheading', 'Industry-Leading Technology'); ?></h2>
        </div>

        <div class="features-grid">
            <div class="feature-box">
                <div class="feature-number">01</div>
                <h3><?php echo SiteContent::getValue($db, 'home.features.item1.title', 'Multi-Device Support'); ?></h3>
                <p><?php echo SiteContent::getValue($db, 'home.features.item1.description', 'Works seamlessly across smartphones, tablets, and wearables'); ?></p>
            </div>
            <div class="feature-box">
                <div class="feature-number">02</div>
                <h3><?php echo SiteContent::getValue($db, 'home.features.item2.title', 'Real-Time Tracking'); ?></h3>
                <p><?php echo SiteContent::getValue($db, 'home.features.item2.description', 'Monitor your progress in real-time with advanced analytics'); ?></p>
            </div>
            <div class="feature-box">
                <div class="feature-number">03</div>
                <h3><?php echo SiteContent::getValue($db, 'home.features.item3.title', 'Secure & Reliable'); ?></h3>
                <p><?php echo SiteContent::getValue($db, 'home.features.item3.description', 'Enterprise-grade security for your data and privacy'); ?></p>
            </div>
            <div class="feature-box">
                <div class="feature-number">04</div>
                <h3>Custom Solutions</h3>
                <p>From third-party product design to our own creations, we build exactly what you need from the ground up.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about-section">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <span class="section-badge">About Us</span>
                <h2><?php echo SiteContent::getValue($db, 'home.about.heading', 'About MAX1ON1FITNESS'); ?></h2>
                <p>
                    <?php echo SiteContent::getValue($db, 'home.about.description', 'We are a one-stop shop for multi-device software and hardware solutions for the sports industry. Our mission is to deliver innovative, reliable, and user-friendly fitness technology.'); ?>
                </p>
                <p>
                    From third-party product design to our own creations, we can build bespoke multi-device 
                    apps from scratch, tailored to any kind of sports or fitness training.
                </p>
                <div class="about-highlights">
                    <div class="highlight-item">
                        <div class="highlight-icon">💪</div>
                        <div>
                            <h4>Weight Training</h4>
                            <p>Complete rep and set tracking</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">🥊</div>
                        <div>
                            <h4>Boxing & Combat</h4>
                            <p>Punch tracking and analysis</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">🏃</div>
                        <div>
                            <h4>Aerobics & Cardio</h4>
                            <p>Heart rate and endurance metrics</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-visual">
                <div class="stats-dashboard">
                    <div class="dashboard-card">
                        <h4>Workouts Tracked</h4>
                        <div class="stat-value">2.5M+</div>
                    </div>
                    <div class="dashboard-card">
                        <h4>Sports Supported</h4>
                        <div class="stat-value">25+</div>
                    </div>
                    <div class="dashboard-card">
                        <h4>Device Integrations</h4>
                        <div class="stat-value">50+</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge"><?php echo SiteContent::getValue($db, 'home.contact.heading', 'Get In Touch'); ?></span>
            <h2 class="section-title"><?php echo SiteContent::getValue($db, 'home.contact.subheading', 'Ready to transform your fitness journey?'); ?></h2>
            <p class="section-description">Contact us to discuss your custom fitness solution needs</p>
        </div>

        <div class="contact-content">
            <form class="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <label><?php echo SiteContent::getValue($db, 'home.contact.name_label', 'Name'); ?></label>
                        <input type="text" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo SiteContent::getValue($db, 'home.contact.email_label', 'Email'); ?></label>
                        <input type="email" placeholder="john@example.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" placeholder="How can we help you?" required>
                </div>
                <div class="form-group">
                    <label><?php echo SiteContent::getValue($db, 'home.contact.message_label', 'Message'); ?></label>
                    <textarea rows="5" placeholder="Tell us about your project..." required></textarea>
                </div>
                <button type="submit" class="btn-primary"><?php echo SiteContent::getValue($db, 'home.contact.submit_button', 'Send Message'); ?></button>
            </form>

            <div class="contact-info">
                <div class="info-card">
                    <div class="info-icon">📧</div>
                    <h4>Email Us</h4>
                    <p>info@max1on1fitness.com</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">💬</div>
                    <h4>Live Chat</h4>
                    <p>Available 24/7</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">📍</div>
                    <h4>Office</h4>
                    <p>Global Support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
require_once __DIR__ . '/../includes/footer.php';
?>
