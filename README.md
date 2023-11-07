# Breeze

The monorepo for the breeze microservices.

## Services and Design Decisions

| Service              | Description                                                                                                                 | Tech                            |
|----------------------|-----------------------------------------------------------------------------------------------------------------------------|---------------------------------|
| API Gateway          | The API Gateway is the entry point for all clients.<br/> It is responsible for routing requests to the appropriate service. | [Laravel](https://laravel.com/) | 
| Suggestion Service   | The Suggestion Service is responsible for providing suggestions to the user.                                                | [Nest.js](https://nestjs.com/)  |
| Wallet Service       | The Wallet Service is responsible for managing user's wallet.                                                               | [Laravel](https://laravel.com/) |
| Notification Service | The Notification Service is responsible for managing user's notification.                                                   | [Laravel](https://laravel.com/) |

## Endpoints

| Service              | Endpoint Production                           | Endpoint Development | Port |
|----------------------|-----------------------------------------------|----------------------|------|
| API Gateway          | https://breeze-backend-api.vercel.app/        | http://172.16.100.10 | 80   |
| Wallet Service       |                                               | http://172.16.100.12 | 80   |
| Suggestion Service   | https://breeze-suggestion-service.vercel.app/ | http://172.16.100.13 | 80   |
| Notification Service |                                               | http://172.16.100.14 | 80   |

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

## Docker Setup

- Step 1 - Start database container

  ```sh
  docker-compose up --build {gateway,wallet}-mysql redis
  ```

- Step 2. Start APIs container
  ``` sh
  # To use gateway service *You must need to up nginx first*
  docker-compose up --build nginx

  # To start all APIs containers
  docker-compose up --build wallet gateway notification suggestion 
  ```

- To start kafka container
  ```sh
  docker-compose up --build kafka
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
