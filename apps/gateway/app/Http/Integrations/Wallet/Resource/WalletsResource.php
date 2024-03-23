<?php

namespace App\Http\Integrations\Wallet\Resource;

use App\DataTransferObjects\WalletData;
use App\Http\Integrations\Wallet\Requests\Wallets\CreateWallet;
use App\Http\Integrations\Wallet\Requests\Wallets\GetWalletById;
use App\Http\Integrations\Wallet\Requests\Wallets\GetWalletByUserId;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class WalletsResource extends BaseResource
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function createWallet(WalletData $walletData): Response
    {
        return $this->connector->send(new CreateWallet($walletData));
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getWalletById(int $id): Response
    {
        return $this->connector->send(new GetWalletById(id: $id));
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getWalletByUserId(int $id): Response
    {
        return $this->connector->send(new GetWalletByUserId($id));
    }
}
