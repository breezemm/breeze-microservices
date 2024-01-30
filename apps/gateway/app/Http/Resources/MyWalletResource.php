<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyWalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'wallet_id' => $this->wallet_id,
            'user_id' => $this->user_id,
            'balance' => $this->balance,
            'currency' => $this->currency,
            'qr_code' => $this->qr_code,
        ];
    }
}
