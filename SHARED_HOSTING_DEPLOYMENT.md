# Shared Hosting Deployment (Without Node.js/npm)

## ⚠️ Important: Build Assets Locally First!

Your production server doesn't have Node.js/npm installed. This is normal for shared hosting. You need to build the assets on your **local machine** and then push the compiled files to production.

## Quick Fix for Your Current Issue

### Step 1: Build Assets Locally (On Your Computer)

```bash
# On your local machine (Windows)
cd "C:\Users\Espacegamers\Documents\bendaikh project"

# Build the assets
npm run build
```

This creates the compiled files in `public/build/`

### Step 2: Commit the Built Assets to Git

The built assets need to be in your repository for deployment:

```bash
# Make sure public/build is tracked by git
git add public/build/
git add public/build/manifest.json
git add public/build/assets/

# Commit the changes
git commit -m "Add compiled assets for production"

# Push to your repository
git push origin master
```

### Step 3: Pull on Production Server

```bash
# On your SSH connection
cd ~/public_html
git pull origin master
```

### Step 4: Run Laravel Commands (No npm needed!)

```bash
# Still on SSH
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

Done! Your application should now work with the latest JavaScript changes.

---

## Complete Deployment Workflow (For Future Updates)

### On Your Local Machine (Development)

1. **Make your changes**
   ```bash
   # Edit files as needed
   ```

2. **Build assets**
   ```bash
   npm run build
   ```

3. **Commit everything including built assets**
   ```bash
   git add .
   git commit -m "Your commit message"
   git push origin master
   ```

### On Production Server (via SSH)

1. **Pull changes**
   ```bash
   cd ~/public_html
   git pull origin master
   ```

2. **Update PHP dependencies** (if composer.json changed)
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Run migrations** (if database changed)
   ```bash
   php artisan migrate --force
   ```

4. **Clear and cache**
   ```bash
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

5. **Set permissions** (if needed)
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

---

## Important: Track Built Assets in Git

By default, Laravel's `.gitignore` might exclude `public/build/`. You need to track these files for shared hosting.

### Check Your .gitignore

Open `.gitignore` and make sure it does NOT have:
```
/public/build
/public/hot
```

If it does, remove those lines or add an exception:

```gitignore
# Allow built assets for shared hosting
!/public/build/
!/public/build/assets/
!/public/build/manifest.json
```

Then commit the built files:
```bash
git add -f public/build/
git commit -m "Track built assets for shared hosting deployment"
git push
```

---

## Alternative: Manual FTP Upload (If Git Issues)

If you have problems with git, you can manually upload the built files:

### Step 1: Build Locally
```bash
npm run build
```

### Step 2: Upload via FTP
Using FileZilla, WinSCP, or your hosting control panel's file manager:

1. Navigate to your local project: `public/build/`
2. Upload the entire `build` folder to server: `~/public_html/public/build/`
3. Make sure to overwrite existing files

### Step 3: Clear Cache via SSH
```bash
php artisan optimize:clear
```

---

## Gitignore Configuration for Shared Hosting

Create or update `.gitignore` to allow built assets:

```gitignore
# Dependencies
/node_modules
/vendor

# Environment
.env
.env.backup
.env.production

# IDE
.idea
.vscode
*.swp
*.swo
*~

# OS
.DS_Store
Thumbs.db

# Laravel
/storage/*.key
/storage/debugbar
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log

# BUT KEEP THESE FOR SHARED HOSTING:
# We need to track compiled assets for production
!/public/build/
!/public/build/**
```

---

## Automated Deployment Script (Optional)

Create a `deploy.sh` script on your local machine:

```bash
#!/bin/bash
# deploy.sh - Run this to deploy to production

echo "🚀 Starting deployment..."

echo "📦 Installing dependencies..."
npm install

echo "🔨 Building assets..."
npm run build

echo "📝 Committing changes..."
git add .
read -p "Enter commit message: " commit_msg
git commit -m "$commit_msg"

echo "⬆️ Pushing to repository..."
git push origin master

echo "✅ Local deployment complete!"
echo ""
echo "📡 Now run these commands on your production server:"
echo "   cd ~/public_html"
echo "   git pull origin master"
echo "   php artisan optimize:clear"
echo "   php artisan config:cache"
echo "   php artisan route:cache"
echo ""
```

Make it executable:
```bash
chmod +x deploy.sh
```

Use it:
```bash
./deploy.sh
```

---

## Quick Reference Commands

### Local Machine (Before Push)
```bash
npm run build                    # Build assets
git add .                       # Stage all changes
git commit -m "message"         # Commit
git push origin master          # Push to remote
```

### Production Server (After Pull)
```bash
cd ~/public_html                # Navigate to project
git pull origin master          # Pull changes
php artisan optimize:clear      # Clear all caches
php artisan config:cache        # Cache config
php artisan route:cache         # Cache routes
php artisan view:cache          # Cache views
```

---

## Troubleshooting

### Issue: "npm: command not found" on server
**Solution**: Build locally, commit the `public/build/` folder, and push to git.

### Issue: Assets not updating after push
**Solution**: 
```bash
# On server
php artisan optimize:clear
# In browser
Ctrl + Shift + R (hard refresh)
```

### Issue: "public/build not found" error
**Solution**: Make sure you committed and pushed the build folder:
```bash
# On local machine
git add -f public/build/
git commit -m "Add built assets"
git push
```

### Issue: Old JavaScript still loading
**Solution**:
1. Check if new files are on server: `ls -la ~/public_html/public/build/assets/`
2. Clear Laravel cache: `php artisan optimize:clear`
3. Hard refresh browser: `Ctrl + Shift + R`

---

## Current Status - What You Need to Do NOW

Based on your error, here's what to do right now:

1. **Exit SSH** (or open a new terminal on your local computer)

2. **On your local Windows machine**, run:
   ```bash
   cd "C:\Users\Espacegamers\Documents\bendaikh project"
   npm run build
   ```

3. **Commit the built files**:
   ```bash
   git add public/build/
   git commit -m "Add compiled assets with task edit/delete fixes"
   git push origin master
   ```

4. **Back on SSH**, pull the changes:
   ```bash
   cd ~/public_html
   git pull origin master
   php artisan optimize:clear
   php artisan config:cache
   ```

5. **Test your application** - the new JavaScript with all the fixes should now be live!

---

## Production Checklist

Before going live, ensure:

- [x] Assets built locally (`npm run build`)
- [x] Built files committed to git (`public/build/`)
- [x] `.env` configured for production
- [x] `APP_DEBUG=false` in `.env`
- [x] Database migrated (`php artisan migrate --force`)
- [x] Caches cleared and rebuilt
- [x] File permissions set correctly (755 for directories, 644 for files)
- [x] Storage linked (`php artisan storage:link`)

---

**Remember**: For shared hosting without Node.js, ALWAYS build assets locally and commit them to git! 🚀

