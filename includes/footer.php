<?php
// Load settings for footer
$settings_file = 'data/settings.json';
if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
} else {
    $settings = [
        'school_name' => 'NAF Public School',
        'school_address' => 'Village Khekra, Baghpat',
        'school_phone' => '+91-8445030782',
        'school_email' => 'info@fampublicschool.com'
    ];
}
?>

<style>
/* Footer Styles */
.footer { background: #1e3a8a; color: white; padding: 60px 0 20px; }
.footer-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 40px; margin-bottom: 40px; }
.footer-section h3 { margin-bottom: 20px; font-size: 1.2rem; }
.footer-section p, .footer-section a { color: #cbd5e1; text-decoration: none; line-height: 1.8; }
.footer-section a:hover { color: white; }
.footer-bottom { border-top: 1px solid #334155; padding-top: 20px; display: flex; justify-content: space-between; align-items: center; color: #cbd5e1; }
.footer-bottom a { color: white; text-decoration: none; }
.footer-bottom a:hover { color: #f59e0b; }

@media (max-width: 768px) {
    .footer-grid { grid-template-columns: 1fr; }
    .footer-bottom { flex-direction: column; gap: 10px; text-align: center; }
}
</style>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-section">
                <h3><?php echo htmlspecialchars($settings['school_name']); ?></h3>
                <p>Dedicated to providing quality education and nurturing young minds for a brighter future.</p>
                <br>
                <h3>Follow Us</h3>
                <p style="white-space: nowrap;"><a href="#">Facebook</a> | <a href="#">Instagram</a> | <a href="#">YouTube</a></p>
            </div>
            <div class="footer-section">
                <h3>About</h3>
                <p><a href="school-history.php">School History</a></p>
                <p><a href="vision-mission.php">Vision & Mission</a></p>
                <p><a href="principal-message.php">Principal's Message</a></p>
                <p><a href="faculty.php">Faculty</a></p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="admission.php">Admission Process</a></p>
                <p><a href="fee-structure.php">Fee Structure</a></p>
                <p><a href="gallery.php">Gallery</a></p>
                <p><a href="notices.php">Notices</a></p>
                <p><a href="circulars.php">Circulars</a></p>
                <p><a href="admin/login.php">Admin Login</a></p>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <p>Pathshala Road | Krishna Nagar, Near Anwar Clinic Khekra (Baghpat)</p>
                <p>Uttar Pradesh</p>
                <p>Phone: +91-8445030782</p>
                <p>Email: info@fampublicschool.com</p>
            </div>
            <div class="footer-section">
                <h3>Location</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3496.8!2d77.2858094!3d28.8622607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390c5575e887cc3d%3A0xc551c7f2eb3c488e!2sNAF%20Public%20School%20Khekra!5e0!3m2!1sen!2sin!4v1234567890" 
                        width="100%" height="150" style="border:0; border-radius: 5px;" allowfullscreen="" loading="lazy"></iframe>
                <p><a href="https://maps.app.goo.gl/hkV1Mgubbgn7AZYh8" target="_blank">View on Google Maps</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 NAF Public School. All rights reserved.</p>
            <p>Developed by <a href="https://wa.me/917217640903" target="_blank">SkyTech Technologies</a></p>
        </div>
    </div>
</footer>
