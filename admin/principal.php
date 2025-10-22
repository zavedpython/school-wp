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
    $settings['principal_name'] = $_POST['principal_name'] ?? '';
    $settings['principal_message'] = $_POST['principal_message'] ?? '';
    $settings['principal_qualification'] = $_POST['principal_qualification'] ?? '';
    $settings['principal_experience'] = $_POST['principal_experience'] ?? '';
    
    file_put_contents($settings_file, json_encode($settings, JSON_PRETTY_PRINT));
    $success = "Principal's message updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal's Message - Admin Panel</title>
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
                <div>Principal's Message Management</div>
                <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
            </nav>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <div class="form-container">
                <h2>Principal's Message</h2>
                
                <?php if (isset($success)): ?>
                    <div class="success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="principal_name">Principal's Name</label>
                        <input type="text" id="principal_name" name="principal_name" 
                               value="<?php echo htmlspecialchars($settings['principal_name'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="principal_qualification">Qualification</label>
                        <input type="text" id="principal_qualification" name="principal_qualification" 
                               value="<?php echo htmlspecialchars($settings['principal_qualification'] ?? ''); ?>" 
                               placeholder="e.g., M.Ed, Ph.D in Education">
                    </div>

                    <div class="form-group">
                        <label for="principal_experience">Experience</label>
                        <input type="text" id="principal_experience" name="principal_experience" 
                               value="<?php echo htmlspecialchars($settings['principal_experience'] ?? ''); ?>" 
                               placeholder="e.g., 15+ years in education">
                    </div>

                    <div class="form-group">
                        <label for="principal_message">Principal's Message</label>
                        <textarea id="principal_message" name="principal_message" required 
                                  placeholder="Enter the principal's message to students and parents..."><?php echo htmlspecialchars($settings['principal_message'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn">Update Principal's Message</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
