<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
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
    file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
}

// Function to log activity
function logActivity($action, $details = '') {
    $log_file = '../data/activity_log.json';
    $logs = [];
    if (file_exists($log_file)) {
        $logs = json_decode(file_get_contents($log_file), true) ?: [];
    }
    
    $logs[] = [
        'id' => count($logs) + 1,
        'user' => $_SESSION['username'] ?? 'Unknown',
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

// Handle form submission
if ($_POST) {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add_user') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            
            // Check if username exists
            $username_exists = false;
            foreach ($users as $user) {
                if ($user['username'] === $username) {
                    $username_exists = true;
                    break;
                }
            }
            
            if (!$username_exists) {
                $new_user = [
                    'id' => count($users) + 1,
                    'username' => $username,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => $role,
                    'full_name' => $full_name,
                    'email' => $email,
                    'created_at' => date('Y-m-d H:i:s'),
                    'last_login' => '',
                    'status' => 'active'
                ];
                
                $users[] = $new_user;
                file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
                logActivity('User Created', "Created user: $username with role: $role");
                $success = "User created successfully!";
            } else {
                $error = "Username already exists!";
            }
        } elseif ($_POST['action'] == 'edit_user') {
            $id = $_POST['id'];
            $role = $_POST['role'];
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $status = $_POST['status'];
            
            foreach ($users as &$user) {
                if ($user['id'] == $id) {
                    $old_role = $user['role'];
                    $user['role'] = $role;
                    $user['full_name'] = $full_name;
                    $user['email'] = $email;
                    $user['status'] = $status;
                    
                    logActivity('User Updated', "Updated user: {$user['username']} - Role changed from $old_role to $role");
                    break;
                }
            }
            
            file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
            $success = "User updated successfully!";
        } elseif ($_POST['action'] == 'delete_user') {
            $id = $_POST['id'];
            
            foreach ($users as $key => $user) {
                if ($user['id'] == $id && $user['username'] !== 'admin') {
                    logActivity('User Deleted', "Deleted user: {$user['username']}");
                    unset($users[$key]);
                    break;
                }
            }
            
            $users = array_values($users);
            file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
            $success = "User deleted successfully!";
        } elseif ($_POST['action'] == 'reset_password') {
            $id = $_POST['id'];
            $new_password = $_POST['new_password'];
            
            foreach ($users as &$user) {
                if ($user['id'] == $id) {
                    $user['password'] = password_hash($new_password, PASSWORD_DEFAULT);
                    logActivity('Password Reset', "Reset password for user: {$user['username']}");
                    break;
                }
            }
            
            file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
            $success = "Password reset successfully!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .form-container, .users-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #2c3e50; }
        .form-group input, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .btn-warning { background: #f39c12; }
        .btn-warning:hover { background: #e67e22; }
        .btn-back { background: #95a5a6; }
        .btn-back:hover { background: #7f8c8d; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .error { background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .user-table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .user-table th, .user-table td { padding: 1rem; text-align: left; border-bottom: 1px solid #ddd; }
        .user-table th { background: #f8f9fa; font-weight: bold; }
        .role-badge { padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; color: white; }
        .role-admin { background: #e74c3c; }
        .role-editor { background: #f39c12; }
        .role-viewer { background: #27ae60; }
        .status-active { color: #27ae60; font-weight: bold; }
        .status-inactive { color: #e74c3c; font-weight: bold; }
        .edit-form { display: none; margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 5px; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>User Management</div>
                <div>
                    <a href="activity-log.php" class="btn" style="margin-right: 1rem;">View Activity Log</a>
                    <a href="dashboard.php" class="btn btn-back">← Back to Dashboard</a>
                </div>
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
                <h2>Add New User</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="add_user">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" id="full_name" name="full_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">User Role</label>
                        <select id="role" name="role" required>
                            <option value="viewer">Viewer (Read Only)</option>
                            <option value="editor">Editor (Read/Write)</option>
                            <option value="admin">Admin (Full Access)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Add User</button>
                </form>
            </div>
            
            <div class="users-container">
                <h2>Current Users</h2>
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><span class="role-badge role-<?php echo $user['role']; ?>"><?php echo strtoupper($user['role']); ?></span></td>
                                <td><span class="status-<?php echo $user['status']; ?>"><?php echo strtoupper($user['status']); ?></span></td>
                                <td><?php echo $user['last_login'] ? date('M d, Y H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
                                <td>
                                    <button onclick="editUser(<?php echo $user['id']; ?>)" class="btn" style="padding: 0.5rem; font-size: 0.8rem;">Edit</button>
                                    <button onclick="resetPassword(<?php echo $user['id']; ?>)" class="btn btn-warning" style="padding: 0.5rem; font-size: 0.8rem;">Reset Password</button>
                                    <?php if ($user['username'] !== 'admin'): ?>
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Delete this user?')">
                                            <input type="hidden" name="action" value="delete_user">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem; font-size: 0.8rem;">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            
                            <!-- Edit Form -->
                            <tr id="edit-form-<?php echo $user['id']; ?>" class="edit-form" style="display: none;">
                                <td colspan="7">
                                    <form method="POST">
                                        <input type="hidden" name="action" value="edit_user">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                        
                                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem; align-items: end;">
                                            <div>
                                                <label>Full Name</label>
                                                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                            </div>
                                            <div>
                                                <label>Email</label>
                                                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                            </div>
                                            <div>
                                                <label>Role</label>
                                                <select name="role" required>
                                                    <option value="viewer" <?php echo $user['role'] == 'viewer' ? 'selected' : ''; ?>>Viewer</option>
                                                    <option value="editor" <?php echo $user['role'] == 'editor' ? 'selected' : ''; ?>>Editor</option>
                                                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label>Status</label>
                                                <select name="status" required>
                                                    <option value="active" <?php echo $user['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                                    <option value="inactive" <?php echo $user['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div style="margin-top: 1rem;">
                                            <button type="submit" class="btn">Update User</button>
                                            <button type="button" onclick="editUser(<?php echo $user['id']; ?>)" class="btn" style="background: #95a5a6;">Cancel</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    
    <!-- Password Reset Modal -->
    <div id="passwordModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
        <div style="background: white; margin: 15% auto; padding: 2rem; width: 400px; border-radius: 10px;">
            <h3>Reset Password</h3>
            <form method="POST">
                <input type="hidden" name="action" value="reset_password">
                <input type="hidden" id="reset_user_id" name="id">
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: end;">
                    <button type="button" onclick="closePasswordModal()" class="btn" style="background: #95a5a6;">Cancel</button>
                    <button type="submit" class="btn">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function editUser(id) {
            const form = document.getElementById('edit-form-' + id);
            form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
        }
        
        function resetPassword(id) {
            document.getElementById('reset_user_id').value = id;
            document.getElementById('passwordModal').style.display = 'block';
        }
        
        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('passwordModal');
            if (event.target === modal) {
                closePasswordModal();
            }
        }
    </script>
</body>
</html>
