<?php

namespace App\Http\Requests\Admin;

use App\Rules\VerifyPasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRechargeOrWithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mID' => request()->route('mID'),
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
            'mID' =>  'required|exists:member,mID',
            'miDescription' => ['nullable', 'string', 'max:255'],
            'miBankMoney' => ['required', 'integer'],
            'miWallet' => ['required', 'string', 'max:255', 'in:' . \App\Models\Member::WALLET_CASINO_SLOT . ',' . \App\Models\Member::WALLET_SPORTS . ',point'],
            'miType' => Rule::in([\App\Models\MoneyInfo::TYPE_AW, \App\Models\MoneyInfo::TYPE_AD]),
        ];
    }
}
