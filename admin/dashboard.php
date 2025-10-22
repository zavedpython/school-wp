<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - School Management</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; }
        .user-info { display: flex; align-items: center; gap: 1rem; }
        .content { padding: 2rem 0; }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin: 2rem 0; }
        .dashboard-card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; }
        .dashboard-card h3 { color: #2c3e50; margin-bottom: 1rem; }
        .dashboard-card p { color: #666; margin-bottom: 1.5rem; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 5px; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo">School Admin Panel</div>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? $_SESSION['admin_username']); ?> 
                    (<?php echo strtoupper($_SESSION['user_role'] ?? 'admin'); ?>)</span>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </nav>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <h1>Dashboard</h1>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>🏫 School Settings</h3>
                    <p>Update school information, contact details, and basic settings</p>
                    <a href="school-settings.php" class="btn">Manage Settings</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>🎨 Logo Management</h3>
                    <p>Upload and manage school logo for website header</p>
                    <a href="logo-management.php" class="btn">Manage Logo</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>🦶 Footer Settings</h3>
                    <p>Manage footer content, social links, and contact information</p>
                    <a href="footer-settings.php" class="btn">Manage Footer</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>👥 User Management</h3>
                    <p>Manage users, roles, and permissions. View activity logs</p>
                    <a href="user-management.php" class="btn">Manage Users</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>📢 Notice Board</h3>
                    <p>Add, edit, and manage notice board announcements</p>
                    <a href="notices.php" class="btn">Manage Notices</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>📸 Gallery</h3>
                    <p>Upload and organize gallery photos by categories</p>
                    <a href="gallery.php" class="btn">Manage Gallery</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>📄 Circulars</h3>
                    <p>Upload and manage PDF circulars and documents</p>
                    <a href="circulars.php" class="btn">Manage Circulars</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>👨‍💼 Principal's Message</h3>
                    <p>Update principal's message and information</p>
                    <a href="principal-management.php" class="btn">Manage Principal</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>🎯 Vision & Mission</h3>
                    <p>Edit school's vision, mission, and core values</p>
                    <a href="vision-mission.php" class="btn">Edit Content</a>
                </div>

                <div class="dashboard-card">
                    <h3>📚 School History</h3>
                    <p>Manage school history, founding details, and achievements</p>
                    <a href="school-history.php" class="btn">Edit Content</a>
                </div>

                <div class="dashboard-card">
                    <h3>🖼️ Banner Management</h3>
                    <p>Upload and manage homepage banner images</p>
                    <a href="banner-management.php" class="btn">Manage Banners</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
