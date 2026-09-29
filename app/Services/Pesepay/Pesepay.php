<?php

namespace App\Services\Pesepay;

use RuntimeException;

/**
 * Minimal client for the PesePay payments engine.
 *
 * Committed verbatim in the JSON payload, so the property names on Transaction
 * and Payment are part of the wire contract and must not be renamed.
 */
class Pesepay
{
    public const PROD_BASE_URL = 'https://api.pesepay.com/api/payments-engine';

    public const SANDBOX_BASE_URL = 'https://api.test.sandbox.pesepay.com/payments-engine';

    private const ALGORITHM = 'AES-256-CBC';

    private const INIT_VECTOR_LENGTH = 16;

    private const SUCCESS_STATUS = 'SUCCESS';

    public ?string $resultUrl = null;

    public ?string $returnUrl = null;

    public function __construct(
        private string $integrationKey,
        private string $encryptionKey,
        private bool $isSandbox = false,
        private int $connectTimeout = 10,
        private int $timeout = 30,
    ) {
        $this->assertKeyLengthValid($this->encryptionKey, 'Encryption key');
    }

    /**
     * Start a payment and return the hosted checkout URL to redirect to.
     */
    public function initiateTransaction(Transaction $transaction): Response|ErrorResponse
    {
        $this->assertUrlsConfigured();

        $transaction->resultUrl = $this->resultUrl;
        $transaction->returnUrl = $this->returnUrl;

        return $this->post(
            $this->initiatePaymentUrl(),
            $this->encodePayload($transaction)
        );
    }

    /**
     * Ask the gateway whether a reference number has actually settled.
     */
    public function checkPayment(string $referenceNumber): Response|ErrorResponse
    {
        return $this->get($this->checkPaymentUrl().'?'.http_build_query([
            'referenceNumber' => $referenceNumber,
        ]));
    }

    public function makeSeamlessPayment(
        Payment $payment,
        string $reasonForPayment,
        float $amount,
        ?array $requiredFields = null,
        ?string $merchantReference = null,
    ): Response|ErrorResponse {
        $this->assertUrlsConfigured();

        $payment->resultUrl = $this->resultUrl;
        $payment->returnUrl = $this->returnUrl;
        $payment->reasonForPayment = $reasonForPayment;
        $payment->amountDetails = new Amount($amount, $payment->currencyCode);
        $payment->merchantReference = $merchantReference;
        $payment->setRequiredFields($requiredFields);

        return $this->post(
            $this->makeSeamlessPaymentUrl(),
            $this->encodePayload($payment)
        );
    }

    public function createTransaction(float $amount, string $currencyCode, string $paymentReason, ?string $merchantReference = null, ?Customer $customer = null): Transaction
    {
        return new Transaction($amount, $currencyCode, $paymentReason, $merchantReference, $customer);
    }

    public function createPayment(string $currencyCode, string $paymentMethodCode, ?string $email = null, ?string $phone = null, ?string $name = null): Payment
    {
        return new Payment($currencyCode, $paymentMethodCode, new Customer($email, $phone, $name));
    }

    private function baseUrl(): string
    {
        return $this->isSandbox ? self::SANDBOX_BASE_URL : self::PROD_BASE_URL;
    }

    private function checkPaymentUrl(): string
    {
        return $this->baseUrl().'/v1/payments/check-payment';
    }

    private function initiatePaymentUrl(): string
    {
        return $this->baseUrl().'/v1/payments/initiate';
    }

    private function makeSeamlessPaymentUrl(): string
    {
        return $this->baseUrl().'/v2/payments/make-payment';
    }

    private function assertUrlsConfigured(): void
    {
        if ($this->resultUrl === null) {
            throw new \InvalidArgumentException('Result url has not been specified.');
        }

        if ($this->returnUrl === null) {
            throw new \InvalidArgumentException('Return url has not been specified.');
        }
    }

    private function post(string $url, string $payload): Response|ErrorResponse
    {
        return $this->send('POST', $url, $payload, needRedirectUrl: true);
    }

    private function get(string $url): Response|ErrorResponse
    {
        return $this->send('GET', $url);
    }

    /**
     * Every field is read defensively: a malformed or truncated payload must
     * come back as an ErrorResponse, not as a PHP warning followed by a null
     * that surfaces much later as a blank redirect.
     *
     * $needRedirectUrl is set only for initiate. A check-payment reply carries
     * no redirect URL by design, so demanding one there would turn every
     * successful settlement verification into an error and no order would ever
     * be marked paid.
     */
    private function send(string $method, string $url, ?string $payload = null, bool $needRedirectUrl = false): Response|ErrorResponse
    {
        $raw = $this->request($method, $url, $payload);

        if ($raw instanceof ErrorResponse) {
            return $raw;
        }

        if (! isset($raw['payload']) || ! is_string($raw['payload']) || $raw['payload'] === '') {
            return new ErrorResponse('Invalid response from PesePay: missing payload.');
        }

        try {
            $decoded = json_decode($this->decrypt($raw['payload']), true);
        } catch (RuntimeException $e) {
            return new ErrorResponse('Could not decrypt response from PesePay: '.$e->getMessage());
        }

        if (! is_array($decoded)) {
            return new ErrorResponse('Invalid response from PesePay: payload was not an object.');
        }

        $referenceNumber = $decoded['referenceNumber'] ?? null;
        $pollUrl = $decoded['pollUrl'] ?? null;
        $redirectUrl = $decoded['redirectUrl'] ?? null;

        if (! is_string($referenceNumber) || $referenceNumber === '') {
            return new ErrorResponse('Invalid response from PesePay: missing reference number.');
        }

        if (! is_string($redirectUrl) || $redirectUrl === '') {
            if ($needRedirectUrl) {
                return new ErrorResponse('Invalid response from PesePay: missing redirect URL.');
            }

            // A check-payment reply has none, and that is not an error.
            $redirectUrl = null;
        }

        if (! is_string($pollUrl) || $pollUrl === '') {
            $pollUrl = null;
        }

        $paid = ($decoded['transactionStatus'] ?? null) === self::SUCCESS_STATUS;

        return new Response($referenceNumber, $pollUrl, $redirectUrl, $paid, $decoded);
    }

    /**
     * @return array<string, mixed>|ErrorResponse
     */
    private function request(string $method, string $url, ?string $payload = null): array|ErrorResponse
    {
        if (! function_exists('curl_init')) {
            return new ErrorResponse('The cURL PHP extension is required to reach PesePay.');
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                'key: '.$this->integrationKey,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'EINEVA-Labs-Pesepay',
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_TIMEOUT => $this->timeout,

            /*
             | Certificate verification is unconditional. The original client
             | keyed this off env('APP_ENV'), which returns null once the
             | config is cached and so would silently downgrade production to
             | no TLS verification. Debug the CA bundle instead.
             */
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);

        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        }

        $response = curl_exec($curl);
        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($response === false) {
            return new ErrorResponse($curlError !== '' ? $curlError : 'Failed to connect to PesePay.');
        }

        $result = json_decode((string) $response, true);

        if ($statusCode !== 200) {
            $message = is_array($result) && is_string($result['message'] ?? null)
                ? $result['message']
                : 'PesePay request failed with status code '.$statusCode.'.';

            return new ErrorResponse($message);
        }

        if (! is_array($result)) {
            return new ErrorResponse('Invalid response from PesePay: expected a JSON object.');
        }

        return $result;
    }

    private function encodePayload(Transaction|Payment $subject): string
    {
        try {
            $json = json_encode($subject, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new RuntimeException('Could not encode the payment request: '.$e->getMessage(), previous: $e);
        }

        return json_encode(['payload' => $this->encrypt($json)], JSON_THROW_ON_ERROR);
    }

    /**
     * PesePay derives the IV from the encryption key itself; this is the
     * documented scheme and cannot be substituted with a random IV.
     */
    private function encrypt(string $plainText): string
    {
        $raw = openssl_encrypt(
            $plainText,
            self::ALGORITHM,
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $this->initVector()
        );

        if ($raw === false) {
            throw new RuntimeException('Encryption failed: '.(openssl_error_string() ?: 'unknown error'));
        }

        return base64_encode($raw);
    }

    private function decrypt(string $cipherText): string
    {
        $encoded = base64_decode($cipherText, true);

        if ($encoded === false) {
            throw new RuntimeException('Decryption failed: payload was not valid base64.');
        }

        $decoded = openssl_decrypt(
            $encoded,
            self::ALGORITHM,
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $this->initVector()
        );

        if ($decoded === false) {
            throw new RuntimeException('Decryption failed: '.($this->opensslErrors() ?: 'wrong key or corrupt payload'));
        }

        return $decoded;
    }

    private function initVector(): string
    {
        return substr($this->encryptionKey, 0, self::INIT_VECTOR_LENGTH);
    }

    private function assertKeyLengthValid(string $key, string $label): void
    {
        if (! in_array(strlen($key), [16, 24, 32], true)) {
            throw new \InvalidArgumentException(
                "{$label} must be 16, 24 or 32 characters (128, 192 or 256 bits); got ".strlen($key).'.'
            );
        }
    }

    /**
     * openssl_error_string() is a single-slot queue and the extension swallows
     * most errors, so drain whatever is left in one pass.
     */
    private function opensslErrors(): string
    {
        $errors = [];

        while (($error = openssl_error_string()) !== false) {
            $errors[] = $error;
        }

        return implode('; ', $errors);
    }
}
