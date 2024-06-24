FROM node:lts-alpine as node
FROM mmcyberyouths/php:v1.0-8.3-alpine

RUN install-php-extensions                                                                              \
        exif                                                                                            \
        sodium

COPY --from=node /usr/lib /usr/lib
COPY --from=node /usr/local/share /usr/local/share
COPY --from=node /usr/local/lib /usr/local/lib
COPY --from=node /usr/local/include /usr/local/include
COPY --from=node /usr/local/bin /usr/local/bin
COPY . .

RUN composer install
RUN npm install

ENTRYPOINT ["./start-container"]