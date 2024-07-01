<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckMemberValid implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $length = mb_strlen($value);

        // Check if the string contains any Korean characters
        if (preg_match('/[\p{Hangul}]/u', $value)) {
            if ($length < 2) {
                $fail(__('validation.check_mNick')); // Custom error message for minimum length
            } elseif (!preg_match('/^[\p{Hangul}a-zA-Z0-9]*$/u', $value)) {
                $fail(__('validation.mNick.regex')); // Custom error message for invalid characters
            }
        } else {
            if ($length < 4) {
                $fail(__('validation.check_mNick')); // Custom error message for minimum length
            } elseif (!preg_match('/^[a-zA-Z0-9]*$/', $value)) {
                $fail(__('validation.mNick.regex')); // Custom error message for invalid characters
            }
        }
    }
}
