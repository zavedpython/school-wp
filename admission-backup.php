<?php
// Load dynamic settings
$settings_file = 'data/settings.json';
if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
} else {
    $settings = ['school_name' => 'Bal Bharti Public School'];
}

// Load footer data
$footer_file = 'data/footer.json';
if (file_exists($footer_file)) {
    $footer_data = json_decode(file_get_contents($footer_file), true);
} else {
    $footer_data = [
        'about_text' => 'Dedicated to providing quality education and nurturing young minds for a brighter future.',
        'quick_links' => [
            'Admission Process' => 'admission.php',
            'Fee Structure' => 'fee-structure.php',
            'Gallery' => 'gallery.php',
            'Contact Us' => '#contact'
        ],
        'contact_info' => [
            'address' => '123 Education Street, New Delhi - 110001',
            'phone' => '+91-11-12345678',
            'email' => 'info@balbarti.edu',
            'website' => 'www.balbarti.edu'
        ],
        'social_links' => [
            'facebook' => 'https://facebook.com/balbarti',
            'twitter' => 'https://twitter.com/balbarti',
            'instagram' => 'https://instagram.com/balbarti'
        ],
        'copyright_text' => 'All rights reserved.',
        'show_map' => true,
        'map_config' => [
            'embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.674870949309!2d77.20902731508236!3d28.65195908240251!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd0683329da9%3A0x1b2b3f6a5c6d7e8f!2sBal%20Bharti%20Public%20School%2C%20New%20Delhi!5e0!3m2!1sen!2sin!4v1634567890123!5m2!1sen!2sin',
            'directions_url' => 'https://maps.google.com/?q=Bal+Bharti+Public+School+New+Delhi'
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissions - <?php echo htmlspecialchars($settings['school_name']); ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <link rel="alternate icon" href="assets/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin-top: 70px; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; position: fixed; top: 0; width: 100%; z-index: 1000; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; }
        .nav-links { display: flex; list-style: none; gap: 2rem; }
        .nav-links a { color: white; text-decoration: none; }
        .nav-links a:hover { color: #3498db; }
        .dropdown { position: relative; display: inline-block; }
        .dropdown-content { display: none; position: absolute; background: #2c3e50; min-width: 200px; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 1; top: 100%; }
        .dropdown-content a { color: white; padding: 12px 16px; text-decoration: none; display: block; }
        .dropdown-content a:hover { background: #34495e; }
        .dropdown:hover .dropdown-content { display: block; }
        .page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; text-align: center; }
        .content { padding: 3rem 0; }
        .section { margin-bottom: 3rem; }
        .section h2 { color: #2c3e50; margin-bottom: 1.5rem; font-size: 2rem; }
        .section h3 { color: #34495e; margin-bottom: 1rem; font-size: 1.3rem; }
        .admission-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin: 2rem 0; }
        .admission-card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-left: 4px solid #3498db; }
        .process-steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0; }
        .step { background: #f8f9fa; padding: 1.5rem; border-radius: 8px; text-align: center; }
        .step-number { background: #3498db; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-weight: bold; }
        .requirements { background: #f8f9fa; padding: 2rem; border-radius: 10px; margin: 2rem 0; }
        .requirements ul { list-style-type: none; padding: 0; }
        .requirements li { padding: 0.5rem 0; border-bottom: 1px solid #e9ecef; }
        .requirements li:before { content: "✓"; color: #28a745; font-weight: bold; margin-right: 10px; }
        .btn { background: #3498db; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 1rem 0; }
        .btn:hover { background: #2980b9; }
        .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-top: 2rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .card h3 { color: #2c3e50; margin-bottom: 1rem; }
        .footer { background: #2c3e50; color: white; text-align: center; padding: 2rem 0; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo" style="display: flex; align-items: center; gap: 10px;"><img src="assets/logo.svg" alt="<?php echo htmlspecialchars($settings['school_name']); ?>" style="height: 50px;"></div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="#about">About Us ▼</a>
                        <div class="dropdown-content">
                            <a href="school-history.php">School History</a>
                            <a href="vision-mission.php">Vision & Mission</a>
                            <a href="principal-message.php">Principal's Message</a>
                            <a href="faculty.php">Faculty</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="admission.php">Admissions ▼</a>
                        <div class="dropdown-content">
                            <a href="admission.php">Admission Process</a>
                            <a href="fee-structure.php">Fee Structure</a>
                            <a href="admission-form.php">Online Application</a>
                        </div>
                    </li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="notices.php">Notices</a></li>
                    <li><a href="circulars.php">Circulars</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="page-header">
        <div class="container">
            <h1>Admissions 2024-25</h1>
            <p>Join our community of learners and leaders</p>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="section">
                <h2>Admission Process</h2>
                <div class="process-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <h3>Application Form</h3>
                        <p>Fill out the online application form with all required details</p>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <h3>Document Submission</h3>
                        <p>Submit all required documents along with the application</p>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <h3>Interaction/Assessment</h3>
                        <p>Student interaction and assessment as per age group</p>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <h3>Admission Confirmation</h3>
                        <p>Fee payment and admission confirmation</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Class-wise Admission Details</h2>
                <div class="admission-grid">
                    <div class="admission-card">
                        <h3>Pre-Primary (Nursery - UKG)</h3>
                        <p><strong>Age Criteria:</strong> 3-5 years</p>
                        <p><strong>Assessment:</strong> Interactive session with child</p>
                        <p><strong>Documents:</strong> Birth certificate, Medical certificate, Photographs</p>
                        <a href="#" class="btn">Apply Now</a>
                    </div>
                    <div class="admission-card">
                        <h3>Primary (Class I - V)</h3>
                        <p><strong>Age Criteria:</strong> 6-10 years</p>
                        <p><strong>Assessment:</strong> Basic reading, writing, and interaction</p>
                        <p><strong>Documents:</strong> Previous school records, Transfer certificate</p>
                        <a href="#" class="btn">Apply Now</a>
                    </div>
                    <div class="admission-card">
                        <h3>Middle School (Class VI - VIII)</h3>
                        <p><strong>Age Criteria:</strong> 11-13 years</p>
                        <p><strong>Assessment:</strong> Written test and interview</p>
                        <p><strong>Documents:</strong> Previous 2 years report cards, TC</p>
                        <a href="#" class="btn">Apply Now</a>
                    </div>
                    <div class="admission-card">
                        <h3>Secondary (Class IX - XII)</h3>
                        <p><strong>Age Criteria:</strong> 14-17 years</p>
                        <p><strong>Assessment:</strong> Entrance test and interview</p>
                        <p><strong>Documents:</strong> Board exam certificates, TC</p>
                        <a href="#" class="btn">Apply Now</a>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Required Documents</h2>
                <div class="requirements">
                    <ul>
                        <li>Duly filled application form</li>
                        <li>Birth certificate (original and photocopy)</li>
                        <li>Previous school report cards/mark sheets</li>
                        <li>Transfer certificate from previous school</li>
                        <li>Character certificate from previous school</li>
                        <li>Medical fitness certificate</li>
                        <li>Recent passport size photographs (4 copies)</li>
                        <li>Address proof (Aadhaar card/Voter ID/Passport)</li>
                        <li>Caste certificate (if applicable)</li>
                        <li>Income certificate (for fee concession)</li>
                    </ul>
                </div>
            </div>

            <div class="section">
                <h2>Important Dates</h2>
                <div class="admission-grid">
                    <div class="admission-card">
                        <h3>Application Start</h3>
                        <p>December 1, 2023</p>
                    </div>
                    <div class="admission-card">
                        <h3>Application Deadline</h3>
                        <p>February 28, 2024</p>
                    </div>
                    <div class="admission-card">
                        <h3>Assessment Period</h3>
                        <p>March 1-15, 2024</p>
                    </div>
                    <div class="admission-card">
                        <h3>Result Declaration</h3>
                        <p>March 20, 2024</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Contact for Admissions</h2>
                <div class="admission-grid">
                    <div class="admission-card">
                        <h3>Admission Office</h3>
                        <p><strong>Phone:</strong> +91-11-12345678</p>
                        <p><strong>Email:</strong> admissions@balbarti.edu</p>
                        <p><strong>Timing:</strong> 9:00 AM - 4:00 PM (Mon-Fri)</p>
                    </div>
                    <div class="admission-card">
                        <h3>Principal's Office</h3>
                        <p><strong>Phone:</strong> +91-11-12345679</p>
                        <p><strong>Email:</strong> principal@balbarti.edu</p>
                        <p><strong>Timing:</strong> 10:00 AM - 2:00 PM (Mon-Fri)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer style="background: #374151; color: white;">
        <div style="background: #4b5563; padding: 2rem 0;">
            <div class="container">
                <h3 style="font-size: 1.5rem; font-weight: bold; text-align: center; margin-bottom: 1.5rem;">Visit Our Campus</h3>
                <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.674870949309!2d77.20902731508236!3d28.65195908240251!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd0683329da9%3A0x1b2b3f6a5c6d7e8f!2sNew%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1634567890123!5m2!1sen!2sin"
                        width="100%"
                        height="300"
                        style="border: 0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="School Location">
                    </iframe>
                </div>
                <div style="text-align: center; margin-top: 1rem;">
                    <p style="color: #d1d5db;">123 Education Street, New Delhi - 110001</p>
                    <a href="https://maps.google.com/?q=Bal+Bharti+Public+School+New+Delhi" target="_blank" 
                       style="display: inline-block; margin-top: 0.5rem; background: #3498db; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">
                        Get Directions
                    </a>
                </div>
            </div>
        </div>
        <div style="padding: 3rem 0;">
            <div class="container">
                <div class="grid">
                    <div class="card" style="background: transparent; box-shadow: none; color: white;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Bal Bharti Public School</h4>
                        <p style="color: #d1d5db; margin-bottom: 1rem;">Providing quality education since 1985. Nurturing young minds for a brighter future.</p>
                        <div style="display: flex; gap: 1rem;">
                            <a href="https://facebook.com/balbarti" target="_blank" style="color: #d1d5db; text-decoration: none;">📘 Facebook</a>
                            <a href="https://instagram.com/balbarti" target="_blank" style="color: #d1d5db; text-decoration: none;">📷 Instagram</a>
                            <a href="https://wa.me/911112345678" target="_blank" style="color: #d1d5db; text-decoration: none;">💬 WhatsApp</a>
                        </div>
                    </div>
                    <div class="card" style="background: transparent; box-shadow: none; color: white;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Quick Links</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">School History</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">Vision & Mission</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">Principal's Message</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">Faculty</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">Admission</a></li>
                        </ul>
                    </div>
                    <div class="card" style="background: transparent; box-shadow: none; color: white;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Services</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">Help Desk</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">Fee Structure</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">Gallery</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">Circulars</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #d1d5db; text-decoration: none;">Bus Routes</a></li>
                        </ul>
                    </div>
                    <div class="card" style="background: transparent; box-shadow: none; color: white;">
                        <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Contact Info</h4>
                        <div style="color: #d1d5db;">
                            <p style="margin-bottom: 0.5rem;">📍 123 Education Street<br />New Delhi - 110001</p>
                            <p style="margin-bottom: 0.5rem;">📞 +91-11-12345678</p>
                            <p style="margin-bottom: 0.5rem;">✉️ info@balbarti.edu</p>
                            <p style="margin-bottom: 0.5rem;">🕒 Mon-Fri: 8:00 AM - 4:00 PM<br />Sat: 8:00 AM - 12:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="background: #1f2937; padding: 1rem 0;">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <p style="color: #9ca3af; font-size: 0.875rem;">© 2024 Bal Bharti Public School. All rights reserved.</p>
                    <p style="color: #9ca3af; font-size: 0.875rem; margin-top: 0.5rem;">Developed by <span style="color: #3498db; font-weight: 600;">SkyTech IT Solutions</span></p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
