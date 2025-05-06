FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_pgsql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html