# Base PHP 8.3 with FPM
FROM php:8.3-fpm

# Install system dependencies + Node.js
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy composer files and install PHP dependencies
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Copy package files and install Node dependencies
COPY package*.json ./
RUN npm install

# Copy the rest of the application
COPY . .

# Build frontend assets
RUN npm run build

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
