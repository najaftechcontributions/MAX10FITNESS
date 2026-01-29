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
                        <img src="/assets/images/sportssoftware.webp" alt="Sports Software Dashboard" class="home-product-image">
                        <p class="image-caption">Sports Software</p>
                    </div>
                    <div class="home-image-card">
                        <img src="/assets/images/heartratemonitor.webp" alt="Wearable Heart Rate Monitor" class="home-product-image">
                        <p class="image-caption">Heart Rate Monitor</p>
                    </div>
                    <div class="home-image-card">
                        <img src="/assets/images/cyclingmonitor.webp" alt="Cycling Monitor Device" class="home-product-image">
                        <p class="image-caption">Cycling Monitor</p>
                    </div>
                    <div class="home-image-card">
                        <img src="/assets/images/workouttracker.webp" alt="Workout Tracker App" class="home-product-image">
                        <p class="image-caption">Workout Tracker</p>
                    </div>
                    <div class="home-image-card">
                        <img src="/assets/images/fitnesstracking.jpg" alt="Fitness Tracking Device" class="home-product-image">
                        <p class="image-caption">Fitness Tracking</p>
                    </div>
                    <div class="home-image-card">
                        <img src="/assets/images/multidevice.jpeg" alt="Multi-Device Fitness App" class="home-product-image">
                        <p class="image-caption">Multi-Device App</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Why Choose Us</span>
            <h2 class="section-title">Cutting-Edge Fitness Technology</h2>
            <p class="section-description">We combine AI, VR, and advanced sensors to deliver the most comprehensive fitness tracking experience</p>
        </div>

        <div class="features-grid">
            <div class="feature-box">
                <span class="feature-number">01</span>
                <h3>AI-Powered Analysis</h3>
                <p>Advanced machine learning algorithms analyze your form, technique, and performance in real-time to provide instant feedback.</p>
            </div>

            <div class="feature-box">
                <span class="feature-number">02</span>
                <h3>VR Coaching Sessions</h3>
                <p>Immersive virtual reality training with world-class coaches from anywhere in the world, making expert guidance accessible.</p>
            </div>

            <div class="feature-box">
                <span class="feature-number">03</span>
                <h3>Multi-Device Sync</h3>
                <p>Seamlessly connect wearables, smartphones, tablets, and smart gym equipment for unified tracking across all platforms.</p>
            </div>

            <div class="feature-box">
                <span class="feature-number">04</span>
                <h3>Performance Analytics</h3>
                <p>Detailed insights and visualizations help you understand progress, identify patterns, and optimize your training routine.</p>
            </div>

            <div class="feature-box">
                <span class="feature-number">05</span>
                <h3>Enterprise Integration</h3>
                <p>Robust APIs and SDKs enable gyms, training centers, and sports facilities to integrate with existing systems.</p>
            </div>

            <div class="feature-box">
                <span class="feature-number">06</span>
                <h3>Real-Time Tracking</h3>
                <p>Monitor heart rate, calories, reps, sets, and dozens of other metrics live during your workout for maximum effectiveness.</p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Our Solutions</span>
            <h2 class="section-title">Complete Fitness Ecosystem</h2>
            <p class="section-description">From hardware to software, we provide everything you need for modern fitness tracking</p>
        </div>

        <div class="products-grid">
            <div class="product-card featured">
                <span class="featured-badge">Most Popular</span>
                <div class="product-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>
                <h3>MAX1 Fitness App</h3>
                <p>Our flagship mobile and web application with comprehensive workout tracking, AI coaching, and social features.</p>
                <ul class="product-features">
                    <li>200+ workout types supported</li>
                    <li>AI form correction</li>
                    <li>Social challenges and leaderboards</li>
                    <li>Nutrition and meal planning</li>
                </ul>
                <a href="/products" class="product-link">Learn More →</a>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <h3>Smart Wearables</h3>
                <p>Premium fitness trackers and smartwatches with advanced biometric sensors and extended battery life.</p>
                <ul class="product-features">
                    <li>Heart rate variability monitoring</li>
                    <li>Blood oxygen saturation</li>
                    <li>Sleep quality analysis</li>
                    <li>7-day battery life</li>
                </ul>
                <a href="/products" class="product-link">Learn More →</a>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div>
                <h3>VR Training Platform</h3>
                <p>Immersive virtual reality environment for remote personal training and group fitness classes.</p>
                <ul class="product-features">
                    <li>Live VR coaching sessions</li>
                    <li>Virtual gym environments</li>
                    <li>Multiplayer workouts</li>
                    <li>Motion capture tracking</li>
                </ul>
                <a href="/products" class="product-link">Learn More →</a>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                        <path d="M2 17l10 5 10-5"></path>
                        <path d="M2 12l10 5 10-5"></path>
                    </svg>
                </div>
                <h3>Enterprise API</h3>
                <p>Powerful REST and GraphQL APIs for gyms, training centers, and fitness facilities to integrate our technology.</p>
                <ul class="product-features">
                    <li>RESTful & GraphQL endpoints</li>
                    <li>Webhook notifications</li>
                    <li>White-label solutions</li>
                    <li>Dedicated support</li>
                </ul>
                <a href="/products" class="product-link">Learn More →</a>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </div>
                <h3>Custom Hardware</h3>
                <p>Bespoke fitness equipment with integrated sensors and Bluetooth connectivity for specialized training.</p>
                <ul class="product-features">
                    <li>Custom sensor integration</li>
                    <li>Bluetooth & WiFi connectivity</li>
                    <li>Durable, gym-grade build</li>
                    <li>OEM manufacturing</li>
                </ul>
                <a href="/products" class="product-link">Learn More →</a>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
                <h3>Nutrition Tracking</h3>
                <p>Comprehensive meal planning and nutrition tracking with AI-powered recommendations and barcode scanning.</p>
                <ul class="product-features">
                    <li>Barcode scanner</li>
                    <li>Macro tracking</li>
                    <li>Meal planning AI</li>
                    <li>Recipe database</li>
                </ul>
                <a href="/products" class="product-link">Learn More →</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="about-section">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <span class="section-badge">Our Impact</span>
                <h2>Trusted by Athletes and Fitness Enthusiasts Worldwide</h2>
                <p>Since 2018, MAX1ON1FITNESS has been at the forefront of fitness technology innovation. Our mission is to make world-class training accessible to everyone through cutting-edge technology.</p>
                <p>We've partnered with professional sports teams, Olympic athletes, and leading fitness centers to develop solutions that actually work in the real world. Our technology has helped millions of people achieve their fitness goals.</p>

                <div class="about-highlights">
                    <div class="highlight-item">
                        <div class="highlight-icon">🏆</div>
                        <div>
                            <h4>Award-Winning Technology</h4>
                            <p>Recognized as "Best Fitness Tech" 2023 by TechCrunch</p>
                        </div>
                    </div>

                    <div class="highlight-item">
                        <div class="highlight-icon">🔒</div>
                        <div>
                            <h4>Enterprise-Grade Security</h4>
                            <p>ISO 27001 certified with end-to-end encryption</p>
                        </div>
                    </div>

                    <div class="highlight-item">
                        <div class="highlight-icon">🌍</div>
                        <div>
                            <h4>Global Presence</h4>
                            <p>Available in 50+ countries with 24/7 support</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stats-dashboard">
                <div class="dashboard-card">
                    <h4>Active Users</h4>
                    <div class="stat-value">2.5M+</div>
                </div>

                <div class="dashboard-card">
                    <h4>Workouts Tracked</h4>
                    <div class="stat-value">150M+</div>
                </div>

                <div class="dashboard-card">
                    <h4>Partner Gyms</h4>
                    <div class="stat-value">3,200+</div>
                </div>

                <div class="dashboard-card">
                    <h4>Countries</h4>
                    <div class="stat-value">50+</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Testimonials</span>
            <h2 class="section-title">What Our Users Say</h2>
            <p class="section-description">Join thousands of satisfied athletes and fitness enthusiasts</p>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"MAX1ON1FITNESS completely transformed how I train. The AI form correction has helped me avoid injuries and improve my technique dramatically. Best investment I've made in my fitness journey."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">SM</div>
                    <div class="author-info">
                        <h4>Sarah Mitchell</h4>
                        <p>Marathon Runner</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"As a gym owner, the enterprise API has been a game-changer. Our members love the seamless integration with their personal devices, and the analytics help us improve our training programs."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">JC</div>
                    <div class="author-info">
                        <h4>James Chen</h4>
                        <p>Gym Owner, FitZone</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"The VR training sessions are incredible! I can work with my coach remotely and it feels like we're in the same room. The motion tracking is so accurate, I get real-time feedback on every movement."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">MD</div>
                    <div class="author-info">
                        <h4>Marcus Davis</h4>
                        <p>Professional Boxer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Ready to Transform Your Fitness Journey?</h2>
            <p class="cta-description">Join over 2.5 million users who are already achieving their fitness goals with MAX1ON1FITNESS. Start your free 30-day trial today.</p>
            <div class="cta-actions">
                <a href="/signup" class="btn-primary">Start Free Trial</a>
                <a href="/contact" class="btn-secondary">Schedule a Demo</a>
            </div>
            <p class="cta-note">No credit card required • Cancel anytime • 30-day money-back guarantee</p>
        </div>
    </div>
</section>

<?php
// Include footer
require_once __DIR__ . '/../includes/footer.php';
?>
