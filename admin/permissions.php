<?php
// Permission checking functions

function hasPermission($required_permission) {
    if (!isset($_SESSION['user_role'])) {
        return false;
    }
    
    $role = $_SESSION['user_role'];
    
    switch ($role) {
        case 'admin':
            return true; // Admin has all permissions
            
        case 'editor':
            return in_array($required_permission, [
                'read', 'write', 'edit', 'create', 'upload',
                'manage_notices', 'manage_gallery', 'manage_circulars',
                'manage_footer', 'manage_settings'
            ]);
            
        case 'viewer':
            return in_array($required_permission, ['read', 'view']);
            
        default:
            return false;
    }
}

function requirePermission($permission) {
    if (!hasPermission($permission)) {
        header('Location: access-denied.php');
        exit;
    }
}

function requireLogin() {
    if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
        header('Location: login.php');
        exit;
    }
}

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

function getUserRole() {
    return $_SESSION['user_role'] ?? 'guest';
}

function isAdmin() {
    return getUserRole() === 'admin';
}

function canWrite() {
    return hasPermission('write');
}

function canRead() {
    return hasPermission('read');
}
?>
