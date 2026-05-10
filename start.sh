#!/bin/bash

# Run migrations and seeders automatically
echo "Configuring database..."
php artisan migrate --force
php artisan db:seed --force

# Start Apache
echo "Starting Apache..."
apache2-foreground
