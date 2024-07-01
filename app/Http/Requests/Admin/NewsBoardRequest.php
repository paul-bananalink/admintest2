<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsBoardRequest extends FormRequest
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
            'title' => 'required',
            'created_date' => 'required|date_format:Y-m-d H:i:s',
            'category' => 'required',
            'content' => 'required',
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
            'title.required' => __('validation.required'),
            'category.required' => __('validation.required'),

            'created_date.required' => __('validation.required'),
            'created_date.date_format' => __('validation.date_format'),

            'content.required' => __('validation.required'),
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
            'title' => '제목',
            'category' => '범주',
            'content' => '내용',
            'created_date' => '작성일'
        ];
    }
}
