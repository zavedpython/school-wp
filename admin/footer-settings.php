<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Load footer settings
$footer_file = '../data/footer.json';
if (file_exists($footer_file)) {
    $footer_data = json_decode(file_get_contents($footer_file), true);
} else {
    $footer_data = [
        'about_text' => 'Dedicated to providing quality education and nurturing young minds for a brighter future.',
        'quick_links' => [
            'Admission Process' => 'admission.php',
            'Fee Structure' => 'fee-structure.php',
            'Gallery' => 'gallery.php',
            'Contact Us' => '#contact'
        ],
        'contact_info' => [
            'address' => '123 Education Street, New Delhi - 110001',
            'phone' => '+91-11-12345678',
            'email' => 'info@balbarti.edu',
            'website' => 'www.balbarti.edu'
        ],
        'social_links' => [
            'facebook' => 'https://facebook.com/balbarti',
            'twitter' => 'https://twitter.com/balbarti',
            'instagram' => 'https://instagram.com/balbarti',
            'youtube' => 'https://youtube.com/balbarti'
        ],
        'copyright_text' => 'All rights reserved.',
        'show_map' => true
    ];
    file_put_contents($footer_file, json_encode($footer_data, JSON_PRETTY_PRINT));
}

// Handle form submission
if ($_POST) {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'update_footer') {
            $footer_data['about_text'] = $_POST['about_text'];
            $footer_data['copyright_text'] = $_POST['copyright_text'];
            $footer_data['show_map'] = isset($_POST['show_map']);
            
            // Update contact info
            $footer_data['contact_info']['address'] = $_POST['address'];
            $footer_data['contact_info']['phone'] = $_POST['phone'];
            $footer_data['contact_info']['email'] = $_POST['email'];
            $footer_data['contact_info']['website'] = $_POST['website'];
            
            // Update social links
            $footer_data['social_links']['facebook'] = $_POST['facebook'];
            $footer_data['social_links']['twitter'] = $_POST['twitter'];
            $footer_data['social_links']['instagram'] = $_POST['instagram'];
            $footer_data['social_links']['youtube'] = $_POST['youtube'];
            
            // Update quick links
            $quick_links = [];
            if (!empty($_POST['link_names']) && !empty($_POST['link_urls'])) {
                for ($i = 0; $i < count($_POST['link_names']); $i++) {
                    if (!empty($_POST['link_names'][$i]) && !empty($_POST['link_urls'][$i])) {
                        $quick_links[$_POST['link_names'][$i]] = $_POST['link_urls'][$i];
                    }
                }
            }
            $footer_data['quick_links'] = $quick_links;
            
            file_put_contents($footer_file, json_encode($footer_data, JSON_PRETTY_PRINT));
            $success = "Footer settings updated successfully!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Settings - Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .form-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #2c3e50; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; }
        .form-group textarea { height: 100px; resize: vertical; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .btn { background: #3498db; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-back { background: #95a5a6; }
        .btn-back:hover { background: #7f8c8d; }
        .btn-add { background: #27ae60; padding: 0.5rem 1rem; font-size: 0.9rem; }
        .btn-add:hover { background: #219a52; }
        .btn-remove { background: #e74c3c; padding: 0.5rem 1rem; font-size: 0.9rem; }
        .btn-remove:hover { background: #c0392b; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .section-title { color: #2c3e50; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #3498db; }
        .link-item { display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem; }
        .checkbox-group { display: flex; align-items: center; gap: 0.5rem; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>Footer Settings</div>
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
                <h2>Manage Footer Content</h2>
                
                <form method="POST">
                    <input type="hidden" name="action" value="update_footer">
                    
                    <!-- About Section -->
                    <h3 class="section-title">About Section</h3>
                    <div class="form-group">
                        <label for="about_text">About Text</label>
                        <textarea id="about_text" name="about_text" placeholder="Brief description about the school"><?php echo htmlspecialchars($footer_data['about_text']); ?></textarea>
                    </div>
                    
                    <!-- Contact Information -->
                    <h3 class="section-title">Contact Information</h3>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address"><?php echo htmlspecialchars($footer_data['contact_info']['address']); ?></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($footer_data['contact_info']['phone']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($footer_data['contact_info']['email']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" value="<?php echo htmlspecialchars($footer_data['contact_info']['website']); ?>">
                    </div>
                    
                    <!-- Quick Links -->
                    <h3 class="section-title">Quick Links</h3>
                    <div id="quick-links">
                        <?php foreach ($footer_data['quick_links'] as $name => $url): ?>
                            <div class="link-item">
                                <input type="text" name="link_names[]" placeholder="Link Name" value="<?php echo htmlspecialchars($name); ?>" style="flex: 1;">
                                <input type="text" name="link_urls[]" placeholder="URL" value="<?php echo htmlspecialchars($url); ?>" style="flex: 1;">
                                <button type="button" onclick="removeLink(this)" class="btn btn-remove">Remove</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="addLink()" class="btn btn-add">Add Link</button>
                    
                    <!-- Social Media -->
                    <h3 class="section-title">Social Media Links</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="url" id="facebook" name="facebook" value="<?php echo htmlspecialchars($footer_data['social_links']['facebook']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input type="url" id="twitter" name="twitter" value="<?php echo htmlspecialchars($footer_data['social_links']['twitter']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="url" id="instagram" name="instagram" value="<?php echo htmlspecialchars($footer_data['social_links']['instagram']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="youtube">YouTube</label>
                            <input type="url" id="youtube" name="youtube" value="<?php echo htmlspecialchars($footer_data['social_links']['youtube']); ?>">
                        </div>
                    </div>
                    
                    <!-- Footer Options -->
                    <h3 class="section-title">Footer Options</h3>
                    <div class="form-group">
                        <label for="copyright_text">Copyright Text</label>
                        <input type="text" id="copyright_text" name="copyright_text" value="<?php echo htmlspecialchars($footer_data['copyright_text']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="show_map" name="show_map" <?php echo $footer_data['show_map'] ? 'checked' : ''; ?>>
                            <label for="show_map">Show Google Maps in Footer</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Update Footer Settings</button>
                </form>
            </div>
        </div>
    </section>
    
    <script>
        function addLink() {
            const container = document.getElementById('quick-links');
            const linkItem = document.createElement('div');
            linkItem.className = 'link-item';
            linkItem.innerHTML = `
                <input type="text" name="link_names[]" placeholder="Link Name" style="flex: 1;">
                <input type="text" name="link_urls[]" placeholder="URL" style="flex: 1;">
                <button type="button" onclick="removeLink(this)" class="btn btn-remove">Remove</button>
            `;
            container.appendChild(linkItem);
        }
        
        function removeLink(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>
