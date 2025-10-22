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
    <title>School History - <?php echo htmlspecialchars($settings['school_name']); ?></title>
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
        
        .content { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .content h2 { color: #1e3a8a; margin-bottom: 1rem; }
        .content p { margin-bottom: 1rem; line-height: 1.8; color: #666; }
        
        .timeline { margin-top: 2rem; }
        .timeline-item { display: flex; margin-bottom: 2rem; padding: 1rem; background: #f8fafc; border-radius: 8px; border-left: 4px solid #1e3a8a; }
        .timeline-year { font-weight: bold; color: #1e3a8a; min-width: 80px; }
        .timeline-content { flex: 1; margin-left: 1rem; }
        .timeline-content h3 { color: #1e3a8a; margin-bottom: 0.5rem; }
        
        .achievements { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 2rem; }
        .achievement-card { background: #e0f2fe; padding: 1.5rem; border-radius: 8px; text-align: center; }
        .achievement-card h3 { color: #1e3a8a; margin-bottom: 0.5rem; }
        .achievement-number { font-size: 2rem; font-weight: bold; color: #f59e0b; }
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
                <h1>School History</h1>
                <p>Four decades of educational excellence and growth</p>
            </div>

            <div class="content">
                <h2>Our Journey</h2>
                <p>NAF Public School was established in 1985 with a vision to provide quality education that nurtures young minds and builds character. Over the years, we have grown from a small institution to one of the most respected schools in the region.</p>
                
                <p>Our commitment to excellence in education has remained unwavering throughout our journey. We have consistently adapted to changing educational needs while maintaining our core values of integrity, respect, and academic excellence.</p>

                <h2>Timeline of Excellence</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-year">1985</div>
                        <div class="timeline-content">
                            <h3>Foundation</h3>
                            <p>NAF Public School was established with 50 students and 5 teachers in a modest building.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-year">1990</div>
                        <div class="timeline-content">
                            <h3>First Expansion</h3>
                            <p>Added new classrooms and science laboratory to accommodate growing student population.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-year">1995</div>
                        <div class="timeline-content">
                            <h3>Recognition</h3>
                            <p>Received official recognition from the State Education Board for academic excellence.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-year">2000</div>
                        <div class="timeline-content">
                            <h3>Modern Infrastructure</h3>
                            <p>Constructed new building with modern facilities including computer lab and library.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-year">2010</div>
                        <div class="timeline-content">
                            <h3>Digital Integration</h3>
                            <p>Introduced smart classrooms and digital learning tools for enhanced education.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-year">2020</div>
                        <div class="timeline-content">
                            <h3>Online Learning</h3>
                            <p>Successfully transitioned to hybrid learning model during the pandemic.</p>
                        </div>
                    </div>
                </div>

                <h2>Our Achievements</h2>
                <div class="achievements">
                    <div class="achievement-card">
                        <div class="achievement-number">40+</div>
                        <h3>Years of Excellence</h3>
                        <p>Serving the community since 1985</p>
                    </div>

                    <div class="achievement-card">
                        <div class="achievement-number">1200+</div>
                        <h3>Students</h3>
                        <p>Currently enrolled across all grades</p>
                    </div>

                    <div class="achievement-card">
                        <div class="achievement-number">50+</div>
                        <h3>Faculty Members</h3>
                        <p>Dedicated and qualified teachers</p>
                    </div>

                    <div class="achievement-card">
                        <div class="achievement-number">95%</div>
                        <h3>Success Rate</h3>
                        <p>Board examination pass percentage</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>
</html>
