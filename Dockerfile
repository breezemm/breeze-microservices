ARG PHP_VERSION=8.3
ARG FRANKENPHP_VERSION=latest

FROM dunglas/frankenphp:${FRANKENPHP_VERSION}-php${PHP_VERSION}-alpine

ARG S6_OVERLAY_VERSION="3.1.5.0"
ARG S6_OVERLAY_ARCH="x86_64"

ARG TZ=UTC
ARG WORK_DIR=/var/www/html
ARG APP_PATH

ARG USER=breeze
ARG UID=1000
ARG GID=1000

ARG COMPOSER_VERSION= 2.7.1

ENV USER=${USER}
ENV UID=${UID}
ENV GID=${GID}

ENV WORK_DIR=${WORK_DIR}
ENV APP_DIR=${APP_PATH}
ENV COMPOSER_VERSION=${COMPOSER_VERSION}


WORKDIR ${WORK_DIR}

RUN apk add --no-cache  \
    supervisor \
    nodejs \
    npm  \
    libzip-dev \
    libxml2-dev \
    librdkafka-dev \
    g++ \
    make \
    autoconf \
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


RUN install-php-extensions @composer-${COMPOSER_VERSION}

RUN adduser -D -u $UID -G www-data ${USER}

USER $USER

COPY  --chown=${USER}:${USER} ./packages/ ./packages/
COPY --chown=${USER}:${USER} ./composer.json ./composer.json
COPY --chown=${USER}:${USER} ./composer.lock ./composer.lock
COPY --chown=${USER}:${USER}  ${APP_DIR} ${APP_DIR}

RUN composer install

# install deps in child apps
RUN composer install --working-dir=${APP_DIR}

RUN chown -R $USER:www-data ${APP_DIR}/storage
RUN chown -R $USER:www-data ${APP_DIR}/bootstrap/cache

RUN chmod -R 775 ${APP_DIR}/storage
RUN chmod -R 775 ${APP_DIR}/bootstrap/cache

# copy devlopment node_modules deps
COPY --from=breezemm.com/bun:latest /temp/dev/node_modules /var/www/html/node_modules

# TODO: change to the start-container script
ENTRYPOINT php ${APP_DIR}/artisan octane:start --server=frankenphp --host=0.0.0.0 --port=80 --admin-port=2019 --watch

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php ${APP_DIR}/artisan octane:status || exit 1
