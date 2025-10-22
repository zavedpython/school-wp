<?php
// Script to fix footer CSS on all pages

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

$newFooterCSS = '/* Footer */
        .footer { background: #1e3a8a; color: white; padding: 60px 0 20px; }
        .footer-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 40px; margin-bottom: 40px; }
        .footer-section h3 { margin-bottom: 20px; font-size: 1.2rem; }
        .footer-section p, .footer-section a { color: #cbd5e1; text-decoration: none; line-height: 1.8; }
        .footer-section a:hover { color: white; }
        .footer-bottom { border-top: 1px solid #334155; padding-top: 20px; display: flex; justify-content: space-between; align-items: center; color: #cbd5e1; }
        .footer-bottom a { color: white; text-decoration: none; }
        .footer-bottom a:hover { color: #f59e0b; }
        
        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; gap: 10px; text-align: center; }
        }';

foreach ($pages as $page) {
    if (file_exists($page)) {
        $content = file_get_contents($page);
        
        // Replace old footer CSS with new one
        $patterns = [
            '/\.footer\s*\{\s*background:\s*#2c3e50[^}]*\}/',
            '/\.footer\s*\{\s*background:\s*#374151[^}]*\}/',
            '/\.footer\s*\{\s*background:\s*#1e3a8a[^}]*padding:\s*2rem[^}]*\}/'
        ];
        
        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, $newFooterCSS, $content);
        }
        
        // If no footer CSS found, add it before </style>
        if (strpos($content, '.footer-grid') === false) {
            $content = str_replace('</style>', "\n        " . $newFooterCSS . "\n    </style>", $content);
        }
        
        file_put_contents($page, $content);
        echo "Fixed CSS: $page\n";
    }
}

echo "All footer CSS updated!\n";
?>
