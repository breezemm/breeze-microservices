<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class UserService
{
    public function create(
        #[ArrayShape(['user_id' => 'int'])] array $data
    ): void
    {
        try {
            DB::beginTransaction();
            User::create($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
