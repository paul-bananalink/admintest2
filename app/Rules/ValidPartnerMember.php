<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPartnerMember implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $member = \App\Models\Member::where('mID', $value)->first();

        $rateFields = [
            'mcRollingCasinoRate' => request('mcRollingCasinoRate'),
            'mcLossCasinoRate' => request('mcLossCasinoRate'),
            'mcPublicBettingCasino' => request('mcPublicBettingCasino'),
            'mcLossSlotRate' => request('mcLossSlotRate'),
        ];
        
        if (!$member || $member->mIsPartner == 0) {
            $fail(__('추천인가 없습니다.'));
            return;
        }
        
        foreach ($rateFields as $field => $rateFromRequest) {
            if ($rateFromRequest > $member->memberConfig->$field) {
                $fail(__('validation.' . $field));
                return;
            }
        }
    }
}
