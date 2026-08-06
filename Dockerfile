FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    curl zip unzip git nodejs npm \
    libpng-dev libzip-dev oniguruma-dev libxml2-dev \
    && docker-php-ext-install \
    pdo pdo_mysql mbstring zip exif bcmath xml ctype

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-scripts --no-interaction --prefer-dist --optimize-autoloader

RUN npm ci && npm run build

RUN php artisan package:discover --ansi \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
