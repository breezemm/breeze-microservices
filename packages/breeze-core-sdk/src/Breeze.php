<?php

namespace MyanmarCyberYouths\Breeze;

use MyanmarCyberYouths\Breeze\Connectors\Auth\AuthConnector;

class Breeze
{

    public function auth(): AuthConnector
    {
        return app(AuthConnector::class);
    }


}
