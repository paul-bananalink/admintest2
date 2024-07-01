<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBannerRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'update-banner-bag';

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
            'bImage' => 'array',
            'bImage.*' => 'required',
            'bLink' => 'array',
            'bLink.*' => 'nullable',
            'bTarget' => 'array',
            'bTarget.*' => 'required',
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
            'bImage.required' => __('validation.required'),

            'bLink.required' => __('validation.required'),

            'bTarget.required' => __('validation.required'),
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
            'bImage' => '배너',
            'bLink' => '링크',
            'bTarget' => 'Target',
        ];
    }
}
