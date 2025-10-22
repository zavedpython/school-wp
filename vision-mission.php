<?php
$settings_file = 'data/settings.json';
if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
} else {
    $settings = ['school_name' => 'NAF Public School'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vision & Mission - <?php echo htmlspecialchars($settings['school_name']); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        .header { background: #1e3a8a; color: white; padding: 1rem 0; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; }
        .nav-links { display: flex; list-style: none; gap: 2rem; }
        .nav-links a { color: white; text-decoration: none; }
        .nav-links a:hover { color: #f59e0b; }
        
        .main { padding: 2rem 0; background: #f8fafc; min-height: 80vh; }
        .page-title { text-align: center; margin-bottom: 3rem; }
        .page-title h1 { color: #1e3a8a; font-size: 2.5rem; margin-bottom: 1rem; }
        .page-title p { color: #666; font-size: 1.1rem; }
        
        .vision-mission-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; }
        .vision-card, .mission-card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .vision-card { border-top: 4px solid #1e3a8a; }
        .mission-card { border-top: 4px solid #f59e0b; }
        .vision-card h2, .mission-card h2 { margin-bottom: 1rem; }
        .vision-card h2 { color: #1e3a8a; }
        .mission-card h2 { color: #f59e0b; }
        .vision-card p, .mission-card p { color: #666; line-height: 1.8; }
        
        .values-section { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .values-section h2 { color: #1e3a8a; margin-bottom: 2rem; text-align: center; }
        .values-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; }
        .value-item { text-align: center; padding: 1rem; }
        .value-icon { font-size: 3rem; margin-bottom: 1rem; }
        .value-item h3 { color: #1e3a8a; margin-bottom: 0.5rem; }
        .value-item p { color: #666; font-size: 0.9rem; }
        
        @media (max-width: 768px) {
            .vision-mission-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo"><?php echo htmlspecialchars($settings['school_name']); ?></div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="admission.php">Admission</a></li>
                    <li><a href="faculty.php">Faculty</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="page-title">
                <h1>Vision & Mission</h1>
                <p>Our guiding principles and aspirations for educational excellence</p>
            </div>

            <div class="vision-mission-grid">
                <div class="vision-card">
                    <h2>Our Vision</h2>
                    <p>To be a leading educational institution that nurtures confident, creative, and compassionate global citizens who are equipped with the knowledge, skills, and values necessary to make a positive impact in an ever-changing world.</p>
                    <p>We envision a learning environment where every student discovers their potential, develops critical thinking abilities, and becomes a lifelong learner committed to excellence and service to humanity.</p>
                </div>

                <div class="mission-card">
                    <h2>Our Mission</h2>
                    <p>To provide holistic education that combines academic excellence with character development, fostering intellectual curiosity, creativity, and moral values in our students.</p>
                    <p>We are committed to creating an inclusive, supportive, and stimulating learning environment that encourages students to explore, question, and grow into responsible citizens who contribute meaningfully to society.</p>
                </div>
            </div>

            <div class="values-section">
                <h2>Our Core Values</h2>
                <div class="values-grid">
                    <div class="value-item">
                        <div class="value-icon">🎓</div>
                        <h3>Excellence</h3>
                        <p>Striving for the highest standards in all aspects of education and personal development</p>
                    </div>

                    <div class="value-item">
                        <div class="value-icon">🤝</div>
                        <h3>Integrity</h3>
                        <p>Building character through honesty, transparency, and ethical behavior in all interactions</p>
                    </div>

                    <div class="value-item">
                        <div class="value-icon">🌟</div>
                        <h3>Innovation</h3>
                        <p>Embracing creativity and new ideas to enhance learning experiences and outcomes</p>
                    </div>

                    <div class="value-item">
                        <div class="value-icon">🤗</div>
                        <h3>Inclusivity</h3>
                        <p>Celebrating diversity and ensuring every student feels valued, respected, and supported</p>
                    </div>

                    <div class="value-item">
                        <div class="value-icon">🌱</div>
                        <h3>Growth</h3>
                        <p>Fostering continuous learning and personal development for students and staff alike</p>
                    </div>

                    <div class="value-item">
                        <div class="value-icon">🌍</div>
                        <h3>Global Citizenship</h3>
                        <p>Preparing students to be responsible global citizens who contribute to a better world</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>
</html>
