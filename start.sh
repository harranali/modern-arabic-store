#!/bin/bash
set -e

echo "Setting up Laravel environment..."

# Copy example env if .env doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Install PHP dependencies first
composer install --optimize-autoloader --no-scripts

# Run post-autoload scripts
composer run-script post-autoload-dump

# Generate APP_KEY
php artisan key:generate --ansi

# Run migrations and seed database
php artisan migrate --force
php artisan db:seed --force

# Install Node dependencies and build frontend
npm install
npm run build

# Set permissions
chown -R www-data:www-data storage bootstrap/cache

echo "Starting PHP-FPM..."
php-fpm
