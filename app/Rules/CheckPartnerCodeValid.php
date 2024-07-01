<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckPartnerCodeValid implements ValidationRule
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
            $fail(__('추친인 코드를 입력해야합니다.'));
        } else {
            $exists = \App\Models\Member::where('mPartnerCode', $value)->where('mNo', '!=', $member->mNo)->exists();
            if ($exists) {
                $fail(__('이 파트너 코드는 이미 사용 중입니다.'));
            }
        }
    }
}
