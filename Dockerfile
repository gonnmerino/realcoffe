FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    software-properties-common curl git unzip zip \
    && add-apt-repository ppa:ondrej/php \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y \
    php8.4 php8.4-cli \
    php8.4-mbstring php8.4-xml \
    php8.4-pdo php8.4-mysql \
    php8.4-pgsql php8.4-zip \
    php8.4-bcmath php8.4-curl \
    php8.4-tokenizer php8.4-ctype \
    php8.4-fileinfo php8.4-dom \
    nodejs \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-scripts --no-interaction --prefer-dist --optimize-autoloader

RUN npm ci && npm run build

RUN php8.4 artisan package:discover --ansi

EXPOSE 8000

CMD php8.4 artisan config:cache && \
    php8.4 artisan route:cache && \
    php8.4 artisan view:cache && \
    php8.4 artisan migrate --force && \
    php8.4 artisan storage:link && \
    php8.4 -S 0.0.0.0:8000 -t public
