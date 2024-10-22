# API Gateway

This is the API Gateway for the application. It will handle all the requests and forward them to the appropriate
microservice.
Current architecture is Domain Driven Design (DDD) without having CQRS and Event Sourcing.

## Setup

### With Docker

```bash
docker-compose build
docker exec breeze_app composer setup
```

#### Exposing the ports

```bash
sudo php artisan serve --host 192.168.1.4 --port 80
sudo php artisan serve --host 0.0.0.0  --port 80
```

### Without Docker

#### PHP Server Setup

We will need to install `apfd` to handle form data in `PUT` and `PATCH` method.

```bash
pecl channel-update pecl.php.net
pecl install apfd
```

Add the following extension to the `php.ini`

```bash
extension=apfd.so
```

#### Install Composer

We are using passport and currently it have some conflicts with other packages. So we will need to install it separately
like following.

```bash
composer require laravel/passport --with-all-dependencies
composer setup # This will setup the application
```

## Deployment

We are using Vercel serverless function so that we can deploy it easily. We will need to add the following configuration
to
forward all the requests to the `index.php` file.

### Overriding Default Rewrites

-   `/(.*)` forward to `/`
-   `/api/(.*)` forward to `/api`

```json
{
    "routes": [
        {
            "src": "/(.*)",
            "dest": "/api/index.php"
        },
        {
            "src": "/api/(.*)",
            "dest": "/api/index.php"
        }
    ]
}
```

```ts
interface User {
    name: string
    email: string
}

interface Interest {
    name: string
}

interface Ticket {
    name: string
    description: string
    hasSeat: boolean
    price: number
}

interface TickWithSeat extends Ticket {
    seat: number
}

interface Phase {
    name: string
    startDate: Date
    endDate: Date
    tickets: Array<Ticket | TickWithSeat>
}

interface Event {
    name: string
    day: string
    month: string
    year: string
    place: string
    organizers: User[]
    image: string
    description: string
    interests: Interest[]
    phases: Phase[]
    isHasPhases: boolean
}

export const event: Event = {
    name: 'Startup Weekend Yangon',
    start_date: '2023-12-10',
    start_time: '09:30', // HH:MM in 24 hours format
    end_date: '2023-12-12', // YYYY-MM-DD
    end_time: '15:00',
    place: 'Yangon',
    co_organizers: [1, 2, 3],
    description: 'Accerlating tech startup come and join with us',
    image: 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
    is_has_phases: true, // if isHasPhases is true, phases will be greater than 1
    interests: [1, 2, 3],
    phases: [
        {
            name: 'Regular',
            start_date: '2023-12-10',
            end_date: '2023-12-12',

            tickets: [
                {
                    name: 'Normal',
                    information: 'Normal ticket',
                    price: 0,
                    is_has_seating_plan: false,
                    total_seats: 0,
                },
            ],
        },
    ],
}
```

# Event Naming Convention

The payload schema is the must follow to communicate between services. The following is the naming convention for the
event.

```json
{
    "id": "68950cb0-397b-43b3-bf03-9c5f8aa619fa",
    "topic": "wallet.create",
    "pattern": {
        "cmd": "wallet.create"
    },
    "data": {
        "name": "Wallet",
        "description": "Wallet for the user",
        "user_id": "68950cb0-397b-43b3-bf03-9c5f8aa619fa",
        "currency": "USD",
        "balance": 0,
        "is_active": true
    }
}
```

| Property | Description                                                                                                                      |
| -------- | -------------------------------------------------------------------------------------------------------------------------------- |
| id       | The unique id for the event                                                                                                      |
| topic    | The event name for the kafka topic                                                                                               |
| pattern  | The command name for the event that will be used in the RabbitMQ or Redis when we have to communicate to the NestJS microservice |
| data     | The payload for the event                                                                                                        |

## Constraints

| Property | Description         |
| -------- | ------------------- |
| id       | 64 bit UUID         |
| topic    | service_name.action |
| pattern  | service_name.action |
| data     | JSON                |


# Minio

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "admin:*"
            ]
        },
        {
            "Effect": "Allow",
            "Action": [
                "kms:*"
            ]
        },
        {
            "Effect": "Allow",
            "Action": [
                "s3:*"
            ],
            "Resource": [
                "arn:aws:s3:::*"
            ]
        }
    ]
}
```
