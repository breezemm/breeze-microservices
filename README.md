# Breeze

The monorepo for the breeze microservices.

## Services and Design Decisions

| Service              | Description                                                                                                                 | Tech                            |
|----------------------|-----------------------------------------------------------------------------------------------------------------------------|---------------------------------|
| API Gateway          | The API Gateway is the entry point for all clients.<br/> It is responsible for routing requests to the appropriate service. | [Laravel](https://laravel.com/) |
| Suggestion Service   | The Suggestion Service is responsible for providing suggestions to the user.                                                | [Nest.js](https://nestjs.com/)  |
| Wallet Service       | The Wallet Service is responsible for managing user's wallet.                                                               | [Laravel](https://laravel.com/) |
| Notification Service | The Notification Service is responsible for managing user's notification.                                                   | [Nest.js](https://nestjs.com/)  |

## Endpoints

| Service              | Endpoint Production                           | Endpoint Development | Port  |
|----------------------|-----------------------------------------------|----------------------|-------|
| API Gateway          | https://breeze-backend-api.vercel.app/        | http://0.0.0.0       | 8001  |
| Wallet Service       |                                               | http://0.0.0.0       | 8002  |
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

| Database      | Username | Password | Host      |
|---------------|----------|----------|-----------|
| Gateway MySQL | root     | password | 127.0.0.1 |
| Wallet MySQL  | root     | password | 127.0.0.1 |

## Development

## Pre-requisites

- Docker Desktop (for Windows and Linux)
- Orbstack (for Mac)
