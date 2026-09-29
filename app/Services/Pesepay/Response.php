<?php

namespace App\Services\Pesepay;

class Response
{
    private array $amountDetails = [];

    private array $transactionMetadata = [];

    public function __construct(
        private string $referenceNumber,
        private ?string $pollUrl = null,
        private ?string $redirectUrl = null,
        private bool $paid = false,
        private array $data = [],
    ) {
        $this->amountDetails = is_array($data['amountDetails'] ?? null) ? $data['amountDetails'] : [];
        $this->transactionMetadata = is_array($data['transactionMetadata'] ?? null) ? $data['transactionMetadata'] : [];
    }

    public function success(): bool
    {
        return true;
    }

    public function referenceNumber(): string
    {
        return $this->referenceNumber;
    }

    public function pollUrl(): ?string
    {
        return $this->pollUrl;
    }

    public function redirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    public function paid(): bool
    {
        return $this->paid;
    }

    public function rawData(): array
    {
        return $this->data;
    }

    public function data(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function dateOfTransaction(): ?string
    {
        return $this->data('dateOfTransaction');
    }

    public function applicationId(): ?string
    {
        return $this->data('applicationId');
    }

    public function applicationName(): ?string
    {
        return $this->data('applicationName');
    }

    public function reasonForPayment(): ?string
    {
        return $this->data('reasonForPayment');
    }

    public function transactionStatus(): ?string
    {
        return $this->data('transactionStatus');
    }

    public function transactionStatusCode(): ?string
    {
        return $this->data('transactionStatusCode');
    }

    public function transactionStatusDescription(): ?string
    {
        return $this->data('transactionStatusDescription');
    }

    public function amountDetails(): array
    {
        return $this->amountDetails;
    }

    public function amount(): ?string
    {
        return $this->amountDetails['amount'] ?? null;
    }

    public function currencyCode(): ?string
    {
        return $this->amountDetails['currencyCode'] ?? null;
    }

    public function defaultCurrencyAmount(): ?string
    {
        return $this->amountDetails['defaultCurrencyAmount'] ?? null;
    }

    public function defaultCurrencyCode(): ?string
    {
        return $this->amountDetails['defaultCurrencyCode'] ?? null;
    }

    public function transactionServiceFee(): ?string
    {
        return $this->amountDetails['transactionServiceFee'] ?? null;
    }

    public function customerPayableAmount(): ?string
    {
        return $this->amountDetails['customerPayableAmount'] ?? null;
    }

    public function totalTransactionAmount(): ?string
    {
        return $this->amountDetails['totalTransactionAmount'] ?? null;
    }

    public function merchantAmount(): ?string
    {
        return $this->amountDetails['merchantAmount'] ?? null;
    }

    public function formattedMerchantAmount(): ?string
    {
        return $this->amountDetails['formattedMerchantAmount'] ?? null;
    }

    public function transactionMetadata(): array
    {
        return $this->transactionMetadata;
    }

    public function metadataCode(): ?string
    {
        return $this->transactionMetadata['code'] ?? null;
    }

    public function metadataQrCode(): ?string
    {
        return $this->transactionMetadata['qrCode'] ?? null;
    }
}
