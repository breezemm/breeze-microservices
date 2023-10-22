FROM php:8.2-fpm-alpine

ARG user
ARG uid

RUN apk update && apk add --no-cache \
    libzip-dev \
    libxml2-dev \
    autoconf \
    g++ \
    make

RUN pecl install \
    apfd \
    redis

RUN docker-php-ext-install \
    exif \
    pdo_mysql

RUN docker-php-ext-enable \
    apfd \
    redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN adduser -D -u $uid -g '' $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /mcy/breeze/gateway

RUN apk del autoconf g++ make && \
    rm -rf /tmp/*

COPY laravel-setup.sh /setup.sh
RUN chmod +x /setup.sh
ENTRYPOINT ["/setup.sh"]

USER $user