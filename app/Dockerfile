FROM php:8.2-fpm

RUN apt update && apt install -y libpq-dev libzip-dev unzip libpng-dev
RUN docker-php-ext-install pdo pdo_pgsql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html/