FROM php:8.0-fpm

RUN docker-php-ext-install pdo_mysql

# Get composer
COPY --from=composer:2 /usr/bin/composer /bin/composer
