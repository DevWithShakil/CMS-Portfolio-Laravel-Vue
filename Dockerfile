# -------- Stage 1: Composer Build --------
FROM php:8.2-cli AS build

RUN apt-get update && apt-get install -y \
    git unzip zip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction


# -------- Stage 2: Production --------
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip zip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

WORKDIR /app
COPY --from=build /app /app

RUN chmod -R 777 storage bootstrap/cache


# -------- Render-safe startup script --------
RUN cat << 'EOF' > /usr/local/bin/startup.sh
#!/bin/sh
echo "[1/4] Checking database..."
while ! php -r "try { new PDO(getenv('DATABASE_URL')); exit(0);} catch (Exception \$e){ exit(1);}"; do
    echo "DB not ready... waiting 3 seconds..."
    sleep 3
done

echo "[2/4] Running migrations..."
php artisan migrate --force || true

echo "[3/4] Creating storage link..."
php artisan storage:link || true

echo "[4/4] Starting server..."
php artisan serve --host=0.0.0.0 --port=8000
EOF

RUN chmod +x /usr/local/bin/startup.sh

CMD ["sh", "/usr/local/bin/startup.sh"]
