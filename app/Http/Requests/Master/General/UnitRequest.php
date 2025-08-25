<?php

namespace App\Http\Requests\Master\General;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unit' => 'required|string|max:100',
            'short_name' => 'required|string|max:20',
            'description' => 'nullable|string',
            'conversion_unit' => 'nullable|string',
            'conversion_quantity' => 'nullable|string',
            'sign' => 'nullable|string',
        ];
    }
}
