<?php

namespace Tests\Feature;

use App\Services\Pesepay\ErrorResponse;
use App\Services\Pesepay\Pesepay;
use App\Services\Pesepay\Response;
use App\Services\Pesepay\Transaction;

/**
 * A gateway that never touches the network.
 *
 * The real client validates key lengths and shells out to cURL in its
 * constructor's call path, so substituting a subclass is the only way to
 * exercise the checkout failure branches in a test suite.
 */
class FakePesepay extends Pesepay
{
    public function __construct(
        public Response|ErrorResponse|null $initiateResult = null,
        public Response|ErrorResponse|null $checkResult = null,
        public ?string $checkStatus = null,
    ) {
        // Bypass the parent's key validation: the fake has no keys.
    }

    public function initiateTransaction(Transaction $transaction): Response|ErrorResponse
    {
        $this->initiated = $transaction;

        return $this->initiateResult ?? new ErrorResponse('No initiate result configured.');
    }

    public function checkPayment(string $referenceNumber): Response|ErrorResponse
    {
        $this->checkedReference = $referenceNumber;

        if ($this->checkResult !== null) {
            return $this->checkResult;
        }

        if ($this->checkStatus === null) {
            return new ErrorResponse('No check result configured.');
        }

        /*
         * The real gateway answers about the reference it was asked about, so
         * the reference is echoed back. Returning a single fixed response for
         * every order instead makes a multi-order reconcile write one
         * reference onto every row and trip the unique index.
         */
        return new Response(
            referenceNumber: $referenceNumber,
            pollUrl: 'https://api.pesepay.com/poll/'.$referenceNumber,
            redirectUrl: null,
            paid: $this->checkStatus === 'SUCCESS',
            data: [
                'referenceNumber' => $referenceNumber,
                'transactionStatus' => $this->checkStatus,
            ],
        );
    }

    public ?Transaction $initiated = null;

    public ?string $checkedReference = null;
}
