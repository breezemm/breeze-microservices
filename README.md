# Breeze

The monorepo for the breeze microservices.

## Prerequisites

Before you begin, ensure you have met the following requirements:

| Windows        | Linux  | MacOS    |
|----------------|--------|----------|
| Docker Desktop | Docker | Orbstack |

## Endpoints

| Service Name         | Production           | Endpoint Development | Port  |
|----------------------|----------------------|----------------------|-------|
| API Gateway          | https://breezemm.com | 127.0.0.1            | 8001  |
| Wallet Service       |                      | 127.0.0.1            | 8002  |
| Notification Service |                      | 127.0.0.1            | 8003  |
| MySQL Database       |                      | 127.0.0.1            | 3306  |
| ZooKeeper            |                      | 127.0.0.1            | 2181  |
| Kafka                |                      | 127.0.0.1            | 29092 |
| Mailpit SMTP         |                      | 127.0.0.1            | 1025  |
| Mailpit Dashboard    |                      | 127.0.0.1            | 8025  |
| Redis                |                      | 127.0.0.1            | 6379  |

## MySQL Database Credentials

| Name      | Value        |
|-----------|--------------|
| User Name | root         |
| Password  | Not Required |

### Databases according to services

| Service Name          | Database Name |
|-----------------------|---------------|
| Gateway Service       | gateway       |
| Wallets Service       | wallets       |
| Notifications Service | notifications |


