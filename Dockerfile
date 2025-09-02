# Base PHP 8.3 with FPM
FROM php:8.3-fpm

# Install system dependencies + Node.js
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy all app files
COPY . .

# Copy example env
RUN cp .env.example .env

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies (skip scripts initially to avoid artisan errors)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Run post-autoload scripts now that artisan exists
RUN composer run-script post-autoload-dump

# run migrations 
RUN php artisan migrate

# seed database 
RUN php artisan db:seed

# Install Node dependencies
RUN npm install

# Set environment variable to skip Wayfinder type generation
ENV WAYFINDER_SKIP_GENERATE=true

# Build frontend assets
RUN npm run build

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
