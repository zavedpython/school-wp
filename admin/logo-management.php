<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Create uploads directory if it doesn't exist
$upload_dir = '../uploads/logo/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Load current logo
$logo_file = '../data/logo.json';
$current_logo = '';
if (file_exists($logo_file)) {
    $logo_data = json_decode(file_get_contents($logo_file), true);
    $current_logo = $logo_data['logo_path'] ?? '';
}

$message = '';

// Handle logo upload
if (isset($_POST['upload_logo'])) {
    $imageFileType = strtolower(pathinfo($_FILES["logo_image"]["name"], PATHINFO_EXTENSION));
    $filename = 'school_logo.' . $imageFileType;
    $target_file = $upload_dir . $filename;
    
    if (getimagesize($_FILES["logo_image"]["tmp_name"]) !== false) {
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
            if (move_uploaded_file($_FILES["logo_image"]["tmp_name"], $target_file)) {
                // Remove old logo if exists
                if ($current_logo && file_exists('../' . $current_logo)) {
                    unlink('../' . $current_logo);
                }
                
                $logo_data = [
                    'logo_path' => 'uploads/logo/' . $filename,
                    'uploaded' => date('Y-m-d H:i:s')
                ];
                file_put_contents($logo_file, json_encode($logo_data, JSON_PRETTY_PRINT));
                $current_logo = $logo_data['logo_path'];
                $message = "Logo uploaded successfully!";
            } else {
                $message = "Error uploading logo.";
            }
        } else {
            $message = "Only JPG, JPEG, PNG, GIF & SVG files are allowed.";
        }
    } else {
        $message = "File is not an image.";
    }
}

// Handle logo removal
if (isset($_GET['remove'])) {
    if ($current_logo && file_exists('../' . $current_logo)) {
        unlink('../' . $current_logo);
    }
    unlink($logo_file);
    $current_logo = '';
    $message = "Logo removed successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logo Management - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .form-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-back { background: #95a5a6; }
        .btn-danger { background: #e74c3c; }
        .message { padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .current-logo { text-align: center; margin: 2rem 0; }
        .current-logo img { max-width: 200px; max-height: 100px; border: 1px solid #ddd; padding: 10px; border-radius: 5px; }
        .info-box { background: #e3f2fd; border: 1px solid #2196f3; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>Logo Management</div>
                <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
            </nav>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <?php if ($message): ?>
                <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Current Logo -->
            <?php if ($current_logo): ?>
                <div class="form-container">
                    <h2>Current School Logo</h2>
                    <div class="current-logo">
                        <img src="../<?php echo htmlspecialchars($current_logo); ?>" alt="School Logo">
                        <br><br>
                        <a href="?remove=1" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove the current logo?')">Remove Logo</a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Upload Form -->
            <div class="form-container">
                <h2><?php echo $current_logo ? 'Replace' : 'Upload'; ?> School Logo</h2>
                
                <div class="info-box">
                    <h4>📋 Logo Guidelines</h4>
                    <p>• Recommended size: 200x80px or similar aspect ratio</p>
                    <p>• Formats: JPG, PNG, GIF, SVG</p>
                    <p>• Transparent background (PNG/SVG) works best</p>
                    <p>• Logo will appear in the website header</p>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="logo_image">Select Logo Image:</label>
                        <input type="file" id="logo_image" name="logo_image" accept="image/*" required>
                    </div>
                    
                    <button type="submit" name="upload_logo" class="btn">Upload Logo</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
