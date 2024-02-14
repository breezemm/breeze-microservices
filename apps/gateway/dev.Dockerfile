FROM dunglas/frankenphp:alpine

ARG uid
ARG user

ENV PNPM_HOME="/pnpm"
ENV PATH="$PNPM_HOME:$PATH"

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN adduser -D -u $uid -g '' $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


WORKDIR /var/www/gateway



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


RUN npm install pnpm --global


RUN apk del autoconf g++ make && \
    rm -rf /tmp/* && \
    rm -rf /var/cache/apk/*

RUN install-php-extensions \
    redis \
    rdkafka \
    exif \
    pdo_mysql \
    zip \
    sockets \
    pcntl \
    opcache \
    mongodb


COPY ./apps/gateway/docker/dev/octane.ini /usr/local/etc/php/octane.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./apps/gateway .

RUN --mount=type=cache,id=pnpm,target=/pnpm/store pnpm install --frozen-lockfile


RUN composer install


COPY ./apps/gateway/docker/dev/start-container /usr/local/bin/start-container

COPY ./apps/gateway/docker/dev/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chmod +x /usr/local/bin/start-container


EXPOSE 80
#EXPOSE 443
#EXPOSE 443/udp
#EXPOSE 2019

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php artisan octane:status || exit 1

VOLUME /var/www/gateway
