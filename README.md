# Breeze

The mono repo for the breeze microservices.

## Services and Design Decisions

| Service            | Description                                                                                                                 | Tech                                     |
|--------------------|-----------------------------------------------------------------------------------------------------------------------------|------------------------------------------|
| API Gateway        | The API Gateway is the entry point for all clients.<br/> It is responsible for routing requests to the appropriate service. | [Laravel](https://laravel.com/)          | 
| Suggestion Service | The Suggestion Service is responsible for providing suggestions to the user.                                                | [Nest.js](https://nestjs.com/)           |
| Mobile             | The mobile app is responsible for providing a mobile interface to the user.                                                 | [React Native](https://reactnative.dev/) |

## Endpoints

| Service              | Endpoint Production                           | Endpoint Development | Port |
|----------------------|-----------------------------------------------|----------------------|------|
| API Gateway          | https://breeze-backend-api.vercel.app/        | https://localhost    | 8000 |
| Suggestion Service   | https://breeze-suggestion-service.vercel.app/ | https://localhost    | 8001 |
| Wallet Service       |                                               | https://localhost    | 8002 |
| Notification Service |                                               | https://localhost    | 8003 |

## Deployment 🚀

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

## Docker Setup

```sh
  docker-compose up -d // up all services
  docker-compose down // down all services
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
