<?php include "includes/header.php"; ?>

<style>
/* Page specific styles */
.page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; text-align: center; }
.content { padding: 3rem 0; }
.fee-table-container { background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; margin: 2rem 0; }
.fee-table { width: 100%; border-collapse: collapse; }
.fee-table th { background: #2c3e50; color: white; padding: 1rem; text-align: left; font-weight: 600; }
.fee-table td { padding: 1rem; border-bottom: 1px solid #e9ecef; }
.fee-table tr:hover { background: #f8f9fa; }
.fee-table tr:nth-child(even) { background: #f8f9fa; }
.fee-amount { font-weight: 600; color: #2c3e50; }
.section-header { text-align: center; margin-bottom: 3rem; }
.section-header h2 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 1rem; }
.section-header p { color: #666; font-size: 1.1rem; }
.info-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin: 3rem 0; }
.info-card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-left: 4px solid #3498db; }
.info-card h3 { color: #2c3e50; margin-bottom: 1rem; }
.info-card ul { list-style-type: none; padding: 0; }
.info-card li { padding: 0.5rem 0; color: #666; }
.info-card li:before { content: "✓"; color: #28a745; font-weight: bold; margin-right: 10px; }
</style>

<section class="page-header">
    <div class="container">
        <h1>Fee Structure</h1>
        <p>Transparent and affordable fee structure for quality education</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="section-header">
            <h2>Academic Year 2024-25</h2>
            <p>Complete fee breakdown for all classes</p>
        </div>

        <div class="fee-table-container">
            <table class="fee-table">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Admission Fee</th>
                        <th>Monthly Tuition</th>
                        <th>Annual Charges</th>
                        <th>Total (First Year)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Nursery</strong></td>
                        <td class="fee-amount">₹5,000</td>
                        <td class="fee-amount">₹2,500</td>
                        <td class="fee-amount">₹3,000</td>
                        <td class="fee-amount">₹38,000</td>
                    </tr>
                    <tr>
                        <td><strong>LKG</strong></td>
                        <td class="fee-amount">₹5,000</td>
                        <td class="fee-amount">₹2,800</td>
                        <td class="fee-amount">₹3,500</td>
                        <td class="fee-amount">₹42,100</td>
                    </tr>
                    <tr>
                        <td><strong>UKG</strong></td>
                        <td class="fee-amount">₹5,000</td>
                        <td class="fee-amount">₹3,000</td>
                        <td class="fee-amount">₹4,000</td>
                        <td class="fee-amount">₹45,000</td>
                    </tr>
                    <tr>
                        <td><strong>Class 1-2</strong></td>
                        <td class="fee-amount">₹6,000</td>
                        <td class="fee-amount">₹3,500</td>
                        <td class="fee-amount">₹5,000</td>
                        <td class="fee-amount">₹53,000</td>
                    </tr>
                    <tr>
                        <td><strong>Class 3-5</strong></td>
                        <td class="fee-amount">₹7,000</td>
                        <td class="fee-amount">₹4,000</td>
                        <td class="fee-amount">₹6,000</td>
                        <td class="fee-amount">₹61,000</td>
                    </tr>
                    <tr>
                        <td><strong>Class 6-8</strong></td>
                        <td class="fee-amount">₹8,000</td>
                        <td class="fee-amount">₹4,500</td>
                        <td class="fee-amount">₹7,000</td>
                        <td class="fee-amount">₹69,000</td>
                    </tr>
                    <tr>
                        <td><strong>Class 9-10</strong></td>
                        <td class="fee-amount">₹10,000</td>
                        <td class="fee-amount">₹5,000</td>
                        <td class="fee-amount">₹8,000</td>
                        <td class="fee-amount">₹78,000</td>
                    </tr>
                    <tr>
                        <td><strong>Class 11-12</strong></td>
                        <td class="fee-amount">₹12,000</td>
                        <td class="fee-amount">₹6,000</td>
                        <td class="fee-amount">₹10,000</td>
                        <td class="fee-amount">₹94,000</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="info-cards">
            <div class="info-card">
                <h3>💰 Fee Includes</h3>
                <ul>
                    <li>Tuition and Academic Fees</li>
                    <li>Library and Laboratory Usage</li>
                    <li>Sports and Physical Education</li>
                    <li>Co-curricular Activities</li>
                    <li>Parent-Teacher Meetings</li>
                    <li>Progress Reports and Assessments</li>
                </ul>
            </div>

            <div class="info-card">
                <h3>📅 Payment Schedule</h3>
                <ul>
                    <li>Admission Fee: At the time of admission</li>
                    <li>Monthly Fee: By 10th of each month</li>
                    <li>Annual Charges: With first month fee</li>
                    <li>Late Payment: ₹100 fine after due date</li>
                    <li>Payment Methods: Cash, Cheque, Online</li>
                    <li>Fee Receipt: Mandatory for all payments</li>
                </ul>
            </div>

            <div class="info-card">
                <h3>🎯 Additional Information</h3>
                <ul>
                    <li>Sibling Discount: 10% on tuition fee</li>
                    <li>Transport Fee: ₹1,500-2,500 per month</li>
                    <li>Uniform & Books: ₹3,000-5,000 annually</li>
                    <li>Examination Fee: ₹500 per term</li>
                    <li>Activity Fee: ₹1,000 per year</li>
                    <li>Refund Policy: As per school guidelines</li>
                </ul>
            </div>
        </div>

        <div class="info-card" style="text-align: center; margin-top: 2rem;">
            <h3>📞 For Fee Related Queries</h3>
            <p style="color: #666; margin: 1rem 0;">
                Contact our accounts department for any fee-related questions or payment assistance.
            </p>
            <p style="color: #2c3e50; font-weight: 600;">
                Phone: +91-8445030782 | Email: accounts@fampublicschool.com
            </p>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
