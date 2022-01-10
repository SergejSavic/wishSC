FROM composer:2.1.3 as vendor

ARG SSH_KEY
ENV DISPLAY 0
ENV COMPOSER_ALLOW_SUPERUSER 1

COPY database/ database/

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN eval `ssh-agent -s` && \
    mkdir -p /root/.ssh && \
    chmod 0700 /root/.ssh && \
    ssh-keyscan github.com > /root/.ssh/known_hosts && \
    ssh-keyscan gitlab.com >> /root/.ssh/known_hosts && \
    echo "${SSH_KEY}" > /root/.ssh/id_rsa && \
    chmod 600 /root/.ssh/id_rsa && \
    eval "$(ssh-add ~/.ssh/id_rsa)"

RUN  composer install \
        --no-ansi \
        --no-dev \
        --no-scripts \
        --ignore-platform-reqs \
        --no-interaction

FROM node:12.8.1-slim as frontend

RUN mkdir -p /app/public
RUN mkdir -p /app/public/sendcloud/js
RUN mkdir -p /app/public/sendcloud/css

COPY package.json webpack.mix.js yarn.lock /app/
COPY resources/ /app/resources/

WORKDIR /app

RUN yarn install && yarn production

FROM php:8.0.8-fpm-buster

RUN apt-get update && apt-get install -y \
        cron \
        git \
        libzip-dev \
        libaspell-dev \
        libbz2-dev \
        libcurl4-gnutls-dev \
        libexpat1-dev \
        libfreetype6-dev \
        libgmp3-dev \
        libicu-dev \
        libjpeg-dev \
        libldap2-dev \
        libmcrypt-dev \
        libpcre3-dev \
        libpng-dev \
        libpq-dev \
        libsnmp-dev \
        libsqlite3-dev \
        libssl-dev \
        libtidy-dev \
        libvpx-dev \
        libxml2-dev \
        libxpm-dev \
        libjpeg62-turbo-dev \
    && docker-php-ext-install -j$(nproc) intl zip bz2 mysqli pdo_mysql \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

COPY ./.docker/php.ini /usr/local/etc/php

COPY . /var/www

COPY --from=vendor /app/vendor /var/www/vendor
COPY --from=frontend /app/public/sendcloud/js /var/www/public/sendcloud/js
COPY --from=frontend /app/public/sendcloud/css /var/www/public/sendcloud/css
COPY --from=frontend /app/mix-manifest.json /var/www/mix-manifest.json

RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache

COPY ./entrypoint.sh /usr/local/bin/


RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/

EXPOSE 9000

CMD ["./entrypoint.sh"]
