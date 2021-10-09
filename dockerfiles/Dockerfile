FROM php:8.0-fpm

RUN docker-php-ext-install pdo_mysql

# Get composer
COPY --from=composer:2 /usr/bin/composer /bin/composer

# Specify host UID for creating runtime user in image
# If we don't create the user, the image will still run
# But there may be subtle problems arising from the user not existing in the container
ARG uid

RUN useradd appuser -u $uid -m
