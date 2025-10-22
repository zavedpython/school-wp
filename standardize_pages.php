<?php
$pages = [
    'admission.php',
    'admission-form.php', 
    'contact.php',
    'circulars.php',
    'faculty.php',
    'fee-structure.php',
    'gallery.php',
    'notices.php',
    'principal-message.php',
    'school-history.php',
    'view-gallery.php',
    'vision-mission.php'
];

foreach ($pages as $page) {
    if (file_exists($page)) {
        $content = file_get_contents($page);
        
        // Remove everything before the main content and replace with header include
        $pattern = '/^.*?(<main|<div class="main|<div class="page|<section)/s';
        if (preg_match($pattern, $content, $matches)) {
            $new_content = '<?php include "includes/header.php"; ?>' . "\n\n" . $matches[1] . substr($content, strpos($content, $matches[1]) + strlen($matches[1]));
            file_put_contents($page, $new_content);
            echo "Standardized: $page\n";
        }
    }
}
echo "All pages now use common header!\n";
?>
