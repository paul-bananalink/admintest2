<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateMemberRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'create-member-bag';

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
            // 'mMemberID' => 'nullable|exists:member,mID',
            'mMemberID' => 'nullable|exists:member,mID',
            'mID' => 'required|string|unique:member,mID|regex:/^[a-zA-Z0-9]+$/',
            'mPW' => [
                'required',
                new \App\Rules\ValidPassword,
            ],
            'mNick' => [
                'required',
                'unique:member,mNick',
                'check_mNick' => new \App\Rules\CheckMemberValid, // Use the custom rule
            ],
            // 'mBankName' => 'nullable|string',
            // 'mBankNumber' => 'nullable|string',
            // 'mBankOwner' => 'nullable|string',
            // 'mPhone' => 'nullable|string',
            'mStatus' => 'in:' . implode(',', array_keys(\App\Models\Member::STATUS_MEMBER_TO_STRING)),
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

            'mID.required' => __('validation.required'),

            'mID.unique' => __('validation.unique'),

            'mNick.unique' => __('validation.unique'),

            'mNick.min' => __('validation.min'),

            'mNick.check_mNick' => __('validation.check_mNick'),

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
            'mMemberID' => '초대된 회원',
            'mID' => '아이디를',
            'mPW' => '비밀번호를',
            'mStatus' => '상태',
            'mBankName' => '은행 이름',
            'mBankNumber' => '은행번호',
            'mBankOwner' => '은행 주인',
            // 'mPhone' => '핸드폰',
            'mNick' => '닉네임',
            'mcSinglePoleAmount' => '단풀제한금액',
            'mcMultiPoleAmount' => '두폴제한금액',
        ];
    }
}
