<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidatePhoneRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->isPhoneInBlackList($value)) {
            $fail("유효하지 않은 전화번호입니다.");
        }
    }

    private function isPhoneInBlackList(string $phone): bool
    {
        return in_array($phone, app('site_info')->siBlackList);
    }
}
