<?php include "includes/header.php"; ?>

<style>
/* Page specific styles */
.page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; text-align: center; }
.form-container { max-width: 800px; margin: 0 auto; padding: 3rem 0; }
.form-section { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
.form-section h3 { color: #2c3e50; margin-bottom: 1.5rem; border-bottom: 2px solid #3498db; padding-bottom: 0.5rem; }
.form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 1rem; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; margin-bottom: 0.5rem; color: #2c3e50; font-weight: 500; }
.form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; }
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #3498db; outline: none; }
.btn { background: #3498db; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; }
.btn:hover { background: #2980b9; }
.required { color: #e74c3c; }
.file-upload { border: 2px dashed #3498db; padding: 1rem; text-align: center; border-radius: 5px; }
.instructions { background: #f8f9fa; padding: 1.5rem; border-radius: 5px; margin-bottom: 2rem; border-left: 4px solid #3498db; }
</style>

<section class="page-header">
    <div class="container">
        <h1>Online Admission Form</h1>
        <p>Fill out the form below to apply for admission</p>
    </div>
</section>

<div class="container">
    <div class="form-container">
        <div class="instructions">
            <h3>📋 Instructions</h3>
            <ul>
                <li>Fill all required fields marked with <span class="required">*</span></li>
                <li>Upload clear scanned copies of documents (PDF/JPG format, max 2MB each)</li>
                <li>Ensure all information is accurate before submission</li>
                <li>You will receive an application number after successful submission</li>
            </ul>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <h3>👤 Student Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="student_name">Full Name <span class="required">*</span></label>
                        <input type="text" id="student_name" name="student_name" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth <span class="required">*</span></label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="gender">Gender <span class="required">*</span></label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class_applying">Class Applying For <span class="required">*</span></label>
                        <select id="class_applying" name="class_applying" required>
                            <option value="">Select Class</option>
                            <option value="Nursery">Nursery</option>
                            <option value="LKG">LKG</option>
                            <option value="UKG">UKG</option>
                            <option value="Class 1">Class 1</option>
                            <option value="Class 2">Class 2</option>
                            <option value="Class 3">Class 3</option>
                            <option value="Class 4">Class 4</option>
                            <option value="Class 5">Class 5</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address <span class="required">*</span></label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>👨‍👩‍👧‍👦 Parent Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="father_name">Father's Name <span class="required">*</span></label>
                        <input type="text" id="father_name" name="father_name" required>
                    </div>
                    <div class="form-group">
                        <label for="mother_name">Mother's Name <span class="required">*</span></label>
                        <input type="text" id="mother_name" name="mother_name" required>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="father_occupation">Father's Occupation</label>
                        <input type="text" id="father_occupation" name="father_occupation">
                    </div>
                    <div class="form-group">
                        <label for="mother_occupation">Mother's Occupation</label>
                        <input type="text" id="mother_occupation" name="mother_occupation">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>📄 Document Upload</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="birth_certificate">Birth Certificate <span class="required">*</span></label>
                        <input type="file" id="birth_certificate" name="birth_certificate" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="form-group">
                        <label for="photo">Student Photo <span class="required">*</span></label>
                        <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png" required>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="address_proof">Address Proof</label>
                        <input type="file" id="address_proof" name="address_proof" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    <div class="form-group">
                        <label for="previous_school">Previous School Certificate</label>
                        <input type="file" id="previous_school" name="previous_school" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>ℹ️ Additional Information</h3>
                <div class="form-group">
                    <label for="previous_school_name">Previous School Name (if any)</label>
                    <input type="text" id="previous_school_name" name="previous_school_name">
                </div>
                <div class="form-group">
                    <label for="medical_conditions">Any Medical Conditions/Allergies</label>
                    <textarea id="medical_conditions" name="medical_conditions" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="additional_info">Additional Information</label>
                    <textarea id="additional_info" name="additional_info" rows="3"></textarea>
                </div>
            </div>

            <div class="form-section" style="text-align: center;">
                <button type="submit" class="btn" style="font-size: 1.2rem; padding: 15px 40px;">Submit Application</button>
                <p style="margin-top: 1rem; color: #666; font-size: 0.9rem;">
                    By submitting this form, you agree to our terms and conditions.
                </p>
            </div>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>
