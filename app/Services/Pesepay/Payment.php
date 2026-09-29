<?php

namespace App\Services\Pesepay;

class Payment
{
    public const SPLIT_AMOUNT_MODE_PRINCIPAL = Transaction::SPLIT_AMOUNT_MODE_PRINCIPAL;

    public const SPLIT_AMOUNT_MODE_ADD_ON = Transaction::SPLIT_AMOUNT_MODE_ADD_ON;

    public ?string $referenceNumber = null;

    public ?Amount $amountDetails = null;

    public ?string $reasonForPayment = null;

    public ?array $paymentRequestFields = null;

    public ?array $paymentMethodRequiredFields = null;

    public ?string $merchantReference = null;

    public ?string $returnUrl = null;

    public ?string $resultUrl = null;

    public ?array $paymentMetadata = null;

    public function __construct(
        public string $currencyCode,
        public string $paymentMethodCode,
        public Customer $customer,
    ) {}

    public function setRequiredFields(?array $requiredFields): void
    {
        $this->paymentRequestFields = $requiredFields;
        $this->paymentMethodRequiredFields = $requiredFields;
    }

    public function setPaymentMetadata(array $paymentMetadata): void
    {
        $this->paymentMetadata = $paymentMetadata;
    }

    public function setSplitPayment(string $beneficiaryMerchantEmail, string $splitAmountMode = self::SPLIT_AMOUNT_MODE_PRINCIPAL): void
    {
        if (! filter_var($beneficiaryMerchantEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('A valid beneficiary merchant email is required for split payments.');
        }

        $this->paymentMetadata = [
            'beneficiaryMerchantEmail' => $beneficiaryMerchantEmail,
            'splitAmountMode' => $this->normalizeSplitAmountMode($splitAmountMode),
        ];
    }

    private function normalizeSplitAmountMode(string $splitAmountMode): string
    {
        $mode = strtoupper($splitAmountMode);

        $aliases = [
            'PRINCIPAL' => self::SPLIT_AMOUNT_MODE_PRINCIPAL,
            'PRINCIPAL_AMOUNT' => self::SPLIT_AMOUNT_MODE_PRINCIPAL,
            'ADD_ON' => self::SPLIT_AMOUNT_MODE_ADD_ON,
            'ADDON' => self::SPLIT_AMOUNT_MODE_ADD_ON,
            'ADDED_ON_TOP' => self::SPLIT_AMOUNT_MODE_ADD_ON,
            'ON_TOP' => self::SPLIT_AMOUNT_MODE_ADD_ON,
        ];

        if (! isset($aliases[$mode])) {
            throw new \InvalidArgumentException("Invalid split amount mode '{$splitAmountMode}'. Use PRINCIPAL or ADD_ON.");
        }

        return $aliases[$mode];
    }
}
