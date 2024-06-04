FROM mmcyberyouths/php:v1.0-8.3-alpine

RUN install-php-extensions                                                                              \
        exif                                                                                            \
        sodium

RUN composer install

ENTRYPOINT ["./start-container"]
