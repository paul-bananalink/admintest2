<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RechargeConfigRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'recharge-config';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'rcMinRecharge' => floatval(str_replace(',', '',data_get($this, 'rcMinRecharge', '0'))),
            'rcDelayTime' => floatval(str_replace(',', '',data_get($this, 'rcDelayTime', '0'))),
            'rcMaxBonusFirstTimeSportsRecharge' => floatval(str_replace(',', '',data_get($this, 'rcMaxBonusFirstTimeSportsRecharge', '0'))),
            'rcMaxBonusSportsRecharge' => floatval(str_replace(',', '',data_get($this, 'rcMaxBonusSportsRecharge', '0'))),
            'rcMaxBonusFirstTimeCasinoRecharge' => floatval(str_replace(',', '',data_get($this, 'rcMaxBonusFirstTimeCasinoRecharge', '0'))),
            'rcMaxBonusCasinoRecharge' => floatval(str_replace(',', '',data_get($this, 'rcMaxBonusCasinoRecharge', '0'))),
            'rcMaxRecharge' => array_map(
                fn($value) => floatval(str_replace(',', '',$value)),
                data_get($this, 'rcMaxRecharge', [])
            ),
            'rcAmountNoBonus' => floatval(str_replace(',', '',data_get($this, 'rcAmountNoBonus', '0'))),
            'rcMaxBonusPokerRecharge' => floatval(str_replace(',', '',data_get($this, 'rcMaxBonusPokerRecharge', '0'))),
            'rcMaxBonusFirstTimePokerRecharge' => floatval(str_replace(',', '',data_get($this, 'rcMaxBonusFirstTimePokerRecharge', '0'))),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rcMinRecharge' => 'nullable|decimal:0,2',
            'rcDelayTime' => 'nullable|decimal:0,2',
            'rcMaxBonusFirstTimeSportsRecharge' => 'nullable|decimal:0,2',
            'rcMaxBonusSportsRecharge' => 'nullable|decimal:0,2',
            'rcMaxBonusFirstTimeCasinoRecharge' => 'nullable|decimal:0,2',
            'rcMaxBonusCasinoRecharge' => 'nullable|decimal:0,2',
            'rcDisableRechargeContent' => 'string|nullable|max:255',
            'rcMaxRecharge.*' => 'nullable|decimal:0,2',
            'rcWarningRechargeContent' => 'string|nullable',
            'rcAmountNoBonus' => 'nullable|decimal:0,2',
            'rcMaxBonusPokerRecharge' => 'nullable|decimal:0,2',
            'rcMaxBonusFirstTimePokerRecharge' => 'nullable|decimal:0,2',
        ];
    }
}
