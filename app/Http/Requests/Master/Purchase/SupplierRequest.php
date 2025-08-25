<?php

namespace App\Http\Requests\Master\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id_data_mig' => 'nullable|string|max:11',
            'company_id' => 'nullable|integer',
            'branch_id' => 'nullable|integer',
            'supplier_type_id' => 'nullable|integer',
            'supplier_category_id' => 'nullable|integer',
            'supplier_code' => 'nullable|string|max:45',
            'supplier_name' => 'required|string|max:150',
            'supplier_invoice_name' => 'nullable|string',
            'contact_person' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:250',
            'mobile' => 'nullable|string|max:250',
            'address' => 'nullable|string',
            'post_office_id' => 'nullable|integer',
            'pincode' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100',
            'aadhaar' => 'nullable|string|max:30',
            'city_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'country_id' => 'nullable|integer',
            'bank_name' => 'nullable|string|max:45',
            'account_number' => 'nullable|string|max:250',
            'ifsc_code' => 'nullable|string|max:50',
            'rtgs_code' => 'nullable|string|max:45',
            'swift_code' => 'nullable|string|max:45',
            'bank_email' => 'nullable|email|max:45',
            'other_details' => 'nullable|string|max:300',
            'terms_of_payment' => 'nullable|string|max:100',
            'tax_percentage' => 'nullable|numeric',
            'discount_type' => 'nullable|string|max:45',
            'discount_terms' => 'nullable|string|max:45',
            'discount_definition' => 'nullable|string|max:45',
            'period_of_discount' => 'nullable|integer',
            'attachments' => 'nullable|string|max:200',
            'vendor_grade' => 'nullable|string|max:45',
            'supplier_group' => 'nullable|string|max:45',
            'group_code' => 'nullable|string|max:30',
            'currency' => 'nullable|string|max:5',
            'tin' => 'nullable|string|max:50',
            'cst' => 'nullable|string|max:50',
            'credit_days' => 'nullable|integer',
            'credit_limit' => 'nullable|numeric',
            'gstin' => 'nullable|string|max:100',
            'no_of_days_for_goods_rcv' => 'nullable|integer|min:0',
            'active' => 'nullable|in:0,1',
            'del_status' => 'nullable|in:0,1',
            'short_name' => 'nullable|string',
            'password' => 'nullable|string',
            'advance' => 'nullable|in:0,1',
            'without_tax' => 'nullable|in:0,1',
            'is_branch' => 'nullable|in:0,1',
            'created_by' => 'nullable|integer',
            'created_date' => 'nullable|date',
        ];
    }
}
