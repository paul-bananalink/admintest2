<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'member_id' => 'string|required|unique:member,mID|min:6|max:255',
            'member_password' => 'string|required|min:6|max:255|confirmed',
            'member_password_confirmation' => 'string|required|min:6|max:255',
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
            //mID
            'member_id.required' => __('validation.required'),
            'member_id.unique' => __('validation.unique'),
            'member_id.min' => __('validation.min'),
            'member_id.max' => __('validation.max'),

            //mPW
            'member_password.required' => __('validation.required'),
            'member_password.min' => __('validation.min'),
            'member_password.max' => __('validation.max'),
            'member_password.confirmed' => __('validation.confirmed'),

            'member_password_confirmation.required' => __('validation.required'),
            'member_password_confirmation.min' => __('validation.min'),
            'member_password_confirmation.max' => __('validation.max'),
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
            'member_id' => 'Member ID',
            'member_password' => 'Member Password',
            'member_password_confirmation' => 'Confirm Password',
        ];
    }
}
