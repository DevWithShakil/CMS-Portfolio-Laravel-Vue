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
set -e\n\
\n\
echo \"[1/4] Waiting for Database...\"\n\
until php -r \"try { new PDO(getenv(\\\"DATABASE_URL\\\")); echo \\\"DB OK\\\"; } catch (Exception \$e) { exit(1); }\"; do\n\
  echo \"DB not ready... retrying in 3 seconds\";\n\
  sleep 3;\n\
done\n\
\n\
echo \"[2/4] Running migrations...\"\n\
php artisan migrate --force || true\n\
\n\
echo \"[3/4] Linking storage...\"\n\
php artisan storage:link || true\n\
\n\
echo \"[4/4] Starting Laravel server...\"\n\
php artisan serve --host=0.0.0.0 --port=8000\n' \
> /usr/local/bin/startup.sh

RUN chmod +x /usr/local/bin/startup.sh

CMD ["sh", "/usr/local/bin/startup.sh"]
