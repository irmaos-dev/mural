FROM composer/composer:2 as composer
FROM node:20 as node
FROM ubuntu:noble as base

FROM composer AS builder-laravel
WORKDIR /build

COPY ./server/ .
RUN composer install --ignore-platform-reqs
RUN mv .env.example .env

FROM node as builder-node
WORKDIR /build

COPY ./client/ .
RUN npm install --force --log=debug
RUN npm run build

FROM base as web
WORKDIR /var/www

RUN apt update && \
    echo Y | apt install software-properties-common

RUN echo Y | apt install php8.3  \
    php8.3-fpm \
    php8.3-ctype  \
    php8.3-curl  \
    php8.3-dom  \
    php8.3-fileinfo  \
    php8.3-mbstring  \
    php8.3-pdo  \
    php8.3-tokenizer  \
    php8.3-xml  \
    php8.3-fpm  \
    php8.3-pgsql \
    php8.3-intl

RUN echo Y | apt remove apache2* --purge
RUN echo Y | apt install nginx

COPY ./docs/docker/nginx/nginx-docker.conf /etc/nginx/sites-enabled/default
COPY --from=builder-node --chown=www-data:www-data --chmod=755 /build/dist /var/www/client
COPY --from=builder-laravel --chown=www-data:www-data --chmod=755 /build /var/www/server

WORKDIR /var/www/server

EXPOSE 80
EXPOSE 443

CMD php artisan migrate && \
    php-fpm8.3 &&  \
    nginx -g "daemon on;" \
    && tail -f /var/log/nginx/access.log | tee /var/log/nginx/access.log