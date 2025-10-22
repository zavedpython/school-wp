<?php
$pages = [
    'admission.php',
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
        
        // Only replace the header HTML section, keep all CSS and other content
        $pattern = '/(<header.*?<\/header>)/s';
        if (preg_match($pattern, $content, $matches)) {
            $new_header = '<?php include "includes/header.php"; ?>';
            $new_content = str_replace($matches[1], $new_header, $content);
            
            // Also add the main-content div wrapper if not present
            if (strpos($new_content, 'main-content') === false) {
                $new_content = str_replace($new_header, $new_header . "\n    <div class=\"main-content\">", $new_content);
                $new_content = str_replace('</body>', "    </div>\n</body>", $new_content);
            }
            
            file_put_contents($page, $new_content);
            echo "Fixed header for: $page\n";
        }
    }
}
echo "Headers fixed while preserving page designs!\n";
?>
