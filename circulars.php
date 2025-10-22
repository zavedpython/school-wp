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
    <title>Circulars - <?php echo htmlspecialchars($settings['school_name']); ?></title>
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
        
        .circulars-list { max-width: 800px; margin: 0 auto; }
        .circular-item { background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .circular-info h3 { color: #1e3a8a; margin-bottom: 0.5rem; }
        .circular-date { color: #f59e0b; font-size: 0.9rem; }
        .download-btn { background: #1e3a8a; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 5px; }
        .download-btn:hover { background: #1e40af; }
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
                <h1>Circulars</h1>
                <p>Important documents and announcements</p>
            </div>

            <div class="circulars-list">
                <div class="circular-item">
                    <div class="circular-info">
                        <h3>Annual Examination Schedule 2024</h3>
                        <div class="circular-date">October 20, 2024</div>
                    </div>
                    <a href="#" class="download-btn">Download PDF</a>
                </div>

                <div class="circular-item">
                    <div class="circular-info">
                        <h3>Fee Structure Update</h3>
                        <div class="circular-date">October 15, 2024</div>
                    </div>
                    <a href="#" class="download-btn">Download PDF</a>
                </div>

                <div class="circular-item">
                    <div class="circular-info">
                        <h3>Sports Day Guidelines</h3>
                        <div class="circular-date">October 10, 2024</div>
                    </div>
                    <a href="#" class="download-btn">Download PDF</a>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>
</html>
