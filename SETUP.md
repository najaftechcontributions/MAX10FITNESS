# MAX1ON1FITNESS - Setup Guide

Complete setup instructions for running MAX1ON1FITNESS on your local machine or production server.

## Table of Contents
- [System Requirements](#system-requirements)
- [Quick Start](#quick-start)
- [Setup with Laravel Herd](#setup-with-laravel-herd)
- [Setup with Hostinger](#setup-with-hostinger)
- [Configuration](#configuration)
- [First Login](#first-login)
- [Troubleshooting](#troubleshooting)

---

## System Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled (or Laravel Herd)
- Minimum 512MB RAM
- 50MB disk space

---

## Quick Start

### 1. Download & Extract
Extract all project files to your desired location.

### 2. Configure Environment
Edit the `.env` file in the root directory:

```env
# Database Configuration
DB_HOST=127.0.0.1
DB_NAME=max1on1fitness
DB_USER=root
DB_PASS=your_password

# Admin Account Credentials
ADMIN_EMAIL=admin@max1on1fitness.com
ADMIN_PASSWORD=Admin@123
ADMIN_USERNAME=admin
```

### 3. Auto-Initialize Database
The database and tables will be created automatically when you first access the application. Just make sure:
- MySQL server is running
- Database credentials in `.env` are correct
- MySQL user has CREATE DATABASE privileges

### 4. Access the Application
- Homepage: `http://localhost/max1on1fitness/pages/home.php`
- Admin Login: `http://localhost/max1on1fitness/pages/login.php`

---

## Setup with Laravel Herd

Laravel Herd makes local PHP development effortless on macOS and Windows.

### Installation

#### macOS
1. Download Herd from [herd.laravel.com](https://herd.laravel.com)
2. Install and launch Herd
3. Herd automatically manages PHP, Nginx, and other services

#### Windows
1. Download Herd for Windows from [herd.laravel.com](https://herd.laravel.com)
2. Install and launch Herd
3. Herd sets up everything automatically

### Configure Your Project

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
   DB_NAME=max1on1fitness
   DB_USER=root
   DB_PASS=
   
   ADMIN_EMAIL=admin@max1on1fitness.com
   ADMIN_PASSWORD=Admin@123
   ADMIN_USERNAME=admin
   ```

3. **Create MySQL Database**
   - Open your preferred MySQL client (TablePlus, Sequel Ace, phpMyAdmin)
   - Or use command line:
   ```bash
   mysql -u root -p
   # The database will be created automatically on first access
   ```

4. **Access Your Site**
   - Herd automatically creates a `.test` domain
   - Visit: `http://max1on1fitness.test/pages/home.php`
   - Admin: `http://max1on1fitness.test/pages/login.php`

### Herd Additional Features

**Custom Domains:**
```bash
# Link custom domain
herd link custom-name
# Access via: http://custom-name.test
```

**PHP Version:**
- Click Herd menu bar icon
- Select PHP version (7.4, 8.0, 8.1, 8.2, 8.3)
- Project automatically uses selected version

**Database Management:**
- Herd includes DBngin for database management
- Access via Herd menu → DBngin

---

## Setup with Hostinger

Deploy MAX1ON1FITNESS to production using Hostinger hosting.

### Prerequisites
- Active Hostinger hosting plan (Business or higher recommended)
- Access to hPanel (Hostinger control panel)
- Domain name (optional but recommended)

### Step-by-Step Deployment

#### 1. Upload Files

**Option A: File Manager**
1. Login to hPanel: https://hpanel.hostinger.com
2. Go to **Files → File Manager**
3. Navigate to `public_html` directory
4. Click **Upload** and select all project files
5. Upload and extract if needed

**Option B: FTP Client (Recommended)**
1. Download FileZilla: https://filezilla-project.org
2. Get FTP credentials from hPanel → **Files → FTP Accounts**
3. Connect via FTP:
   - Host: `ftp.yourdomain.com`
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21
4. Upload all files to `public_html` or subdirectory

#### 2. Create MySQL Database

1. In hPanel, go to **Databases → MySQL Databases**
2. Click **Create New Database**
3. Database name: `u123456789_fitness` (example)
4. Click **Create**
5. Create database user:
   - Username: `u123456789_admin`
   - Password: Create a strong password
   - Click **Create**
6. Assign user to database with **ALL PRIVILEGES**
7. Note down:
   - Database name
   - Database username
   - Database password
   - Database host (usually `localhost`)

#### 3. Configure .env File

1. In File Manager, navigate to your project root
2. Edit `.env` file:
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

#### 4. Set File Permissions

1. In File Manager, right-click on project folder
2. Set permissions:
   - Folders: `755`
   - Files: `644`
   - `.env` file: `600` (important for security)

#### 5. Configure Domain (Optional)

**If using subdomain:**
1. Go to **Domains → Subdomains**
2. Create subdomain: `app.yourdomain.com`
3. Point to project directory

**If using main domain:**
1. Ensure files are in `public_html`
2. Domain automatically points to this directory

#### 6. Update .htaccess (If Needed)

If your site is in a subdirectory, edit `.htaccess`:
```apache
RewriteEngine On
RewriteBase /subfolder/

# Redirect to pages/home.php
RewriteCond %{REQUEST_URI} ^/$
RewriteRule ^(.*)$ pages/home.php [L]
```

#### 7. SSL Certificate (Recommended)

1. In hPanel, go to **Security → SSL**
2. Select your domain
3. Click **Install SSL** (free Let's Encrypt)
4. Wait 15-20 minutes for activation
5. Force HTTPS in `.htaccess`:
   ```apache
   RewriteEngine On
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

#### 8. First Access & Database Auto-Initialization

1. Visit your domain: `https://yourdomain.com/pages/home.php`
2. Database tables will be created automatically
3. Admin user will be seeded automatically

#### 9. Test Login

1. Go to: `https://yourdomain.com/pages/login.php`
2. Login with admin credentials from `.env`
3. You should see the admin dashboard

### Hostinger Production Checklist

- ✅ All files uploaded
- ✅ MySQL database created
- ✅ `.env` configured with production values
- ✅ File permissions set correctly
- ✅ SSL certificate installed
- ✅ Admin password changed to strong password
- ✅ Test all pages (home, login, admin)
- ✅ Verify database auto-initialization worked

### Hostinger Optimization Tips

**Enable OPcache:**
1. hPanel → **Advanced → PHP Configuration**
2. Enable OPcache for better performance

**Set PHP Version:**
1. hPanel → **Advanced → PHP Configuration**
2. Select PHP 8.0 or higher

**Backup Schedule:**
1. hPanel → **Files → Backups**
2. Enable automatic weekly backups

---

## Configuration

### Environment Variables

Edit `.env` file to customize:

| Variable | Description | Default |
|----------|-------------|---------|
| `DB_HOST` | Database host | `127.0.0.1` |
| `DB_NAME` | Database name | `max1on1fitness` |
| `DB_USER` | Database username | `root` |
| `DB_PASS` | Database password | `root` |
| `ADMIN_EMAIL` | Admin login email | `admin@max1on1fitness.com` |
| `ADMIN_PASSWORD` | Admin password | `Admin@123` |
| `ADMIN_USERNAME` | Admin display name | `admin` |
| `APP_ENV` | Environment | `development` |
| `SESSION_LIFETIME` | Session duration (seconds) | `3600` |

### Security Notes

🔒 **Important for Production:**
1. Change `ADMIN_PASSWORD` to a strong password
2. Set `APP_ENV=production`
3. Set `.env` file permissions to `600`
4. Never commit `.env` to version control
5. Use strong database passwords
6. Enable HTTPS/SSL

---

## First Login

### Default Admin Credentials
- **Email:** As set in `.env` (default: `admin@max1on1fitness.com`)
- **Password:** As set in `.env` (default: `Admin@123`)

### After First Login
1. Go to Admin Dashboard → Users
2. Click Edit on admin user
3. Change password to something secure
4. Update email if needed

### Admin Panel Features
- **Dashboard:** Overview of users and statistics
- **Users:** Manage user accounts and roles
- **Content:** Manage all page text and content
- **View Site:** Preview the public website

---

## Troubleshooting

### Database Connection Error

**Problem:** "Connection Error" message

**Solutions:**
1. Verify `.env` database credentials
2. Check MySQL service is running:
   ```bash
   # macOS
   brew services list
   
   # Windows (XAMPP)
   # Open XAMPP Control Panel, start MySQL
   
   # Linux
   sudo service mysql status
   ```
3. Test database connection:
   ```bash
   mysql -h 127.0.0.1 -u root -p
   ```
4. Ensure database user has CREATE privileges

### Database Not Auto-Initializing

**Problem:** Tables not created automatically

**Solutions:**
1. Check MySQL user has CREATE DATABASE privilege:
   ```sql
   GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost';
   FLUSH PRIVILEGES;
   ```
2. Check PHP error logs:
   - XAMPP: `xampp/logs/php_error_log`
   - Herd: Check Herd logs
   - Linux: `/var/log/apache2/error.log`
3. Manually create database:
   ```sql
   CREATE DATABASE max1on1fitness;
   ```

### Login Not Working

**Problem:** Cannot login with admin credentials

**Solutions:**
1. Verify credentials match `.env` file
2. Check if users table exists:
   ```sql
   USE max1on1fitness;
   SHOW TABLES;
   SELECT * FROM users WHERE role='admin';
   ```
3. If no admin user, manually run seeder:
   ```bash
   php database/seed.php
   ```

### Page Not Found (404)

**Problem:** 404 errors on all pages

**Solutions:**
1. **Apache:** Enable mod_rewrite:
   ```bash
   # Linux
   sudo a2enmod rewrite
   sudo service apache2 restart
   
   # XAMPP: Already enabled
   ```
2. Check `.htaccess` exists in project root
3. Verify Apache allows `.htaccess` overrides:
   - Edit Apache config
   - Set `AllowOverride All` for your directory
4. **Herd:** Automatically handles routing

### CSS/Styles Not Loading

**Problem:** Website displays but no styling

**Solutions:**
1. Check browser console for errors (F12)
2. Verify `assets/css/` files exist
3. Check file paths in HTML
4. Clear browser cache (Ctrl+Shift+R)
5. Check file permissions (644 for CSS files)

### Session Errors

**Problem:** "Session could not be started" errors

**Solutions:**
1. Check session directory permissions
2. Verify PHP session is enabled in `php.ini`
3. Set custom session path in PHP:
   ```php
   // Add to config/Database.php or includes/session.php
   ini_set('session.save_path', '/path/to/writable/directory');
   ```

### Herd-Specific Issues

**Problem:** Site not accessible at `.test` domain

**Solutions:**
1. Restart Herd from menu bar
2. Re-park the directory:
   ```bash
   cd ~/Herd
   herd park
   ```
3. Check Herd is running (green icon in menu bar)

### Hostinger-Specific Issues

**Problem:** Internal Server Error (500)

**Solutions:**
1. Check file permissions:
   - Folders: `755`
   - Files: `644`
2. Review error logs in hPanel → **Advanced → Error Logs**
3. Verify PHP version compatibility (PHP 7.4+)
4. Check `.htaccess` syntax
5. Disable error display in production:
   ```php
   // Add to config/Database.php
   ini_set('display_errors', 0);
   ```

---

## Support & Contact

For additional help:
- Check error logs for specific error messages
- Verify all requirements are met
- Ensure `.env` file is properly configured

## Next Steps

After successful setup:
1. ✅ Login to admin panel
2. ✅ Change admin password
3. ✅ Customize page content via Admin → Content
4. ✅ Test all features (login, signup, content editing)
5. ✅ Set up regular backups (production)

---

**Version:** 1.0.0  
**Last Updated:** 2024
