#!/bin/bash

# Business Manager - Setup Script
# This script automates the initial setup process

echo "======================================"
echo "Business Manager - Setup Script"
echo "======================================"
echo ""

# Check if .env exists
if [ -f .env ]; then
    echo "⚠️  .env file already exists!"
    read -p "Do you want to overwrite it? (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo "Setup cancelled."
        exit 1
    fi
fi

# Copy .env.example to .env
echo "📄 Creating .env file from .env.example..."
cp .env.example .env
echo "✅ .env file created"
echo ""

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer first."
    echo "   Visit: https://getcomposer.org/download/"
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "❌ NPM is not installed. Please install Node.js and NPM first."
    echo "   Visit: https://nodejs.org/"
    exit 1
fi

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install
echo "✅ PHP dependencies installed"
echo ""

# Install Node dependencies
echo "📦 Installing Node dependencies..."
npm install
echo "✅ Node dependencies installed"
echo ""

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate
echo "✅ Application key generated"
echo ""

# Prompt for database configuration
echo "======================================"
echo "Database Configuration"
echo "======================================"
echo ""

read -p "Enter database name [business_manager]: " db_name
db_name=${db_name:-business_manager}

read -p "Enter database username [root]: " db_user
db_user=${db_user:-root}

read -sp "Enter database password: " db_pass
echo ""

read -p "Enter database host [127.0.0.1]: " db_host
db_host=${db_host:-127.0.0.1}

read -p "Enter database port [3306]: " db_port
db_port=${db_port:-3306}

# Update .env file with database credentials
echo ""
echo "📝 Updating .env file with database credentials..."

# For macOS (use gsed if available, otherwise sed -i '')
if [[ "$OSTYPE" == "darwin"* ]]; then
    sed -i '' "s/DB_DATABASE=business_manager/DB_DATABASE=$db_name/" .env
    sed -i '' "s/DB_USERNAME=root/DB_USERNAME=$db_user/" .env
    sed -i '' "s/DB_PASSWORD=/DB_PASSWORD=$db_pass/" .env
    sed -i '' "s/DB_HOST=127.0.0.1/DB_HOST=$db_host/" .env
    sed -i '' "s/DB_PORT=3306/DB_PORT=$db_port/" .env
else
    sed -i "s/DB_DATABASE=business_manager/DB_DATABASE=$db_name/" .env
    sed -i "s/DB_USERNAME=root/DB_USERNAME=$db_user/" .env
    sed -i "s/DB_PASSWORD=/DB_PASSWORD=$db_pass/" .env
    sed -i "s/DB_HOST=127.0.0.1/DB_HOST=$db_host/" .env
    sed -i "s/DB_PORT=3306/DB_PORT=$db_port/" .env
fi

echo "✅ Database credentials updated"
echo ""

# Ask if user wants to create the database
read -p "Do you want to create the database now? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "📊 Creating database..."
    mysql -u"$db_user" -p"$db_pass" -h"$db_host" -P"$db_port" -e "CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    if [ $? -eq 0 ]; then
        echo "✅ Database created successfully"
    else
        echo "⚠️  Could not create database. You may need to create it manually."
    fi
    echo ""
fi

# Run migrations
read -p "Do you want to run database migrations now? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "🗄️  Running database migrations..."
    php artisan migrate
    echo "✅ Migrations completed"
    echo ""
fi

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link
echo "✅ Storage link created"
echo ""

# Build assets
read -p "Do you want to build frontend assets now? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "🎨 Building frontend assets..."
    npm run build
    echo "✅ Assets built successfully"
    echo ""
fi

# Set permissions (Linux/Mac only)
if [[ "$OSTYPE" != "msys" && "$OSTYPE" != "win32" ]]; then
    echo "🔒 Setting file permissions..."
    chmod -R 775 storage bootstrap/cache
    echo "✅ Permissions set"
    echo ""
fi

echo "======================================"
echo "✅ Setup Complete!"
echo "======================================"
echo ""
echo "Next steps:"
echo "1. Start the development server: php artisan serve"
echo "2. In another terminal, run: npm run dev (for development)"
echo "3. Visit: http://localhost:8000"
echo "4. Register your admin account"
echo ""
echo "For production deployment, see DEPLOYMENT.md"
echo ""
echo "Happy Managing! 🚀"

