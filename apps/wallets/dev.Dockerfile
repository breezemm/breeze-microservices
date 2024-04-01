FROM dunglas/frankenphp:alpine

ARG UID
ARG USER

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /usr/src/app

RUN adduser -D -u $UID -g '' $USER && \
    mkdir -p /home/$USER/.composer && \
    chown -R $USER:$USER /home/$USER


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

RUN install-php-extensions \
    redis \
    rdkafka \
    exif \
    pdo_mysql \
    zip \
    sockets \
    pcntl \
    opcache \
    mongodb \
    gd

RUN apk del autoconf g++ make && \
    rm -rf /tmp/* && \
    rm -rf /var/cache/apk/*

RUN npm install -g pnpm

COPY package*.json .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./apps/wallets .

RUN chown -R $USER:www-data storage
RUN chown -R $USER:www-data bootstrap/cache
RUN chmod -R 775 storage
RUN chmod -R 775 bootstrap/cache

COPY ./apps/wallets/docker/dev/start-container /usr/local/bin/start-container
COPY ./apps/wallets/docker/dev/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php artisan octane:status || exit 1
