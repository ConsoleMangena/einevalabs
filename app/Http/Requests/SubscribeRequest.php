<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\InteractsWithHoneypot;
use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    use InteractsWithHoneypot;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email:filter', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please enter an email address.',
            'email.email' => 'That email address does not look valid.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'email' => 'email address',
        ];
    }
}
