<?php

namespace App\Http\Requests\Concerns;

trait InteractsWithHoneypot
{
    /** Hidden field name, deliberately plausible to a naive form-filling bot. */
    public const BOTCHECK = 'botcheck';

    /**
     * Strip the trap out of the validated payload and record whether it was
     * tripped.
     *
     * The old rule was `'nullable|in:0,false,'` - a malformed `in` list. A bot
     * that filled the field got a validation error and a visible failure, and
     * the "spam detected" branch after it was unreachable. A honeypot should
     * instead accept the request and discard it, so the bot learns nothing and
     * the visitor is never shown an error.
     */
    protected function prepareForValidation(): void
    {
        $this->honeypotTripped = $this->honeypotWasFilled();

        $this->merge([self::BOTCHECK => null]);
    }

    public bool $honeypotTripped = false;

    public function honeypotTripped(): bool
    {
        return $this->honeypotTripped;
    }

    /**
     * An unchecked checkbox is not submitted at all, so any value present is
     * either the box being ticked or a bot filling in every field it finds.
     */
    private function honeypotWasFilled(): bool
    {
        $value = $this->input(self::BOTCHECK);

        if ($value === null || is_array($value)) {
            return $value !== null;
        }

        return ! in_array(strtolower((string) $value), ['', '0', 'false'], true);
    }
}
