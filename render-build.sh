#!/usr/bin/env bash
# exit on error
set -o errexit

echo "🚀 Starting Build Process..."

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations (Optional: some prefer running this manually via shell)
# php artisan migrate --force

# Clear and cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Link storage
php artisan storage:link

echo "✅ Build Completed Successfully!"
