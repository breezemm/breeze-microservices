ARG APP_PATH

FROM node:lts-alpine as node
FROM mmcyberyouths/php:v1.0-8.3-alpine

COPY --from=node /usr/lib /usr/lib
COPY --from=node /usr/local/share /usr/local/share
COPY --from=node /usr/local/lib /usr/local/lib
COPY --from=node /usr/local/include /usr/local/include
COPY --from=node /usr/local/bin /usr/local/bin

COPY infra/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY infra/supervisord/supervisord.*.conf /etc/supervisor/conf.d/
COPY infra/start-container /usr/local/bin/start-container

COPY ./packages/ ./packages/
COPY ./composer.json ./composer.json
COPY ./composer.lock ./composer.lock
COPY  ${APP_PATH} ${APP_PATH}

RUN install-php-extensions                                                                              \
        exif                                                                                            \
        sodium

RUN composer install --working-dir=${APP_PATH}
RUN npm install --prefix ${APP_PATH}

RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]
