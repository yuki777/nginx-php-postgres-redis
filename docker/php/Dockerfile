FROM php:7.2-fpm-alpine

ENV PHPIZE_DEPS \
    autoconf \
    cmake \
    file \
    g++ \
    gcc \
    libc-dev \
    pcre-dev \
    make \
    git \
    pkgconf \
    re2c

RUN apk add --no-cache --virtual .persistent-deps \
    icu-dev \
    postgresql-dev

RUN set -xe \
    && docker-php-ext-configure bcmath --enable-bcmath \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-configure pdo_pgsql --with-pgsql \
    && docker-php-ext-configure mbstring --enable-mbstring \
    && docker-php-ext-install \
        bcmath \
        intl \
        pdo_pgsql

ENV PHPREDIS_VERSION 3.1.6
RUN apk update \
 && apk --no-cache upgrade \
 && docker-php-source extract \
 && curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/$PHPREDIS_VERSION.tar.gz \
 && tar xfz /tmp/redis.tar.gz -C /tmp \
 && rm -r /tmp/redis.tar.gz \
 && mv /tmp/phpredis-$PHPREDIS_VERSION /usr/src/php/ext/redis \
 && docker-php-ext-install redis
