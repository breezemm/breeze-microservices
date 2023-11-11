# Breeze

The monorepo for the breeze microservices.

## Services and Design Decisions

| Service              | Description                                                                                                                 | Tech                            |
|----------------------|-----------------------------------------------------------------------------------------------------------------------------|---------------------------------|
| API Gateway          | The API Gateway is the entry point for all clients.<br/> It is responsible for routing requests to the appropriate service. | [Laravel](https://laravel.com/) | 
| Suggestion Service   | The Suggestion Service is responsible for providing suggestions to the user.                                                | [Nest.js](https://nestjs.com/) |
| Wallet Service       | The Wallet Service is responsible for managing user's wallet.                                                               | [Laravel](https://laravel.com/) |
| Notification Service | The Notification Service is responsible for managing user's notification.                                                   | [Nest.js](https://nestjs.com/) |

## Endpoints

| Service              | Endpoint Production                           | Endpoint Development | Port  |
|----------------------|-----------------------------------------------|----------------------|-------|
| API Gateway          | https://breeze-backend-api.vercel.app/        | http://localhost     | 8001  |
| Wallet Service       |                                               | http://localhost     | 8002  |
| Suggestion Service   | https://breeze-suggestion-service.vercel.app/ | http://localhost     | 8003  |
| Notification Service |                                               | http://localhost     | 8004  |
| ZooKeeper            |                                               | http://localhost     | 2181  |
| Kafka                |                                               | http://localhost     | 29092 |
| Schema Registry      |                                               | http://localhost     | 8089  |
| Kafka Manager        |                                               | http://localhost     | 10000 |
| Mailpit SMTP         |                                               | http://localhost     | 1025  |
| Mailpit Dashboard    |                                               | http://localhost     | 8025  |
| Redis                |                                               | http://localhost     | 6379  |
| Gateway MySQL        |                                               | http://localhost     | 33061 |
| Wallet MySQL         |                                               | http://localhost     | 33062 |

## Credentials for Development

| Service       | Username | Password | Host      |
|---------------|----------|----------|-----------|
| Gateway MySQL | admin    | admin    | 127.0.0.1 |
| Wallet MySQL  | admin    | admin    | 127.0.0.1 |

## Development

## Pre-requisites

We use docker for development. So you need to install docker and docker-compose in your machine.
After installing docker and docker-compose, you need to run the following command to start all services.

```bash
bash scripts/start.sh # start all services
bash scripts/stop.sh # stop all services
```

## Deployment on Vercel 🚀

### Git Setup in Vercel

We have to ignore build step in Vercel in terms of deployment. So we have to setup git in vercel.

`Settings` -> `Git` -> `Ignored Build Step`  and add the following command.

```sh
git diff HEAD^ HEAD --quiet ./
```

# Run SuperVisor

```sh
brew services start supervisor
```

# Laravel with MongoDB in Mac

## Install MongoDB

```sh
brew install icu4c #install unicode library
brew link icu4c --force
```

## Install PHP MongoDB Driver

```sh
export PATH="/usr/local/opt/icu4c/bin:$PATH"
export PATH="/usr/local/opt/icu4c/sbin:$PATH"
export LDFLAGS="-L/usr/local/opt/icu4c/lib"
export CPPFLAGS="-I/usr/local/opt/icu4c/include"

sudo pecl install mongodb
```

## Add extension to php.ini

Add the following lines to your php.ini file

```ini
extension = rdkafka.so
extension = mongodb.so
```

# FAQs

```sh
-----
 > [gateway internal] load metadata for docker.io/library/php:8.1-cli-alpine:
------
failed to solve: php:8.1-cli-alpine: failed to authorize: failed to fetch oauth token: Post "https://auth.docker.io/token": EOF
```


```sh
- https://github.com/docker/for-mac/issues/3785
