<?php
/**
 * Database Seeder - Creates dummy data for testing
 */

class DatabaseSeeder {
    private $conn;
    private $isCli;

    public function __construct($conn = null, $isCli = null) {
        if ($conn === null) {
            // Only create Database instance if no connection is provided
            // This is for CLI usage
            require_once __DIR__ . '/../config/env.php';

            $host = EnvLoader::get('DB_HOST', '127.0.0.1');
            $port = EnvLoader::get('DB_PORT', '3306');
            $db_name = EnvLoader::get('DB_NAME', 'analognxt');
            $username = EnvLoader::get('DB_USER', 'root');
            $password = EnvLoader::get('DB_PASS', '');

            try {
                $this->conn = new PDO(
                    "mysql:host={$host};port={$port};dbname={$db_name}",
                    $username,
                    $password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                $this->output("✗ Database connection error: " . $e->getMessage());
                $this->conn = null;
            }
        } else {
            $this->conn = $conn;
        }

        $this->isCli = $isCli === null ? (php_sapi_name() === 'cli') : $isCli;
    }

    private function output($message) {
        if ($this->isCli) {
            echo $message . "\n";
        }
    }

    public function seed() {
        if ($this->conn === null) {
            $this->output("✗ Error: Database connection is not established");
            return false;
        }

        $this->seedUsers();
        $this->seedPagesContent();
        $this->seedSiteContent();
        $this->output("✓ Database seeded successfully!");
        return true;
    }
    
    private function seedUsers() {
        // Load admin credentials from .env
        require_once __DIR__ . '/../config/env.php';
        $adminEmail = EnvLoader::get('ADMIN_EMAIL', 'admin@max1on1fitness.com');
        $adminPassword = EnvLoader::get('ADMIN_PASSWORD', 'Admin@123');
        $adminUsername = EnvLoader::get('ADMIN_USERNAME', 'admin');

        // Check if admin already exists
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
        $stmt->execute([$adminEmail]);
        $result = $stmt->fetch();

        if ($result['count'] == 0) {
            // Create admin user
            $stmt = $this->conn->prepare(
                "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([
                $adminUsername,
                $adminEmail,
                password_hash($adminPassword, PASSWORD_BCRYPT),
                'admin'
            ]);
            $this->output("✓ Admin user created (email: {$adminEmail}, password: {$adminPassword})");
        }

        // Create sample regular users
        $users = [
            ['john_doe', 'john@example.com', 'User@123'],
            ['jane_smith', 'jane@example.com', 'User@123'],
            ['mike_wilson', 'mike@example.com', 'User@123']
        ];

        foreach ($users as $user) {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
            $stmt->execute([$user[1]]);
            $result = $stmt->fetch();

            if ($result['count'] == 0) {
                $stmt = $this->conn->prepare(
                    "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)"
                );
                $stmt->execute([
                    $user[0],
                    $user[1],
                    password_hash($user[2], PASSWORD_BCRYPT),
                    'user'
                ]);
            }
        }
        $this->output("✓ Sample users created");
    }
    
    private function seedPagesContent() {
        $pages = [
            [
                'home',
                'MAX1ON1FITNESS - Multi-Device Sports & Fitness Solutions',
                'Your One-Stop Shop for Multi-Device Fitness Solutions',
                'From integrated Bluetooth apps to multi-function full-workout trackers, we deliver bespoke software and hardware solutions for the sports industry.'
            ],
            [
                'about',
                'About Us - MAX1ON1FITNESS',
                'One-Stop Shop for Sports Industry Solutions',
                'MAX1on1Fitness is a one-stop shop for multi-device software and hardware solutions for the sports industry.'
            ],
            [
                'contact',
                'Contact Us - MAX1ON1FITNESS',
                'Ready to Transform Your Fitness Journey?',
                'Contact us to discuss your custom fitness solution needs'
            ]
        ];
        
        foreach ($pages as $page) {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM pages_content WHERE page_name = ?");
            $stmt->execute([$page[0]]);
            $result = $stmt->fetch();
            
            if ($result['count'] == 0) {
                $stmt = $this->conn->prepare(
                    "INSERT INTO pages_content (page_name, title, content, meta_description) VALUES (?, ?, ?, ?)"
                );
                $stmt->execute($page);
            }
        }
        $this->output("✓ Pages content created");
    }

    private function seedSiteContent() {
        $contents = [
            // ========== LOGIN PAGE ==========
            ['login.page.title', 'Login - MAX1ON1FITNESS', 'login', 'page', 'heading', 'Page title for login'],
            ['login.form.heading', 'Welcome Back', 'login', 'form', 'heading', 'Login form heading'],
            ['login.form.subheading', 'Login to your account', 'login', 'form', 'text', 'Login form subheading'],
            ['login.form.email_label', 'Email Address', 'login', 'form', 'text', 'Email input label'],
            ['login.form.password_label', 'Password', 'login', 'form', 'text', 'Password input label'],
            ['login.form.submit_button', 'Login', 'login', 'form', 'button', 'Login submit button'],
            ['login.form.signup_link_text', 'Don\'t have an account?', 'login', 'form', 'text', 'Signup link text'],
            ['login.form.signup_link', 'Sign Up', 'login', 'form', 'link', 'Signup link'],

            // ========== SIGNUP PAGE ==========
            ['signup.page.title', 'Sign Up - MAX1ON1FITNESS', 'signup', 'page', 'heading', 'Page title for signup'],
            ['signup.form.heading', 'Create Account', 'signup', 'form', 'heading', 'Signup form heading'],
            ['signup.form.subheading', 'Join MAX1ON1FITNESS today', 'signup', 'form', 'text', 'Signup form subheading'],
            ['signup.form.username_label', 'Username', 'signup', 'form', 'text', 'Username input label'],
            ['signup.form.email_label', 'Email Address', 'signup', 'form', 'text', 'Email input label'],
            ['signup.form.password_label', 'Password', 'signup', 'form', 'text', 'Password input label'],
            ['signup.form.confirm_password_label', 'Confirm Password', 'signup', 'form', 'text', 'Confirm password label'],
            ['signup.form.submit_button', 'Create Account', 'signup', 'form', 'button', 'Signup submit button'],
            ['signup.form.login_link_text', 'Already have an account?', 'signup', 'form', 'text', 'Login link text'],
            ['signup.form.login_link', 'Login', 'signup', 'form', 'link', 'Login link'],

            // ========== HOME PAGE - HEADER ==========
            ['home.header.brand', 'MAX1ON1', 'home', 'header', 'heading', 'Brand name in header (first part)'],
            ['home.header.nav.home', 'Home', 'home', 'header', 'link', 'Home navigation link'],
            ['home.header.nav.products', 'Products', 'home', 'header', 'link', 'Products navigation link'],
            ['home.header.nav.features', 'Features', 'home', 'header', 'link', 'Features navigation link'],
            ['home.header.nav.about', 'About', 'home', 'header', 'link', 'About navigation link'],
            ['home.header.nav.contact', 'Contact', 'home', 'header', 'link', 'Contact navigation link'],
            ['home.header.login_button', 'Login', 'home', 'header', 'button', 'Login button in header'],
            ['home.header.signup_button', 'Get Started', 'home', 'header', 'button', 'Signup button in header'],

            // ========== HOME PAGE - HERO SECTION ==========
            ['home.hero.title', 'Multi-Device Sports & Fitness Solutions', 'home', 'hero', 'heading', 'Main hero title'],
            ['home.hero.subtitle', 'From integrated Bluetooth apps to multi-function full-workout trackers, we deliver bespoke software and hardware solutions for the sports industry.', 'home', 'hero', 'paragraph', 'Hero subtitle/description'],
            ['home.hero.cta_button', 'Get Started', 'home', 'hero', 'button', 'Hero call-to-action button'],
            ['home.hero.learn_more_button', 'Learn More', 'home', 'hero', 'button', 'Hero learn more button'],

            // ========== HOME PAGE - PRODUCTS SECTION ==========
            ['home.products.heading', 'Our Solutions', 'home', 'products', 'heading', 'Products section badge'],
            ['home.products.subheading', 'Innovative Fitness Technology', 'home', 'products', 'heading', 'Products section title'],

            // ========== HOME PAGE - FEATURES SECTION ==========
            ['home.features.heading', 'Why Choose Us', 'home', 'features', 'heading', 'Features section badge'],
            ['home.features.subheading', 'Industry-Leading Technology', 'home', 'features', 'heading', 'Features section title'],
            ['home.features.item1.title', 'Multi-Device Support', 'home', 'features', 'heading', 'Feature 1 title'],
            ['home.features.item1.description', 'Works seamlessly across smartphones, tablets, and wearables', 'home', 'features', 'paragraph', 'Feature 1 description'],
            ['home.features.item2.title', 'Real-Time Tracking', 'home', 'features', 'heading', 'Feature 2 title'],
            ['home.features.item2.description', 'Monitor your progress in real-time with advanced analytics', 'home', 'features', 'paragraph', 'Feature 2 description'],
            ['home.features.item3.title', 'Secure & Reliable', 'home', 'features', 'heading', 'Feature 3 title'],
            ['home.features.item3.description', 'Enterprise-grade security for your data and privacy', 'home', 'features', 'paragraph', 'Feature 3 description'],

            // ========== HOME PAGE - ABOUT SECTION ==========
            ['home.about.heading', 'About MAX1ON1FITNESS', 'home', 'about', 'heading', 'About section heading'],
            ['home.about.description', 'We are a one-stop shop for multi-device software and hardware solutions for the sports industry. Our mission is to deliver innovative, reliable, and user-friendly fitness technology.', 'home', 'about', 'paragraph', 'About section description'],

            // ========== HOME PAGE - CONTACT SECTION ==========
            ['home.contact.heading', 'Get In Touch', 'home', 'contact', 'heading', 'Contact section badge'],
            ['home.contact.subheading', 'Ready to transform your fitness journey?', 'home', 'contact', 'heading', 'Contact section title'],
            ['home.contact.name_label', 'Name', 'home', 'contact', 'text', 'Contact form name label'],
            ['home.contact.email_label', 'Email', 'home', 'contact', 'text', 'Contact form email label'],
            ['home.contact.message_label', 'Message', 'home', 'contact', 'text', 'Contact form message label'],
            ['home.contact.submit_button', 'Send Message', 'home', 'contact', 'button', 'Contact form submit button'],

            // ========== HOME PAGE - FOOTER ==========
            ['home.footer.copyright', '© 2024 MAX1ON1FITNESS. All rights reserved.', 'home', 'footer', 'text', 'Footer copyright text'],

            // ========== DASHBOARD ==========
            ['dashboard.page.title', 'Admin Dashboard - MAX1ON1FITNESS', 'dashboard', 'page', 'heading', 'Dashboard page title'],
            ['dashboard.users.page.title', 'User Management - MAX1ON1FITNESS', 'dashboard', 'page', 'heading', 'Users page title'],
            ['dashboard.content.page.title', 'Content Management - MAX1ON1FITNESS', 'dashboard', 'page', 'heading', 'Content management page title']
        ];

        foreach ($contents as $content) {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM site_content WHERE content_key = ?");
            $stmt->execute([$content[0]]);
            $result = $stmt->fetch();

            if ($result['count'] == 0) {
                $stmt = $this->conn->prepare(
                    "INSERT INTO site_content (content_key, content_value, page_name, section_name, content_type, description)
                     VALUES (?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute($content);
            } else {
                // Update existing content if value is different
                $stmt = $this->conn->prepare("UPDATE site_content SET content_value = ?, description = ? WHERE content_key = ?");
                $stmt->execute([$content[1], $content[5], $content[0]]);
            }
        }
        $this->output("✓ Site content created/updated (" . count($contents) . " items)");
    }
}

// Run seeder if called directly
if (php_sapi_name() === 'cli') {
    $seeder = new DatabaseSeeder();
    $seeder->seed();
}
?>
