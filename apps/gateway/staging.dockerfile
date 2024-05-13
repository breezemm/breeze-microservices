FROM mmcyberyouths/php:dev

RUN install-php-extensions                                                                           \
        exif                                                                                         \
        rdkafka redis
        
COPY . .

RUN composer install \
    --no-autoloader && \
    composer dump-autoload --optimize --no-scripts

ENTRYPOINT ["./start-container"]
