# syntax=docker/dockerfile:1

# 1. Base PHP image with FPM
FROM php:8.1-fpm

# 2. Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip && \
    docker-php-ext-install pdo pdo_pgsql zip && \
    rm -rf /var/lib/apt/lists/*

# 3. Copy Composer binary from Composer official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www/html

# 5. Copy application files
COPY . /var/www/html

# 6. Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev && \
    php artisan key:generate --force && \
    php artisan config:cache && \
    chmod -R 775 storage bootstrap/cache

# 7. Expose FPM port
EXPOSE 9000

# 8. Start PHP-FPM
CMD ["php-fpm"]

# 9. Install PostgreSQL PHP extension
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql
