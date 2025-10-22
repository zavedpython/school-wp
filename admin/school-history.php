<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Load current settings
$settings_file = '../data/settings.json';
$settings = [];
if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
}

// Handle form submission
if ($_POST) {
    $settings['school_history'] = $_POST['school_history'] ?? '';
    $settings['school_founded'] = $_POST['school_founded'] ?? '';
    $settings['school_founder'] = $_POST['school_founder'] ?? '';
    $settings['school_achievements'] = $_POST['school_achievements'] ?? '';
    
    file_put_contents($settings_file, json_encode($settings, JSON_PRETTY_PRINT));
    $success = "School history updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School History - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .form-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; }
        .form-group textarea { height: 150px; resize: vertical; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #2980b9; }
        .btn-back { background: #95a5a6; text-decoration: none; }
        .btn-back:hover { background: #7f8c8d; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>School History Management</div>
                <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
            </nav>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <div class="form-container">
                <h2>School History</h2>
                
                <?php if (isset($success)): ?>
                    <div class="success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="school_founded">Founded Year</label>
                        <input type="text" id="school_founded" name="school_founded" 
                               value="<?php echo htmlspecialchars($settings['school_founded'] ?? ''); ?>" 
                               placeholder="e.g., 1985">
                    </div>

                    <div class="form-group">
                        <label for="school_founder">Founder</label>
                        <input type="text" id="school_founder" name="school_founder" 
                               value="<?php echo htmlspecialchars($settings['school_founder'] ?? ''); ?>" 
                               placeholder="Name of the founder">
                    </div>

                    <div class="form-group">
                        <label for="school_history">School History</label>
                        <textarea id="school_history" name="school_history" required 
                                  placeholder="Enter the complete history of the school..."><?php echo htmlspecialchars($settings['school_history'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="school_achievements">Major Achievements</label>
                        <textarea id="school_achievements" name="school_achievements" 
                                  placeholder="List major achievements and milestones..."><?php echo htmlspecialchars($settings['school_achievements'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn">Update School History</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
