</div>
    <!-- End Main Content Container -->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3 class="logo"><?php echo SiteContent::getValue($db ?? null, 'footer.brand', 'MAX1ON1'); ?><span>FITNESS</span></h3>
                    <p><?php echo SiteContent::getValue($db ?? null, 'footer.description', 'Multi-device software and hardware solutions for the sports industry.'); ?></p>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h4><?php echo SiteContent::getValue($db ?? null, 'footer.products.title', 'Products'); ?></h4>
                        <ul>
                            <li><a href="/">Heart Rate Monitor</a></li>
                            <li><a href="/">Mobile Apps</a></li>
                            <li><a href="/">Cycling Tracker</a></li>
                            <li><a href="/">Workout Tracker</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4><?php echo SiteContent::getValue($db ?? null, 'footer.company.title', 'Company'); ?></h4>
                        <ul>
                            <li><a href="/about">About Us</a></li>
                            <li><a href="/contact">Contact</a></li>
                            <li><a href="/partner">Partner</a></li>
                            <li><a href="#">Careers</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4><?php echo SiteContent::getValue($db ?? null, 'footer.support.title', 'Support'); ?></h4>
                        <ul>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="/contact">Contact Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p><?php echo SiteContent::getValue($db ?? null, 'footer.copyright', '© 2024 MAX1ON1FITNESS. All rights reserved.'); ?></p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/assets/js/script.js"></script>
</body>
</html>
