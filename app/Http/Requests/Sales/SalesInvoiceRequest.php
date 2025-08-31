<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

class SalesInvoiceRequest extends FormRequest
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
            'doc_date' => 'required|date',
            'status' => 'required|string',
            'customer_id' => 'nullable|exists:cs_customer,customer_id',
            'customer_name' => 'required|string|max:255',
            'customer_contact_no' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string',
            'service_type' => 'nullable|array',
            //'items' => 'required|array|min:1',
            'total_amount' => 'required|numeric|min:0',
            'cgst_amount' => 'nullable|numeric|min:0',
            'sgst_amount' => 'nullable|numeric|min:0',
            'igst_amount' => 'nullable|numeric|min:0',
            'grand_amount' => 'required|numeric|min:0',
        ];
    }
}
