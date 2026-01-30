# MAX1ON1FITNESS

A modern PHP web application for multi-device sports & fitness solutions with MVC architecture and role-based access control.

## Quick Start

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled

### Installation

1. **Clone or download the project**
   ```bash
   git clone <repository-url>
   cd max1on1fitness
   ```

2. **Configure Environment**
   
   Edit the `.env` file in the root directory:
   ```env
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_NAME=analognxt
   DB_USER=root
   DB_PASS=root
   
   ADMIN_EMAIL=admin@max1on1fitness.com
   ADMIN_PASSWORD=Admin@123
   ADMIN_USERNAME=admin
   ```

3. **Start Server**
   
   The database will be initialized automatically on first access.
   
   - Local: `http://localhost/`
   - Login: `http://localhost/login`

### Default Admin Credentials

- Email: `admin@max1on1fitness.com`
- Password: `Admin@123`

**⚠️ Change these credentials after first login!**

## Customizing Theme

All colors are defined as CSS variables in `assets/css/main.css`. To change the theme:

1. Open `assets/css/main.css`
2. Find the `:root` section at the top
3. Modify the CSS variables:

```css
:root {
    /* Primary Brand Colors */
    --primary-purple: #667eea;
    --primary-purple-dark: #764ba2;
    --secondary-pink: #f093fb;
    --secondary-red: #f5576c;
    --accent-blue: #4facfe;
    --accent-cyan: #00f2fe;
    
    /* Neutral Colors */
    --dark-color: #1a1a2e;
    --text-dark: #2d3436;
    --text-light: #636e72;
    --bg-light: #f8f9fa;
    --white: #ffffff;
    
    /* Status Colors */
    --success-color: #00b894;
    --error-color: #ff4655;
    
    /* ... more variables ... */
}
```

4. Save and refresh your browser

## Project Structure

```
.
├── assets/
│   ├── css/main.css       # All styles with CSS variables
│   └── js/script.js       # JavaScript functionality
├── config/
│   ├── Database.php       # Database connection
│   └── env.php           # Environment config
├── includes/
│   ├── header.php        # Common header
│   └── footer.php        # Common footer
├── models/               # Data models
├── views/                # Page views
├── .env                  # Configuration
├── index.php            # Entry point
└── router.php           # URL routing
```

## Routes

| URL | Description |
|-----|-------------|
| `/` | Home page |
| `/login` | Login page |
| `/signup` | Registration |
| `/dashboard` | Admin dashboard |

## Support

For issues or questions, contact: support@max1on1fitness.com

## License

All rights reserved.
