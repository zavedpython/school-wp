<?php
// Load dynamic settings
$settings_file = 'data/settings.json';
if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
} else {
    $settings = [
        'school_name' => 'NAF Public School',
        'school_address' => '123 Education Street, New Delhi - 110001',
        'school_phone' => '+91-11-12345678',
        'school_email' => 'info@balbarti.edu',
        'principal_name' => 'Dr. Rajesh Kumar'
    ];
}

// Load logo
$logo_file = 'data/logo.json';
$logo_path = '';
if (file_exists($logo_file)) {
    $logo_data = json_decode(file_get_contents($logo_file), true);
    $logo_path = $logo_data['logo_path'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($settings['school_name']); ?> - Excellence in Education</title>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg?v=<?php echo time(); ?>">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        
        /* Header */
        .header { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: fixed; top: 0; width: 100%; z-index: 1000; }
        .top-bar { background: #1e3a8a; color: white; padding: 8px 0; font-size: 14px; }
        .top-bar .container { display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .contact-info { color: white; margin: 0; }
        .contact-info span { margin-right: 20px; }
        .social-links a { color: white; margin-left: 10px; text-decoration: none; }
        
        .main-nav { padding: 25px 0; position: relative; }
        .nav-container { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        .logo { 
            display: flex; 
            align-items: center; 
            position: absolute; 
            left: 0; 
            top: 50%; 
            transform: translateY(-50%);
            z-index: 10;
        }
        .logo img { 
            height: 70px; 
            width: auto; 
            margin-right: 15px; 
            border-radius: 8px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            object-fit: contain;
        }
        .logo-text { text-align: left; }
        .logo-text h1 { color: #1e3a8a; font-size: 24px; margin: 0; }
        .logo-text p { color: #666; font-size: 14px; margin: 0; }
        
        .nav-links { display: flex; list-style: none; gap: 30px; margin-left: auto; padding-left: 400px; }
        .nav-links a { color: #333; text-decoration: none; font-weight: 500; padding: 10px 0; }
        .nav-links a:hover { color: #1e3a8a; }
        .dropdown { position: relative; }
        .dropdown-content { display: none; position: absolute; background: white; min-width: 200px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); top: 100%; z-index: 1000; }
        .dropdown-content a { padding: 12px 16px; display: block; border-bottom: 1px solid #eee; }
        .dropdown:hover .dropdown-content { display: block; }
        
        /* Hamburger Menu */
        .hamburger { display: none; flex-direction: column; cursor: pointer; padding: 10px; }
        .hamburger span { width: 25px; height: 3px; background: #333; margin: 3px 0; transition: 0.3s; }
        .hamburger.active span:nth-child(1) { transform: rotate(-45deg) translate(-5px, 6px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(45deg) translate(-5px, -6px); }
        
        /* Mobile Menu */
        .mobile-menu { display: none; position: fixed; top: 120px; left: 0; width: 100%; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 999; }
        .mobile-menu.active { display: block; }
        .mobile-menu ul { list-style: none; padding: 0; margin: 0; }
        .mobile-menu li { border-bottom: 1px solid #eee; }
        .mobile-menu a { display: block; padding: 15px 20px; color: #333; text-decoration: none; }
        .mobile-menu a:hover { background: #f8fafc; color: #1e3a8a; }
        .mobile-dropdown { background: #f8fafc; }
        .mobile-dropdown a { padding-left: 40px; font-size: 0.9rem; }
        
        @media (max-width: 1024px) {
            .nav-links { display: none; }
            .hamburger { display: flex; }
        }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        /* Main content spacing */
        .main-content { margin-top: 120px; }
    </style>
</head>
<body>
    <header class="header">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="contact-info">
                    <span>📞 +91-8445030782</span>
                    <span>✉️ info@fampublicschool.com</span>
                </div>
                <div class="social-links">
                    <a href="#">📘</a>
                    <a href="#">📷</a>
                    <a href="#">📺</a>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <div class="main-nav">
            <div class="container">
                <div class="nav-container">
                    <div class="logo">
                        <img src="logo/logo.jpg" alt="School Logo">
                        <div class="logo-text">
                            <h1><?php echo htmlspecialchars($settings['school_name']); ?></h1>
                            <p>Excellence in Education</p>
                        </div>
                    </div>
                    <nav>
                        <ul class="nav-links">
                            <li><a href="index.php">Home</a></li>
                            <li class="dropdown">
                                <a href="#">About Us</a>
                                <div class="dropdown-content">
                                    <a href="school-history.php">School History</a>
                                    <a href="vision-mission.php">Vision & Mission</a>
                                    <a href="principal-message.php">Principal's Message</a>
                                </div>
                            </li>
                            <li><a href="admission.php">Admission</a></li>
                            <li><a href="faculty.php">Faculty</a></li>
                            <li><a href="fee-structure.php">Fee Structure</a></li>
                            <li><a href="gallery.php">Gallery</a></li>
                            <li><a href="notices.php">Notices</a></li>
                            <li><a href="circulars.php">Circulars</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                        
                        <!-- Hamburger Menu -->
                        <div class="hamburger" onclick="toggleMobileMenu()">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#" onclick="toggleDropdown(event)">About Us ▼</a>
                <div class="mobile-dropdown" style="display: none;">
                    <a href="school-history.php">School History</a>
                    <a href="vision-mission.php">Vision & Mission</a>
                    <a href="principal-message.php">Principal's Message</a>
                </div>
            </li>
            <li><a href="admission.php">Admission</a></li>
            <li><a href="faculty.php">Faculty</a></li>
            <li><a href="fee-structure.php">Fee Structure</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="notices.php">Notices</a></li>
            <li><a href="circulars.php">Circulars</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
    
    <div class="main-content">
    
    <script>
        function toggleMobileMenu() {
            const hamburger = document.querySelector('.hamburger');
            const mobileMenu = document.getElementById('mobileMenu');
            
            hamburger.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        }
        
        function toggleDropdown(event) {
            event.preventDefault();
            const dropdown = event.target.nextElementSibling;
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const hamburger = document.querySelector('.hamburger');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (!hamburger.contains(event.target) && !mobileMenu.contains(event.target)) {
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('active');
            }
        });
    </script>
