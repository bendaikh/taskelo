# Quick Start Guide

## ⚡ Fastest Way to Get Started

### Option 1: Automated Setup (Recommended)

**For Linux/Mac:**
```bash
chmod +x setup.sh
./setup.sh
```

**For Windows:**
```bash
setup.bat
```

The setup script will:
- ✅ Create `.env` file from `.env.example`
- ✅ Install all dependencies (PHP + Node)
- ✅ Generate application key
- ✅ Configure database (interactive prompts)
- ✅ Create database (optional)
- ✅ Run migrations (optional)
- ✅ Build frontend assets (optional)
- ✅ Set proper permissions

### Option 2: Manual Setup

If you prefer manual setup or the script doesn't work:

#### Step 1: Create Environment File
```bash
# Copy the template
cp .env.example .env

# Edit with your favorite editor
nano .env
# or
code .env
```

#### Step 2: Configure Database in .env
```env
DB_DATABASE=business_manager
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### Step 3: Install Dependencies
```bash
composer install
npm install
```

#### Step 4: Generate Application Key
```bash
php artisan key:generate
```

#### Step 5: Create Database
```bash
# Using MySQL command line
mysql -u root -p

# Then in MySQL:
CREATE DATABASE business_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

Or use phpMyAdmin/MySQL Workbench to create the database.

#### Step 6: Run Migrations
```bash
php artisan migrate
```

#### Step 7: Create Storage Link
```bash
php artisan storage:link
```

#### Step 8: Build Frontend Assets
```bash
# For development (with hot reload)
npm run dev

# For production
npm run build
```

#### Step 9: Start the Server
```bash
php artisan serve
```

Visit `http://localhost:8000` and register your account!

## 📋 Prerequisites Checklist

Before starting, make sure you have:

- [ ] **PHP 8.1+** - Check: `php -v`
- [ ] **Composer** - Check: `composer -V`
- [ ] **Node.js 16+** - Check: `node -v`
- [ ] **NPM** - Check: `npm -v`
- [ ] **MySQL/MariaDB** - Check: `mysql --version`

### Installing Prerequisites

**Windows:**
- PHP: Use [XAMPP](https://www.apachefriends.org/) or [Laragon](https://laragon.org/)
- Composer: [Download](https://getcomposer.org/download/)
- Node.js: [Download](https://nodejs.org/)

**Mac:**
```bash
# Using Homebrew
brew install php@8.1
brew install composer
brew install node
brew install mysql
```

**Linux (Ubuntu/Debian):**
```bash
# PHP
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-common php8.1-mysql php8.1-xml php8.1-curl php8.1-mbstring php8.1-zip php8.1-gd

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs

# MySQL
sudo apt install mysql-server
```

## 🚨 Common Issues

### "Copy .env.example to .env first"
```bash
cp .env.example .env
```

### "No application encryption key has been specified"
```bash
php artisan key:generate
```

### "SQLSTATE[HY000] [1049] Unknown database"
Create the database:
```bash
mysql -u root -p -e "CREATE DATABASE business_manager;"
```

### "Permission denied"
**Linux/Mac:**
```bash
chmod -R 775 storage bootstrap/cache
```

**Windows:** Run terminal as Administrator

### "npm: command not found"
Install Node.js from [nodejs.org](https://nodejs.org/)

### "composer: command not found"
Install Composer from [getcomposer.org](https://getcomposer.org/)

## 🎯 What Happens After Setup?

Once setup is complete:

1. **Start Development Server:**
   ```bash
   php artisan serve
   ```
   App available at: `http://localhost:8000`

2. **Start Vite Dev Server** (in another terminal):
   ```bash
   npm run dev
   ```
   This enables hot module replacement for instant updates

3. **Register Your Account:**
   - Visit `http://localhost:8000/register`
   - Create your admin account
   - Start managing your business!

## 📁 Project Structure After Setup

```
bendaikh-project/
├── .env                    ✅ Your environment config (created by setup)
├── .env.example            ✅ Template file
├── vendor/                 ✅ PHP dependencies (installed by composer)
├── node_modules/           ✅ Node dependencies (installed by npm)
├── public/build/           ✅ Compiled assets (created by npm run build)
├── storage/app/public/     ✅ Uploaded files
└── database/
    └── database.sqlite     ✅ Created if using SQLite
```

## 🔄 Development Workflow

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (for hot reload)
npm run dev

# Your code changes will auto-reload in the browser!
```

## 🚀 Ready for Production?

See [DEPLOYMENT.md](DEPLOYMENT.md) for complete production deployment instructions.

## 💡 Tips

1. **Use SQLite for quick testing:**
   In `.env`:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database.sqlite
   ```
   Then:
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

2. **Reset database:**
   ```bash
   php artisan migrate:fresh
   ```

3. **Clear all caches:**
   ```bash
   php artisan optimize:clear
   ```

4. **View routes:**
   ```bash
   php artisan route:list
   ```

## ❓ Need Help?

1. Check `README.md` for full documentation
2. Check `DEPLOYMENT.md` for production setup
3. Review Laravel logs: `storage/logs/laravel.log`
4. Check browser console for JavaScript errors

---

**You're all set! Start building your business management system! 🎉**

