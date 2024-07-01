<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberConfigRequest extends FormRequest
{
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
        $mID = request('mID');
        return [
            'mID' => [
                'unique:member,mID,'.$mID.',mID',
                'min:6',
                'regex:/^[^\W_]+$/', //Only a-z, 0-9
            ],
            'mNick' => 'nullable|required|regex:/^[^\W_]+$/',
            'mStatus' => 'in:'.implode(',', array_keys(\App\Models\Member::STATUS_MEMBER_TO_STRING)),
            'mBankOwner' => 'nullable|string',
            // 'mBankExchangePW' => 'nullable|string|between:8,16',
            // 'mBankName' => 'nullable|string',
            // 'mBankNumber' => 'nullable|string',
            // 'mPW' => 'nullable|string|between:8,16',
            'mMemberID' => 'required|exists:member,mID'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'mID' => '아이디',
            'mNick' => '닉네임',
            'mPW' => '유형',
            'mPhone' => '전화번호',
        ];
    }
}
