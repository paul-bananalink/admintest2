<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'banner' => 'required',
            'created_date' => 'required|date_format:Y-m-d H:i:s',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
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
            'banner.required' => __('validation.required'),

            'created_date.required' => __('validation.required'),
            'created_date.date_format' => __('validation.date_format'),

            'start_date.required' => __('validation.required'),
            'start_date.date_format' => __('validation.date_format'),

            'end_date.required' => __('validation.required'),
            'end_date.date_format' => __('validation.date_format'),

            'end_date.after' => '종료일은 시작일보다 이후여야 합니다.',
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
            'content' => '내용',
            'start_date' => '시작일',
            'end_date' => '종료일',
            'created_date' => '작성일',
            'banner' => '이미지',
        ];
    }
}
