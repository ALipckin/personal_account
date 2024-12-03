FROM php:7.4.33-fpm-alpine3.16

# Install required packages, including build dependencies
RUN apk add --no-cache \
        bash \
        git \
        libpng-dev \
        libpq \
        libzip-dev \
        zip \
        unzip \
        autoconf \
        make \
        g++ \
    && docker-php-ext-install pdo_mysql bcmath gd zip \
    && pecl install xdebug-3.0.1 \
    && docker-php-ext-enable xdebug \
    && apk del --no-cache autoconf make g++

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /var/www


