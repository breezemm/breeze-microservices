ARG PHP_VERSION=8.3
ARG FRANKENPHP_VERSION=latest
ARG COMPOSER_VERSION=latest

FROM dunglas/frankenphp:${FRANKENPHP_VERSION}-php${PHP_VERSION}-alpine

ARG TZ=UTC
ARG APP_NAME

ARG USER=breeze
ARG UID=1000
ARG GID=1000
ENV APP_NAME=${APP_NAME}

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
    bcmath \
    @composer-${COMPOSER_VERSION}

RUN adduser -D -u $UID -G www-data ${USER}

USER $USER

COPY --chown=${USER}:${USER}  ${APP_NAME} ${APP_NAME}
COPY  --chown=${USER}:${USER} ./packages/ ./packages/
COPY --chown=${USER}:${USER} ./composer.json ./composer.json
COPY --chown=${USER}:${USER} ./composer.lock ./composer.lock

RUN chown -R $USER:www-data ${APP_NAME}/storage
RUN chown -R $USER:www-data ${APP_NAME}/bootstrap/cache

RUN chmod -R 775 ${APP_NAME}/storage
RUN chmod -R 775 ${APP_NAME}/bootstrap/cache

RUN composer install

RUN ./vendor/bin/mono run composer install

ENTRYPOINT ["php", "apps/auth/artisan", "octane:frankenphp"]



