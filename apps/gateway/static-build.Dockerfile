FROM --platform=linux/amd64 dunglas/frankenphp:static-builder-alpine

# Copy your app
WORKDIR /go/src/app/dist/app
COPY . .

# Build the static binary, be sure to select only the PHP extensions you want
WORKDIR /go/src/app/
RUN EMBED=dist/app/ \
    PHP_EXTENSIONS=ctype,iconv,pdo_sqlite,gd,zip,sockets,pdo_mysql,pcntl,rdkafka,redis,opcache \
    ./build-static.sh

