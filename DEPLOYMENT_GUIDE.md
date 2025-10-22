# Deployment Guide - NAF Public School Website

## 🚀 Deployment Options

### 1. Local Development
### 2. Shared Hosting
### 3. VPS/Cloud Server
### 4. Docker Deployment

---

## 🏠 Local Development Setup

### Prerequisites
- PHP 7.4 or higher
- Git
- Modern web browser

### Quick Setup
```bash
# Clone repository
git clone https://github.com/zavedpython/school-wp.git
cd school-wp

# Start PHP built-in server
php -S localhost:3232

# Access application
# Website: http://localhost:3232/
# Admin: http://localhost:3232/admin/login.php
```

### Development Configuration
```bash
# Set file permissions
chmod 755 -R .
chmod 777 -R uploads/
chmod 777 -R data/

# Create necessary directories
mkdir -p uploads/{gallery,notices,circulars,applications}
mkdir -p data/applications
```

---

## 🌐 Shared Hosting Deployment

### Step 1: Prepare Files
```bash
# Create deployment package
zip -r school-website.zip . -x "*.git*" "*.DS_Store*" "node_modules/*"
```

### Step 2: Upload to Hosting
1. Access your hosting control panel (cPanel/Plesk)
2. Navigate to File Manager
3. Upload `school-website.zip` to public_html/
4. Extract the zip file
5. Move contents to root directory

### Step 3: Set Permissions
```bash
# Via SSH or File Manager
chmod 755 -R .
chmod 777 -R uploads/
chmod 777 -R data/
```

### Step 4: Configure Domain
1. Point domain to public_html directory
2. Update any hardcoded URLs in configuration
3. Test website functionality

### Common Shared Hosting Issues
```php
// If PHP version is old, add to .htaccess
AddHandler application/x-httpd-php74 .php

// Increase memory limit if needed
ini_set('memory_limit', '256M');

// Set timezone
date_default_timezone_set('Asia/Kolkata');
```

---

## ☁️ VPS/Cloud Server Deployment

### Ubuntu/Debian Server Setup

#### Step 1: Server Preparation
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y nginx php8.1-fpm php8.1-common php8.1-mysql \
    php8.1-xml php8.1-xmlrpc php8.1-curl php8.1-gd \
    php8.1-imagick php8.1-cli php8.1-dev php8.1-imap \
    php8.1-mbstring php8.1-opcache php8.1-soap \
    php8.1-zip php8.1-intl git unzip
```

#### Step 2: Nginx Configuration
```nginx
# /etc/nginx/sites-available/school-website
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/school-website;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;

    # Main location
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to sensitive files
    location ~ /\.ht {
        deny all;
    }

    location ~ /data/ {
        deny all;
    }

    # Static file caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

#### Step 3: Deploy Application
```bash
# Create web directory
sudo mkdir -p /var/www/school-website

# Clone repository
cd /var/www
sudo git clone https://github.com/zavedpython/school-wp.git school-website

# Set permissions
sudo chown -R www-data:www-data /var/www/school-website
sudo chmod -R 755 /var/www/school-website
sudo chmod -R 777 /var/www/school-website/uploads
sudo chmod -R 777 /var/www/school-website/data

# Enable site
sudo ln -s /etc/nginx/sites-available/school-website /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

#### Step 4: SSL Certificate (Let's Encrypt)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Get SSL certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

---

## 🐳 Docker Deployment

### Dockerfile
```dockerfile
FROM php:8.1-apache

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Copy application
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/uploads \
    && chmod -R 777 /var/www/html/data

# Apache configuration
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
```

### Docker Compose
```yaml
version: '3.8'

services:
  web:
    build: .
    ports:
      - "80:80"
    volumes:
      - ./uploads:/var/www/html/uploads
      - ./data:/var/www/html/data
    environment:
      - PHP_MEMORY_LIMIT=256M
    restart: unless-stopped

  nginx:
    image: nginx:alpine
    ports:
      - "443:443"
    volumes:
      - ./nginx.conf:/etc/nginx/nginx.conf
      - ./ssl:/etc/nginx/ssl
    depends_on:
      - web
    restart: unless-stopped
```

### Deploy with Docker
```bash
# Build and run
docker-compose up -d

# View logs
docker-compose logs -f

# Update application
git pull
docker-compose build --no-cache
docker-compose up -d
```

---

## 🔧 Production Configuration

### PHP Configuration
```ini
; /etc/php/8.1/fpm/php.ini
memory_limit = 256M
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
max_input_vars = 3000

; Security
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log

; Session security
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
```

### Security Hardening
```bash
# Firewall setup
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable

# Fail2ban for brute force protection
sudo apt install fail2ban
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### Backup Script
```bash
#!/bin/bash
# /usr/local/bin/backup-school-website.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/school-website"
SOURCE_DIR="/var/www/school-website"

# Create backup directory
mkdir -p $BACKUP_DIR

# Create backup
tar -czf "$BACKUP_DIR/backup_$DATE.tar.gz" \
    --exclude="$SOURCE_DIR/.git" \
    $SOURCE_DIR

# Keep only last 30 backups
cd $BACKUP_DIR
ls -t backup_*.tar.gz | tail -n +31 | xargs -r rm

echo "Backup completed: backup_$DATE.tar.gz"
```

### Cron Jobs
```bash
# Edit crontab
sudo crontab -e

# Daily backup at 2 AM
0 2 * * * /usr/local/bin/backup-school-website.sh

# Weekly log rotation
0 0 * * 0 /usr/sbin/logrotate /etc/logrotate.conf

# SSL certificate renewal
0 12 * * * /usr/bin/certbot renew --quiet
```

---

## 📊 Monitoring & Maintenance

### Log Monitoring
```bash
# Nginx logs
sudo tail -f /var/log/nginx/access.log
sudo tail -f /var/log/nginx/error.log

# PHP logs
sudo tail -f /var/log/php8.1-fpm.log

# System logs
sudo journalctl -f -u nginx
sudo journalctl -f -u php8.1-fpm
```

### Performance Monitoring
```bash
# Install monitoring tools
sudo apt install htop iotop nethogs

# Monitor system resources
htop
iotop
nethogs

# Check disk usage
df -h
du -sh /var/www/school-website/*
```

### Health Check Script
```bash
#!/bin/bash
# /usr/local/bin/health-check.sh

URL="https://your-domain.com"
ADMIN_URL="https://your-domain.com/admin/login.php"

# Check main website
if curl -f -s $URL > /dev/null; then
    echo "✅ Website is accessible"
else
    echo "❌ Website is down"
    # Send alert email
    echo "Website down at $(date)" | mail -s "Website Alert" admin@your-domain.com
fi

# Check admin panel
if curl -f -s $ADMIN_URL > /dev/null; then
    echo "✅ Admin panel is accessible"
else
    echo "❌ Admin panel is down"
fi

# Check disk space
DISK_USAGE=$(df / | tail -1 | awk '{print $5}' | sed 's/%//')
if [ $DISK_USAGE -gt 80 ]; then
    echo "⚠️ Disk usage is high: ${DISK_USAGE}%"
fi

# Check memory usage
MEM_USAGE=$(free | grep Mem | awk '{printf("%.0f", $3/$2 * 100.0)}')
if [ $MEM_USAGE -gt 80 ]; then
    echo "⚠️ Memory usage is high: ${MEM_USAGE}%"
fi
```

---

## 🔄 Update Procedure

### Manual Update
```bash
# Backup current installation
sudo /usr/local/bin/backup-school-website.sh

# Pull latest changes
cd /var/www/school-website
sudo git pull origin main

# Set permissions
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 777 uploads data

# Clear any caches
sudo systemctl reload php8.1-fpm
sudo systemctl reload nginx
```

### Automated Update Script
```bash
#!/bin/bash
# /usr/local/bin/update-school-website.sh

SITE_DIR="/var/www/school-website"
BACKUP_DIR="/backups/school-website"

echo "Starting update process..."

# Create backup
echo "Creating backup..."
/usr/local/bin/backup-school-website.sh

# Pull updates
echo "Pulling updates..."
cd $SITE_DIR
sudo -u www-data git pull origin main

# Set permissions
echo "Setting permissions..."
sudo chown -R www-data:www-data $SITE_DIR
sudo chmod -R 755 $SITE_DIR
sudo chmod -R 777 $SITE_DIR/uploads $SITE_DIR/data

# Reload services
echo "Reloading services..."
sudo systemctl reload php8.1-fpm
sudo systemctl reload nginx

# Health check
echo "Running health check..."
/usr/local/bin/health-check.sh

echo "Update completed!"
```

---

## 🚨 Troubleshooting

### Common Issues

#### 1. Permission Errors
```bash
# Fix permissions
sudo chown -R www-data:www-data /var/www/school-website
sudo chmod -R 755 /var/www/school-website
sudo chmod -R 777 /var/www/school-website/uploads
sudo chmod -R 777 /var/www/school-website/data
```

#### 2. PHP Errors
```bash
# Check PHP error log
sudo tail -f /var/log/php_errors.log

# Test PHP configuration
php -m | grep -i required_module
php --ini
```

#### 3. Nginx Issues
```bash
# Test Nginx configuration
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx

# Check Nginx status
sudo systemctl status nginx
```

#### 4. File Upload Issues
```bash
# Check upload directory permissions
ls -la uploads/
sudo chmod 777 uploads/

# Check PHP upload settings
php -i | grep upload
```

### Emergency Recovery
```bash
# Restore from backup
cd /backups/school-website
tar -xzf backup_YYYYMMDD_HHMMSS.tar.gz -C /var/www/

# Fix permissions after restore
sudo chown -R www-data:www-data /var/www/school-website
sudo chmod -R 755 /var/www/school-website
sudo chmod -R 777 /var/www/school-website/uploads
sudo chmod -R 777 /var/www/school-website/data
```

---

## 📞 Support

### Technical Support
- **Repository**: https://github.com/zavedpython/school-wp
- **Issues**: Create GitHub issue for bugs/features
- **Documentation**: Check README.md and docs/

### Emergency Contacts
- **Developer**: SkyTech Technologies
- **Phone**: +91-7217640903
- **Email**: support@skytech.com

---

This deployment guide covers all major deployment scenarios and provides comprehensive instructions for production deployment and maintenance.
