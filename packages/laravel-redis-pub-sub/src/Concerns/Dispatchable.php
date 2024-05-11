<?php

namespace MyanmarCyberYouths\RedisPubSub\Concerns;


use Prwnr\Streamer\Facades\Streamer;

trait Dispatchable
{

    public string $channel = 'default';

    public string $className = __CLASS__;

    public static function dispatch(...$args): int
    {
        return (int)Streamer::emit(new self(...$args));
    }

    public static function dispatchIf(bool $condition, ...$args): int
    {
        return $condition ? (int)Streamer::emit(new self(...$args)) : 0;
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
