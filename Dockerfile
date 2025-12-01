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
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy only Laravel backend (Vue folders ignored via .dockerignore)
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Cache Laravel configuration
RUN php artisan config:cache
RUN php artisan route:cache

# ---------------------------------------------------------
# Stage 2: Serve Laravel using PHP Built-in Server
# ---------------------------------------------------------
FROM php:8.2-fpm

WORKDIR /var/www

COPY --from=build /var/www .

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
