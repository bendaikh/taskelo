@echo off
REM Business Manager - Setup Script for Windows
REM This script automates the initial setup process

echo ======================================
echo Business Manager - Setup Script
echo ======================================
echo.

REM Check if .env exists
if exist .env (
    echo WARNING: .env file already exists!
    set /p overwrite="Do you want to overwrite it? (y/n): "
    if /i not "%overwrite%"=="y" (
        echo Setup cancelled.
        exit /b 1
    )
)

REM Copy .env.example to .env
echo Creating .env file from .env.example...
copy .env.example .env
echo .env file created
echo.

REM Check if composer is installed
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Composer is not installed. Please install Composer first.
    echo Visit: https://getcomposer.org/download/
    pause
    exit /b 1
)

REM Check if npm is installed
where npm >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: NPM is not installed. Please install Node.js and NPM first.
    echo Visit: https://nodejs.org/
    pause
    exit /b 1
)

REM Install PHP dependencies
echo Installing PHP dependencies...
call composer install
echo PHP dependencies installed
echo.

REM Install Node dependencies
echo Installing Node dependencies...
call npm install
echo Node dependencies installed
echo.

REM Generate application key
echo Generating application key...
php artisan key:generate
echo Application key generated
echo.

REM Database Configuration
echo ======================================
echo Database Configuration
echo ======================================
echo.

set /p db_name="Enter database name [business_manager]: "
if "%db_name%"=="" set db_name=business_manager

set /p db_user="Enter database username [root]: "
if "%db_user%"=="" set db_user=root

set /p db_pass="Enter database password: "

set /p db_host="Enter database host [127.0.0.1]: "
if "%db_host%"=="" set db_host=127.0.0.1

set /p db_port="Enter database port [3306]: "
if "%db_port%"=="" set db_port=3306

REM Update .env file with database credentials using PowerShell
echo.
echo Updating .env file with database credentials...

powershell -Command "(Get-Content .env) -replace 'DB_DATABASE=business_manager', 'DB_DATABASE=%db_name%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_USERNAME=root', 'DB_USERNAME=%db_user%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_PASSWORD=', 'DB_PASSWORD=%db_pass%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_HOST=127.0.0.1', 'DB_HOST=%db_host%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_PORT=3306', 'DB_PORT=%db_port%' | Set-Content .env"

echo Database credentials updated
echo.

REM Ask to create database
set /p create_db="Do you want to create the database now? (y/n): "
if /i "%create_db%"=="y" (
    echo Creating database...
    mysql -u%db_user% -p%db_pass% -h%db_host% -P%db_port% -e "CREATE DATABASE IF NOT EXISTS %db_name% CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    if %ERRORLEVEL% EQU 0 (
        echo Database created successfully
    ) else (
        echo Could not create database. You may need to create it manually.
    )
    echo.
)

REM Run migrations
set /p run_migrations="Do you want to run database migrations now? (y/n): "
if /i "%run_migrations%"=="y" (
    echo Running database migrations...
    php artisan migrate
    echo Migrations completed
    echo.
)

REM Create storage link
echo Creating storage link...
php artisan storage:link
echo Storage link created
echo.

REM Build assets
set /p build_assets="Do you want to build frontend assets now? (y/n): "
if /i "%build_assets%"=="y" (
    echo Building frontend assets...
    call npm run build
    echo Assets built successfully
    echo.
)

echo ======================================
echo Setup Complete!
echo ======================================
echo.
echo Next steps:
echo 1. Start the development server: php artisan serve
echo 2. In another terminal, run: npm run dev (for development)
echo 3. Visit: http://localhost:8000
echo 4. Register your admin account
echo.
echo For production deployment, see DEPLOYMENT.md
echo.
echo Happy Managing!
echo.
pause

