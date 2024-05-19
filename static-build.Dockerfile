FROM --platform=linux/arm64 dunglas/frankenphp:static-builder


RUN apk add --no-cache  \
    supervisor \
    nodejs \
    npm  \
    libzip-dev \
    libxml2-dev \
    librdkafka-dev \
    g++ \
    make \
    autoconf \
    && apk del autoconf g++ make  \
    && rm -rf /tmp/*  \
    && rm -rf /var/cache/apk/*


# Copy your app
WORKDIR /go/src/app/dist/app
COPY ./apps/auth .

# Remove the tests and other unneeded files to save space
# Alternatively, add these files to a .dockerignore file
RUN rm -Rf tests/

# Change APP_ENV and APP_DEBUG to be production ready
#RUN sed -i'' -e 's/^APP_ENV=.*/APP_ENV=production/' -e 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env

# Make other changes to your .env file if needed

# Install the dependencies
RUN composer install --ignore-platform-reqs --no-dev -a

# Build the static binary
WORKDIR /go/src/app/
RUN EMBED=dist/app/ \
    PHP_EXTENSIONS=redis,rdkafka,exif,pdo_mysql,zip,sockets,pcntl,opcache,mongodb,gd,opcache,intl,bcmath \
     ./build-static.sh
