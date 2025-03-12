FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libonig-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . ./

RUN composer install --optimize-autoloader

CMD ["php-fpm"]
