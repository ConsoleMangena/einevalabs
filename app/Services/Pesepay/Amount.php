<?php

namespace App\Services\Pesepay;

class Amount
{
    public function __construct(
        public float $amount,
        public string $currencyCode,
    ) {}
}
