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
    // Filter only active banners
    $banners = array_filter($all_banners, function($banner) {
        return $banner['active'] ?? false;
    });
}

// Load dynamic notices
$notices_file = 'data/notices.json';
if (file_exists($notices_file)) {
    $notices = json_decode(file_get_contents($notices_file), true) ?: [];
} else {
    $notices = [
        ['title' => 'Parent-Teacher Meeting', 'content' => 'Parent-Teacher meeting on Oct 25, 2024. All parents requested to attend.', 'created_at' => date('Y-m-d H:i:s')],
        ['title' => 'Annual Sports Day', 'content' => 'Annual Sports Day on Nov 15, 2024. Practice sessions start from Oct 28.', 'created_at' => date('Y-m-d H:i:s')]
    ];
}

// Load footer data
$footer_file = 'data/footer.json';
if (file_exists($footer_file)) {
    $footer_data = json_decode(file_get_contents($footer_file), true);
} else {
    $footer_data = [
        'about_text' => 'Dedicated to providing quality education and nurturing young minds for a brighter future.',
        'quick_links' => [
            'Admission Process' => 'admission.php',
            'Fee Structure' => 'fee-structure.php',
            'Gallery' => 'gallery.php',
            'Contact Us' => '#contact'
        ],
        'contact_info' => [
            'address' => '123 Education Street, New Delhi - 110001',
            'phone' => '+91-11-12345678',
            'email' => 'info@balbarti.edu',
            'website' => 'www.balbarti.edu'
        ],
        'social_links' => [
            'facebook' => 'https://facebook.com/balbarti',
            'twitter' => 'https://twitter.com/balbarti',
            'instagram' => 'https://instagram.com/balbarti',
            'youtube' => 'https://youtube.com/balbarti'
        ],
        'copyright_text' => 'All rights reserved.',
        'show_map' => true
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
    <link rel="alternate icon" href="assets/favicon.ico">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <link rel="alternate icon" href="assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin-top: 70px; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; position: fixed; top: 0; width: 100%; z-index: 1000; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; }
        .nav-links { display: flex; list-style: none; gap: 2rem; }
        .nav-links a { color: white; text-decoration: none; }
        .nav-links a:hover { color: #3498db; }
        .dropdown { position: relative; display: inline-block; }
        .dropdown-content { display: none; position: absolute; background: #2c3e50; min-width: 200px; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 1; top: 100%; }
        .dropdown-content a { color: white; padding: 12px 16px; text-decoration: none; display: block; }
        .dropdown-content a:hover { background: #34495e; }
        .dropdown:hover .dropdown-content { display: block; }
        .hero { 
            position: relative; 
            color: white; 
            padding: 2rem 0; 
            text-align: center; 
            margin-right: 350px; 
            height: 450px; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
        }
        .hero-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .hero-slide.active {
            opacity: 1;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 2;
        }
        .hero-content {
            position: relative;
            z-index: 3;
        }
        .hero h1 { font-size: 3rem; margin-bottom: 1rem; }
        .hero p { font-size: 1.2rem; margin-bottom: 2rem; }
        .btn { background: #3498db; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .content { padding: 4rem 0; margin-right: 350px; }
        .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-top: 2rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .card h3 { color: #2c3e50; margin-bottom: 1rem; }
        .footer { background: #2c3e50; color: white; text-align: center; padding: 2rem 0; }
        
        /* Scrolling Notice Board */
        .notice-ticker {
            position: fixed;
            top: 70px;
            right: 0;
            width: 350px;
            height: 450px;
            background: #2c3e50;
            border-radius: 0;
            box-shadow: -5px 0 20px rgba(0,0,0,0.3);
            z-index: 999;
            overflow: hidden;
        }
        .notice-header {
            background: #e74c3c;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }
        .notice-content {
            height: 400px;
            overflow: hidden;
            position: relative;
        }
        .notice-scroll {
            position: absolute;
            width: 100%;
            animation: scrollUp 20s linear infinite;
        }
        .notice-item {
            padding: 15px;
            border-bottom: 1px solid #34495e;
            color: white;
            font-size: 12px;
            line-height: 1.4;
        }
        .notice-date {
            color: #f39c12;
            font-size: 10px;
            margin-bottom: 5px;
        }
        .notice-text {
            color: #ecf0f1;
        }
        @keyframes scrollUp {
            0% { transform: translateY(100%); }
            100% { transform: translateY(-100%); }
        }
        .notice-ticker:hover .notice-scroll {
            animation-play-state: paused;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo" style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 50px; height: 50px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">
                        <?php echo strtoupper(substr($settings['school_name'], 0, 1)); ?>
                    </div>
                    <span style="font-size: 1.5rem; font-weight: bold;"><?php echo htmlspecialchars($settings['school_name']); ?></span>
                </div>
                <ul class="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li class="dropdown">
                        <a href="#about">About Us ▼</a>
                        <div class="dropdown-content">
                            <a href="school-history.php">School History</a>
                            <a href="vision-mission.php">Vision & Mission</a>
                            <a href="principal-message.php">Principal's Message</a>
                            <a href="faculty.php">Faculty</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="admission.php">Admissions ▼</a>
                        <div class="dropdown-content">
                            <a href="admission.php">Admission Process</a>
                            <a href="fee-structure.php">Fee Structure</a>
                            <a href="admission-form.php">Online Application</a>
                        </div>
                    </li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="notices.php">Notices</a></li>
                    <li><a href="circulars.php">Circulars</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <?php if (!empty($banners)): ?>
            <div class="hero-slider">
                <?php foreach ($banners as $index => $banner): ?>
                    <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>" 
                         style="background-image: url('<?php echo $banner['image']; ?>')"></div>
                <?php endforeach; ?>
            </div>
            <div class="hero-overlay"></div>
            
            <?php if (!empty($banners[0]['title']) || !empty($banners[0]['subtitle'])): ?>
            <div class="hero-content">
                <div class="container">
                    <?php if (!empty($banners[0]['title'])): ?>
                        <h1><?php echo htmlspecialchars($banners[0]['title']); ?></h1>
                    <?php endif; ?>
                    <?php if (!empty($banners[0]['subtitle'])): ?>
                        <p><?php echo htmlspecialchars($banners[0]['subtitle']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>

    <section class="content" id="about">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 2rem;">About Our School</h2>
            <div class="grid">
                <div class="card">
                    <h3>Our Mission</h3>
                    <p>To provide quality education that empowers students to become responsible global citizens and lifelong learners.</p>
                </div>
                <div class="card">
                    <h3>Our Vision</h3>
                    <p>To be a leading educational institution that fosters academic excellence, character development, and innovative thinking.</p>
                </div>
                <div class="card">
                    <h3>Our Values</h3>
                    <p>Integrity, Excellence, Respect, Innovation, and Community - these core values guide everything we do.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="content" style="background: #f8f9fa;" id="admissions">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 2rem;">Admissions</h2>
            <div class="grid">
                <div class="card">
                    <h3>Admission Process</h3>
                    <p>Our admission process is designed to identify students who will thrive in our academic environment.</p>
                    <a href="admission.php" class="btn" style="margin-top: 1rem;">Apply Now</a>
                </div>
                <div class="card">
                    <h3>Fee Structure</h3>
                    <p>Transparent and competitive fee structure with various payment options available.</p>
                    <a href="fee-structure.php" class="btn" style="margin-top: 1rem;">View Fees</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Scrolling Notice Board -->
    <div class="notice-ticker">
        <div class="notice-header">
            📢 NOTICE BOARD
        </div>
        <div class="notice-content">
            <div class="notice-scroll">
                <?php foreach ($notices as $notice): ?>
                <div class="notice-item">
                    <div class="notice-date"><?php echo date('M d, Y', strtotime($notice['created_at'])); ?></div>
                    <div class="notice-text">
                        <?php echo htmlspecialchars($notice['content']); ?>
                        <?php if (!empty($notice['pdf_file'])): ?>
                            <br><a href="<?php echo $notice['pdf_file']; ?>" target="_blank" style="color: #3498db; text-decoration: none;">📄 View PDF</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <footer style="background: #374151; color: white;">
        <!-- Main Footer Content -->
        <div style="padding: 3rem 0;">
            <div class="container">
                <div class="grid">
                    <!-- School Info -->
                    <div class="card" style="background: transparent; box-shadow: none; color: white;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;"><?php echo htmlspecialchars($settings['school_name']); ?></h4>
                        <p style="color: #d1d5db; margin-bottom: 1rem;">
                            <?php echo htmlspecialchars($footer_data['about_text']); ?>
                        </p>
                        <div style="display: flex; gap: 1rem;">
                            <?php if (!empty($footer_data['social_links']['facebook'])): ?>
                                <a href="<?php echo $footer_data['social_links']['facebook']; ?>" target="_blank" style="color: #d1d5db; text-decoration: none;">📘 Facebook</a>
                            <?php endif; ?>
                            <?php if (!empty($footer_data['social_links']['instagram'])): ?>
                                <a href="<?php echo $footer_data['social_links']['instagram']; ?>" target="_blank" style="color: #d1d5db; text-decoration: none;">📷 Instagram</a>
                            <?php endif; ?>
                            <?php if (!empty($footer_data['social_links']['twitter'])): ?>
                                <a href="<?php echo $footer_data['social_links']['twitter']; ?>" target="_blank" style="color: #d1d5db; text-decoration: none;">🐦 Twitter</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="card" style="background: transparent; box-shadow: none; color: white;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Quick Links</h4>
                        <ul style="list-style: none; padding: 0;">
                            <?php foreach ($footer_data['quick_links'] as $name => $url): ?>
                                <li style="margin-bottom: 0.5rem;"><a href="<?php echo $url; ?>" style="color: #d1d5db; text-decoration: none;"><?php echo htmlspecialchars($name); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="card" style="background: transparent; box-shadow: none; color: white;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Contact Info</h4>
                        <div style="color: #d1d5db;">
                            <p style="margin-bottom: 0.5rem;">📍 <?php echo htmlspecialchars($footer_data['contact_info']['address']); ?></p>
                            <p style="margin-bottom: 0.5rem;">📞 <?php echo htmlspecialchars($footer_data['contact_info']['phone']); ?></p>
                            <p style="margin-bottom: 0.5rem;">✉️ <?php echo htmlspecialchars($footer_data['contact_info']['email']); ?></p>
                            <?php if (!empty($footer_data['contact_info']['website'])): ?>
                                <p style="margin-bottom: 0.5rem;">🌐 <?php echo htmlspecialchars($footer_data['contact_info']['website']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Google Maps -->
                    <?php if ($footer_data['show_map']): ?>
                    <div class="card" style="background: transparent; box-shadow: none; color: white;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">📍 Our Location</h4>
                        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin-bottom: 1rem;">
                            <iframe
                                src="<?php echo $footer_data['map_config']['embed_url']; ?>"
                                width="100%"
                                height="200"
                                style="border: 0; display: block;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="<?php echo htmlspecialchars($settings['school_name']); ?> Location">
                            </iframe>
                        </div>
                        <div style="text-align: center;">
                            <a href="<?php echo $footer_data['map_config']['directions_url']; ?>" target="_blank" 
                               style="display: inline-block; background: #3498db; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-size: 0.9rem;">
                                🧭 Get Directions
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div style="background: #1f2937; padding: 1rem 0;">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <p style="color: #9ca3af; font-size: 0.875rem;">
                        © 2024 <?php echo htmlspecialchars($settings['school_name']); ?>. <?php echo htmlspecialchars($footer_data['copyright_text']); ?>
                    </p>
                    <p style="color: #9ca3af; font-size: 0.875rem; margin-top: 0.5rem;">
                        Developed by <span style="color: #3498db; font-weight: 600;">SkyTech IT Solutions</span>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const footer = document.querySelector('footer');
            const noticeTicker = document.querySelector('.notice-ticker');
            const footerRect = footer.getBoundingClientRect();
            
            if (footerRect.top <= window.innerHeight) {
                noticeTicker.style.display = 'none';
            } else {
                noticeTicker.style.display = 'block';
            }
        });

        // Banner slideshow functionality
        <?php if (count($banners) > 1): ?>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            slides[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        // Auto-advance slides every 5 seconds
        if (totalSlides > 1) {
            setInterval(nextSlide, 5000);
        }
        <?php endif; ?>
    </script>
</body>
</html>
