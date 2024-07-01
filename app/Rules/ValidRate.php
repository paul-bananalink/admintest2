<?php

namespace App\Rules;

use App\Models\Member;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidRate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $member = Member::where('mID', request('mID'))->first();

        if ($member->mMemberID) {
            if ($member->partner->memberConfig->{$attribute} < $value) {
                $fail(__('validation.' . $attribute));
            }
        }
    }
}
