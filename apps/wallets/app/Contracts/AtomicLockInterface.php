<?php

namespace App\Contracts;

use App\Exceptions\TransactionFailedException;
use App\Models\Wallet;
use Illuminate\Database\RecordsNotFoundException;

interface AtomicLockInterface
{

    /**
     * The method atomically locks the transaction for other concurrent requests.
     * @template T
     *
     * @param callable(): T $callback
     * @return T
     *
     * @throws RecordsNotFoundException
     * @throws TransactionFailedException
     */
    public function block(Wallet $object, callable $callback): mixed;


    /**
     * The method atomically locks the transaction for other concurrent requests.
     *
     * @template T
     *
     * @param non-empty-array<Wallet> $objects
     * @param callable(): T $callback
     * @return T
     *
     * @throws RecordsNotFoundException
     * @throws TransactionFailedException
     */
    public function blocks(array $objects, callable $callback): mixed;
}
