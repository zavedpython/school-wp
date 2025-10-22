<?php
// Load dynamic settings
$settings_file = 'data/settings.json';
if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
} else {
    $settings = [
        'school_name' => 'Bal Bharti Public School',
        'school_address' => '123 Education Street, New Delhi - 110001',
        'school_phone' => '+91-11-12345678',
        'school_email' => 'info@balbarti.edu',
        'principal_name' => 'Dr. Rajesh Kumar'
    ];
}

// Load banner images
$banner_file = 'data/banner.json';
$banners = [];
if (file_exists($banner_file)) {
    $all_banners = json_decode(file_get_contents($banner_file), true);
    $banners = array_filter($all_banners, function($banner) {
        return $banner['active'] ?? false;
    });
}

// Load notices
$notices_file = 'data/notices.json';
if (file_exists($notices_file)) {
    $notices = json_decode(file_get_contents($notices_file), true) ?: [];
} else {
    $notices = [
        ['title' => 'Parent-Teacher Meeting', 'content' => 'Parent-Teacher meeting on Oct 25, 2024.', 'created_at' => date('Y-m-d H:i:s')],
        ['title' => 'Annual Sports Day', 'content' => 'Annual Sports Day on Nov 15, 2024.', 'created_at' => date('Y-m-d H:i:s')]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($settings['school_name']); ?> - Excellence in Education</title>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        
        /* Header */
        .header { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: fixed; top: 0; width: 100%; z-index: 1000; }
        .top-bar { background: #1e3a8a; color: white; padding: 8px 0; font-size: 14px; }
        .top-bar .container { display: flex; justify-content: space-between; align-items: center; }
        .contact-info span { margin-right: 20px; }
        .social-links a { color: white; margin-left: 10px; text-decoration: none; }
        
        .main-nav { padding: 15px 0; }
        .nav-container { display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; }
        .logo img { height: 60px; margin-right: 15px; }
        .logo-text h1 { color: #1e3a8a; font-size: 24px; margin: 0; }
        .logo-text p { color: #666; font-size: 14px; margin: 0; }
        
        .nav-links { display: flex; list-style: none; gap: 30px; }
        .nav-links a { color: #333; text-decoration: none; font-weight: 500; padding: 10px 0; }
        .nav-links a:hover { color: #1e3a8a; }
        .dropdown { position: relative; }
        .dropdown-content { display: none; position: absolute; background: white; min-width: 200px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); top: 100%; }
        .dropdown-content a { padding: 12px 16px; display: block; border-bottom: 1px solid #eee; }
        .dropdown:hover .dropdown-content { display: block; }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        /* Hero Section */
        .hero { 
            position: relative; 
            height: 600px; 
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            display: flex; 
            align-items: center;
            margin-top: 120px;
            overflow: hidden;
        }
        .hero-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .hero-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .hero-slide.active { opacity: 1; }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(30, 58, 138, 0.7);
        }
        .hero-content {
            position: relative;
            z-index: 3;
            color: white;
            text-align: center;
        }
        .hero h1 { font-size: 3.5rem; margin-bottom: 1rem; font-weight: 700; }
        .hero p { font-size: 1.3rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto; }
        .btn { background: #f59e0b; color: white; padding: 15px 35px; text-decoration: none; border-radius: 50px; font-weight: 600; display: inline-block; transition: all 0.3s; }
        .btn:hover { background: #d97706; transform: translateY(-2px); }
        
        /* Quick Links */
        .quick-links { padding: 60px 0; background: #f8fafc; }
        .quick-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; margin-top: 40px; }
        .quick-card { 
            background: white; 
            padding: 40px 30px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            text-align: center;
            transition: transform 0.3s;
        }
        .quick-card:hover { transform: translateY(-10px); }
        .quick-card .icon { font-size: 3rem; color: #1e3a8a; margin-bottom: 20px; }
        .quick-card h3 { color: #1e3a8a; margin-bottom: 15px; font-size: 1.3rem; }
        .quick-card p { color: #666; font-size: 14px; }
        
        /* About Section */
        .about-section { padding: 80px 0; }
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .about-content h2 { color: #1e3a8a; font-size: 2.5rem; margin-bottom: 20px; }
        .about-content p { color: #666; margin-bottom: 20px; line-height: 1.8; }
        .about-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-top: 40px; }
        .stat-item { text-align: center; }
        .stat-number { font-size: 2.5rem; font-weight: 700; color: #1e3a8a; }
        .stat-label { color: #666; font-size: 14px; }
        .about-image { text-align: center; }
        .about-image img { max-width: 100%; border-radius: 15px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        
        /* Notice Board */
        .notice-section { padding: 80px 0; background: #f8fafc; }
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-header h2 { color: #1e3a8a; font-size: 2.5rem; margin-bottom: 15px; }
        .section-header p { color: #666; font-size: 1.1rem; }
        .notice-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; }
        .notice-card { 
            background: white; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 5px solid #1e3a8a;
        }
        .notice-date { color: #f59e0b; font-weight: 600; font-size: 14px; }
        .notice-title { color: #1e3a8a; font-size: 1.2rem; margin: 10px 0; }
        .notice-content { color: #666; line-height: 1.6; }
        
        /* Footer */
        .footer { background: #1e3a8a; color: white; padding: 60px 0 20px; }
        .footer-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; margin-bottom: 40px; }
        .footer-section h3 { margin-bottom: 20px; font-size: 1.2rem; }
        .footer-section p, .footer-section a { color: #cbd5e1; text-decoration: none; line-height: 1.8; }
        .footer-section a:hover { color: white; }
        .footer-bottom { border-top: 1px solid #334155; padding-top: 20px; text-align: center; color: #cbd5e1; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hero h1 { font-size: 2.5rem; }
            .quick-grid, .about-grid, .notice-grid, .footer-grid { grid-template-columns: 1fr; }
            .about-stats { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="contact-info">
                    <span>📞 <?php echo htmlspecialchars($settings['school_phone']); ?></span>
                    <span>✉️ <?php echo htmlspecialchars($settings['school_email']); ?></span>
                </div>
                <div class="social-links">
                    <a href="#">📘</a>
                    <a href="#">🐦</a>
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
                        <img src="assets/logo.svg" alt="School Logo">
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
                            <li><a href="gallery.php">Gallery</a></li>
                            <li><a href="notices.php">Notices</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-slider">
            <?php if (!empty($banners)): ?>
                <?php foreach ($banners as $index => $banner): ?>
                    <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>" 
                         style="background-image: url('<?php echo htmlspecialchars($banner['image_path']); ?>');">
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');"></div>
            <?php endif; ?>
        </div>
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1>Welcome to <?php echo htmlspecialchars($settings['school_name']); ?></h1>
                <p>Nurturing young minds for a brighter tomorrow with excellence in education, character building, and holistic development.</p>
                <a href="admission.php" class="btn">Apply for Admission</a>
            </div>
        </div>
    </section>

    <!-- Quick Links -->
    <section class="quick-links">
        <div class="container">
            <div class="section-header">
                <h2>Quick Access</h2>
                <p>Everything you need at your fingertips</p>
            </div>
            <div class="quick-grid">
                <div class="quick-card">
                    <div class="icon">🎓</div>
                    <h3>Admission</h3>
                    <p>Start your journey with us. Apply online for admission.</p>
                </div>
                <div class="quick-card">
                    <div class="icon">💰</div>
                    <h3>Fee Structure</h3>
                    <p>Transparent and affordable fee structure for all classes.</p>
                </div>
                <div class="quick-card">
                    <div class="icon">📚</div>
                    <h3>Academics</h3>
                    <p>Comprehensive curriculum designed for holistic development.</p>
                </div>
                <div class="quick-card">
                    <div class="icon">🏆</div>
                    <h3>Achievements</h3>
                    <p>Celebrating our students' success and accomplishments.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <h2>About Our School</h2>
                    <p>At <?php echo htmlspecialchars($settings['school_name']); ?>, we believe in nurturing every child's potential through innovative teaching methods, state-of-the-art facilities, and a caring environment that promotes both academic excellence and character development.</p>
                    <p>Our dedicated faculty and comprehensive curriculum ensure that students receive the best education while developing critical thinking skills, creativity, and moral values that will serve them throughout their lives.</p>
                    <div class="about-stats">
                        <div class="stat-item">
                            <div class="stat-number">25+</div>
                            <div class="stat-label">Years of Excellence</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">1200+</div>
                            <div class="stat-label">Happy Students</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">50+</div>
                            <div class="stat-label">Expert Faculty</div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="School Building">
                </div>
            </div>
        </div>
    </section>

    <!-- Notice Board -->
    <section class="notice-section">
        <div class="container">
            <div class="section-header">
                <h2>Latest Notices</h2>
                <p>Stay updated with our latest announcements and events</p>
            </div>
            <div class="notice-grid">
                <?php foreach (array_slice($notices, 0, 4) as $notice): ?>
                    <div class="notice-card">
                        <div class="notice-date"><?php echo date('M d, Y', strtotime($notice['created_at'])); ?></div>
                        <h3 class="notice-title"><?php echo htmlspecialchars($notice['title']); ?></h3>
                        <p class="notice-content"><?php echo htmlspecialchars(substr($notice['content'], 0, 120)) . '...'; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3><?php echo htmlspecialchars($settings['school_name']); ?></h3>
                    <p>Dedicated to providing quality education and nurturing young minds for a brighter future.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="admission.php">Admission Process</a></p>
                    <p><a href="fee-structure.php">Fee Structure</a></p>
                    <p><a href="gallery.php">Gallery</a></p>
                    <p><a href="notices.php">Notices</a></p>
                </div>
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p><?php echo htmlspecialchars($settings['school_address']); ?></p>
                    <p>Phone: <?php echo htmlspecialchars($settings['school_phone']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($settings['school_email']); ?></p>
                </div>
                <div class="footer-section">
                    <h3>Follow Us</h3>
                    <p><a href="#">Facebook</a></p>
                    <p><a href="#">Twitter</a></p>
                    <p><a href="#">Instagram</a></p>
                    <p><a href="#">YouTube</a></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($settings['school_name']); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Hero slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        
        function nextSlide() {
            if (slides.length > 1) {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
            }
        }
        
        if (slides.length > 1) {
            setInterval(nextSlide, 5000);
        }
    </script>
</body>
</html>
