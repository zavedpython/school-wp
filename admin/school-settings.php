<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Simple file-based storage
$settings_file = '../data/settings.json';
if (!file_exists('../data')) {
    mkdir('../data', 0777, true);
}

// Default settings
$default_settings = [
    'school_name' => 'Bal Bharti Public School',
    'school_address' => '123 Education Street, New Delhi - 110001',
    'school_phone' => '+91-11-12345678',
    'school_email' => 'info@balbarti.edu',
    'principal_name' => 'Dr. Rajesh Kumar',
    'school_vision' => 'To be a leading educational institution that fosters academic excellence...',
    'school_mission' => 'To provide quality education in a nurturing environment...'
];

// Load settings
if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
} else {
    $settings = $default_settings;
}

// Handle form submission
if ($_POST) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'submit') {
            $settings[$key] = $value;
        }
    }
    file_put_contents($settings_file, json_encode($settings, JSON_PRETTY_PRINT));
    $success = "Settings updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Settings - Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .form-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #2c3e50; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; }
        .form-group textarea { height: 100px; resize: vertical; }
        .btn { background: #3498db; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-back { background: #95a5a6; margin-bottom: 1rem; }
        .btn-back:hover { background: #7f8c8d; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>School Settings</div>
                <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
            </nav>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <?php if (isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <h2>School Information Settings</h2>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="school_name">School Name</label>
                        <input type="text" id="school_name" name="school_name" value="<?php echo htmlspecialchars($settings['school_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="school_address">School Address</label>
                        <textarea id="school_address" name="school_address" required><?php echo htmlspecialchars($settings['school_address']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="school_phone">Phone Number</label>
                        <input type="text" id="school_phone" name="school_phone" value="<?php echo htmlspecialchars($settings['school_phone']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="school_email">Email Address</label>
                        <input type="email" id="school_email" name="school_email" value="<?php echo htmlspecialchars($settings['school_email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="principal_name">Principal Name</label>
                        <input type="text" id="principal_name" name="principal_name" value="<?php echo htmlspecialchars($settings['principal_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="school_vision">School Vision</label>
                        <textarea id="school_vision" name="school_vision" required><?php echo htmlspecialchars($settings['school_vision']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="school_mission">School Mission</label>
                        <textarea id="school_mission" name="school_mission" required><?php echo htmlspecialchars($settings['school_mission']); ?></textarea>
                    </div>
                    
                    <button type="submit" name="submit" class="btn">Update Settings</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
