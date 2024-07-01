<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'update-member-bag';

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
    public function rules(): array
    {
        return [
            'mMemberID' => [
                'nullable',
                new \App\Rules\ValidPartnerMember,
            ],
            'mPartnerCode' => [
                new \App\Rules\CheckPartnerCodeValid,
            ],
            'mPartnerName' => [
                new \App\Rules\CheckPartnerNameValid,
            ],
            'mID' => 'required|string|unique:member,mID,' . request('mID') . ',mID',
            'mPW' => [
                'nullable',
                new \App\Rules\ValidPassword,
            ],
            'mNick' => [
                'required',
                'unique:member,mNick,' . request('mID') . ',mID',
                'check_mNick' => new \App\Rules\CheckMemberValid, // Use the custom rule
            ],
            // 'mBankName' => 'nullable|string',
            // 'mBankNumber' => 'nullable|string',
            // 'mBankOwner' => 'nullable|string',
            'mcRollingCasinoRate' => [
                new \App\Rules\ValidRate,
            ],
            'mcRollingSlotRate' => [
                new \App\Rules\ValidRate,
            ],
            'mcLossCasinoRate' => [
                new \App\Rules\ValidRate,
            ],
            'mcLossSlotRate' => [
                new \App\Rules\ValidRate,
            ],
            'mPhone' => ['nullable', 'min:9', 'max:11'],
            'mcSinglePoleAmount' => 'nullable|decimal:0,2',
            'mcMultiPoleAmount' => 'nullable|decimal:0,2',
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
            'mMemberID.exists' => __('validation.exists'),
            'mPhone.min' => __('validation.mPhone.min'),
            'mPhone.max' => __('validation.mPhone.max'),


            // 'mID.required' => __('validation.required'),
            // 'mID.exists' => __('validation.exists'),
            'mPartnerCode.unique' => __('validation.unique'),
            'mPartnerName.unique' => __('validation.unique'),

            'mNick.unique' => __('validation.unique'),

            'mNick.min' => __('validation.min'),

            'mNick.regex' => __('validation.regex'),

            'mPW.required' => __('validation.required'),

            'mStatus.in' => __('validation.in'),
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
            'mMemberID' => '파트너 ID',
            'mPartnerCode' => '파트너명',
            'mPartnerName' => '추천 코드가',
            'mPW' => '유형',
            'mNick' => '닉네임',
            'mcSinglePoleAmount' => '단풀제한금액',
            'mcMultiPoleAmount' => '두폴제한금액',
        ];
    }
}
