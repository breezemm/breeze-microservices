# Laravel Redis Pub-Sub

Pub-Sub Protocol for service to service communication in laravel.

## Installation

You can install the package via composer:

```bash
composer require myanmarcyberyouths/laravel-redis-pub-sub
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-redis-pub-sub-config"
```

## Usage

You will need to implement the `Event` interface and use the `Dispatchable` and `SerializesEvents` traits in your event
class. This will allow you to dispatch the event and serialize the event.

You will need to specify the channel name in the `publishOn` method. This will be the channel that the event will be
published to.

```php
<?php

namespace MyanmarCyberYouths\Common\Events;
use MyanmarCyberYouths\RedisPubSub\Contracts\Event;
use MyanmarCyberYouths\RedisPubSub\Concerns\Dispatchable;
use MyanmarCyberYouths\RedisPubSub\Concerns\SerializesEvents;

class UserCreated implements Event
{
    use Dispatchable, SerializesEvents;

    public function __construct(
        public readonly User $user,
    )
    {
    }

    public function publishOn(): string
    {
        return 'user.created';
    }
}
```

## Dispatching Event

You can dispatch the event by using the `dispatch` method on the event class. This will dispatch the event to the
specified channel.

```php
 $user = new User(name: 'Jame');

// Dispatch the event
$id = UserCreated::dispatch($user);

```

## Listening to Event

You need to register the event in the `listen_and_fire` array in the `config/streamer.php` configuration file. This will
allow you to listen to the event and fire the local handlers.

```php
<?php


return [

   
    /*
    |--------------------------------------------------------------------------
    | Application handlers
    |--------------------------------------------------------------------------
    |
    | Handlers classes that should be invoked with Streamer listen command
    | based on streamer.event.name => [local_handlers] pairs
    |
    | Local handlers should implement MessageReceiver contract
    |
    */
    'listen_and_fire' => [
        'user.created' => [
            \App\Listeners\CreateNewUser::class,
        ],
    ],
```

And then you need to implement the `ShouldListen` interface and use the `Listener` trait in your listener class. This
will
allow you to listen to the event.

```php
<?php

namespace App\Listeners;

use MyanmarCyberYouths\RedisPubSub\Contracts\ShouldListen;
use MyanmarCyberYouths\RedisPubSub\Concerns\Listener;


class CreateNewUser implements ShouldListen
{
    use Listener;

    public function listen(UserCreated $event): void
    {
        dump("Username is {$event->user->name}");
    }
}
```

## Listening Events

You can listen to the events by using the `streamer:listen` command. This will listen to the events and fire the local
handlers.

```bash
php artisan streamer:listen --all
```

You can use `streamer:watch` in development mode to listen to the events and fire the local handlers.

```bash
php artisan streamer:watch 
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
