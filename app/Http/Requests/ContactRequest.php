<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\InteractsWithHoneypot;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:filter', 'max:255'],
            // Optional, but constrained to a known slug. An unconstrained
            // string would let anyone write unbounded text into a column that
            // the admin panel renders in a table and a filter.
            'department' => ['nullable', 'string', Rule::in(array_keys(config('departments', [])))],
            'subject' => ['nullable', 'string', 'max:255'],
            // Bounded: the column is TEXT and this endpoint is unauthenticated,
            // so an unbounded field is a cheap way to fill the database. The
            // floor rejects filler submissions such as "hi" or "test".
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please tell us your name.',
            'email.required' => 'Please provide an email address so we can reply.',
            'email.email' => 'That email address does not look valid.',
            'message.required' => 'Please include a message.',
            'message.min' => 'Please write a little more so we can help.',
            'message.max' => 'Please keep your message under 5000 characters.',
            'department.in' => 'Please choose one of the listed capabilities.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'email address',
            'department' => 'department',
            'subject' => 'subject',
            'message' => 'message',
        ];
    }
}
