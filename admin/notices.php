<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Create uploads directory if it doesn't exist
if (!file_exists('../uploads/notices')) {
    mkdir('../uploads/notices', 0777, true);
}

// Simple file-based storage
$notices_file = '../data/notices.json';
if (!file_exists('../data')) {
    mkdir('../data', 0777, true);
}

// Load notices
if (file_exists($notices_file)) {
    $notices = json_decode(file_get_contents($notices_file), true) ?: [];
} else {
    $notices = [
        ['id' => 1, 'title' => 'Parent-Teacher Meeting', 'content' => 'Parent-Teacher meeting on Oct 25, 2024. All parents requested to attend.', 'notice_type' => 'urgent', 'pdf_file' => '', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 2, 'title' => 'Annual Sports Day', 'content' => 'Annual Sports Day on Nov 15, 2024. Practice sessions start from Oct 28.', 'notice_type' => 'important', 'pdf_file' => '', 'created_at' => date('Y-m-d H:i:s')]
    ];
}

// Handle form submission
if ($_POST && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $pdf_file = '';
        
        // Handle PDF upload if provided
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
            $filename = $_FILES['pdf_file']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if ($ext === 'pdf') {
                $new_filename = 'notice_' . time() . '.pdf';
                $upload_path = '../uploads/notices/' . $new_filename;
                
                if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path)) {
                    $pdf_file = 'uploads/notices/' . $new_filename;
                }
            }
        }
        
        $new_notice = [
            'id' => count($notices) + 1,
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'notice_type' => $_POST['notice_type'],
            'pdf_file' => $pdf_file,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $notices[] = $new_notice;
        file_put_contents($notices_file, json_encode($notices, JSON_PRETTY_PRINT));
        $success = "Notice added successfully!";
    } elseif ($_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $pdf_file = $_POST['existing_pdf'] ?? '';
        
        // Handle new PDF upload if provided
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
            $filename = $_FILES['pdf_file']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if ($ext === 'pdf') {
                // Delete old PDF if exists
                if (!empty($pdf_file) && file_exists('../' . $pdf_file)) {
                    unlink('../' . $pdf_file);
                }
                
                $new_filename = 'notice_' . time() . '.pdf';
                $upload_path = '../uploads/notices/' . $new_filename;
                
                if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path)) {
                    $pdf_file = 'uploads/notices/' . $new_filename;
                }
            }
        }
        
        foreach ($notices as &$notice) {
            if ($notice['id'] == $id) {
                $notice['title'] = $_POST['title'];
                $notice['content'] = $_POST['content'];
                $notice['notice_type'] = $_POST['notice_type'];
                $notice['pdf_file'] = $pdf_file;
                break;
            }
        }
        
        file_put_contents($notices_file, json_encode($notices, JSON_PRETTY_PRINT));
        $success = "Notice updated successfully!";
    } elseif ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        foreach ($notices as $key => $notice) {
            if ($notice['id'] == $id) {
                // Delete PDF file if exists
                if (!empty($notice['pdf_file']) && file_exists('../' . $notice['pdf_file'])) {
                    unlink('../' . $notice['pdf_file']);
                }
                unset($notices[$key]);
                break;
            }
        }
        $notices = array_values($notices);
        file_put_contents($notices_file, json_encode($notices, JSON_PRETTY_PRINT));
        $success = "Notice deleted successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Notices - Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .form-container, .notices-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #2c3e50; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; }
        .form-group textarea { height: 100px; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .btn-back { background: #95a5a6; }
        .btn-back:hover { background: #7f8c8d; }
        .notice-item { border: 1px solid #ddd; padding: 1rem; margin-bottom: 1rem; border-radius: 5px; }
        .notice-type { padding: 2px 8px; border-radius: 3px; font-size: 0.8rem; color: white; }
        .urgent { background: #e74c3c; }
        .important { background: #f39c12; }
        .event { background: #27ae60; }
        .exam { background: #8e44ad; }
        .admission { background: #3498db; }
        .general { background: #95a5a6; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .error { background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .edit-form { display: none; margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 5px; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>Manage Notices</div>
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
                <h2>Add New Notice</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="form-group">
                        <label for="title">Notice Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Notice Content</label>
                        <textarea id="content" name="content" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="notice_type">Notice Type</label>
                        <select id="notice_type" name="notice_type" required>
                            <option value="general">General</option>
                            <option value="urgent">Urgent</option>
                            <option value="important">Important</option>
                            <option value="event">Event</option>
                            <option value="exam">Examination</option>
                            <option value="admission">Admission</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="pdf_file">Attach PDF (Optional)</label>
                        <input type="file" id="pdf_file" name="pdf_file" accept=".pdf">
                        <small style="color: #666;">Upload a PDF file if you want to attach it to this notice</small>
                    </div>
                    
                    <button type="submit" class="btn">Add Notice</button>
                </form>
            </div>
            
            <div class="notices-container">
                <h2>Current Notices</h2>
                <?php foreach ($notices as $notice): ?>
                    <div class="notice-item">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span class="notice-type <?php echo $notice['notice_type']; ?>"><?php echo strtoupper($notice['notice_type']); ?></span>
                            <span style="color: #666; font-size: 0.9rem;"><?php echo date('M d, Y', strtotime($notice['created_at'])); ?></span>
                        </div>
                        <h4><?php echo htmlspecialchars($notice['title']); ?></h4>
                        <p><?php echo htmlspecialchars($notice['content']); ?></p>
                        <?php if (!empty($notice['pdf_file'])): ?>
                            <p><strong>Attachment:</strong> <a href="../<?php echo $notice['pdf_file']; ?>" target="_blank">📄 View PDF</a></p>
                        <?php endif; ?>
                        
                        <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                            <button onclick="toggleEdit(<?php echo $notice['id']; ?>)" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Edit</button>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this notice?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $notice['id']; ?>">
                                <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Delete</button>
                            </form>
                        </div>
                        
                        <div id="edit-form-<?php echo $notice['id']; ?>" class="edit-form">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?php echo $notice['id']; ?>">
                                <input type="hidden" name="existing_pdf" value="<?php echo $notice['pdf_file']; ?>">
                                
                                <div class="form-group">
                                    <label>Notice Title</label>
                                    <input type="text" name="title" value="<?php echo htmlspecialchars($notice['title']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Notice Content</label>
                                    <textarea name="content" required><?php echo htmlspecialchars($notice['content']); ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Notice Type</label>
                                    <select name="notice_type" required>
                                        <option value="general" <?php echo $notice['notice_type'] == 'general' ? 'selected' : ''; ?>>General</option>
                                        <option value="urgent" <?php echo $notice['notice_type'] == 'urgent' ? 'selected' : ''; ?>>Urgent</option>
                                        <option value="important" <?php echo $notice['notice_type'] == 'important' ? 'selected' : ''; ?>>Important</option>
                                        <option value="event" <?php echo $notice['notice_type'] == 'event' ? 'selected' : ''; ?>>Event</option>
                                        <option value="exam" <?php echo $notice['notice_type'] == 'exam' ? 'selected' : ''; ?>>Examination</option>
                                        <option value="admission" <?php echo $notice['notice_type'] == 'admission' ? 'selected' : ''; ?>>Admission</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>PDF Attachment</label>
                                    <?php if (!empty($notice['pdf_file'])): ?>
                                        <p>Current: <a href="../<?php echo $notice['pdf_file']; ?>" target="_blank">📄 View Current PDF</a></p>
                                    <?php endif; ?>
                                    <input type="file" name="pdf_file" accept=".pdf">
                                    <small style="color: #666;">Upload a new PDF to replace the current one (optional)</small>
                                </div>
                                
                                <div style="display: flex; gap: 0.5rem;">
                                    <button type="submit" class="btn">Update Notice</button>
                                    <button type="button" onclick="toggleEdit(<?php echo $notice['id']; ?>)" class="btn" style="background: #95a5a6;">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
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
