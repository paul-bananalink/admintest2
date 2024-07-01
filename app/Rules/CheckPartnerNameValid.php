<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckPartnerNameValid implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $member = \App\Models\Member::where('mNo', request('mNo'))->first();
        if ($member->mIsPartner && !$value) {
            $fail(__('사용자 이름을 입력해야 합니다.'));
        } else if($member->mPartnerName && !$value) {
                $fail(__('이 파트너 이름은 이미 사용 중입니다.'));
        }
    }
}
