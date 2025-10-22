<?php
$settings_file = 'data/settings.json';
$principal_file = 'data/principal.json';

if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
} else {
    $settings = ['school_name' => 'NAF Public School'];
}

if (file_exists($principal_file)) {
    $principal = json_decode(file_get_contents($principal_file), true);
} else {
    $principal = [
        'name' => 'Dr. Rajesh Kumar',
        'message' => 'Welcome to our school where we nurture young minds for a bright future.',
        'photo' => 'uploads/principal_photo.jpeg'
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal's Message - <?php echo htmlspecialchars($settings['school_name']); ?></title>
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
        
        .principal-content { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .principal-info { display: grid; grid-template-columns: 200px 1fr; gap: 2rem; margin-bottom: 2rem; }
        .principal-photo { width: 200px; height: 250px; border-radius: 10px; object-fit: cover; box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .principal-details h2 { color: #1e3a8a; margin-bottom: 0.5rem; }
        .principal-details .title { color: #f59e0b; font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; }
        .principal-message { color: #666; line-height: 1.8; font-size: 1.1rem; }
        .principal-message p { margin-bottom: 1rem; }
        
        @media (max-width: 768px) {
            .principal-info { grid-template-columns: 1fr; text-align: center; }
            .principal-photo { width: 150px; height: 200px; margin: 0 auto; }
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
                <h1>Principal's Message</h1>
                <p>A word from our school leader</p>
            </div>

            <div class="principal-content">
                <div class="principal-info">
                    <img src="<?php echo htmlspecialchars($principal['photo']); ?>" alt="Principal" class="principal-photo">
                    <div class="principal-details">
                        <h2><?php echo htmlspecialchars($principal['name']); ?></h2>
                        <div class="title">Principal</div>
                        <div class="principal-message">
                            <?php echo nl2br(htmlspecialchars($principal['message'])); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>
</html>
