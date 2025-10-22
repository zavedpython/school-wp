<?php include "includes/header.php"; ?>

<style>
/* Page specific styles */
.main { padding: 2rem 0; background: #f8fafc; min-height: 80vh; }
.page-title { text-align: center; margin-bottom: 3rem; }
.page-title h1 { color: #1e3a8a; font-size: 2.5rem; margin-bottom: 1rem; }
.page-title p { color: #666; font-size: 1.1rem; }

.contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem; }
.contact-info, .contact-form { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
.contact-item { display: flex; align-items: flex-start; margin-bottom: 2rem; }
.contact-item .i { font-size: 1.5rem; margin-right: 1rem; margin-top: 0.25rem; }
.contact-item h3 { color: #1e3a8a; margin-bottom: 0.5rem; }
.contact-item p { color: #666; }

.form-group { margin-bottom: 1.5rem; }
.form-group label { display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500; }
.form-group input, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; }
.form-group textarea { height: 120px; resize: vertical; }
.btn { background: #1e3a8a; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; }
.btn:hover { background: #1e40af; }

.map-section { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
.map-section h2 { color: #1e3a8a; margin-bottom: 1rem; text-align: center; }
.map-container { position: relative; height: 400px; border-radius: 10px; overflow: hidden; }
.map-container iframe { width: 100%; height: 100%; border: 0; }

@media (max-width: 768px) {
    .contact-grid { grid-template-columns: 1fr; }
}
</style>

<main class="main">
    <div class="container">
        <div class="page-title">
            <h1>Contact Us</h1>
            <p>Get in touch with us for any inquiries or information</p>
        </div>

        <div class="contact-grid">
            <div class="contact-info">
                <h2 style="color: #1e3a8a; margin-bottom: 2rem;">Get In Touch</h2>
                
                <div class="contact-item">
                    <div class="i">📍</div>
                    <div>
                        <h3>Address</h3>
                        <p>Village Khekra, Baghpat, Uttar Pradesh</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="i">📞</div>
                    <div>
                        <h3>Phone</h3>
                        <p>+91-8445030782</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="i">✉️</div>
                    <div>
                        <h3>Email</h3>
                        <p>info@fampublicschool.com</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="i">🕒</div>
                    <div>
                        <h3>Office Hours</h3>
                        <p>Monday - Friday: 8:00 AM - 4:00 PM<br>Saturday: 8:00 AM - 12:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h2 style="color: #1e3a8a; margin-bottom: 2rem;">Send Message</h2>
                <form>
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="btn">Send Message</button>
                </form>
            </div>
        </div>

        <div class="map-section">
            <h2>Find Us</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3497.8!2d77.2!3d28.6!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjjCsDM2JzAwLjAiTiA3N8KwMTInMDAuMCJF!5e0!3m2!1sen!2sin!4v1234567890" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</main>

<?php include "includes/footer.php"; ?>
</body>
</html>
