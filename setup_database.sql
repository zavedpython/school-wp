CREATE DATABASE IF NOT EXISTS school_website;
USE school_website;

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- School settings table
CREATE TABLE IF NOT EXISTS school_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Gallery table
CREATE TABLE IF NOT EXISTS gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Notices table
CREATE TABLE IF NOT EXISTS notices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    notice_type ENUM('urgent', 'important', 'event', 'exam', 'admission', 'general') DEFAULT 'general',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Circulars table
CREATE TABLE IF NOT EXISTS circulars (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert default school settings
INSERT INTO school_settings (setting_key, setting_value) VALUES
('school_name', 'Bal Bharti Public School'),
('school_address', '123 Education Street, New Delhi - 110001'),
('school_phone', '+91-11-12345678'),
('school_email', 'info@balbarti.edu'),
('principal_name', 'Dr. Rajesh Kumar'),
('principal_message', 'Welcome to our esteemed institution...'),
('school_vision', 'To be a leading educational institution...'),
('school_mission', 'To provide quality education...');

-- Insert sample notices
INSERT INTO notices (title, content, notice_type) VALUES
('Parent-Teacher Meeting', 'Parent-Teacher meeting on Oct 25, 2024. All parents requested to attend.', 'urgent'),
('Annual Sports Day', 'Annual Sports Day on Nov 15, 2024. Practice sessions start from Oct 28.', 'important'),
('Science Exhibition', 'Inter-School Science Exhibition on Nov 5, 2024. Registration open till Oct 30.', 'event'),
('Half Yearly Examinations', 'Half Yearly Examinations from Dec 2, 2024. Time table will be issued soon.', 'exam'),
('Admissions Open', 'Admissions open for 2025-26. Apply online or visit school office.', 'admission');
