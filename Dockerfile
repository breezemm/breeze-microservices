ARG PHP_VERSION=8.3
ARG FRANKENPHP_VERSION=latest

FROM dunglas/frankenphp:${FRANKENPHP_VERSION}-php${PHP_VERSION}-alpine
ARG COMPOSER_VERSION=latest
ARG TZ=UTC
ARG APP_PATH

ARG USER=breeze
ARG UID=1000
ARG GID=1000

ENV APP_NAME=${APP_PATH}

WORKDIR /var/www/html

RUN apk add --no-cache  \
    libzip-dev \
    libxml2-dev \
    librdkafka-dev \
    supervisor \
    g++ \
    make \
    autoconf \
    nodejs \
    npm  \
    && apk del autoconf g++ make  \
    && rm -rf /tmp/*  \
    && rm -rf /var/cache/apk/*

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
    gd \
    opcache \
    intl \
    bcmath

RUN install-php-extensions @composer

RUN adduser -D -u $UID -G www-data ${USER}

USER $USER

COPY  --chown=${USER}:${USER} ./packages/ ./packages/
COPY --chown=${USER}:${USER} ./composer.json ./composer.json
COPY --chown=${USER}:${USER} ./composer.lock ./composer.lock
COPY --chown=${USER}:${USER}  ${APP_NAME} ${APP_NAME}

RUN composer install

RUN vendor/bin/mono run composer install


RUN chown -R $USER:www-data ${APP_NAME}/storage
RUN chown -R $USER:www-data ${APP_NAME}/bootstrap/cache

RUN chmod -R 775 ${APP_NAME}/storage
RUN chmod -R 775 ${APP_NAME}/bootstrap/cache

COPY --from=breezemm.com/bun:latest /temp/dev/node_modules /var/www/html/node_modules


ENTRYPOINT php $APP_NAME/artisan octane:start --server=frankenphp --host=0.0.0.0 --port=80 --admin-port=2019 --watch



