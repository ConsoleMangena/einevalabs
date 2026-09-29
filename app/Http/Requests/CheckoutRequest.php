<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The email is the only field the customer supplies, and it is the address
     * the receipt and any delivery contact go to. It was previously written to
     * the order straight from the request, so an unbounded string ended up in
     * a column the database then truncated or rejected, and an order could be
     * created with no reachable contact address at all.
     */
    public function rules(): array
    {
        return [
            'customer_email' => ['required', 'email:rfc', 'max:255'],
            'customer_name' => ['sometimes', 'nullable', 'string', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_email.required' => 'We need an email address to send your receipt to.',
            'customer_email.email' => 'That does not look like a valid email address.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->input('customer_email'))) {
            $this->merge(['customer_email' => trim($this->input('customer_email'))]);
        }

        if (is_string($this->input('customer_name'))) {
            $this->merge(['customer_name' => trim($this->input('customer_name'))]);
        }
    }
}
