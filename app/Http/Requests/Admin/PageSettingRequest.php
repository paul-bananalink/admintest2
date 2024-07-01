<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PageSettingRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'page-setting';

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
            'siOpenUserJoin' => 'nullable|boolean',
            'siOpenType' => 'nullable|boolean',
            'selectSiTimeOUt' => [
                'nullable',
                'in:'.implode(',', config('constant_view.VIEW.selectSiTimeOUt')),
            ],
            'siName' => 'string|nullable',
            'siEmail' => 'email|nullable',
            'siTel' => 'string|nullable',
            'siBankBankAccountOwner' => 'string|nullable',
            'siDescription' => 'string|nullable',
            'siKeywords' => 'string|nullable',
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
            'selectSiTimeOUt.in' => __('validation.in'),
            'siEmail.email' => __('validation.email'),
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
            'selectSiTimeOUt' => '자동 로그아웃시간',
            'siEmail' => '사이트 email',
        ];
    }
}
