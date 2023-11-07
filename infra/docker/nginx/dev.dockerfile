FROM nginx:alpine

ARG uid
ARG user

WORKDIR /var/www

COPY nginx.conf /etc/nginx/

RUN set -x ; \
    addgroup -g $uid -S $user ; \
    adduser -u $uid -D -S -G $user $user && exit 0 ; exit 1

RUN rm /etc/nginx/conf.d/default.conf

ADD start.sh /usr/local/bin/start-container
RUN sed -i 's/\r//g' /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]