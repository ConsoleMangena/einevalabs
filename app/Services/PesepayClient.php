<?php

namespace App\Services;

use App\Services\Pesepay\ErrorResponse;
use App\Services\Pesepay\Pesepay;
use App\Services\Pesepay\Response;
use RuntimeException;

/**
 * Builds a configured PesePay client and turns "the credentials are missing or
 * malformed" into a clear runtime error instead of an undefined-index warning
 * deep inside the HTTP layer.
 */
class PesepayClient
{
    public static function make(): Pesepay
    {
        $integrationKey = (string) config('services.pesepay.integration_key');
        $encryptionKey = (string) config('services.pesepay.encryption_key');

        if ($integrationKey === '' || $encryptionKey === '') {
            throw new RuntimeException(
                'PesePay is not configured. Set PESEPAY_INTEGRATION_KEY and PESEPAY_ENCRYPTION_KEY.'
            );
        }

        return new Pesepay(
            integrationKey: $integrationKey,
            encryptionKey: $encryptionKey,
            isSandbox: (bool) config('services.pesepay.sandbox'),
            connectTimeout: (int) config('services.pesepay.connect_timeout'),
            timeout: (int) config('services.pesepay.timeout'),
        );
    }

    public static function currency(): string
    {
        return (string) config('services.pesepay.currency', 'USD');
    }

    public static function reason(): string
    {
        return (string) config('services.pesepay.reason', 'EINEVA Labs Store Checkout');
    }

    public static function isError(Response|ErrorResponse|null $result): bool
    {
        return $result instanceof ErrorResponse;
    }
}
