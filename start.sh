#!/bin/bash
set -e

echo "Setting up Laravel environment..."

# Copy example env if .env doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
fi

# add sqlite
touch database/database.sqlite
chown www-data:www-data database/database.sqlite
chmod 664 database/database.sqlite

# Set permissions early
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Generate APP_KEY if missing
if ! grep -q 'APP_KEY=' .env || [ -z "$(grep 'APP_KEY=' .env | cut -d'=' -f2)" ]; then
    php artisan key:generate --ansi
fi

# Final ownership (just in case)
chown -R www-data:www-data storage bootstrap/cache

# Determine port (Render sets $PORT, default to 8000 locally)
PORT=${PORT:-8000}

echo "Starting Laravel server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
