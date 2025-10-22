<?php
// Simple routing for admin panel
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$path = str_replace('/admin/', '', $path);
$path = str_replace('/admin', '', $path);

switch($path) {
    case '':
    case 'login':
        include 'login.php';
        break;
    case 'dashboard':
        include 'dashboard.php';
        break;
    case 'logout':
        include 'logout.php';
        break;
    default:
        // Try to include the file directly
        if (file_exists($path . '.php')) {
            include $path . '.php';
        } else {
            include 'login.php';
        }
        break;
}
?>
