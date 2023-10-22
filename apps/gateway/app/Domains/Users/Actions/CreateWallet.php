<?php

namespace App\Domains\Users\Actions;

use App\Domains\Users\Events\UserSignedUp;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class CreateWallet
{

    /**
     * @throws \Exception
     */
    #[ArrayShape(["id" => "int"])]
    public function __invoke(array $user)
    {
        try {
            Kafka::publishOn('wallet')
                ->withMessage(new Message(
                    body: json_encode([
                        'id' => Str::uuid(),
                        'topic' => 'wallet',
                        'pattern' => [
                            'cmd' => 'wallet.created',
                        ],
                        'data' => [
                            'id' => $user['id'],
                        ],
                    ]),
                ))
                ->send();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
