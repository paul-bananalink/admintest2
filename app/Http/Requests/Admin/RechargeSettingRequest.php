<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RechargeSettingRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'recharge-setting';

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
        if ($v = data_get($this, 'siOptionMinDeposit')) {
            $v = trim($v, ',');
            $this->merge([
                'siOptionMinDeposit' => floatval($v),
            ]);
        }
        if ($v = data_get($this, 'siOptionMinWithraw')) {
            $v = trim($v, ',');
            $this->merge([
                'siOptionMinWithraw' => floatval($v),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'siOptionMinDeposit' => 'nullable|decimal:0,2',
            'siOptionMinWithraw' => 'nullable|decimal:0,2',
            'siOptionDepositText' => 'nullable|string',
            'siOptionWithrawText' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'siOptionMinDeposit.decimal' => __('validation.decimal'),
            'siOptionMinWithraw.decimal' => __('validation.decimal'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'siOptionMinDeposit' => '최소충전금액',
            'siOptionMinWithraw' => '최소환전금액',
        ];
    }
}
