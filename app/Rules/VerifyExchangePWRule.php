<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class VerifyExchangePWRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        if ($value !== $member->mBankExchangePW) {
            $fail(__('validation.bank_exchange_not_match'));
        }
    }
}
