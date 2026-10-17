# Ecotech Service — Setup Instructions

## Prerequisites

- **XAMPP** (PHP 8.1+, Apache, MySQL) — [Download](https://www.apachefriends.org/download.html)
- **Composer** (optional, for PHPMailer) — [Download](https://getcomposer.org)

---

## Step 1 — Copy Project Files

Place the entire `Ecotechservice` folder inside your XAMPP `htdocs` directory:

```
C:\xampp\htdocs\Ecotechservice\
```

---

## Step 2 — Create the Database

1. Start XAMPP → Start **Apache** and **MySQL**
2. Open **phpMyAdmin**: `http://localhost/phpmyadmin`
3. Click **Import** → choose `database/ecotech.sql`
4. Click **Go** → database `ecotech_service` is created

---

## Step 3 — Configure the Application

Open `config/config.php` and update:

```php
// Database (if using a password)
define('DB_USER', 'root');
define('DB_PASS', '');          // your MySQL password

// Email (Gmail SMTP example)
define('SMTP_USER', 'your_email@gmail.com');
define('SMTP_PASS', 'your_app_password');   // Gmail App Password

// WhatsApp (digits only, no + or spaces)
define('WHATSAPP_NUMBER', '918001234567');
```

---

## Step 4 — Install PHPMailer (Optional but Recommended)

```bash
cd C:\xampp\htdocs\Ecotechservice
composer install
```

If you skip this step, contact form emails won't be sent but form submissions will still be saved in the database.

---

## Step 5 — Enable Apache mod_rewrite

In XAMPP:
1. Open **Apache** → **Config** → **httpd.conf**
2. Find `#LoadModule rewrite_module` → remove the `#`
3. Find `AllowOverride None` (for htdocs) → change to `AllowOverride All`
4. Restart Apache

---

## Step 6 — Access the Website

| Page | URL |
|------|-----|
| Homepage | `http://localhost/Ecotechservice/public/` |
| Admin Panel | `http://localhost/Ecotechservice/public/admin` |

### Admin Credentials
The seed data in `database/ecotech.sql` creates a default admin account.
> **⚠️ Change its email and password immediately after first login via Admin → Settings.**

---

## Gmail SMTP App Password Setup

1. Go to your Google Account → Security → 2-Step Verification (enable it)
2. Search for "App Passwords" → Create one for "Mail" + "Windows Computer"
3. Copy the 16-character password → paste into `config/config.php` as `SMTP_PASS`

---

## Folder Structure

```
Ecotechservice/
├── app/
│   ├── controllers/
│   │   ├── Admin/              ← All admin controllers
│   │   ├── BaseController.php
│   │   ├── HomeController.php
│   │   ├── ServicesController.php
│   │   ├── ProjectsController.php
│   │   ├── TemplatesController.php
│   │   └── ContactController.php
│   ├── helpers/
│   │   ├── Security.php        ← CSRF, XSS, uploads
│   │   └── Helpers.php         ← URL, flash, slugify
│   └── views/
│       ├── layouts/
│       │   ├── main.php        ← Public layout
│       │   ├── admin.php       ← Admin sidebar layout
│       │   └── admin_auth.php  ← Login layout
│       ├── admin/              ← All admin views
│       ├── home.php
│       ├── about.php
│       ├── services.php
│       ├── projects.php
│       ├── project_detail.php
│       ├── templates.php
│       ├── contact.php
│       └── errors/404.php
├── config/
│   ├── config.php              ← All configuration
│   └── database.php            ← PDO connection
├── database/
│   └── ecotech.sql             ← Full database schema + seed data
├── public/
│   ├── .htaccess               ← URL rewriting + security headers
│   ├── index.php               ← Front controller
│   ├── sitemap.xml
│   ├── robots.txt
│   └── assets/
│       ├── css/
│       │   ├── style.css       ← Main site CSS
│       │   └── admin.css       ← Admin CSS
│       ├── js/
│       │   ├── app.js          ← Frontend JS
│       │   └── admin.js        ← Admin JS
│       ├── img/                ← Place your images here
│       └── uploads/            ← Auto-created on first upload
├── logs/                       ← PHP error logs
├── vendor/                     ← Composer packages (after install)
└── composer.json
```

---

## Admin Panel Features

| Feature | URL |
|---------|-----|
| Dashboard | `/admin/dashboard` |
| Projects CRUD | `/admin/projects` |
| Services CRUD | `/admin/services` |
| Testimonials CRUD | `/admin/testimonials` |
| Contact Messages | `/admin/contacts` |
| Site Settings | `/admin/settings` |

---

## Security Features Implemented

- ✅ **SQL Injection** — PDO prepared statements everywhere
- ✅ **XSS** — `Security::e()` output escaping in all views
- ✅ **CSRF** — Token validation on every POST form
- ✅ **Session Fixation** — `session_regenerate_id()` on login
- ✅ **Rate Limiting** — Session-based login attempt counter
- ✅ **Secure Headers** — X-Frame-Options, X-XSS-Protection, etc.
- ✅ **Password Hashing** — bcrypt with cost factor 12
- ✅ **File Upload Validation** — MIME type check, size limit
- ✅ **Admin Route Protection** — `requireAdmin()` on every admin action

---

## Deploying to Hostinger / cPanel

1. Upload all files via FTP (FileZilla)
2. Import `ecotech.sql` via phpMyAdmin on your hosting
3. Update `config/config.php`:
   - `APP_URL` → your domain (e.g. `https://ecotechservice.com`)
   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` → hosting DB credentials
   - `APP_ENV` → `'production'`
4. Update `.htaccess` `RewriteBase` to `/public/` (if domain points to `/public`)
5. Run `composer install --no-dev` on server or upload `vendor/` folder

---

*Generated clean, modular, production-ready code with proper comments and scalability in mind.*
