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


# -------- Startup Script (Dash Compatible) --------
RUN printf "%s\n" "\
#!/bin/sh\n\
echo \"[1/4] Checking database...\"\n\
while ! php -r \"try{ new PDO(getenv('DATABASE_URL')); exit(0);} catch(Exception \$e){ exit(1);} \"; do\n\
    echo \"DB not ready... wait 3 sec\"\n\
    sleep 3\n\
done\n\
\n\
echo \"[2/4] Running migrations...\"\n\
php artisan migrate --force || true\n\
\n\
echo \"[3/4] Storage Link\"\n\
php artisan storage:link || true\n\
\n\
echo \"[4/4] Starting server...\"\n\
php artisan serve --host=0.0.0.0 --port=8000\n\
" > /usr/local/bin/startup.sh

RUN chmod +x /usr/local/bin/startup.sh

CMD ["sh", "/usr/local/bin/startup.sh"]
