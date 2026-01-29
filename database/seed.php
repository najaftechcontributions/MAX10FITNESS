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
            // ========== GLOBAL HEADER ==========
            ['header.brand', 'MAX1ON1', 'global', 'header', 'heading', 'Brand name in header (first part)'],
            ['header.nav.home', 'Home', 'global', 'header', 'link', 'Home navigation link'],
            ['header.nav.about', 'About', 'global', 'header', 'link', 'About navigation link'],
            ['header.nav.partner', 'Partner', 'global', 'header', 'link', 'Partner navigation link'],
            ['header.nav.contact', 'Contact', 'global', 'header', 'link', 'Contact navigation link'],
            ['header.login_button', 'Login', 'global', 'header', 'button', 'Login button in header'],
            ['header.signup_button', 'Get Started', 'global', 'header', 'button', 'Signup button in header'],

            // ========== GLOBAL FOOTER ==========
            ['footer.brand', 'MAX1ON1', 'global', 'footer', 'heading', 'Brand name in footer (first part)'],
            ['footer.description', 'Multi-device software and hardware solutions for the sports industry.', 'global', 'footer', 'text', 'Footer description'],
            ['footer.products.title', 'Products', 'global', 'footer', 'heading', 'Products column title'],
            ['footer.company.title', 'Company', 'global', 'footer', 'heading', 'Company column title'],
            ['footer.support.title', 'Support', 'global', 'footer', 'heading', 'Support column title'],
            ['footer.copyright', '© 2024 MAX1ON1FITNESS. All rights reserved.', 'global', 'footer', 'text', 'Footer copyright text'],

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

            // ========== HOME PAGE ==========
            ['home.page.title', 'MAX1ON1FITNESS - Multi-Device Sports & Fitness Solutions', 'home', 'page', 'heading', 'Home page title'],
            ['home.hero.title', 'MAX1ON1FITNESS', 'home', 'hero', 'heading', 'Main hero title'],
            ['home.hero.description', 'MAX1on1Fitness is a one-stop shop for multi-device software and hardware solutions for the sports industry, from integrated Bluetooth apps to multi-function full-workout apps that track a host of metrics across a variety of workouts, including weight training, boxing, and aerobics, and everything in between. From third-party product design to our own creations, we can build bespoke multi-device apps from scratch, tailored to any kind of sports or fitness training.', 'home', 'hero', 'paragraph', 'Hero description'],

            // ========== ABOUT PAGE ==========
            ['about.page.title', 'About Us - MAX1ON1FITNESS', 'about', 'page', 'heading', 'About page title'],
            ['about.business.heading', 'Our Business Concept', 'about', 'business', 'heading', 'Business concept heading'],
            ['about.business.description', 'Max 1ON1 Fitness is developing an AI & Virtual Reality-based fitness application (AV Fitness App) that enables remote fitness coaching through VR devices, combined with an AI assessment module for real-time monitoring, technique correction, and personalised programming. The product bridges immersive VR experiences with data-driven coaching to deliver scalable, engaging, and effective fitness training for individuals and organisations.', 'about', 'business', 'paragraph', 'Business concept description'],
            ['about.products.heading', 'Our Products/Services', 'about', 'products', 'heading', 'Products/Services heading'],
            ['about.products.description', 'The AV Fitness App delivers multi-module fitness coaching (strength, cardio, mobility, sports-specific drills) via downloadable applications for PC, laptop, and mobile devices, with cloud and local storage options. Core features include VR coaching sessions, AI motion analysis and feedback, real-time correction prompts, session recording, performance analytics, and integration APIs for training centres and institutional use.', 'about', 'products', 'paragraph', 'Products/Services description'],

            // ========== PARTNER PAGE ==========
            ['partner.page.title', 'Partner Login - MAX1ON1FITNESS', 'partner', 'page', 'heading', 'Partner page title'],
            ['partner.heading', 'Welcome MAX1ON1FITNESS Technical Partnership Page', 'partner', 'form', 'heading', 'Partner page heading'],
            ['partner.subheading', 'Please log in below', 'partner', 'form', 'text', 'Partner page subheading'],
            ['partner.member_id_label', 'MEMBER ID', 'partner', 'form', 'text', 'Member ID label'],
            ['partner.password_label', 'PASSWORD', 'partner', 'form', 'text', 'Password label'],
            ['partner.submit_button', 'Login', 'partner', 'form', 'button', 'Partner login button'],

            // ========== CONTACT PAGE ==========
            ['contact.page.title', 'Contact Us - MAX1ON1FITNESS', 'contact', 'page', 'heading', 'Contact page title'],
            ['contact.heading', 'Contact Us', 'contact', 'form', 'heading', 'Contact page heading'],
            ['contact.subheading', 'Get in touch with us', 'contact', 'form', 'text', 'Contact page subheading'],
            ['contact.name_label', 'Full Name', 'contact', 'form', 'text', 'Name input label'],
            ['contact.email_label', 'Email Address', 'contact', 'form', 'text', 'Email input label'],
            ['contact.phone_label', 'Phone Number', 'contact', 'form', 'text', 'Phone input label'],
            ['contact.company_label', 'Company Name', 'contact', 'form', 'text', 'Company input label'],
            ['contact.subject_label', 'Subject', 'contact', 'form', 'text', 'Subject input label'],
            ['contact.message_label', 'Message', 'contact', 'form', 'text', 'Message textarea label'],
            ['contact.submit_button', 'Send Message', 'contact', 'form', 'button', 'Contact form submit button'],

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
