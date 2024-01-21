<?php

namespace App\Support;

class CodeGenerator
{
    public static function generate(): string
    {
        return (string) rand(100000, 999999);
    }
}
