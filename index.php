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
        .nav-container { display: flex; justify-content: flex-end; align-items: center; width: 100%; }
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
        
        .nav-links { display: flex; list-style: none; gap: 20px; margin-right: 0; flex-wrap: wrap; }
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
            height: 100vh; 
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            display: flex; 
            align-items: center;
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
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
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
        .footer-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 40px; margin-bottom: 40px; }
        .footer-section h3 { margin-bottom: 20px; font-size: 1.2rem; }
        .footer-section p, .footer-section a { color: #cbd5e1; text-decoration: none; line-height: 1.8; }
        .footer-section a:hover { color: white; }
        .footer-bottom { border-top: 1px solid #334155; padding-top: 20px; display: flex; justify-content: space-between; align-items: center; color: #cbd5e1; }
        .footer-bottom a { color: white; text-decoration: none; }
        .footer-bottom a:hover { color: #f59e0b; }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .nav-links { gap: 15px; font-size: 0.9rem; }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hero h1 { font-size: 2.5rem; }
            .quick-grid, .about-grid, .notice-grid, .footer-grid { grid-template-columns: 1fr; }
            .about-stats { grid-template-columns: repeat(2, 1fr); }
            .footer-bottom { flex-direction: column; gap: 10px; text-align: center; }
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
                            <li><a href="gallery.php">Gallery</a></li>
                            <li><a href="fee-structure.php">Fee Structure</a></li>
                            <li><a href="notices.php">Notices</a></li>
                            <li><a href="circulars.php">Circulars</a></li>
                            <li><a href="contact.php">Contact</a></li>
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
                         style="background-image: url('<?php echo htmlspecialchars($banner['image']); ?>');">
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
                <a href="admission.php" style="text-decoration: none; color: inherit;">
                    <div class="quick-card">
                        <div class="icon">🎓</div>
                        <h3>Admission</h3>
                        <p>Start your journey with us. Apply online for admission.</p>
                    </div>
                </a>
                <a href="fee-structure.php" style="text-decoration: none; color: inherit;">
                    <div class="quick-card">
                        <div class="icon">💰</div>
                        <h3>Fee Structure</h3>
                        <p>Transparent and affordable fee structure for all classes.</p>
                    </div>
                </a>
                <a href="faculty.php" style="text-decoration: none; color: inherit;">
                    <div class="quick-card">
                        <div class="icon">📚</div>
                        <h3>Faculty</h3>
                        <p>Meet our experienced and dedicated teaching staff.</p>
                    </div>
                </a>
                <a href="contact.php" style="text-decoration: none; color: inherit;">
                    <div class="quick-card">
                        <div class="icon">📞</div>
                        <h3>Contact Us</h3>
                        <p>Get in touch with us for any queries or information.</p>
                    </div>
                </a>
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
                            <div class="stat-number" data-target="25">0</div>
                            <div class="stat-label">Years of Excellence</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" data-target="1200">0</div>
                            <div class="stat-label">Happy Students</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" data-target="50">0</div>
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

    <?php include 'includes/footer.php'; ?>

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

    <script>
        // Counter Animation
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                    element.textContent = target + '+';
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 20);
        }

        // Intersection Observer for triggering animation when section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-number');
                    statNumbers.forEach(stat => {
                        const target = parseInt(stat.getAttribute('data-target'));
                        animateCounter(stat, target);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        // Start observing the about stats section
        document.addEventListener('DOMContentLoaded', () => {
            const aboutStats = document.querySelector('.about-stats');
            if (aboutStats) {
                observer.observe(aboutStats);
            }
        });
    </script>
</body>
</html>
