<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$principal_file = '../data/principal.json';

// Handle form submission
if ($_POST) {
    $principal_data = [
        'name' => $_POST['principal_name'],
        'qualification' => $_POST['qualification'],
        'experience' => $_POST['experience'],
        'message' => $_POST['message'],
        'photo' => ''
    ];
    
    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['photo'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_extension, ['jpg', 'jpeg', 'png'])) {
            if ($file['size'] <= 5 * 1024 * 1024) {
                $new_filename = 'principal_photo.' . $file_extension;
                $upload_path = '../uploads/' . $new_filename;
                
                if (!file_exists('../uploads')) {
                    mkdir('../uploads', 0755, true);
                }
                
                if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                    $principal_data['photo'] = 'uploads/' . $new_filename;
                }
            }
        }
    } else {
        // Keep existing photo if no new upload
        if (file_exists($principal_file)) {
            $existing_data = json_decode(file_get_contents($principal_file), true);
            $principal_data['photo'] = $existing_data['photo'] ?? '';
        }
    }
    
    // Create data directory if not exists
    if (!file_exists('../data')) {
        mkdir('../data', 0755, true);
    }
    
    file_put_contents($principal_file, json_encode($principal_data, JSON_PRETTY_PRINT));
    $message = 'Principal information updated successfully!';
}

// Load existing data
$principal_data = [];
if (file_exists($principal_file)) {
    $principal_data = json_decode(file_get_contents($principal_file), true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal Management - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .header { background: #1e3a8a; color: white; padding: 1rem; border-radius: 10px 10px 0 0; }
        .content { background: white; padding: 2rem; border-radius: 0 0 10px 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem; }
        .form-group textarea { height: 200px; resize: vertical; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #1e3a8a; }
        .btn { background: #1e3a8a; color: white; padding: 0.75rem 2rem; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; }
        .btn:hover { background: #1e40af; }
        .success { background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; }
        .current-photo { max-width: 200px; border-radius: 10px; margin: 1rem 0; }
        .nav-links { margin-bottom: 2rem; }
        .nav-links a { color: #1e3a8a; text-decoration: none; margin-right: 1rem; }
        .nav-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Principal Management</h1>
        </div>
        <div class="content">
            <div class="nav-links">
                <a href="dashboard.php">← Back to Dashboard</a>
                <a href="../principal-message.php" target="_blank">View Principal Page</a>
            </div>
            
            <?php if ($message): ?>
                <div class="success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="principal_name">Principal Name</label>
                    <input type="text" id="principal_name" name="principal_name" 
                           value="<?php echo htmlspecialchars($principal_data['name'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="qualification">Qualification</label>
                    <input type="text" id="qualification" name="qualification" 
                           value="<?php echo htmlspecialchars($principal_data['qualification'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="experience">Experience</label>
                    <input type="text" id="experience" name="experience" 
                           value="<?php echo htmlspecialchars($principal_data['experience'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="photo">Principal Photo</label>
                    <?php if (!empty($principal_data['photo']) && file_exists('../' . $principal_data['photo'])): ?>
                        <img src="../<?php echo htmlspecialchars($principal_data['photo']); ?>" 
                             alt="Current Principal Photo" class="current-photo">
                        <p>Current photo (upload new to replace)</p>
                    <?php endif; ?>
                    <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png">
                    <small>Upload JPG, JPEG, or PNG (Max 5MB)</small>
                </div>
                
                <div class="form-group">
                    <label for="message">Principal's Message</label>
                    <textarea id="message" name="message" required><?php echo htmlspecialchars($principal_data['message'] ?? ''); ?></textarea>
                </div>
                
                <button type="submit" class="btn">Update Principal Information</button>
            </form>
        </div>
    </div>
</body>
</html>
