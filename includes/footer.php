</div>
    <!-- End Main Content Container -->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3 class="logo">MAX1ON1<span>FITNESS</span></h3>
                    <p>Multi-device software and hardware solutions for the sports industry.</p>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h4>Products</h4>
                        <ul>
                            <li><a href="#products">Heart Rate Monitor</a></li>
                            <li><a href="#products">Mobile Apps</a></li>
                            <li><a href="#products">Cycling Tracker</a></li>
                            <li><a href="#products">Workout Tracker</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>Company</h4>
                        <ul>
                            <li><a href="#about">About Us</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#contact">Contact Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p><?php echo SiteContent::getValue($db ?? null, 'home.footer.copyright', '© 2024 MAX1ON1FITNESS. All rights reserved.'); ?></p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/assets/js/script.js"></script>
</body>
</html>
