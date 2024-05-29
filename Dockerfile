ARG PHP_VERSION=8.3
ARG FRANKENPHP_VERSION=latest

FROM dunglas/frankenphp:${FRANKENPHP_VERSION}-php${PHP_VERSION}-alpine

ARG TZ=UTC
ARG WORK_DIR=/var/www/html
ARG APP_PATH

ARG USER=breeze
ARG UID=1000
ARG GID=1000

ARG COMPOSER_VERSION=2.7.1

ENV USER=${USER} \
    UID=${UID} \
    GID=${GID} \
    WITH_HORIZON=false \
    WITH_SCHEDULER=false

ENV WORK_DIR=${WORK_DIR}
ENV APP_PATH=${APP_PATH}
ENV COMPOSER_VERSION=${COMPOSER_VERSION}


WORKDIR ${WORK_DIR}

RUN apk update; \
    apk upgrade; \
    apk add --no-cache  \
    bash \
    curl \
    supervisor \
    nodejs \
    npm  \
    libsodium-dev \
    librdkafka-dev \
    g++ \
    make \
    autoconf \
    && apk del autoconf g++ make  \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

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
    grpc \
  protobuf


RUN install-php-extensions @composer-${COMPOSER_VERSION}


RUN adduser -D -u $UID -G www-data ${USER}

USER $USER

COPY --chown=${USER}:${USER} ./packages/ ./packages/
COPY --chown=${USER}:${USER} ./composer.json ./composer.json
COPY --chown=${USER}:${USER} ./composer.lock ./composer.lock
COPY --chown=${USER}:${USER}  ${APP_PATH} ${APP_PATH}

# install deps in app path
RUN composer install --working-dir=${APP_PATH}

RUN chown -R $USER:www-data ${APP_PATH}/storage
RUN chown -R $USER:www-data ${APP_PATH}/bootstrap/cache

RUN chmod -R 775 ${APP_PATH}/storage
RUN chmod -R 775 ${APP_PATH}/bootstrap/cache

# copy devlopment node_modules deps
COPY --from=breezemm.com/bun:latest /temp/dev/node_modules /var/www/html/node_modules

# copy supervisord config
COPY --chown=${USER}:${USER} infra/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY --chown=${USER}:${USER} infra/supervisord/supervisord.*.conf /etc/supervisor/conf.d/
COPY --chown=${USER}:${USER} infra/start-container /usr/local/bin/start-container

RUN chmod +x /usr/local/bin/start-container


EXPOSE 8000
EXPOSE 443
EXPOSE 443/udp
EXPOSE 2019

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php ${APP_PATH}/artisan octane:status || exit 1
