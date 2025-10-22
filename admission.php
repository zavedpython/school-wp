<?php include "includes/header.php"; ?>

<style>
/* Page specific styles */
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
</style>

<section class="page-header">
    <div class="container">
        <h1>Admissions Open</h1>
        <p>Join our family of learners and embark on a journey of excellence</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="section">
            <h2>Why Choose NAF Public School?</h2>
            <div class="admission-grid">
                <div class="admission-card">
                    <h3>🎓 Academic Excellence</h3>
                    <p>Our comprehensive curriculum and experienced faculty ensure students receive the highest quality education with focus on both theoretical knowledge and practical application.</p>
                </div>
                <div class="admission-card">
                    <h3>🏆 Holistic Development</h3>
                    <p>We believe in nurturing not just academic skills but also character, creativity, and critical thinking through various co-curricular activities and programs.</p>
                </div>
                <div class="admission-card">
                    <h3>🔬 Modern Facilities</h3>
                    <p>State-of-the-art laboratories, well-equipped classrooms, library, sports facilities, and technology integration provide an optimal learning environment.</p>
                </div>
                <div class="admission-card">
                    <h3>👥 Individual Attention</h3>
                    <p>Small class sizes and dedicated teachers ensure each student receives personalized attention and support to reach their full potential.</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Admission Process</h2>
            <div class="process-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Application Form</h3>
                    <p>Fill out the online application form with all required details and submit necessary documents.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Document Verification</h3>
                    <p>Submit original documents for verification along with photocopies as per the requirements list.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Interaction Session</h3>
                    <p>Attend a brief interaction session with the child and parents to understand learning needs and expectations.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Admission Confirmation</h3>
                    <p>Upon selection, complete the admission formalities and fee payment to secure your child's seat.</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Required Documents</h2>
            <div class="requirements">
                <ul>
                    <li>Birth Certificate (Original + 2 photocopies)</li>
                    <li>Previous School Transfer Certificate (if applicable)</li>
                    <li>Previous School Report Card/Progress Report</li>
                    <li>Passport Size Photographs (6 copies)</li>
                    <li>Address Proof (Ration Card/Voter ID/Aadhar Card)</li>
                    <li>Parent's ID Proof (Aadhar Card/Passport/Driving License)</li>
                    <li>Medical Certificate from Registered Medical Practitioner</li>
                    <li>Caste Certificate (if applicable)</li>
                </ul>
            </div>
        </div>

        <div class="section">
            <h2>Age Criteria</h2>
            <div class="grid">
                <div class="card">
                    <h3>Nursery</h3>
                    <p><strong>Age:</strong> 3+ years<br>
                    <strong>As on:</strong> March 31st</p>
                </div>
                <div class="card">
                    <h3>LKG</h3>
                    <p><strong>Age:</strong> 4+ years<br>
                    <strong>As on:</strong> March 31st</p>
                </div>
                <div class="card">
                    <h3>UKG</h3>
                    <p><strong>Age:</strong> 5+ years<br>
                    <strong>As on:</strong> March 31st</p>
                </div>
                <div class="card">
                    <h3>Class 1</h3>
                    <p><strong>Age:</strong> 6+ years<br>
                    <strong>As on:</strong> March 31st</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Important Information</h2>
            <div class="admission-card">
                <h3>📅 Admission Schedule 2024-25</h3>
                <p><strong>Application Start:</strong> December 1, 2024<br>
                <strong>Last Date to Apply:</strong> February 28, 2025<br>
                <strong>Document Verification:</strong> March 1-15, 2025<br>
                <strong>Interaction Sessions:</strong> March 16-30, 2025<br>
                <strong>Result Declaration:</strong> April 5, 2025<br>
                <strong>Admission Confirmation:</strong> April 6-20, 2025</p>
            </div>
        </div>

        <div class="section" style="text-align: center;">
            <h2>Ready to Apply?</h2>
            <p>Take the first step towards your child's bright future</p>
            <a href="admission-form.php" class="btn" style="font-size: 1.2rem; padding: 15px 40px;">Apply Now Online</a>
            <p style="margin-top: 1rem; color: #666;">
                <strong>For queries:</strong> Call +91-8445030782 | Email: info@fampublicschool.com
            </p>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
