<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Load activity logs
$log_file = '../data/activity_log.json';
$logs = [];
if (file_exists($log_file)) {
    $logs = json_decode(file_get_contents($log_file), true) ?: [];
}

// Sort logs by timestamp (newest first)
usort($logs, function($a, $b) {
    return strtotime($b['timestamp']) - strtotime($a['timestamp']);
});

// Pagination
$per_page = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_logs = count($logs);
$total_pages = ceil($total_logs / $per_page);
$offset = ($page - 1) * $per_page;
$logs_page = array_slice($logs, $offset, $per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log - Admin Panel</title>
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="alternate icon" href="../assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .content { padding: 2rem 0; }
        .log-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .log-table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .log-table th, .log-table td { padding: 1rem; text-align: left; border-bottom: 1px solid #ddd; }
        .log-table th { background: #f8f9fa; font-weight: bold; }
        .btn { background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-back { background: #95a5a6; }
        .btn-back:hover { background: #7f8c8d; }
        .action-badge { padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; color: white; }
        .action-login { background: #27ae60; }
        .action-logout { background: #e74c3c; }
        .action-create { background: #3498db; }
        .action-update { background: #f39c12; }
        .action-delete { background: #e74c3c; }
        .action-other { background: #95a5a6; }
        .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem; }
        .pagination a { padding: 0.5rem 1rem; background: #3498db; color: white; text-decoration: none; border-radius: 5px; }
        .pagination a:hover { background: #2980b9; }
        .pagination .current { background: #2c3e50; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; }
        .stat-number { font-size: 2rem; font-weight: bold; color: #3498db; }
        .stat-label { color: #666; margin-top: 0.5rem; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div>Activity Log</div>
                <a href="user-management.php" class="btn btn-back">← Back to User Management</a>
            </nav>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <!-- Statistics -->
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_logs; ?></div>
                    <div class="stat-label">Total Activities</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo count(array_filter($logs, function($log) { return strpos($log['action'], 'Login') !== false; })); ?></div>
                    <div class="stat-label">Login Activities</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo count(array_unique(array_column($logs, 'user'))); ?></div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo count(array_filter($logs, function($log) { return date('Y-m-d', strtotime($log['timestamp'])) === date('Y-m-d'); })); ?></div>
                    <div class="stat-label">Today's Activities</div>
                </div>
            </div>
            
            <div class="log-container">
                <h2>Activity Log</h2>
                <?php if (empty($logs_page)): ?>
                    <p>No activity logs found.</p>
                <?php else: ?>
                    <table class="log-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs_page as $log): ?>
                                <tr>
                                    <td><?php echo date('M d, Y H:i:s', strtotime($log['timestamp'])); ?></td>
                                    <td><?php echo htmlspecialchars($log['user']); ?></td>
                                    <td>
                                        <?php
                                        $action_class = 'action-other';
                                        if (strpos($log['action'], 'Login') !== false) $action_class = 'action-login';
                                        elseif (strpos($log['action'], 'Logout') !== false) $action_class = 'action-logout';
                                        elseif (strpos($log['action'], 'Created') !== false || strpos($log['action'], 'Added') !== false) $action_class = 'action-create';
                                        elseif (strpos($log['action'], 'Updated') !== false || strpos($log['action'], 'Modified') !== false) $action_class = 'action-update';
                                        elseif (strpos($log['action'], 'Deleted') !== false) $action_class = 'action-delete';
                                        ?>
                                        <span class="action-badge <?php echo $action_class; ?>"><?php echo htmlspecialchars($log['action']); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($log['details']); ?></td>
                                    <td><?php echo htmlspecialchars($log['ip_address']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                        <div class="pagination">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo $page - 1; ?>">← Previous</a>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                <a href="?page=<?php echo $i; ?>" <?php echo $i == $page ? 'class="current"' : ''; ?>><?php echo $i; ?></a>
                            <?php endfor; ?>
                            
                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?php echo $page + 1; ?>">Next →</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>
