FROM dunglas/frankenphp:1.1-php8.3-alpine as base

WORKDIR /application

ENV TZ=UTC

RUN apk add --no-cache --virtual postgresql-dev libpq-dev; \
    install-php-extensions opcache pdo pdo_pgsql

COPY ./docker/Caddy/Caddyfile /etc/Caddyfile

CMD [ "frankenphp", "run", "--config", "/etc/Caddyfile" ]

FROM base as dev

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN    mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

FROM composer as builder

COPY . /application
WORKDIR /application

ENV APP_ENV=prod APP_DEBUG=0

RUN set -eux; \
    composer install --no-dev --ignore-platform-reqs; \
    APP_ENV=prod APP_DEBUG=0 composer dump-autoload --classmap-authoritative --no-dev;

FROM base as prod 

WORKDIR /application

COPY  . /application/
COPY --link docker/php/app.prod.ini $PHP_INI_DIR/conf.d/
COPY  --link --from=builder /application/vendor /application/vendor

ENV APP_ENV=prod APP_DEBUG=0

RUN set -eux; \
	mkdir -p var/cache var/log; \
	chmod +x bin/console; sync; \
    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" ; \
     /application/bin/console cache:clear ; \
    /application/bin/console cache:warmup
