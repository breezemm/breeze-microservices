<?php

namespace App;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

trait Pagination
{
    public function paginate(array|Collection $items, ?int $perPage = null, ?int $page = null, array $options = [], ?string $path = null): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        if (! isset($options['path'])) {
            $options['path'] = request()->url();
        }

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage)->values(), $items->count(), $perPage, $page, $options);
    }
}
