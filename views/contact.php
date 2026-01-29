<?php
/**
 * Contact Us Page View
 * Comprehensive contact form for user inquiries
 */

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $company = $_POST['company'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all required fields';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        // Here you would typically send an email or save to database
        // For now, we'll just show a success message
        $success = 'Thank you for contacting us! We will get back to you soon.';
        
        // Clear form data on success
        $name = $email = $phone = $company = $subject = $message = '';
    }
}

$pageTitle = SiteContent::getValue($db, 'contact.page.title', 'Contact Us - MAX1ON1FITNESS');
$pageDescription = 'Get in touch with MAX1ON1FITNESS for inquiries and support';
$currentPage = 'contact';

// Include header
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Contact Hero Section -->
<section class="contact-hero-section">
    <div class="container">
        <div class="page-header-contact">
            <h1 class="page-title-contact">
                <?php echo SiteContent::getValue($db, 'contact.heading', 'Contact Us'); ?>
            </h1>
            <p class="page-subtitle-contact">
                <?php echo SiteContent::getValue($db, 'contact.subheading', 'Get in touch with us'); ?>
            </p>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-form-section">
    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-form-container">
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

                <form method="POST" action="" class="comprehensive-contact-form">
                    <div class="form-row-contact">
                        <div class="form-group">
                            <label for="name" class="form-label-contact">
                                <?php echo SiteContent::getValue($db, 'contact.name_label', 'Full Name'); ?> <span class="required-asterisk">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-control" 
                                placeholder="John Doe"
                                value="<?php echo htmlspecialchars($name ?? ''); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label-contact">
                                <?php echo SiteContent::getValue($db, 'contact.email_label', 'Email Address'); ?> <span class="required-asterisk">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control" 
                                placeholder="john@example.com"
                                value="<?php echo htmlspecialchars($email ?? ''); ?>"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-row-contact">
                        <div class="form-group">
                            <label for="phone" class="form-label-contact">
                                <?php echo SiteContent::getValue($db, 'contact.phone_label', 'Phone Number'); ?>
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                class="form-control" 
                                placeholder="+1 (555) 000-0000"
                                value="<?php echo htmlspecialchars($phone ?? ''); ?>"
                            >
                        </div>

                        <div class="form-group">
                            <label for="company" class="form-label-contact">
                                <?php echo SiteContent::getValue($db, 'contact.company_label', 'Company Name'); ?>
                            </label>
                            <input 
                                type="text" 
                                id="company" 
                                name="company" 
                                class="form-control" 
                                placeholder="Your Company"
                                value="<?php echo htmlspecialchars($company ?? ''); ?>"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label-contact">
                            <?php echo SiteContent::getValue($db, 'contact.subject_label', 'Subject'); ?> <span class="required-asterisk">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            class="form-control" 
                            placeholder="How can we help you?"
                            value="<?php echo htmlspecialchars($subject ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label-contact">
                            <?php echo SiteContent::getValue($db, 'contact.message_label', 'Message'); ?> <span class="required-asterisk">*</span>
                        </label>
                        <textarea 
                            id="message" 
                            name="message" 
                            class="form-control" 
                            rows="6" 
                            placeholder="Tell us more about your inquiry..."
                            required
                        ><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn-primary btn-contact-submit">
                        <?php echo SiteContent::getValue($db, 'contact.submit_button', 'Send Message'); ?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M22 2L11 13M22 2L15 22L11 13M22 2L2 9L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>

            <div class="contact-info-sidebar">
                <div class="contact-info-card">
                    <div class="contact-info-icon">📧</div>
                    <h3 class="contact-info-title">Email Us</h3>
                    <p class="contact-info-text">info@max1on1fitness.com</p>
                    <p class="contact-info-text">support@max1on1fitness.com</p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-icon">📞</div>
                    <h3 class="contact-info-title">Call Us</h3>
                    <p class="contact-info-text">+1 (555) 123-4567</p>
                    <p class="contact-info-text">Mon-Fri, 9am-6pm EST</p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-icon">📍</div>
                    <h3 class="contact-info-title">Visit Us</h3>
                    <p class="contact-info-text">123 Fitness Avenue</p>
                    <p class="contact-info-text">New York, NY 10001</p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-icon">💬</div>
                    <h3 class="contact-info-title">Live Chat</h3>
                    <p class="contact-info-text">Available 24/7</p>
                    <p class="contact-info-text">Instant support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
require_once __DIR__ . '/../includes/footer.php';
?>
