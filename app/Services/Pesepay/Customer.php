<?php

namespace App\Services\Pesepay;

class Customer
{
    public function __construct(
        public ?string $email = null,
        public ?string $phoneNumber = null,
        public ?string $name = null,
    ) {}
}
