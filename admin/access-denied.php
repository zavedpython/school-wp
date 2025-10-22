<?php
session_start();
require_once 'permissions.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { background: white; padding: 3rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; max-width: 500px; }
        .error-icon { font-size: 4rem; color: #e74c3c; margin-bottom: 1rem; }
        h1 { color: #2c3e50; margin-bottom: 1rem; }
        p { color: #666; margin-bottom: 2rem; line-height: 1.6; }
        .btn { background: #3498db; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .user-info { background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-bottom: 2rem; }
        .role-badge { padding: 4px 12px; border-radius: 12px; font-size: 0.9rem; color: white; }
        .role-admin { background: #e74c3c; }
        .role-editor { background: #f39c12; }
        .role-viewer { background: #27ae60; }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-icon">🚫</div>
        <h1>Access Denied</h1>
        <p>You don't have permission to access this page. Your current role doesn't allow this action.</p>
        
        <div class="user-info">
            <p><strong>Current User:</strong> <?php echo htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username']); ?></p>
            <p><strong>Role:</strong> <span class="role-badge role-<?php echo getUserRole(); ?>"><?php echo strtoupper(getUserRole()); ?></span></p>
        </div>
        
        <p>If you believe this is an error, please contact your administrator.</p>
        
        <a href="dashboard.php" class="btn">← Back to Dashboard</a>
    </div>
</body>
</html>
