<?php

namespace App\Http\Integrations\Wallet;

use Ackintosh\Ganesha\Builder;
use Ackintosh\Ganesha\GuzzleMiddleware;
use Ackintosh\Ganesha\Storage\Adapter\Redis as GeishaRedis;
use App\Http\Integrations\Wallet\Resources\PaymentResource;
use App\Http\Integrations\Wallet\Resources\WalletResource;
use Predis\Client;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class WalletAPI extends Connector
{
    use AcceptsJson;

    public ?int $tries = 3;

    public ?int $retryInterval = 500;

    public ?bool $useExponentialBackoff = true;

    public function __construct()
    {
        //        ->adapter(new GeishaRedis(Redis::connection()->client()))

        $circuitBreakerBuilder = Builder::withRateStrategy()
            ->timeWindow(30)
            ->failureRateThreshold(50)
            ->adapter(new GeishaRedis(new Client([
                'scheme' => 'tcp',
                'host' => 'redis',
                'port' => 6379,
            ])))
            ->minimumRequests(10)
            ->intervalToHalfOpen(5)
            ->build();

        $circuitBreakerMiddleware = new GuzzleMiddleware($circuitBreakerBuilder);
        $handlerStack = $this->sender()->getHandlerStack();
        $handlerStack->push($circuitBreakerMiddleware);
    }

    public function resolveBaseUrl(): string
    {
        return config('services.breeze.wallets');
    }

    public function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    public function wallets(): WalletResource
    {
        return new WalletResource($this);
    }

    public function payments(): PaymentResource
    {
        return new PaymentResource($this);
    }
}
