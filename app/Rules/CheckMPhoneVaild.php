<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckMPhoneVaild implements ValidationRule
{
    protected $mPhone;
    public function __construct($mPhone)
    {
        $this->mPhone = $mPhone;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //  $checkPhone = app('site_info')->siBlackList;
        //  if ($checkPhone && in_array($this->mPhone, $checkPhone)) {
        //      $fail('This phone number is blocked.');
        //  }
    }
}
