<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Create uploads directory if it doesn't exist
if (!file_exists('../uploads/gallery')) {
    mkdir('../uploads/gallery', 0777, true);
}

// Load categories from file
$categories_file = '../data/categories.json';
if (file_exists($categories_file)) {
    $categories = json_decode(file_get_contents($categories_file), true) ?: [];
} else {
    // Default categories
    $categories = [
        'independence-day' => 'Independence Day',
        'diwali-event' => 'Diwali Event',
        'sports-day' => 'Sports Day',
        'annual-function' => 'Annual Function',
        'science-exhibition' => 'Science Exhibition',
        'environment-day' => 'Environment Day',
        'teachers-day' => 'Teachers Day',
        'rose-day' => 'Rose Day',
        'graduation-day' => 'Graduation Day',
        'health-awareness' => 'Health Awareness',
        'book-fair' => 'Book Fair',
        'campus-life' => 'Campus Life'
    ];
    file_put_contents($categories_file, json_encode($categories, JSON_PRETTY_PRINT));
}

// Load gallery data
$gallery_file = '../data/gallery.json';
if (file_exists($gallery_file)) {
    $gallery_data = json_decode(file_get_contents($gallery_file), true) ?: [];
} else {
    $gallery_data = [];
}

// Handle form submission
if ($_POST) {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add_category') {
            $cat_key = strtolower(str_replace(' ', '-', $_POST['category_key']));
            $cat_name = $_POST['category_name'];
            if (!empty($cat_key) && !empty($cat_name)) {
                $categories[$cat_key] = $cat_name;
                file_put_contents($categories_file, json_encode($categories, JSON_PRETTY_PRINT));
                $success = "Category added successfully!";
            } else {
                $error = "Please fill all category fields.";
            }
        } elseif ($_POST['action'] == 'edit_category') {
            $old_key = $_POST['old_key'];
            $new_key = strtolower(str_replace(' ', '-', $_POST['category_key']));
            $new_name = $_POST['category_name'];
            
            if (!empty($new_key) && !empty($new_name)) {
                // Update category
                unset($categories[$old_key]);
                $categories[$new_key] = $new_name;
                
                // Update gallery data if key changed
                if ($old_key !== $new_key) {
                    foreach ($gallery_data as &$item) {
                        if ($item['category'] === $old_key) {
                            $item['category'] = $new_key;
                        }
                    }
                    file_put_contents($gallery_file, json_encode($gallery_data, JSON_PRETTY_PRINT));
                }
                
                file_put_contents($categories_file, json_encode($categories, JSON_PRETTY_PRINT));
                $success = "Category updated successfully!";
            } else {
                $error = "Please fill all category fields.";
            }
        } elseif ($_POST['action'] == 'delete_category') {
            $cat_key = $_POST['category_key'];
            
            // Delete all images in this category
            foreach ($gallery_data as $key => $item) {
                if ($item['category'] === $cat_key) {
                    if (file_exists('../' . $item['image_path'])) {
                        unlink('../' . $item['image_path']);
                    }
                    unset($gallery_data[$key]);
                }
            }
            $gallery_data = array_values($gallery_data);
            file_put_contents($gallery_file, json_encode($gallery_data, JSON_PRETTY_PRINT));
            
            // Delete category
            unset($categories[$cat_key]);
            file_put_contents($categories_file, json_encode($categories, JSON_PRETTY_PRINT));
            $success = "Category and all its images deleted successfully!";
        } elseif ($_POST['action'] == 'upload') {
            $category = $_POST['category'];
            $caption = $_POST['caption'];
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $new_filename = $category . '_' . time() . '.' . $ext;
                    $upload_path = '../uploads/gallery/' . $new_filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $gallery_data[] = [
                            'id' => count($gallery_data) + 1,
                            'category' => $category,
                            'image_path' => 'uploads/gallery/' . $new_filename,
                            'caption' => $caption,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        
                        file_put_contents($gallery_file, json_encode($gallery_data, JSON_PRETTY_PRINT));
                        $success = "Image uploaded successfully!";
                    } else {
                        $error = "Failed to upload image.";
                    }
                } else {
                    $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
                }
            } else {
                $error = "Please select an image to upload.";
            }
        } elseif ($_POST['action'] == 'delete') {
            $id = $_POST['id'];
            foreach ($gallery_data as $key => $item) {
                if ($item['id'] == $id) {
                    if (file_exists('../' . $item['image_path'])) {
                        unlink('../' . $item['image_path']);
                    }
                    unset($gallery_data[$key]);
                    break;
                }
            }
            $gallery_data = array_values($gallery_data);
            file_put_contents($gallery_file, json_encode($gallery_data, JSON_PRETTY_PRINT));
            $success = "Image deleted successfully!";
        }
    }
}

// Group images by category
$grouped_images = [];
foreach ($gallery_data as $item) {
    $grouped_images[$item['category']][] = $item;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery - Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .form-container, .gallery-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #2c3e50; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .btn-back { background: #95a5a6; }
        .btn-back:hover { background: #7f8c8d; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .error { background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .category-section { margin-bottom: 2rem; }
        .category-title { color: #2c3e50; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #3498db; }
        .image-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
        .image-item { border: 1px solid #ddd; border-radius: 5px; overflow: hidden; }
        .image-item img { width: 100%; height: 150px; object-fit: cover; }
        .image-info { padding: 0.5rem; }
        .image-caption { font-size: 0.9rem; margin-bottom: 0.5rem; }
        .image-date { font-size: 0.8rem; color: #666; margin-bottom: 0.5rem; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>Manage Gallery</div>
                <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
            </nav>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <?php if (isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Category Management Section -->
            <div class="form-container">
                <h2>Manage Categories</h2>
                
                <!-- Add New Category -->
                <div style="margin-bottom: 2rem;">
                    <h3>Add New Category</h3>
                    <form method="POST" style="display: flex; gap: 1rem; align-items: end;">
                        <input type="hidden" name="action" value="add_category">
                        <div class="form-group" style="margin-bottom: 0; flex: 1;">
                            <label for="category_key">Category Key (URL-friendly)</label>
                            <input type="text" id="category_key" name="category_key" placeholder="e.g., new-event" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0; flex: 1;">
                            <label for="category_name">Category Name</label>
                            <input type="text" id="category_name" name="category_name" placeholder="e.g., New Event" required>
                        </div>
                        <button type="submit" class="btn">Add Category</button>
                    </form>
                </div>
                
                <!-- Existing Categories -->
                <div>
                    <h3>Existing Categories</h3>
                    <div style="display: grid; gap: 1rem;">
                        <?php foreach ($categories as $key => $name): ?>
                            <div style="border: 1px solid #ddd; padding: 1rem; border-radius: 5px; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong><?php echo htmlspecialchars($name); ?></strong>
                                    <span style="color: #666; margin-left: 10px;">(<?php echo $key; ?>)</span>
                                    <span style="color: #999; margin-left: 10px;"><?php echo count($grouped_images[$key] ?? []); ?> images</span>
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <button onclick="editCategory('<?php echo $key; ?>', '<?php echo htmlspecialchars($name); ?>')" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Edit</button>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Delete this category and ALL its images?')">
                                        <input type="hidden" name="action" value="delete_category">
                                        <input type="hidden" name="category_key" value="<?php echo $key; ?>">
                                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Edit Category Modal -->
            <div id="editModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
                <div style="background: white; margin: 15% auto; padding: 2rem; width: 500px; border-radius: 10px;">
                    <h3>Edit Category</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="edit_category">
                        <input type="hidden" id="edit_old_key" name="old_key">
                        
                        <div class="form-group">
                            <label for="edit_category_key">Category Key</label>
                            <input type="text" id="edit_category_key" name="category_key" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_category_name">Category Name</label>
                            <input type="text" id="edit_category_name" name="category_name" required>
                        </div>
                        
                        <div style="display: flex; gap: 1rem; justify-content: end;">
                            <button type="button" onclick="closeEditModal()" class="btn" style="background: #95a5a6;">Cancel</button>
                            <button type="submit" class="btn">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="form-container">
                <h2>Upload New Image</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload">
                    
                    <div class="form-group">
                        <label for="category">Gallery Category</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $key => $name): ?>
                                <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Select Image</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="caption">Image Caption</label>
                        <input type="text" id="caption" name="caption" placeholder="Enter image caption" required>
                    </div>
                    
                    <button type="submit" class="btn">Upload Image</button>
                </form>
            </div>
            
            <div class="gallery-container">
                <h2>Current Gallery Images</h2>
                
                <?php foreach ($categories as $cat_key => $cat_name): ?>
                    <?php if (isset($grouped_images[$cat_key])): ?>
                        <div class="category-section">
                            <h3 class="category-title"><?php echo $cat_name; ?> (<?php echo count($grouped_images[$cat_key]); ?> images)</h3>
                            <div class="image-grid">
                                <?php foreach ($grouped_images[$cat_key] as $image): ?>
                                    <div class="image-item">
                                        <img src="../<?php echo $image['image_path']; ?>" alt="<?php echo htmlspecialchars($image['caption']); ?>">
                                        <div class="image-info">
                                            <div class="image-caption"><?php echo htmlspecialchars($image['caption']); ?></div>
                                            <div class="image-date"><?php echo date('M d, Y', strtotime($image['created_at'])); ?></div>
                                            <form method="POST" style="margin-top: 0.5rem;" onsubmit="return confirm('Are you sure you want to delete this image?')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?php echo $image['id']; ?>">
                                                <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                
                <?php if (empty($gallery_data)): ?>
                    <p>No images uploaded yet. Use the form above to upload images to different gallery categories.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <script>
        function editCategory(key, name) {
            document.getElementById('edit_old_key').value = key;
            document.getElementById('edit_category_key').value = key;
            document.getElementById('edit_category_name').value = name;
            document.getElementById('editModal').style.display = 'block';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>
