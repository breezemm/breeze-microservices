FROM php:8.2-cli-alpine

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

# Install PHP Extensions installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN pecl install \
    redis \
    rdkafka

RUN docker-php-ext-install \
    exif \
    pdo_mysql \
    zip


RUN install-php-extensions sockets

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

RUN docker-php-ext-enable \
    redis \
    rdkafka

RUN apk del autoconf g++ make && \
    rm -rf /tmp/* && \
    rm -rf /var/cache/apk/*


RUN adduser -D -u $uid -g '' $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


COPY docker/dev/start-container /usr/local/bin/start-container
COPY docker/dev/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

ADD --chown=${NON_ROOT_USER}:${NON_ROOT_USER} https://github.com/dunglas/frankenphp/releases/download/v1.0.3/frankenphp-linux-x86_64 ./frankenphp

RUN chmod +x /usr/local/bin/start-container frankenphp

EXPOSE 80
EXPOSE 443
EXPOSE 443/udp
EXPOSE 2019

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php artisan octane:status || exit 1
