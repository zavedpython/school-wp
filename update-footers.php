<?php
// Script to update all pages with common footer

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

$footerCss = '
/* Footer */
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
        
        // Add footer CSS if not present
        if (strpos($content, '.footer {') === false) {
            $content = str_replace('</style>', $footerCss . "\n    </style>", $content);
        }
        
        // Add footer include before closing body tag
        if (strpos($content, "include 'includes/footer.php'") === false) {
            $content = str_replace('</body>', "    <?php include 'includes/footer.php'; ?>\n</body>", $content);
        }
        
        file_put_contents($page, $content);
        echo "Updated: $page\n";
    }
}

echo "Footer update completed!\n";
?>
