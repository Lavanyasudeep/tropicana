<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

class CustomerEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doc_date' => 'required|date',
            'status' => 'required|in:created,approved,paid',

            // Either existing customer_id or new customer name is required
            'customer_id' => 'nullable|exists:cs_customer,customer_id',
            'customer_name' => 'required_without:customer_id|string|max:255',
            'contact_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',

            'service_type' => 'nullable|array',
            'service_type.*' => 'in:rent,packing',

            'item_type' => 'nullable|array',
            'item_type.*' => 'in:frozen,chilled,dry',

            'description' => 'nullable|string|max:2000',
            'remarks' => 'nullable|string|max:2000',
        ];
    }

}
