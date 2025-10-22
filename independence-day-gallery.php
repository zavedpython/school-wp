<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Independence Day Gallery - Bal Bharti Public School</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .header { background: #2c3e50; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; }
        .nav-links { display: flex; list-style: none; gap: 2rem; }
        .nav-links a { color: white; text-decoration: none; }
        .nav-links a:hover { color: #3498db; }
        .page-header { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; padding: 3rem 0; text-align: center; }
        .content { padding: 3rem 0; }
        .photo-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin: 2rem 0; }
        .photo-item { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .photo-item:hover { transform: scale(1.05); }
        .photo-img { width: 100%; height: 200px; background-size: cover; background-position: center; }
        .photo-caption { padding: 1rem; text-align: center; font-size: 0.9rem; color: #666; }
        .back-btn { background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 2rem; }
        .back-btn:hover { background: #2980b9; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo">Bal Bharti Public School</div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="page-header">
        <div class="container">
            <h1>🇮🇳 Independence Day Gallery</h1>
            <p>Celebrating India's Independence Day with patriotic fervor</p>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <a href="gallery.php" class="back-btn">← Back to Gallery</a>
            
            <div class="photo-grid">
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Flag Hoisting Ceremony</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1596727147705-61a532a659bd?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Students Parade</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Cultural Performance</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Principal's Speech</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">March Past</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Dance Performance</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Students Assembly</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Award Distribution</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Patriotic Songs</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Group Photo</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Teachers Participation</div>
                </div>
                
                <div class="photo-item">
                    <div class="photo-img" style="background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=300&h=200&fit=crop');"></div>
                    <div class="photo-caption">Closing Ceremony</div>
                </div>
            </div>
        </div>
    </section>

    <footer style="background: #2c3e50; color: white; text-align: center; padding: 2rem 0;">
        <div class="container">
            <p>&copy; 2024 Bal Bharti Public School. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
