<?php

namespace MyanmarCyberYouths\RedisPubSub\Concerns;


use Prwnr\Streamer\Contracts\Event;
use Prwnr\Streamer\Facades\Streamer;

trait Dispatchable
{

    public string $channel = 'default';

    public string $className = __CLASS__;

    public static function dispatch(...$args): int
    {
        $event = type(new self(...$args))->as(Event::class);
        return (int)Streamer::emit($event);
    }

    public static function dispatchIf(bool $condition, ...$args): int
    {
        $event = type(new self(...$args))->as(Event::class);
        return $condition ? (int)Streamer::emit($event) : 0;
    }

    public function name(): string
    {
        if (method_exists($this, 'publishOn')) {
            return $this->publishOn();
        }

        return $this->channel;
    }

    public function type(): string
    {

        return 'event';
    }

}
