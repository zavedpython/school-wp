<?php
session_start();

// Log logout activity
if (isset($_SESSION['username'])) {
    $log_file = '../data/activity_log.json';
    $logs = [];
    if (file_exists($log_file)) {
        $logs = json_decode(file_get_contents($log_file), true) ?: [];
    }
    
    $logs[] = [
        'id' => count($logs) + 1,
        'user' => $_SESSION['username'],
        'action' => 'Logout',
        'details' => 'User logged out',
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    file_put_contents($log_file, json_encode($logs, JSON_PRETTY_PRINT));
}

session_destroy();
header('Location: login.php');
exit;
?>
