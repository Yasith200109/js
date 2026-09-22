# J & S Constructions Website + Admin Panel

A complete responsive construction-company website built with Core PHP, MySQL, Tailwind CSS CDN and vanilla JavaScript.

## Premium update included

- Redesigned premium homepage with contact information, visual service cards and featured house designs
- Responsive hero section with corrected spacing and content visibility
- Expanded project portfolio and bundled construction image library
- Multi-image project galleries with fullscreen lightbox, next/previous controls and related projects
- Improved WhatsApp floating contact dock
- Mobile quick-contact bar for Call, WhatsApp and Quotation
- Desktop header Call Now and Get a Quote actions
- Redesigned admin control center with grouped navigation, notification badges and scrollable sidebar
- Upgraded dashboard with content health, project overview and quick-management actions

## Included public pages

- Home
- About Us
- Services
- Projects and premium project detail pages
- House Designs and design detail pages
- Gallery
- Request a Quotation
- Contact Us
- Responsive mobile navigation
- WhatsApp, phone and email actions
- SEO title and description support

## Admin panel features

- Secure admin login with hashed password
- Premium responsive dashboard
- Project CRUD, cover image and multi-image project gallery
- Service CRUD
- House design CRUD
- Gallery CRUD
- Testimonial CRUD
- Quotation request management with statuses and internal notes
- Contact-message management with statuses and internal notes
- Company/contact/SEO settings
- Admin profile and password change
- CSRF protection, PDO prepared statements and image validation

## Requirements

- PHP 8.1 or newer
- MySQL 5.7+ or MySQL 8+
- PHP extensions: `pdo_mysql`, `fileinfo`, `mbstring`
- Apache recommended; Nginx also works with normal PHP routing

## New XAMPP installation

1. Copy the `js-constructions` folder into `C:\xampp\htdocs\`.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin.
4. Import `database.sql`. It creates the `js_constructions` database, complete sample content and expanded project galleries.
5. Check `config/database.php`:

```php
'host' => 'localhost',
'name' => 'js_constructions',
'user' => 'root',
'pass' => '',
```

6. Ensure the `uploads` folder is writable.
7. Open:

- Website: `http://localhost/js-constructions/`
- Admin: `http://localhost/js-constructions/admin/login.php`

## Updating an already-installed older version

1. Back up the existing files and database.
2. Replace the project files with this updated version.
3. Import `database_patch_v2_premium.sql` once through phpMyAdmin.
4. Clear the browser cache and reload the website.

The patch adds the expanded sample projects, gallery records and project-detail image galleries without changing the database structure.

## Default admin account

- Email: `admin@jsconstructions.lk`
- Password: `Admin@12345`

**Change the password immediately** from Admin Panel → Admin Profile.

## Shared hosting installation

1. Upload all files to `public_html` or a subfolder.
2. Create a MySQL database and database user from cPanel.
3. Import `database.sql` through phpMyAdmin.
4. Update `config/database.php` with the hosting database credentials.
5. Set the `uploads` directory permission to `755` or `775`, depending on the host.
6. Sign in to the admin panel and open Website Settings.
7. Set **Site URL** to the live domain, for example `https://jsconstructions.lk`.
8. Change the default admin password.

## Database environment variables

Instead of editing the config file, the project supports:

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`

## Image notes

- A complete local sample image library is included under `uploads/library`
- Admin-uploaded images: JPG, PNG or WEBP
- Maximum application upload size: 5 MB per image
- If hosting blocks larger uploads, update `upload_max_filesize` and `post_max_size` in PHP settings
- Sample portfolio images can be replaced from the admin panel
- Bundled library images are protected from accidental deletion when editing sample records

## Branding assets included

- `assets/images/logo.jpg`
- `assets/images/hero-banner.jpg`
- `assets/images/pages/about-cover.jpg`
- `assets/images/services/`
- `uploads/library/`

The color palette is based on the supplied J & S Constructions logo: deep navy, royal blue, white and light blue.
