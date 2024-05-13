<?php

namespace MyanmarCyberYouths\RedisPubSub\Concerns;


use Prwnr\Streamer\Contracts\Event;
use Prwnr\Streamer\Facades\Streamer;


trait Dispatchable
{

    public string $channel = 'default';

    public string $className = __CLASS__;


    /**
     * Dispatch the event to the redis pub/sub
     *
     * @param mixed ...$args
     * @return int
     */
    public static function dispatch(...$args): int
    {
        $event = type(new static(...$args))->as(Event::class);

        return (int)Streamer::emit($event);
    }

    /**
     * Dispatch the event with the given arguments if the given truth test passes.
     *
     * @param bool $boolean
     * @param mixed ...$arguments
     * @return int
     */
    public static function dispatchIf(bool $boolean, ...$arguments): int
    {
        $event = type(new static(...$arguments))->as(Event::class);
        return value($boolean) ? Streamer::emit($event) : 0;
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
