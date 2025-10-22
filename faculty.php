<?php include "includes/header.php"; ?>

<style>
/* Page specific styles */
.page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; text-align: center; }
.content { padding: 3rem 0; }
.faculty-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin: 2rem 0; }
.faculty-card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s; }
.faculty-card:hover { transform: translateY(-10px); }
.faculty-photo { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin: 0 auto 1rem; border: 4px solid #3498db; }
.faculty-card h3 { color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.3rem; }
.faculty-position { color: #3498db; font-weight: 600; margin-bottom: 1rem; }
.faculty-bio { color: #666; line-height: 1.6; }
.section-header { text-align: center; margin-bottom: 3rem; }
.section-header h2 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 1rem; }
.section-header p { color: #666; font-size: 1.1rem; }
</style>

<section class="page-header">
    <div class="container">
        <h1>Our Faculty</h1>
        <p>Meet our dedicated and experienced teaching professionals</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="section-header">
            <h2>Experienced Educators</h2>
            <p>Our faculty members are committed to providing quality education and nurturing young minds</p>
        </div>

        <div class="faculty-grid">
            <div class="faculty-card">
                <img src="https://via.placeholder.com/150x150" alt="Principal" class="faculty-photo">
                <h3>Dr. Rajesh Kumar</h3>
                <div class="faculty-position">Principal</div>
                <p class="faculty-bio">With over 25 years of experience in education, Dr. Kumar leads our school with vision and dedication to academic excellence.</p>
            </div>

            <div class="faculty-card">
                <img src="https://via.placeholder.com/150x150" alt="Vice Principal" class="faculty-photo">
                <h3>Mrs. Priya Sharma</h3>
                <div class="faculty-position">Vice Principal</div>
                <p class="faculty-bio">An experienced educator with expertise in curriculum development and student welfare programs.</p>
            </div>

            <div class="faculty-card">
                <img src="https://via.placeholder.com/150x150" alt="Math Teacher" class="faculty-photo">
                <h3>Mr. Amit Singh</h3>
                <div class="faculty-position">Mathematics Teacher</div>
                <p class="faculty-bio">Specializes in making mathematics fun and accessible for students of all levels with innovative teaching methods.</p>
            </div>

            <div class="faculty-card">
                <img src="https://via.placeholder.com/150x150" alt="English Teacher" class="faculty-photo">
                <h3>Ms. Sunita Gupta</h3>
                <div class="faculty-position">English Teacher</div>
                <p class="faculty-bio">Passionate about literature and language, helping students develop strong communication and writing skills.</p>
            </div>

            <div class="faculty-card">
                <img src="https://via.placeholder.com/150x150" alt="Science Teacher" class="faculty-photo">
                <h3>Dr. Vikram Patel</h3>
                <div class="faculty-position">Science Teacher</div>
                <p class="faculty-bio">Brings scientific concepts to life through hands-on experiments and innovative laboratory sessions.</p>
            </div>

            <div class="faculty-card">
                <img src="https://via.placeholder.com/150x150" alt="Social Studies Teacher" class="faculty-photo">
                <h3>Mrs. Kavita Joshi</h3>
                <div class="faculty-position">Social Studies Teacher</div>
                <p class="faculty-bio">Expert in history and geography, making social studies engaging and relevant to current affairs.</p>
            </div>

            <div class="faculty-card">
                <img src="https://via.placeholder.com/150x150" alt="Art Teacher" class="faculty-photo">
                <h3>Mr. Rohit Mehta</h3>
                <div class="faculty-position">Art & Craft Teacher</div>
                <p class="faculty-bio">Nurtures creativity and artistic expression through various art forms and creative projects.</p>
            </div>

            <div class="faculty-card">
                <img src="https://via.placeholder.com/150x150" alt="PE Teacher" class="faculty-photo">
                <h3>Coach Suresh Kumar</h3>
                <div class="faculty-position">Physical Education</div>
                <p class="faculty-bio">Promotes physical fitness and sportsmanship through various sports activities and fitness programs.</p>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
