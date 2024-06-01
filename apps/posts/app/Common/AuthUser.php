<?php

namespace App\Common;

readonly class AuthUser
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $username,
        public string $email,
        public string $profileImage,
        public string $city,
    )
    {


    }

    public function id()
    {
        return $this->id;
    }
}
