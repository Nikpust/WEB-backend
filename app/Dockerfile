FROM php:8.2-apache

RUN apt update && apt install -y libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html/