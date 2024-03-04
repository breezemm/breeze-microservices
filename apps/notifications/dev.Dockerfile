FROM oven/bun:latest as base

WORKDIR /usr/src/app

FROM base AS install

RUN mkdir -p /temp/dev

COPY  bun.lockb /temp/dev/

COPY ./apps/notifications/package.json /temp/dev/package.json

RUN cd /temp/dev && bun install

FROM dunglas/frankenphp:alpine as dev

ARG uid
ARG user

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /usr/src/app

RUN adduser -D -u $uid -g '' $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN apk update && apk add --no-cache \
    libzip-dev \
    libxml2-dev \
    librdkafka-dev \
    supervisor \
    g++ \
    make \
    autoconf \
    nodejs \
    npm

RUN apk del autoconf g++ make && \
    rm -rf /tmp/* && \
    rm -rf /var/cache/apk/*

RUN install-php-extensions \
    redis \
    rdkafka \
    exif \
    pdo_mysql \
    zip \
    sockets \
    pcntl \
    opcache \
    mongodb

COPY --from=install /temp/dev/node_modules node_modules

COPY ./apps/notifications/docker/dev/octane.ini /usr/local/etc/php/octane.ini

COPY ./apps/notifications .

RUN chown -R $user:www-data storage
RUN chown -R $user:www-data bootstrap/cache

RUN chmod -R 775 storage
RUN chmod -R 775 bootstrap/cache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install

COPY ./apps/notifications/docker/dev/start-container /usr/local/bin/start-container

COPY ./apps/notifications/docker/dev/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chmod +x /usr/local/bin/start-container

EXPOSE 80
#EXPOSE 443
#EXPOSE 443/udp
#EXPOSE 2019

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php artisan octane:status || exit 1

