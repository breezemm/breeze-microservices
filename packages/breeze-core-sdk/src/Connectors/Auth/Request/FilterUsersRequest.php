<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth\Request;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class FilterUsersRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public readonly array $userIds,
    )
    {
    }

    public function resolveEndpoint(): string
    {
        return '/auth/users';
    }

    protected function defaultQuery(): array
    {
        return [
            'filter' => [
                'id' => collect($this->userIds)->implode(','), // Convert array to comma-separated string
            ],
        ];
    }
}
