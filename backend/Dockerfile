FROM php:7.4-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql zip

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

CMD composer install && php-fpm
