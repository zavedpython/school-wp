<?php
session_start();

// Function to log activity
function logActivity($action, $details = '', $user = 'Unknown') {
    $log_file = '../data/activity_log.json';
    $logs = [];
    if (file_exists($log_file)) {
        $logs = json_decode(file_get_contents($log_file), true) ?: [];
    }
    
    $logs[] = [
        'id' => count($logs) + 1,
        'user' => $user,
        'action' => $action,
        'details' => $details,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    // Keep only last 1000 logs
    if (count($logs) > 1000) {
        $logs = array_slice($logs, -1000);
    }
    
    file_put_contents($log_file, json_encode($logs, JSON_PRETTY_PRINT));
}

// Load users data
$users_file = '../data/users.json';
if (file_exists($users_file)) {
    $users = json_decode(file_get_contents($users_file), true) ?: [];
} else {
    // Default admin user
    $users = [
        [
            'id' => 1,
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'full_name' => 'System Administrator',
            'email' => 'admin@school.edu',
            'created_at' => date('Y-m-d H:i:s'),
            'last_login' => '',
            'status' => 'active'
        ]
    ];
    if (!file_exists('../data')) {
        mkdir('../data', 0777, true);
    }
    file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
}

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password)) {
        foreach ($users as &$user) {
            if ($user['username'] === $username && $user['status'] === 'active') {
                if (password_verify($password, $user['password'])) {
                    // Update last login
                    $user['last_login'] = date('Y-m-d H:i:s');
                    file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
                    
                    // Set session variables
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['admin_username'] = $username; // Keep for backward compatibility
                    
                    // Log successful login
                    logActivity('Login Success', "User logged in successfully", $username);
                    
                    header('Location: dashboard.php');
                    exit;
                }
            }
        }
        
        // Log failed login attempt
        logActivity('Login Failed', "Failed login attempt for username: $username", $username);
        $error = "Invalid username or password";
    } else {
        $error = "Please enter both username and password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - School Management</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); width: 400px; }
        .login-header { text-align: center; margin-bottom: 2rem; color: #2c3e50; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #2c3e50; font-weight: bold; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; }
        .form-group input:focus { outline: none; border-color: #3498db; }
        .btn { background: #3498db; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; width: 100%; }
        .btn:hover { background: #2980b9; }
        .error { color: #e74c3c; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Admin Login</h2>
            <p>School Management System</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        
        <div style="text-align: center; margin-top: 1rem; color: #666; font-size: 0.9rem;">
            Default: admin / admin123
        </div>
    </div>
</body>
</html>
