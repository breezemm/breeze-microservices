FROM php:8.1-cli-alpine

ARG uid
ARG user

WORKDIR /var/www/gateway

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk update && apk add --no-cache \
    libzip-dev \
    libxml2-dev \
    librdkafka-dev \
    supervisor \
    g++ \
    make \
    autoconf

RUN pecl install \
    redis \
    rdkafka

RUN docker-php-ext-install \
    exif \
    pcntl \
    sockets \
    pdo_mysql

RUN docker-php-ext-enable \
    redis \
    rdkafka

RUN apk del autoconf g++ make && \
    rm -rf /tmp/* && \
    rm -rf /var/cache/apk/*

RUN set -x ; \
    addgroup -g $uid -S $user ; \
    adduser -u $uid -D -S -G $user $user && exit 0 ; exit 1

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY docker/dev/start-container /usr/local/bin/start-container
COPY docker/dev/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]