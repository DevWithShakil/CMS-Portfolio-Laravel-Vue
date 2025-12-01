# ---------------------------------------------------------
# Stage 1: Build Laravel Application
# ---------------------------------------------------------
FROM php:8.2-fpm as build

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Cache configs
RUN php artisan config:cache
RUN php artisan route:cache

# ---------------------------------------------------------
# Stage 2: Runtime Container with Auto-Migrate
# ---------------------------------------------------------
FROM php:8.2-fpm

WORKDIR /var/www

COPY --from=build /var/www .

# Small script to wait for database
RUN echo '#!/bin/sh\n\
echo "Waiting for database connection..."\n\
until php -r "try { new PDO(getenv(\"DB_CONNECTION\") . \":host=\" . getenv(\"DB_HOST\") . \";port=\" . getenv(\"DB_PORT\")); echo \"DB connected\"; } catch (Exception \$e) { exit(1); }"; do\n\
  echo "DB not ready... retrying in 3 seconds..."\n\
  sleep 3\n\
done\n\
echo '#!/bin/sh\n\
echo "Waiting for 5 seconds before starting..." \n\
sleep 5 \n\
php artisan migrate --force \n\
php artisan storage:link \n\
php artisan serve --host=0.0.0.0 --port=8000' > /usr/local/bin/startup.sh


RUN chmod +x /usr/local/bin/startup.sh

EXPOSE 8000

CMD ["sh", "/usr/local/bin/startup.sh"]
