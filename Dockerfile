# ---------- Stage 1: Build ----------
FROM php:8.2-fpm AS build

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app

RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader


# ---------- Stage 2: Production ----------
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip

WORKDIR /app

COPY --from=build /app /app

RUN chmod -R 777 /app/storage /app/bootstrap/cache


# ---------- Startup Script ----------
RUN echo '#!/bin/sh\n\
echo \"Waiting for 5 seconds before starting...\" \n\
sleep 5 \n\
echo \"Running migrations...\" \n\
php artisan migrate --force || true \n\
echo \"Linking storage...\" \n\
php artisan storage:link || true \n\
echo \"Starting Laravel server...\" \n\
php artisan serve --host=0.0.0.0 --port=8000' \
> /usr/local/bin/startup.sh

RUN chmod +x /usr/local/bin/startup.sh

CMD ["sh", "/usr/local/bin/startup.sh"]
