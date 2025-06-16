# syntax=docker/dockerfile:1

# 1. Base PHP image with FPM
FROM php:8.2-fpm

# 2. Install system dependencies, Node, and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    nodejs npm && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip bcmath && \
    rm -rf /var/lib/apt/lists/*

# 3. Copy Composer binary from Composer official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www/html

# 5. Copy application files and env example
COPY . /var/www/html
# Copy environment file (ensure .env has PostgreSQL settings)
COPY .env.example .env
# 5. Ensure correct host for PostgreSQL when running in Docker
RUN if grep -q '^DB_HOST=' .env; then \
    sed -i 's/^DB_HOST=.*/DB_HOST=host.docker.internal/' .env; \
  fi

# 6. Install PHP dependencies and build assets (skip scripts)
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts && \
    npm install && npm run build && \
    php artisan key:generate --force && \
    php artisan config:cache && \
    chmod -R 775 storage bootstrap/cache

# 8. Expose application port
EXPOSE 8000

# 9. Serve application via Artisan (development)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
