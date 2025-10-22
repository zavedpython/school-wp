<?php
// Script to fix duplicate footers

$pages = [
    'admission.php',
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
        
        // Remove any existing footer HTML (keep only the include)
        $content = preg_replace('/<footer[^>]*>.*?<\/footer>\s*(?=<\?php include)/s', '', $content);
        
        // Ensure footer include is present before closing body
        if (strpos($content, "include 'includes/footer.php'") === false) {
            $content = str_replace('</body>', "    <?php include 'includes/footer.php'; ?>\n</body>", $content);
        }
        
        file_put_contents($page, $content);
        echo "Fixed: $page\n";
    }
}

echo "Footer fix completed!\n";
?>
