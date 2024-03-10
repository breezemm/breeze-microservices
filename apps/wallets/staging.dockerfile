FROM composer:lts as composer_builder

WORKDIR /var/www/wallets

COPY composer.json .
COPY composer.lock .

RUN composer install \
    --no-autoloader \
    --ignore-platform-reqs && \
    composer dump-autoload --optimize --no-scripts


FROM breeze/php:latest

WORKDIR /var/www/wallets

COPY . .
COPY --from=composer_builder /var/www/wallets/vendor ./vendor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start-container /usr/local/bin/start-container

RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]
