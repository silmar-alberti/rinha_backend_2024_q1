FROM php:8.3-fpm-alpine as base

WORKDIR /application

ENV TZ=UTC

RUN apk add --no-cache --virtual postgresql-dev libpq-dev; \
    docker-php-ext-install opcache pdo pdo_pgsql

FROM base as dev

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apk add --no-cache linux-headers $PHPIZE_DEPS; \
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
    mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY ./docker/php/opcache-dev.ini /usr/local/etc/php/conf.d/z-opcache.ini
COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/z-xdebug.ini


FROM composer as builder

COPY . /application
WORKDIR /application

RUN composer install --no-dev --no-scripts --ignore-platform-reqs

FROM base as prod 

WORKDIR /application

COPY  . /application/
COPY  --from=builder /application/vendor /application/vendor

RUN  mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" ; \
    /application/bin/console cache:warmup
