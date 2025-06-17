# syntax=docker/dockerfile:1

# 1. Base PHP image
FROM php:8.2-cli

# 2. Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    nodejs npm && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip bcmath && \
    rm -rf /var/lib/apt/lists/*

# 3. Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www/html

# 5. Copy application files
COPY . /var/www/html

# 6. Install dependencies and build assets
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts && \
    npm install && npm run build && \
    chmod -R 775 storage bootstrap/cache

# 7. Create startup script that handles database connection gracefully
RUN echo '#!/bin/bash\n\
echo "Starting PBS NYC application..."\n\
\n\
# Wait for environment variables to be available\n\
sleep 3\n\
\n\
# Try to run migrations, but don\'t fail if database is not ready\n\
echo "Attempting database migration..."\n\
php artisan migrate --force || echo "Migration failed - database may not be ready yet"\n\
\n\
# Start the application\n\
echo "Starting web server on port $PORT..."\n\
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}' > /start.sh && chmod +x /start.sh

# 8. Expose port (Railway will set $PORT)
EXPOSE 8000

# 9. Start application
CMD ["/start.sh"]
