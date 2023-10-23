<?php

namespace App\Domains\Users\Actions;

use App\Domains\Users\Events\UserSignedUp;
use JetBrains\PhpStorm\ArrayShape;
use Junges\Kafka\Config\Sasl;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class CreateWallet
{

    /**
     * @throws \Exception
     */
    public function __invoke(
        #[ArrayShape(["id" => "int"])] array $user): void
    {
        try {
            Kafka::publishOn('wallet')
                ->withSasl(new Sasl(
                    username: env('KAFKA_USERNAME'),
                    password: env('KAFKA_PASSWORD'),
                    mechanisms: env('KAFKA_SASL_MECHANISMS'),
                    securityProtocol: env('KAFKA_SECURITY_PROTOCOL'),
                ))
                ->withMessage(new Message(
                        body: createPayload(
                            topic: 'wallet',
                            pattern: [
                                'cmd' => 'wallet.created',
                            ],
                            data: $user,
                        ))
                )->send();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
