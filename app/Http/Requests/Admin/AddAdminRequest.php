<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddAdminRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'list-admin-setting';

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
        $mLevel = config('constant_view.VIEW.selectMLevel');
        if (auth()->user()->mLevel == config('constant_view.VIEW.M_LEVEL_MA')) {
            array_push($mLevel, config('constant_view.VIEW.M_LEVEL_MA'));
        }

        return [
            'mID' => 'unique:member,mID|required',
            'mNick' => 'required',
            'mPW' => 'required',
            'mLevel' => [
                'required',
                Rule::in($mLevel),
            ],
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
            'mID.unique' => __('validation.unique'),
            'mID.required' => __('validation.required'),

            'mNick.required' => __('validation.required'),

            'mPW.required' => __('validation.required'),

            'mLevel.required' => __('validation.required'),
            'mLevel.in' => __('validation.in'),
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
            'mID' => '아이디',
            'mNick' => '이름',
            'mPW' => '유형',
            'mLevel' => '패스워드',
        ];
    }
}
