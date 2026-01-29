# MAX1ON1FITNESS - Multi-Device Sports & Fitness Solutions

A modern PHP web application with MVC architecture, routing system, and role-based access control.

## 🚀 Features

- **Clean URL Routing**: SEO-friendly URLs without file extensions
- **Role-Based Access Control**: Admin and user roles with protected routes
- **MVC Architecture**: Separation of concerns with Models, Views, and Controllers
- **Single CSS File**: All styles consolidated in `assets/css/main.css`
- **Reusable Components**: Common header and footer files
- **Dynamic Content Management**: Database-driven content for easy updates
- **Responsive Design**: Mobile-first approach with modern UI

## 📁 Project Structure

```
.
├── .htaccess                  # URL rewriting rules
├── router.php                 # Main routing controller
├── index.php                  # Entry point
├── README.md                  # This file
│
├── assets/
│   ├── css/
│   │   └── main.css          # Single CSS file for all pages
│   └── js/
│       └── script.js         # JavaScript files
│
├── config/
│   ├── Database.php          # Database connection class
│   └── env.php               # Environment configuration loader
│
├── database/
│   ├── init.php              # Database initialization
│   └── seed.php              # Database seeder
│
├── includes/
│   ├── session.php           # Session management functions
│   ├── header.php            # Common header for public pages
│   ├── footer.php            # Common footer for public pages
│   ├── admin-header.php      # Common header for admin pages
│   └── admin-footer.php      # Common footer for admin pages
│
├── models/
│   ├── User.php              # User model
│   ├── SiteContent.php       # Site content model
│   └── PageContent.php       # Page content model
│
├── views/
│   ├── home.php              # Home page view
│   ├── login.php             # Login page view
│   ├── signup.php            # Signup page view
│   ├── logout.php            # Logout handler
│   └── admin/
│       ├── dashboard.php     # Admin dashboard
│       ├── users.php         # User management
│       └── content.php       # Content management
│
└── pages/
    ├── 404.php               # 404 error page
    └── 500.php               # 500 error page
```

## 🛠️ Installation & Setup

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled (or Laravel Herd)
- Minimum 512MB RAM
- 50MB disk space

### Quick Start (Local Development)

1. **Download & Configure**
   ```bash
   # Extract project files
   # Edit .env file with your database credentials
   ```

2. **Configure Environment**

   Edit the `.env` file in the root directory:
   ```env
   # Database Configuration
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_NAME=analognxt
   DB_USER=root
   DB_PASS=root

   # Admin Account
   ADMIN_EMAIL=admin@max1on1fitness.com
   ADMIN_PASSWORD=Admin@123
   ADMIN_USERNAME=admin
   ```

3. **Auto-Initialize Database**

   The database and tables will be created automatically when you first access the application. Just ensure:
   - MySQL server is running
   - Database credentials in `.env` are correct
   - MySQL user has CREATE DATABASE privileges

4. **Access the Application**

   Open your browser and navigate to:
   - Home: `http://localhost/`
   - Login: `http://localhost/login`
   - Signup: `http://localhost/signup`
   - Admin: `http://localhost/dashboard`

---

### Setup with Laravel Herd

Laravel Herd makes local PHP development effortless on macOS and Windows.

#### Installation

**macOS/Windows:**
1. Download Herd from [herd.laravel.com](https://herd.laravel.com)
2. Install and launch Herd
3. Herd automatically manages PHP, Nginx, and other services

#### Configure Your Project

1. **Move Project to Herd Sites Directory**
   - macOS: `~/Herd` (default)
   - Windows: `C:\Users\YourName\Herd` (default)

   ```bash
   # macOS/Linux
   mv max1on1fitness ~/Herd/

   # Windows PowerShell
   Move-Item max1on1fitness C:\Users\YourName\Herd\
   ```

2. **Configure .env File**
   ```env
   DB_HOST=127.0.0.1
   DB_NAME=analognxt
   DB_USER=root
   DB_PASS=
   ```

3. **Access Your Site**
   - Herd automatically creates a `.test` domain
   - Visit: `http://max1on1fitness.test/`
   - Admin: `http://max1on1fitness.test/login`

**Herd Features:**
- Custom domains: `herd link custom-name`
- PHP version switching via menu bar
- Integrated database management (DBngin)

---

### Setup with Hostinger (Production)

Deploy MAX1ON1FITNESS to production using Hostinger hosting.

#### Prerequisites
- Active Hostinger hosting plan (Business or higher recommended)
- Access to hPanel (Hostinger control panel)
- Domain name (optional but recommended)

#### Deployment Steps

**1. Upload Files**
- Via File Manager: hPanel → Files → File Manager → Upload to `public_html`
- Via FTP: Use FileZilla with credentials from hPanel → Files → FTP Accounts

**2. Create MySQL Database**
1. hPanel → Databases → MySQL Databases
2. Create new database and user
3. Assign user with ALL PRIVILEGES
4. Note credentials

**3. Configure .env File**
```env
DB_HOST=localhost
DB_NAME=u123456789_fitness
DB_USER=u123456789_admin
DB_PASS=your_strong_password

ADMIN_EMAIL=admin@yourdomain.com
ADMIN_PASSWORD=ChangeThisPassword123!
ADMIN_USERNAME=admin

APP_ENV=production
```

**4. Set File Permissions**
- Folders: `755`
- Files: `644`
- `.env` file: `600` (important for security)

**5. Install SSL Certificate**
1. hPanel → Security → SSL
2. Install free Let's Encrypt certificate
3. Force HTTPS in `.htaccess`

**6. Test Your Site**
- Visit: `https://yourdomain.com/`
- Login: `https://yourdomain.com/login`

---

### Apache Configuration (Manual Setup)

If not using Herd, ensure Apache has proper configuration:

```apache
<Directory /path/to/max1on1fitness>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

Enable mod_rewrite:
```bash
# Linux
sudo a2enmod rewrite
sudo service apache2 restart
```

## 🔐 Default Credentials

**Admin Account:**
- Email: `admin@max1on1fitness.com`
- Password: `Admin@123`

## 🌐 Routing System

The application uses a custom routing system defined in `router.php`:

### Available Routes

| URL | View | Auth Required | Role Required | Description |
|-----|------|---------------|---------------|-------------|
| `/` | `views/home.php` | No | - | Home page |
| `/home` | `views/home.php` | No | - | Home page (alias) |
| `/login` | `views/login.php` | No (guest only) | - | Login page |
| `/signup` | `views/signup.php` | No (guest only) | - | Signup page |
| `/logout` | `views/logout.php` | Yes | - | Logout handler |
| `/dashboard` | `views/admin/dashboard.php` | Yes | admin | Admin dashboard |
| `/dashboard/users` | `views/admin/users.php` | Yes | admin | User management |
| `/dashboard/content` | `views/admin/content.php` | Yes | admin | Content management |

### Adding New Routes

Edit `router.php` and add your route:

```php
$routes = [
    'your-route' => [
        'view' => 'views/your-view.php',
        'auth' => false,          // Set to true if login required
        'role' => 'admin',        // Optional: Specify required role
        'guest_only' => false     // Optional: Only accessible when logged out
    ],
];
```

## 🎨 Styling

All styles are consolidated in a single file: `assets/css/main.css`

The stylesheet is organized into sections:
1. CSS Reset & Global Styles
2. Navigation
3. Hero Section
4. Section Styles
5. Products Section
6. Features Section
7. About Section
8. Contact Section
9. Footer
10. Auth Pages (Login/Signup)
11. Admin Dashboard
12. Animations
13. Responsive Design

## 📝 Content Management

### Database-Driven Content

All page content is stored in the `site_content` table and can be managed through the admin panel:

1. Login to admin dashboard: `/dashboard`
2. Navigate to "Content" section: `/dashboard/content`
3. Search, filter, and edit content as needed

### Content Key Format

Content keys follow this format: `page.section.element`

Examples:
- `home.hero.title` - Home page hero section title
- `login.form.heading` - Login form heading
- `home.contact.submit_button` - Contact form submit button

### Adding New Content

To add new content keys:

1. Add the key to `database/seed.php` in the `seedSiteContent()` method
2. Run the seeder: `php database/seed.php`
3. Use in your views: `<?php echo SiteContent::getValue($db, 'your.content.key', 'Default Value'); ?>`

## 👥 User Management

### Roles

- **Admin**: Full access to admin panel, can manage users and content
- **User**: Regular user with limited access

### Managing Users

Admins can manage users through `/dashboard/users`:
- View all users
- Edit user details
- Change user roles
- Delete users (cannot delete self)

## 🔒 Session Management

Session functions are available in `includes/session.php`:

- `isLoggedIn()` - Check if user is logged in
- `getCurrentUserId()` - Get current user ID
- `getCurrentUsername()` - Get current username
- `getCurrentUserRole()` - Get current user role
- `isAdmin()` - Check if current user is admin
- `requireLogin()` - Require login (redirect if not)
- `requireAdmin()` - Require admin role (redirect if not)

## 📂 File Organization

### Views

Views contain only the main content. Header and footer are included separately:

```php
<?php
// Set page variables
$pageTitle = 'Page Title';
$currentPage = 'home';

// Include header
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Your page content here -->

<?php
// Include footer
require_once __DIR__ . '/../includes/footer.php';
?>
```

### Admin Views

Admin views use admin-specific header and footer:

```php
<?php
// Set page variables
$pageTitle = 'Admin Page Title';
$currentAdminPage = 'dashboard';
$pageHeading = 'Dashboard';

// Include admin header
require_once __DIR__ . '/../../includes/admin-header.php';
?>

<!-- Your admin content here -->

<?php
// Include admin footer
require_once __DIR__ . '/../../includes/admin-footer.php';
?>
```

## 🚀 Deployment

### Production Checklist

1. **Update .env file** with production credentials
2. **Disable error display** in PHP configuration
3. **Enable HTTPS** and update absolute URLs
4. **Set secure session settings** in `includes/session.php`
5. **Update admin credentials** (change default password)
6. **Optimize database** indexes and queries
7. **Enable caching** for static assets
8. **Set proper file permissions** (644 for files, 755 for directories)

### Security Recommendations

- Change default admin password immediately
- Use strong database passwords
- Keep `.env` file outside web root if possible
- Enable HTTPS/SSL certificates
- Implement rate limiting for login attempts
- Regular security updates and patches
- Use prepared statements (already implemented)

## 📊 Database Schema

### Users Table
```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- username (VARCHAR)
- email (VARCHAR, UNIQUE)
- password (VARCHAR, hashed)
- role (ENUM: 'user', 'admin')
- created_at (TIMESTAMP)
```

### Site Content Table
```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- content_key (VARCHAR, UNIQUE)
- content_value (TEXT)
- page_name (VARCHAR)
- section_name (VARCHAR)
- content_type (VARCHAR)
- description (TEXT)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### Pages Content Table
```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- page_name (VARCHAR, UNIQUE)
- title (VARCHAR)
- content (TEXT)
- meta_description (TEXT)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 🔧 Troubleshooting

### Database Connection Error

**Problem:** "Connection Error" message

**Solutions:**
1. Verify `.env` database credentials
2. Check MySQL service is running
3. Test database connection: `mysql -h 127.0.0.1 -u root -p`
4. Ensure database user has CREATE privileges

### Database Not Auto-Initializing

**Solutions:**
1. Grant privileges: `GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost'; FLUSH PRIVILEGES;`
2. Check PHP error logs
3. Manually create database: `CREATE DATABASE analognxt;`

### Login Not Working

**Solutions:**
1. Verify credentials match `.env` file
2. Check if users table exists and has admin user
3. Manually run seeder: `php database/seed.php`

### Page Not Found (404)

**Solutions:**
1. Enable Apache mod_rewrite: `sudo a2enmod rewrite`
2. Check `.htaccess` exists in project root
3. Verify `AllowOverride All` in Apache config
4. For Herd: Automatically handles routing

### CSS/Styles Not Loading

**Solutions:**
1. Check browser console for errors (F12)
2. Verify `assets/css/main.css` exists
3. Clear browser cache (Ctrl+Shift+R)
4. Check file permissions (644 for CSS files)

### Session Errors

**Solutions:**
1. Check session directory permissions
2. Verify PHP session is enabled in `php.ini`
3. Set custom session path if needed

### Herd-Specific Issues

**Problem:** Site not accessible at `.test` domain

**Solutions:**
1. Restart Herd from menu bar
2. Re-park directory: `cd ~/Herd && herd park`
3. Check Herd is running (green icon in menu bar)

### Hostinger-Specific Issues

**Problem:** Internal Server Error (500)

**Solutions:**
1. Check file permissions (folders: 755, files: 644)
2. Review error logs in hPanel → Advanced → Error Logs
3. Verify PHP version compatibility (PHP 7.4+)
4. Check `.htaccess` syntax

---

## 📄 License

This project is proprietary software. All rights reserved.

## 📞 Support

For support, email: support@max1on1fitness.com

## 🎯 Roadmap

- [ ] User profile management
- [ ] Password reset functionality
- [ ] Email verification
- [ ] API endpoints for mobile apps
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] Dark mode theme

---

**Built with ❤️ for fitness enthusiasts worldwide**
