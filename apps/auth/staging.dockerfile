FROM mmcyberyouths/php:dev

RUN install-php-extensions                                                                           \
        exif

COPY . .

RUN composer install \
    --no-autoloader && \
    composer dump-autoload --optimize --no-scripts

ENTRYPOINT ["./start-container"]
