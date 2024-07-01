<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckMMoneyValid implements ValidationRule
{
    const TWO_BILLION = 2000000000;

    public function __construct()
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $money = auth()->user()->mMoney;
        if ($money < $value) {
            $fail(__('validation.mmoney_not_enough', ['money' => formatNumber($money)]));
        }
        $site_money = app('site_info')->siOptionMinWithraw ?? null;
        if ($site_money && $value < $site_money) {
            $fail('최소 ' . formatNumber($site_money) . ' 이상 충전신청을 해야합니다.');
        }

        if ($value > self::TWO_BILLION) {
            $fail(formatNumber(self::TWO_BILLION) . '이하 환전신청을 해야합니다.');
        }
    }
}
