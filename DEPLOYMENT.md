# Production Deployment Guide

## Prerequisites for Production

- ✅ PHP 8.1+ with required extensions
- ✅ MySQL/MariaDB database
- ✅ Apache/Nginx web server
- ✅ Composer installed
- ✅ Node.js and NPM installed
- ✅ SSL certificate (recommended)

## Server Requirements

### PHP Extensions Required
```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD (for image processing)
```

Check with: `php -m`

### Apache Modules Required
```
- mod_rewrite
- mod_headers (optional but recommended)
- mod_deflate (optional but recommended)
- mod_expires (optional but recommended)
```

Enable with:
```bash
sudo a2enmod rewrite
sudo a2enmod headers
sudo a2enmod deflate
sudo a2enmod expires
sudo systemctl restart apache2
```

## Deployment Steps

### 1. Upload Files

Upload all files to your server. Your directory structure should be:

```
/var/www/your-domain/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          ← Document root should point here
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── .htaccess        ← Root .htaccess
└── ...
```

### 2. Configure Apache Virtual Host

Create a new virtual host configuration:

```bash
sudo nano /etc/apache2/sites-available/business-manager.conf
```

Add the following:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    
    DocumentRoot /var/www/your-domain/public
    
    <Directory /var/www/your-domain/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/business-manager-error.log
    CustomLog ${APACHE_LOG_DIR}/business-manager-access.log combined
</VirtualHost>
```

For SSL (HTTPS):

```apache
<VirtualHost *:443>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    
    DocumentRoot /var/www/your-domain/public
    
    <Directory /var/www/your-domain/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
    SSLCertificateChainFile /path/to/chain.crt
    
    ErrorLog ${APACHE_LOG_DIR}/business-manager-error.log
    CustomLog ${APACHE_LOG_DIR}/business-manager-access.log combined
</VirtualHost>

# Redirect HTTP to HTTPS
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    Redirect permanent / https://yourdomain.com/
</VirtualHost>
```

Enable the site:

```bash
sudo a2ensite business-manager.conf
sudo systemctl reload apache2
```

### 3. Set File Permissions

**CRITICAL:** Proper permissions are essential for security and functionality.

```bash
# Navigate to project directory
cd /var/www/your-domain

# Set ownership
sudo chown -R www-data:www-data .

# Set directory permissions
sudo find . -type d -exec chmod 755 {} \;

# Set file permissions
sudo find . -type f -exec chmod 644 {} \;

# Set writable directories
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### 4. Configure Environment

```bash
# Copy and edit .env file
cp .env.example .env
nano .env
```

Configure for production:

```env
APP_NAME="Your Business Name"
APP_ENV=production
APP_KEY=           # Will be generated
APP_DEBUG=false    # IMPORTANT: false in production
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Mail configuration (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Install Dependencies

```bash
# Install PHP dependencies (production only)
composer install --optimize-autoloader --no-dev

# Install Node dependencies
npm install

# Build assets for production
npm run build
```

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Run Database Migrations

```bash
# Run migrations
php artisan migrate --force

# If you have seeders (optional)
# php artisan db:seed --force
```

### 8. Create Storage Link

```bash
php artisan storage:link
```

### 9. Optimize Application

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize composer autoloader
composer dump-autoload --optimize
```

### 10. Security Checklist

- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_ENV=production` in `.env`
- [ ] Strong database password
- [ ] SSL certificate installed
- [ ] File permissions set correctly
- [ ] `.env` file not publicly accessible
- [ ] Database backups configured
- [ ] Error logging configured

### 11. Test Deployment

Visit your domain and verify:

1. ✅ Homepage loads without errors
2. ✅ Can register/login
3. ✅ Can create clients
4. ✅ Can create projects
5. ✅ Can add tasks
6. ✅ Can record payments
7. ✅ Charts render correctly
8. ✅ File uploads work (logo in settings)
9. ✅ CSV/PDF exports work
10. ✅ Theme switching works

## Nginx Configuration (Alternative)

If using Nginx instead of Apache:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/your-domain/public;

    index index.php index.html;

    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Gzip compression
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
}
```

## Shared Hosting Deployment

### For cPanel/Plesk/Shared Hosting:

1. **Upload files** via FTP to your hosting account

2. **Set document root** to the `public` folder:
   - In cPanel: Go to "Domains" → "Domains" → Edit domain → Change document root to `/public`
   - Or move all files one level up and adjust paths

3. **Create database** via hosting control panel

4. **Configure .env** via File Manager

5. **Run Artisan commands** via SSH (if available) or create a setup script:

Create `setup.php` in the root:

```php
<?php
// setup.php - Run this once via browser: yourdomain.com/setup.php

// Change to your project directory
chdir(__DIR__);

echo "Running setup...\n\n";

// Generate app key
echo "Generating app key...\n";
exec('php artisan key:generate', $output);
print_r($output);

// Run migrations
echo "\nRunning migrations...\n";
exec('php artisan migrate --force', $output);
print_r($output);

// Create storage link
echo "\nCreating storage link...\n";
exec('php artisan storage:link', $output);
print_r($output);

// Cache config
echo "\nCaching configuration...\n";
exec('php artisan config:cache', $output);
print_r($output);

echo "\nSetup complete! DELETE THIS FILE NOW for security.";
```

**IMPORTANT:** Delete `setup.php` after running!

## Maintenance

### Updating the Application

```bash
# Pull latest changes (if using git)
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear and recache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Backup Strategy

**Database Backup:**
```bash
# Create backup script
nano /var/www/backup.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u your_db_user -p'your_password' your_database > /var/backups/db_backup_$DATE.sql
# Keep only last 7 days
find /var/backups/ -name "db_backup_*.sql" -mtime +7 -delete
```

```bash
chmod +x /var/www/backup.sh
# Add to crontab: 0 2 * * * /var/www/backup.sh
```

**Files Backup:**
```bash
# Backup uploaded files
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public
```

## Troubleshooting

### 500 Internal Server Error
- Check Apache error logs: `tail -f /var/log/apache2/error.log`
- Check Laravel logs: `tail -f storage/logs/laravel.log`
- Verify file permissions
- Clear cache: `php artisan optimize:clear`

### Page Not Found / 404 Errors
- Verify `.htaccess` exists in public folder
- Check if `mod_rewrite` is enabled
- Verify document root points to `public` folder

### CSS/JS Not Loading
- Run `npm run build`
- Check file permissions on `public/build` folder
- Clear browser cache
- Check `APP_URL` in `.env`

### Database Connection Error
- Verify database credentials in `.env`
- Check if MySQL is running
- Ensure database user has proper privileges

## Post-Deployment

1. **Monitor logs** for the first few days
2. **Set up automated backups**
3. **Configure monitoring** (UptimeRobot, etc.)
4. **Set up SSL auto-renewal** (if using Let's Encrypt)
5. **Create maintenance page** for future updates

---

**Your application is now live in production! 🚀**

