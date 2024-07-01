<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateMemberRequest extends FormRequest
{
    public function __construct()
    {
        $this->errorBag = request('type_form', 'create') . $this->errorBag;
    }

    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = '-member-bag';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'mcSinglePoleAmount' => floatval(str_replace(',', '', data_get($this, 'mcSinglePoleAmount', '0'))),
            'mcMultiPoleAmount' => floatval(str_replace(',', '', data_get($this, 'mcMultiPoleAmount', '0'))),
            'mPhone' => str_replace(' ', '', data_get($this, 'mPhone', '')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (request('mNo')) {
            return (new UpdateMemberRequest())->rules();
        } else {
            return (new CreateMemberRequest())->rules();
        }

        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        if (request('mNo')) {
            return (new UpdateMemberRequest())->messages();
        } else {
            return (new CreateMemberRequest())->messages();
        }

        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        if (request('mNo')) {
            return (new UpdateMemberRequest())->attributes();
        } else {
            return (new CreateMemberRequest())->attributes();
        }

        return [];
    }
}
