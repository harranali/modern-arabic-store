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

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# set script permission
RUN chmod +x start.sh

# Expose port for PHP-FPM
EXPOSE 9000

# Start script
CMD ["./start.sh"]
