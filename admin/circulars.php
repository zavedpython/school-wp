<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Create uploads directory if it doesn't exist
if (!file_exists('../uploads/circulars')) {
    mkdir('../uploads/circulars', 0777, true);
}

// Load circulars data
$circulars_file = '../data/circulars.json';
if (file_exists($circulars_file)) {
    $circulars = json_decode(file_get_contents($circulars_file), true) ?: [];
} else {
    $circulars = [];
}

// Handle form submission
if ($_POST) {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'upload') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
                $filename = $_FILES['pdf_file']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if ($ext === 'pdf') {
                    $new_filename = 'circular_' . time() . '.pdf';
                    $upload_path = '../uploads/circulars/' . $new_filename;
                    
                    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path)) {
                        $circulars[] = [
                            'id' => count($circulars) + 1,
                            'title' => $title,
                            'description' => $description,
                            'file_path' => 'uploads/circulars/' . $new_filename,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        
                        file_put_contents($circulars_file, json_encode($circulars, JSON_PRETTY_PRINT));
                        $success = "Circular uploaded successfully!";
                    } else {
                        $error = "Failed to upload circular.";
                    }
                } else {
                    $error = "Only PDF files are allowed.";
                }
            } else {
                $error = "Please select a PDF file to upload.";
            }
        } elseif ($_POST['action'] == 'edit') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            foreach ($circulars as &$circular) {
                if ($circular['id'] == $id) {
                    $circular['title'] = $title;
                    $circular['description'] = $description;
                    break;
                }
            }
            
            file_put_contents($circulars_file, json_encode($circulars, JSON_PRETTY_PRINT));
            $success = "Circular updated successfully!";
        } elseif ($_POST['action'] == 'delete') {
            $id = $_POST['id'];
            
            foreach ($circulars as $key => $circular) {
                if ($circular['id'] == $id) {
                    if (file_exists('../' . $circular['file_path'])) {
                        unlink('../' . $circular['file_path']);
                    }
                    unset($circulars[$key]);
                    break;
                }
            }
            
            $circulars = array_values($circulars);
            file_put_contents($circulars_file, json_encode($circulars, JSON_PRETTY_PRINT));
            $success = "Circular deleted successfully!";
        }
    }
}

// Sort circulars by date (newest first)
usort($circulars, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Circulars - Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .form-container, .circulars-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #2c3e50; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; }
        .form-group textarea { height: 80px; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .btn-back { background: #95a5a6; }
        .btn-back:hover { background: #7f8c8d; }
        .circular-item { border: 1px solid #ddd; padding: 1rem; margin-bottom: 1rem; border-radius: 5px; }
        .circular-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
        .circular-date { color: #666; font-size: 0.9rem; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .error { background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .edit-form { display: none; margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 5px; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>Manage Circulars</div>
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
            
            <div class="form-container">
                <h2>Upload New Circular</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload">
                    
                    <div class="form-group">
                        <label for="title">Circular Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" placeholder="Brief description of the circular"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="pdf_file">PDF File</label>
                        <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" required>
                    </div>
                    
                    <button type="submit" class="btn">Upload Circular</button>
                </form>
            </div>
            
            <div class="circulars-container">
                <h2>Current Circulars</h2>
                <?php if (empty($circulars)): ?>
                    <p>No circulars uploaded yet.</p>
                <?php else: ?>
                    <?php foreach ($circulars as $circular): ?>
                        <div class="circular-item">
                            <div class="circular-header">
                                <h4><?php echo htmlspecialchars($circular['title']); ?></h4>
                                <span class="circular-date"><?php echo date('M d, Y', strtotime($circular['created_at'])); ?></span>
                            </div>
                            <p><?php echo htmlspecialchars($circular['description']); ?></p>
                            <p><strong>File:</strong> <a href="../<?php echo $circular['file_path']; ?>" target="_blank">View PDF</a></p>
                            
                            <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                                <button onclick="toggleEdit(<?php echo $circular['id']; ?>)" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Edit</button>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this circular?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $circular['id']; ?>">
                                    <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Delete</button>
                                </form>
                            </div>
                            
                            <div id="edit-form-<?php echo $circular['id']; ?>" class="edit-form">
                                <form method="POST">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?php echo $circular['id']; ?>">
                                    
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" value="<?php echo htmlspecialchars($circular['title']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description"><?php echo htmlspecialchars($circular['description']); ?></textarea>
                                    </div>
                                    
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button type="submit" class="btn">Update</button>
                                        <button type="button" onclick="toggleEdit(<?php echo $circular['id']; ?>)" class="btn" style="background: #95a5a6;">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <script>
        function toggleEdit(id) {
            const form = document.getElementById('edit-form-' + id);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
