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
        
        // Find the end of the header section (look for </header> or start of main content)
        if (preg_match('/(<header.*?<\/header>)/s', $content, $matches)) {
            // Replace the entire header section
            $new_content = str_replace($matches[1], '<?php include "includes/header.php"; ?>', $content);
            
            // Also remove any duplicate DOCTYPE, html, head tags if they exist after header include
            $new_content = preg_replace('/(<\?php include "includes\/header\.php"; \?>)\s*<!DOCTYPE html>.*?<body[^>]*>/s', '$1', $new_content);
            
            file_put_contents($page, $new_content);
            echo "Updated: $page\n";
        }
    }
}
echo "Header update complete!\n";
?>
