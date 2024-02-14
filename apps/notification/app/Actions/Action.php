<?php

namespace App\Actions;

interface Action
{
    public function handle(array $data): void;
}
