<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawConfigRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'withdraw-config';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

      /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'wcMinWithdraw' => floatval(str_replace(',', '',data_get($this, 'wcMinWithdraw', '0'))),
        ]);
    }
    public function rules(): array
    {
        return [
            'wcMinWithdraw' => 'nullable|numeric',
            'wcDelayTime' => 'nullable|numeric',
            'wcRollingRules' => 'nullable|string|max:255',
            'wcTimeOffWithdraw' => 'nullable|string|max:255',
            'wcDisableWithdrawContent' => 'nullable|string|max:255',
            'wcMaxRechargePerDay' => 'nullable|array',
            'wcMaxRechargePerTime' => 'nullable|array',
            'wcNoBonus' => 'nullable|array',
            'wcBonus' => 'nullable|array',
            'wcWithdrawRules' => 'nullable|string',
        ];
    }
}
