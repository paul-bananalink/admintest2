<?php

namespace App\Http\Requests\Admin;

use App\Services\MemberService;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'member_id' => 'required',
            'member_password' => 'required',
            'captcha_key'=>'required|captcha',
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
            'member_id.required' => __('validation.required'),
            'member_password.required' => __('validation.required'),
            'captcha_key.required' => __('validation.required'),
            'captcha_key.captcha' => '잘못된 캡차',
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
            'member_id' => '아이디',//Member ID
            'member_password' => '비밀번호',//'Member Password',
            'captcha_key' => '캡차',
        ];
    }
}
