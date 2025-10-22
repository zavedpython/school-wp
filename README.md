# NAF Public School - WordPress Website

A modern, responsive school website with comprehensive admin panel for content management, built with PHP, HTML, CSS, and JavaScript.

## 🌟 Features

### Public Website
- **Dynamic Home Page** - Hero section, about, achievements, quick links
- **Admission System** - Online admission form with file uploads
- **Contact System** - Contact form with Google Maps integration
- **About Us Pages** - School History, Vision & Mission, Principal's Message
- **Faculty Directory** - Staff profiles with photos and descriptions
- **Fee Structure** - Detailed fee breakdown by class
- **Photo Gallery** - Categorized image gallery with filters
- **Notice Board** - Latest announcements and updates
- **Circulars** - Downloadable PDF documents
- **Responsive Design** - Mobile-first, works on all devices

### Admin Panel
- **Secure Authentication** - Login system with session management
- **Dashboard** - Overview with statistics and quick actions
- **Content Management** - Update home page sections and content
- **Gallery Management** - Upload, edit, delete images
- **Notice Management** - Create, edit, delete notices
- **Circular Management** - Upload PDF documents with metadata
- **Principal Management** - Update principal information and photo
- **School Settings** - Manage school information and contact details
- **User Management** - Admin user management system
- **Activity Logging** - Track admin actions and changes

## 🚀 Quick Start

### Prerequisites
- PHP 7.4+ with built-in server or Apache/Nginx
- Modern web browser
- Git (for development)

### Installation

1. **Clone Repository**
```bash
git clone https://github.com/zavedpython/school-wp.git
cd school-wp
```

2. **Start PHP Server**
```bash
php -S localhost:3232
```

3. **Access Application**
- **Website**: http://localhost:3232/
- **Admin Panel**: http://localhost:3232/admin/login.php

### Default Admin Credentials
- **Username**: admin
- **Password**: admin123

⚠️ **Change these credentials immediately after first login!**

## 📁 Project Structure

```
school-wp/
├── admin/                  # Admin panel files
│   ├── login.php          # Admin login page
│   ├── dashboard.php      # Admin dashboard
│   ├── gallery.php        # Gallery management
│   ├── notices.php        # Notice management
│   ├── principal-management.php
│   ├── school-settings.php
│   └── ...
├── assets/                # Static assets
│   ├── favicon.svg
│   └── school-logo.svg
├── data/                  # JSON data files
│   ├── settings.json      # School settings
│   ├── principal.json     # Principal information
│   ├── footer.json        # Footer configuration
│   └── users.json         # Admin users
├── includes/              # Include files
│   ├── header.php         # Common header
│   └── footer.php         # Common footer
├── logo/                  # Logo files
│   └── logo.jpg
├── uploads/               # File uploads
│   ├── gallery/
│   ├── notices/
│   ├── circulars/
│   └── applications/
├── index.php              # Homepage
├── admission.php          # Admission information
├── admission-form.php     # Online admission form
├── contact.php            # Contact page
├── faculty.php            # Faculty directory
├── fee-structure.php      # Fee information
├── gallery.php            # Photo gallery
├── notices.php            # Notice board
├── circulars.php          # Circulars page
├── school-history.php     # School history
├── vision-mission.php     # Vision & mission
├── principal-message.php  # Principal's message
└── .htaccess             # URL rewriting rules
```

## 🔧 Configuration

### School Settings
Edit `data/settings.json` to update:
- School name and address
- Contact information
- Principal details
- Social media links

### Admin Users
Admin users are stored in `data/users.json`:
```json
{
  "admin": {
    "username": "admin",
    "password": "admin123",
    "role": "administrator",
    "created": "2024-10-22"
  }
}
```

### Footer Configuration
Customize footer in `data/footer.json`:
- Contact information
- Quick links
- Social media links
- Google Maps integration

## 🎨 Design Features

### Color Scheme
- **Primary Blue**: #1e3a8a
- **Accent Orange**: #f59e0b
- **Background**: #f8fafc
- **Text**: #333333

### Typography
- **Font Family**: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- **Responsive**: Mobile-first design
- **Accessibility**: WCAG compliant

### Layout Components
- **Fixed Header** - Contact info + navigation
- **Hero Section** - Dynamic banner with call-to-action
- **Card Layouts** - Information cards with shadows
- **Grid Systems** - Responsive grid layouts
- **Footer** - 5-column footer with map integration

## 📱 Responsive Design

### Breakpoints
- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

### Mobile Features
- Collapsible navigation
- Touch-friendly buttons
- Optimized images
- Readable typography

## 🔒 Security Features

### Admin Panel Security
- Session-based authentication
- Password protection
- File upload validation
- Directory access protection
- XSS prevention

### File Security
- `.htaccess` protection for sensitive files
- Upload directory restrictions
- File type validation
- Size limitations

## 📊 Admin Panel Features

### Dashboard
- Quick statistics
- Recent activities
- System status
- Quick action buttons

### Content Management
- **Gallery**: Upload, organize, delete images
- **Notices**: Create, edit, publish notices
- **Circulars**: Upload PDF documents
- **Principal**: Update photo and message
- **Settings**: School information management

### User Management
- Add/remove admin users
- Role-based permissions
- Activity logging
- Password management

## 🌐 SEO Features

- **Meta Tags** - Proper title and description tags
- **Semantic HTML** - Structured markup
- **Image Alt Tags** - Accessibility compliance
- **Clean URLs** - SEO-friendly URL structure
- **Mobile Optimization** - Mobile-first indexing ready

## 📈 Performance

### Optimization
- **Minified CSS/JS** - Reduced file sizes
- **Image Optimization** - Compressed images
- **Caching Headers** - Browser caching
- **Lazy Loading** - Images load on demand

### Loading Speed
- **Lightweight** - Minimal dependencies
- **Efficient Code** - Optimized PHP/CSS/JS
- **CDN Ready** - External resource optimization

## 🔧 Customization

### Adding New Pages
1. Create new PHP file in root directory
2. Include header: `<?php include "includes/header.php"; ?>`
3. Add page content with proper styling
4. Include footer: `<?php include "includes/footer.php"; ?>`

### Modifying Styles
- Edit inline CSS in individual pages
- Update common styles in `includes/header.php`
- Maintain responsive design principles

### Adding Admin Features
1. Create new PHP file in `admin/` directory
2. Add authentication check
3. Include admin navigation
4. Implement CRUD operations

## 🚀 Deployment

### Local Development
```bash
php -S localhost:3232
```

### Production Deployment
1. Upload files to web server
2. Configure web server (Apache/Nginx)
3. Set proper file permissions
4. Update configuration files
5. Test all functionality

### Server Requirements
- **PHP**: 7.4 or higher
- **Web Server**: Apache/Nginx
- **Storage**: 100MB minimum
- **Memory**: 128MB PHP memory limit

## 📞 Support & Contact

### School Information
- **Name**: NAF Public School
- **Address**: Village Khekra, Baghpat, Uttar Pradesh
- **Phone**: +91-8445030782
- **Email**: info@fampublicschool.com

### Development
- **Repository**: https://github.com/zavedpython/school-wp
- **Developer**: SkyTech Technologies
- **Contact**: +91-7217640903

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📝 Changelog

### Version 1.0.0 (2024-10-22)
- Initial release
- Complete website with admin panel
- Responsive design implementation
- Security features implementation
- Documentation and deployment guide

---

**Made with ❤️ for educational institutions**
