# Quick Setup Guide

Follow these steps to get your Business Manager application up and running:

## Prerequisites Check

Before starting, ensure you have:
- ✅ PHP 8.1 or higher (`php -v`)
- ✅ Composer (`composer -V`)
- ✅ Node.js 16+ and NPM (`node -v` and `npm -v`)
- ✅ MySQL or MariaDB running

## Step-by-Step Setup

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup

Edit your `.env` file:
```env
DB_DATABASE=business_manager
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database:
```bash
# MySQL
mysql -u root -p -e "CREATE DATABASE business_manager;"

# Or use phpMyAdmin/MySQL Workbench
```

Run migrations:
```bash
php artisan migrate
```

### 4. Storage Setup

```bash
# Create storage link for uploaded files
php artisan storage:link
```

### 5. Build Frontend Assets

```bash
# For development (with hot reload)
npm run dev

# For production
npm run build
```

### 6. Start the Application

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2 (if using npm run dev): Keep Vite running
npm run dev
```

### 7. Access the Application

Open your browser and navigate to:
```
http://localhost:8000
```

### 8. Create Your Admin Account

1. Click on "Register"
2. Fill in your details
3. Start managing your business!

## Common Issues & Solutions

### Issue: "No application encryption key has been specified"
**Solution:**
```bash
php artisan key:generate
```

### Issue: Assets not loading
**Solution:**
```bash
npm run build
php artisan optimize:clear
```

### Issue: Database connection error
**Solution:**
- Check `.env` database credentials
- Ensure MySQL is running: `sudo service mysql start` (Linux) or check XAMPP/WAMP
- Verify database exists: `SHOW DATABASES;` in MySQL

### Issue: Permission denied errors
**Solution:**
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Windows (run as administrator)
# Use File Explorer to grant full permissions to storage and bootstrap/cache folders
```

### Issue: Vue components not working
**Solution:**
```bash
# Clear cache and rebuild
npm install
npm run build
php artisan optimize:clear
```

## Development Mode

For active development with hot module replacement:

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Your changes will auto-reload in the browser!

## Production Deployment

When deploying to production:

```bash
# Install production dependencies
composer install --optimize-autoloader --no-dev

# Build assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Environment Variables

Key `.env` variables to configure:

```env
APP_NAME="Your Business Name"
APP_ENV=production  # or local for development
APP_DEBUG=false     # false in production
APP_URL=https://your-domain.com

DB_DATABASE=business_manager
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password
```

## File Permissions (Linux/Mac)

```bash
# Set proper permissions
sudo chown -R www-data:www-data /path/to/project
sudo find /path/to/project -type f -exec chmod 644 {} \;
sudo find /path/to/project -type d -exec chmod 755 {} \;
sudo chmod -R 775 storage bootstrap/cache
```

## Testing Your Installation

After setup, verify:

1. ✅ Can access login page at `http://localhost:8000`
2. ✅ Can register a new admin account
3. ✅ Dashboard loads with charts
4. ✅ Can create a client
5. ✅ Can create a project
6. ✅ Can add tasks to project
7. ✅ Can record a payment
8. ✅ Analytics page shows data

## Next Steps

1. Customize your profile in **Settings**
2. Set your preferred currency
3. Choose your theme (Light/Dark)
4. Add your first client
5. Create a project
6. Start tracking tasks and payments!

## Support

If you encounter any issues:
1. Check the main README.md
2. Review the troubleshooting section
3. Check Laravel logs: `storage/logs/laravel.log`
4. Check browser console for JavaScript errors

---

**Happy Managing! 🎉**

