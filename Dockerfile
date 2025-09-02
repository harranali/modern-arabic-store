# Use PHP 8.3 with Node pre-installed
FROM shivammathur/php:8.3-node

# Set working directory
WORKDIR /var/www/html

# Copy composer files and install PHP dependencies
COPY composer.json composer.lock ./
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
