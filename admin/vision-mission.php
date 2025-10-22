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
    $settings['school_vision'] = $_POST['school_vision'] ?? '';
    $settings['school_mission'] = $_POST['school_mission'] ?? '';
    $settings['school_values'] = $_POST['school_values'] ?? '';
    $settings['school_objectives'] = $_POST['school_objectives'] ?? '';
    
    file_put_contents($settings_file, json_encode($settings, JSON_PRETTY_PRINT));
    $success = "Vision & Mission updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vision & Mission - Admin Panel</title>
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
        .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; height: 120px; resize: vertical; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #2980b9; }
        .btn-back { background: #95a5a6; text-decoration: none; }
        .btn-back:hover { background: #7f8c8d; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>Vision & Mission Management</div>
                <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
            </nav>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <div class="form-container">
                <h2>Vision & Mission</h2>
                
                <?php if (isset($success)): ?>
                    <div class="success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="grid">
                        <div>
                            <div class="form-group">
                                <label for="school_vision">School Vision</label>
                                <textarea id="school_vision" name="school_vision" required 
                                          placeholder="Enter the school's vision statement..."><?php echo htmlspecialchars($settings['school_vision'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="school_mission">School Mission</label>
                                <textarea id="school_mission" name="school_mission" required 
                                          placeholder="Enter the school's mission statement..."><?php echo htmlspecialchars($settings['school_mission'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <div>
                            <div class="form-group">
                                <label for="school_values">Core Values</label>
                                <textarea id="school_values" name="school_values" 
                                          placeholder="Enter the school's core values..."><?php echo htmlspecialchars($settings['school_values'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="school_objectives">Objectives</label>
                                <textarea id="school_objectives" name="school_objectives" 
                                          placeholder="Enter the school's main objectives..."><?php echo htmlspecialchars($settings['school_objectives'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn">Update Vision & Mission</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
