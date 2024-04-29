FROM dunglas/frankenphp:alpine
LABEL authors="aungmyatmoe"

WORKDIR /usr/src/app

RUN apk add nodejs npm

COPY --from=breezemm.com/bun:latest /temp/dev/node_modules ./node_modules/
COPY ./apps/auth .

