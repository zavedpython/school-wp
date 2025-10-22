<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Create uploads directory if it doesn't exist
$upload_dir = '../uploads/banners/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Load current banner settings
$banner_file = '../data/banner.json';
$banners = [];
if (file_exists($banner_file)) {
    $banners = json_decode(file_get_contents($banner_file), true);
}

$message = '';

// Function to resize image without cropping (stretch to fit)
function resizeImage($source, $destination, $width = 1920, $height = 450) {
    $imageInfo = getimagesize($source);
    $mime = $imageInfo['mime'];
    
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }
    
    $resized = imagecreatetruecolor($width, $height);
    
    // Preserve transparency for PNG and GIF
    if ($mime == 'image/png' || $mime == 'image/gif') {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
        imagefilledrectangle($resized, 0, 0, $width, $height, $transparent);
    }
    
    // Stretch image to fit exact dimensions (no cropping)
    imagecopyresampled($resized, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
    
    switch ($mime) {
        case 'image/jpeg':
            imagejpeg($resized, $destination, 90);
            break;
        case 'image/png':
            imagepng($resized, $destination);
            break;
        case 'image/gif':
            imagegif($resized, $destination);
            break;
    }
    
    imagedestroy($image);
    imagedestroy($resized);
    return true;
}

// Handle file upload
if (isset($_POST['upload'])) {
    $imageFileType = strtolower(pathinfo($_FILES["banner_image"]["name"], PATHINFO_EXTENSION));
    $filename = 'banner_' . time() . '.' . $imageFileType;
    $target_file = $upload_dir . $filename;
    
    $upload_type = $_POST['upload_type'] ?? 'original';
    
    // Check if image file is valid
    if (getimagesize($_FILES["banner_image"]["tmp_name"]) !== false) {
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            
            if ($upload_type === 'original') {
                // Upload original size
                if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)) {
                    // Get original dimensions
                    list($orig_width, $orig_height) = getimagesize($target_file);
                    
                    $banners[] = [
                        'image' => 'uploads/banners/' . $filename,
                        'title' => '',
                        'subtitle' => '',
                        'active' => true,
                        'uploaded' => date('Y-m-d H:i:s'),
                        'original_size' => $_FILES["banner_image"]["size"],
                        'resized_dimensions' => $orig_width . 'x' . $orig_height
                    ];
                    file_put_contents($banner_file, json_encode($banners, JSON_PRETTY_PRINT));
                    $message = "Banner uploaded successfully! Original size: {$orig_width}x{$orig_height}px";
                } else {
                    $message = "Error uploading file.";
                }
            } else {
                // Resize and upload
                $custom_width = !empty($_POST['custom_width']) ? (int)$_POST['custom_width'] : 1920;
                $custom_height = !empty($_POST['custom_height']) ? (int)$_POST['custom_height'] : 450;
                
                // Validate dimensions
                if ($custom_width < 100 || $custom_width > 4000 || $custom_height < 50 || $custom_height > 2000) {
                    $message = "Invalid dimensions. Width: 100-4000px, Height: 50-2000px";
                } else {
                    // Resize and save image
                    if (resizeImage($_FILES["banner_image"]["tmp_name"], $target_file, $custom_width, $custom_height)) {
                        $banners[] = [
                            'image' => 'uploads/banners/' . $filename,
                            'title' => '',
                            'subtitle' => '',
                            'active' => true,
                            'uploaded' => date('Y-m-d H:i:s'),
                            'original_size' => $_FILES["banner_image"]["size"],
                            'resized_dimensions' => $custom_width . 'x' . $custom_height
                        ];
                        file_put_contents($banner_file, json_encode($banners, JSON_PRETTY_PRINT));
                        $message = "Banner uploaded and resized to {$custom_width}x{$custom_height}px!";
                    } else {
                        $message = "Error processing image.";
                    }
                }
            }
        } else {
            $message = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
        $message = "File is not an image.";
    }
}

// Handle banner deletion
if (isset($_GET['delete'])) {
    $index = (int)$_GET['delete'];
    if (isset($banners[$index])) {
        $image_path = '../' . $banners[$index]['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        unset($banners[$index]);
        $banners = array_values($banners);
        file_put_contents($banner_file, json_encode($banners, JSON_PRETTY_PRINT));
        $message = "Banner deleted successfully!";
    }
}

// Handle banner toggle
if (isset($_GET['toggle'])) {
    $index = (int)$_GET['toggle'];
    if (isset($banners[$index])) {
        $banners[$index]['active'] = !$banners[$index]['active'];
        file_put_contents($banner_file, json_encode($banners, JSON_PRETTY_PRINT));
        $message = "Banner status updated!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banner Management - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .form-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-back { background: #95a5a6; }
        .btn-back:hover { background: #7f8c8d; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .btn-success { background: #27ae60; }
        .btn-success:hover { background: #229954; }
        .message { padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .banner-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; }
        .banner-card { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .banner-image { width: 100%; height: 200px; object-fit: cover; }
        .banner-info { padding: 1rem; }
        .banner-actions { display: flex; gap: 0.5rem; margin-top: 1rem; }
        .status-active { color: #27ae60; font-weight: bold; }
        .status-inactive { color: #e74c3c; font-weight: bold; }
        .info-box { background: #e3f2fd; border: 1px solid #2196f3; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .info-box h4 { color: #1976d2; margin-bottom: 0.5rem; }
        .size-info { font-size: 0.9rem; color: #666; margin-top: 0.5rem; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>Banner Management</div>
                <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
            </nav>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <!-- Upload Form -->
            <div class="form-container">
                <h2>Upload New Banner</h2>
                
                <div class="info-box">
                    <h4>🔧 Custom Resize Options</h4>
                    <p>Choose your preferred banner dimensions or use the default <strong>1920x450px</strong>.</p>
                    <p><strong>No cropping:</strong> Images are stretched to fit exact dimensions - entire image will be visible.</p>
                    <p><strong>Tip:</strong> Use images with similar aspect ratio to your target size for best results.</p>
                </div>
                
                <?php if ($message): ?>
                    <div class="message <?php echo strpos($message, 'Error') !== false || strpos($message, 'Invalid') !== false ? 'error' : 'success'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="banner_image">Banner Image</label>
                        <input type="file" id="banner_image" name="banner_image" accept="image/*" required>
                        <small>Formats: JPG, PNG, GIF</small>
                    </div>

                    <div class="form-group">
                        <label>Upload Option:</label>
                        <div style="margin-top: 10px;">
                            <label style="display: block; margin-bottom: 10px; font-weight: normal;">
                                <input type="radio" name="upload_type" value="original" checked style="margin-right: 8px;">
                                <strong>Upload Original Size</strong> - Keep image as-is (recommended for proper aspect ratio)
                            </label>
                            <label style="display: block; font-weight: normal;">
                                <input type="radio" name="upload_type" value="resize" style="margin-right: 8px;">
                                <strong>Resize & Upload</strong> - Resize to custom dimensions
                            </label>
                        </div>
                    </div>
                    
                    <div id="resize-options" style="display: none; border: 1px solid #ddd; padding: 15px; border-radius: 5px; background: #f9f9f9;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="custom_width">Custom Width (px)</label>
                                <input type="number" id="custom_width" name="custom_width" value="1920" min="100" max="4000">
                            </div>
                            <div class="form-group">
                                <label for="custom_height">Custom Height (px)</label>
                                <input type="number" id="custom_height" name="custom_height" value="450" min="50" max="2000">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Quick Presets:</label>
                            <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                                <button type="button" onclick="setDimensions(1920, 450)" class="btn" style="font-size: 0.9rem; padding: 0.5rem 1rem;">Full HD</button>
                                <button type="button" onclick="setDimensions(1366, 400)" class="btn" style="font-size: 0.9rem; padding: 0.5rem 1rem;">Standard</button>
                                <button type="button" onclick="setDimensions(1200, 350)" class="btn" style="font-size: 0.9rem; padding: 0.5rem 1rem;">Compact</button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="upload" class="btn">Upload Banner</button>
                </form>
                
                <script>
                document.querySelectorAll('input[name="upload_type"]').forEach(radio => {
                    radio.addEventListener('change', function() {
                        const resizeOptions = document.getElementById('resize-options');
                        if (this.value === 'resize') {
                            resizeOptions.style.display = 'block';
                        } else {
                            resizeOptions.style.display = 'none';
                        }
                    });
                });
                
                function setDimensions(width, height) {
                    document.getElementById('custom_width').value = width;
                    document.getElementById('custom_height').value = height;
                }
                </script>

                <script>
                function setDimensions(width, height) {
                    document.getElementById('custom_width').value = width;
                    document.getElementById('custom_height').value = height;
                }
                </script>
            </div>

            <!-- Current Banners -->
            <div class="form-container">
                <h2>Current Banners (<?php echo count($banners); ?>)</h2>
                
                <?php if (empty($banners)): ?>
                    <p>No banners uploaded yet.</p>
                <?php else: ?>
                    <div class="banner-grid">
                        <?php foreach ($banners as $index => $banner): ?>
                            <div class="banner-card">
                                <img src="../<?php echo $banner['image']; ?>" alt="Banner" class="banner-image">
                                <div class="banner-info">
                                    <h4><?php echo htmlspecialchars($banner['title'] ?: 'Untitled'); ?></h4>
                                    <p><?php echo htmlspecialchars($banner['subtitle'] ?: 'No subtitle'); ?></p>
                                    <p><small>Uploaded: <?php echo $banner['uploaded']; ?></small></p>
                                    <div class="size-info">
                                        <strong>Dimensions:</strong> <?php echo $banner['resized_dimensions'] ?? '1920x450'; ?>px<br>
                                        <strong>Original Size:</strong> <?php echo isset($banner['original_size']) ? round($banner['original_size']/1024, 1) . 'KB' : 'N/A'; ?>
                                    </div>
                                    <p>Status: <span class="<?php echo $banner['active'] ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo $banner['active'] ? 'Active' : 'Inactive'; ?>
                                    </span></p>
                                    
                                    <div class="banner-actions">
                                        <a href="?toggle=<?php echo $index; ?>" class="btn <?php echo $banner['active'] ? 'btn-danger' : 'btn-success'; ?>">
                                            <?php echo $banner['active'] ? 'Deactivate' : 'Activate'; ?>
                                        </a>
                                        <a href="?delete=<?php echo $index; ?>" class="btn btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this banner?')">Delete</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>
