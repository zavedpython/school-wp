<?php
// Script to update Contact links in navigation menus

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
        
        // Update Contact link in navigation
        $content = str_replace('href="#contact"', 'href="contact.php"', $content);
        $content = str_replace('href="#Contact"', 'href="contact.php"', $content);
        
        // Add Contact link if navigation exists but Contact is missing
        if (strpos($content, 'nav-links') !== false && strpos($content, 'contact.php') === false) {
            // Look for closing </ul> in navigation and add Contact before it
            $content = preg_replace('/(<li><a href="[^"]*">Gallery<\/a><\/li>\s*<\/ul>)/', '$1' . "\n                            <li><a href=\"contact.php\">Contact</a></li>\n                        </ul>", $content);
        }
        
        file_put_contents($page, $content);
        echo "Updated: $page\n";
    }
}

echo "Contact links updated in all pages!\n";
?>
