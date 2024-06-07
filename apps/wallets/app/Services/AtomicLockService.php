<?php

namespace App\Services;

use App\Contracts\AtomicLockInterface;
use App\Models\Wallet;
use Illuminate\Support\Facades\Cache;

class AtomicLockService implements AtomicLockInterface
{
    public function block(Wallet $object, callable $callback): mixed
    {
        return $this->blocks([$object], $callback);
    }

    // @phpstan-ignore-next-line
    public function blocks(array $objects, callable $callback): mixed
    {
        $locks = collect($objects)->map(fn ($object) => Cache::lock('atomic-lock:'.$object->id, 10));

        try {
            if ($locks->every(fn ($lock) => $lock->get())) {
                return $callback($objects);
            }
        } finally {
            return $locks->each(fn ($lock) => $lock->release());
        }
    }
}
