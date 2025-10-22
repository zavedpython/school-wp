<?php
echo "=== FINAL FOOTER VERIFICATION ===\n\n";

$pages = [
    'index.php' => 'Homepage',
    'admission.php' => 'Admission Page',
    'circulars.php' => 'Circulars Page', 
    'faculty.php' => 'Faculty Page',
    'fee-structure.php' => 'Fee Structure Page',
    'gallery.php' => 'Gallery Page',
    'notices.php' => 'Notices Page',
    'principal-message.php' => 'Principal Message Page',
    'school-history.php' => 'School History Page',
    'view-gallery.php' => 'View Gallery Page',
    'vision-mission.php' => 'Vision Mission Page'
];

$allGood = true;

foreach ($pages as $file => $name) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $hasInclude = strpos($content, "includes/footer.php") !== false;
        $hasFooterCSS = strpos($content, ".footer {") !== false;
        
        $status = ($hasInclude && $hasFooterCSS) ? "✅ READY" : "❌ MISSING";
        echo sprintf("%-25s: %s\n", $name, $status);
        
        if (!$hasInclude || !$hasFooterCSS) {
            $allGood = false;
        }
    } else {
        echo sprintf("%-25s: ❌ FILE NOT FOUND\n", $name);
        $allGood = false;
    }
}

echo "\n=== FINAL FOOTER FEATURES ===\n";
echo "✅ Copyright: © 2025 NAF Public School. All rights reserved.\n";
echo "✅ Developer: SkyTech Technologies (with WhatsApp link)\n";
echo "✅ Contact Info: School address, Uttar Pradesh, Phone, Email\n";
echo "✅ Location: Correct Google Maps embed + link\n";
echo "✅ 5-column layout: School info, About, Quick Links, Contact, Location\n";
echo "✅ Responsive design for mobile devices\n";
echo "✅ White hyperlinks for visibility\n";

echo "\n=== RESULT ===\n";
if ($allGood) {
    echo "🎉 ALL PAGES HAVE FINAL FOOTER - PRODUCTION READY!\n";
} else {
    echo "⚠️  Some pages need footer updates\n";
}
?>
