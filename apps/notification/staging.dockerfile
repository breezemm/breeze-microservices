FROM composer:lts as composer_build

WORKDIR /var/www/notification

COPY composer.json .
COPY composer.lock .

RUN composer install \
    --ignore-platform-reqs \
    --no-autoloader

COPY . .
RUN composer dump-autoload --optimize


FROM dunglas/frankenphp:1.1-php8.3-alpine

WORKDIR /var/www/notification

ARG UID
ARG USER

RUN adduser -D -u $UID -g '' $USER && \
    mkdir -p /home/$USER && \
    chown -R $USER:$USER /home/$USER

RUN apk add --update --no-cache --virtual .persistent-deps \
    supervisor

RUN install-php-extensions \
    pdo_mysql \
    redis \
    zip \
    pcntl \
    rdkafka \
    exif \
    bz2

COPY --chown=${USER}:${USER} . .
COPY --chown=${USER}:${USER} --from=composer_build /var/www/notification/vendor ./vendor

COPY docker/start-container /usr/local/bin/start-container
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY docker/config/octane.ini /usr/local/etc/php/conf.d/

RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]