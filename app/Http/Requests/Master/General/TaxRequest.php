<?php

namespace App\Http\Requests\Master\General;

use Illuminate\Foundation\Http\FormRequest;

class TaxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tax_per' => 'required|numeric|min:0|max:100',
            'gst_input_account_code' => 'nullable|string|max:50',
            'gst_output_account_code' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean', // <-- Add this
        ];
    }
}

