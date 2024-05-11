<?php

namespace MyanmarCyberYouths\RedisPubSub\Contracts;

use Prwnr\Streamer\Contracts\Event as StreamerEvent;

interface Event extends StreamerEvent
{
    public function publishOn(): string;
}
