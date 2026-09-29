<?php

namespace App\Services\Pesepay;

/**
 * A failed gateway call. Returned rather than thrown so callers can branch on
 * the result without try/catch noise; `message()` is safe to log but is not
 * shown verbatim to customers.
 */
class ErrorResponse
{
    private bool $success = false;

    public function __construct(private string $message) {}

    public function success(): bool
    {
        return $this->success;
    }

    public function message(): string
    {
        return $this->message;
    }
}
