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

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files first to leverage Docker cache
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-scripts

# Copy all app files
COPY . .

# run post scrits
RUN composer run-script post-autoload-dump

# Install Node dependencies and build frontend
RUN npm install
RUN npm run build

# set script permission
RUN chmod +x start.sh

# Expose port for PHP-FPM
EXPOSE 9000

# Start script
CMD ["./start.sh"]
