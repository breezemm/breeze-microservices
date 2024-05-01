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

ARG COMPOSER_VERSION=2.7.1

ENV USER=${USER}
ENV UID=${UID}
ENV GID=${GID}

ENV WORK_DIR=${WORK_DIR}
ENV APP_PATH=${APP_PATH}
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
COPY --chown=${USER}:${USER}  ${APP_PATH} ${APP_PATH}

RUN composer install

# install deps in child apps
RUN composer install --working-dir=${APP_PATH}

RUN chown -R $USER:www-data ${APP_PATH}/storage
RUN chown -R $USER:www-data ${APP_PATH}/bootstrap/cache

RUN chmod -R 775 ${APP_PATH}/storage
RUN chmod -R 775 ${APP_PATH}/bootstrap/cache

# copy devlopment node_modules deps
COPY --from=breezemm.com/bun:latest /temp/dev/node_modules /var/www/html/node_modules

COPY --chown=${USER}:${USER} ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY --chown=${USER}:${USER} ./start-container /usr/local/bin/start-container

RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]

EXPOSE 8000
EXPOSE 443
EXPOSE 443/udp
EXPOSE 2019

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php ${APP_PATH}/artisan octane:status || exit 1
