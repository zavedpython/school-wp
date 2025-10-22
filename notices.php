<?php include "includes/header.php"; ?>

<style>
/* Page specific styles */
.page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; text-align: center; }
.content { padding: 3rem 0; }
.notices-container { max-width: 800px; margin: 0 auto; }
.notice-item { background: white; padding: 2rem; margin-bottom: 1.5rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-left: 5px solid #3498db; transition: transform 0.3s; }
.notice-item:hover { transform: translateX(10px); }
.notice-item.urgent { border-left-color: #e74c3c; }
.notice-item.urgent::before { content: "URGENT"; background: #e74c3c; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.75rem; font-weight: bold; }
.notice-date { color: #3498db; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.5rem; }
.notice-title { color: #2c3e50; font-size: 1.3rem; margin-bottom: 1rem; }
.notice-content { color: #666; line-height: 1.6; }
.notice-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e9ecef; }
.notice-category { background: #f8f9fa; color: #495057; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; }
</style>

<section class="page-header">
    <div class="container">
        <h1>School Notices</h1>
        <p>Stay updated with the latest announcements and information</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="notices-container">
            <div class="notice-item urgent">
                <div class="notice-date">October 25, 2024</div>
                <h3 class="notice-title">Parent-Teacher Meeting</h3>
                <p class="notice-content">Dear Parents, we are organizing a Parent-Teacher meeting on November 5th, 2024, from 10:00 AM to 2:00 PM. Please make sure to attend and discuss your child's progress with the respective teachers. Kindly bring your child's progress report and any concerns you may have.</p>
                <div class="notice-meta">
                    <span class="notice-category">Academic</span>
                    <small>Posted by: Administration</small>
                </div>
            </div>

            <div class="notice-item">
                <div class="notice-date">October 20, 2024</div>
                <h3 class="notice-title">Annual Sports Day 2024</h3>
                <p class="notice-content">Our Annual Sports Day will be held on November 15th, 2024, at the school playground. All students are required to participate in various sporting events. Practice sessions will begin from October 28th. Parents are cordially invited to attend and cheer for their children.</p>
                <div class="notice-meta">
                    <span class="notice-category">Sports</span>
                    <small>Posted by: Sports Department</small>
                </div>
            </div>

            <div class="notice-item">
                <div class="notice-date">October 18, 2024</div>
                <h3 class="notice-title">Diwali Holiday Notice</h3>
                <p class="notice-content">The school will remain closed from November 1st to November 5th, 2024, on account of Diwali festival. Classes will resume on November 6th, 2024. We wish all our students and their families a very Happy and Prosperous Diwali.</p>
                <div class="notice-meta">
                    <span class="notice-category">Holiday</span>
                    <small>Posted by: Administration</small>
                </div>
            </div>

            <div class="notice-item">
                <div class="notice-date">October 15, 2024</div>
                <h3 class="notice-title">Science Exhibition 2024</h3>
                <p class="notice-content">Students from classes 6-12 are invited to participate in the Science Exhibition scheduled for November 20th, 2024. Registration deadline is November 1st, 2024. This is a great opportunity to showcase scientific projects and innovations.</p>
                <div class="notice-meta">
                    <span class="notice-category">Academic</span>
                    <small>Posted by: Science Department</small>
                </div>
            </div>

            <div class="notice-item">
                <div class="notice-date">October 10, 2024</div>
                <h3 class="notice-title">Fee Payment Reminder</h3>
                <p class="notice-content">This is a reminder that the quarterly fees for the second quarter are due by October 31st, 2024. Please ensure timely payment to avoid late fees. Payment can be made at the school office or through online banking.</p>
                <div class="notice-meta">
                    <span class="notice-category">Finance</span>
                    <small>Posted by: Accounts Department</small>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
