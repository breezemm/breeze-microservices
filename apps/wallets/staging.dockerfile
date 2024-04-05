FROM breeze/php:latest as builder

WORKDIR /var/www/wallets

COPY composer.json .
COPY composer.lock .

RUN composer install \
    --no-autoloader && \
    composer dump-autoload --optimize --no-scripts


FROM breeze/php:latest

WORKDIR /var/www/wallets

COPY . .
COPY --from=builder /var/www/wallets/vendor ./vendor
COPY docker/staging.supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start-container /usr/local/bin/start-container

RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]