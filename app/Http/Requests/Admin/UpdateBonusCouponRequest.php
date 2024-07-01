<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBonusCouponRequest extends FormRequest
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
            'coupon_bonus.roulette' => [
                'required',
                'array',
                function ($attribute, $array, $fail) {
                    $totalPercent = 0;
                    foreach ($array as $value) {
                        $totalPercent += (float) $value['percent'];
                    }
                    if ($totalPercent != 100) {
                        $fail("The total percentage must be equal to 100%. Current total: $totalPercent%.");
                    }
                },
            ]
        ];
    }
}
