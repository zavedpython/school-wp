<?php include "includes/header.php"; ?>

<style>
/* Page specific styles */
.page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; text-align: center; }
.content { padding: 3rem 0; }
.gallery-filters { text-align: center; margin-bottom: 3rem; }
.filter-btn { background: #e9ecef; color: #495057; padding: 0.75rem 1.5rem; margin: 0 0.5rem; border: none; border-radius: 25px; cursor: pointer; transition: all 0.3s; }
.filter-btn.active, .filter-btn:hover { background: #3498db; color: white; }
.gallery-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
.gallery-item { position: relative; overflow: hidden; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s; }
.gallery-item:hover { transform: translateY(-10px); }
.gallery-item img { width: 100%; height: 250px; object-fit: cover; }
.gallery-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1.5rem; transform: translateY(100%); transition: transform 0.3s; }
.gallery-item:hover .gallery-overlay { transform: translateY(0); }
.gallery-overlay h3 { margin-bottom: 0.5rem; }
</style>

<section class="page-header">
    <div class="container">
        <h1>Photo Gallery</h1>
        <p>Capturing moments and memories from our school life</p>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="gallery-filters">
            <button class="filter-btn active">All</button>
            <button class="filter-btn">Events</button>
            <button class="filter-btn">Sports</button>
            <button class="filter-btn">Academics</button>
            <button class="filter-btn">Cultural</button>
        </div>

        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400" alt="Annual Day">
                <div class="gallery-overlay">
                    <h3>Annual Day Celebration</h3>
                    <p>Students showcasing their talents on stage</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400" alt="Sports Day">
                <div class="gallery-overlay">
                    <h3>Sports Day</h3>
                    <p>Athletic competitions and team spirit</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400" alt="Classroom">
                <div class="gallery-overlay">
                    <h3>Interactive Learning</h3>
                    <p>Students engaged in classroom activities</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=400" alt="Science Lab">
                <div class="gallery-overlay">
                    <h3>Science Laboratory</h3>
                    <p>Hands-on experiments and discoveries</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400" alt="Library">
                <div class="gallery-overlay">
                    <h3>School Library</h3>
                    <p>Students exploring the world of books</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400" alt="Art Class">
                <div class="gallery-overlay">
                    <h3>Art & Craft</h3>
                    <p>Creative expressions and artistic talents</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
