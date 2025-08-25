<?php

namespace App\Http\Requests\Master\Sales;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'company_id' => 'required|integer|exists:cs_company,company_id',
            'branch_id' => 'required|integer|exists:cs_branch,branch_id',
            'customer_type_id' => 'nullable|integer',
            'customer_name' => 'required|string|max:150',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'customer_cat_id' => 'nullable|integer',
            'contact_person' => 'nullable|string|max:100',
            'main_address' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:100',
            'place_id' => 'nullable|integer|exists:cs_place,place_id',
            'route_id' => 'nullable|integer',
            'post_office_id' => 'nullable|integer|exists:cs_post_office,post_office_id',
            'city_id' => 'nullable|integer|exists:cs_city,city_id',
            'district_id' => 'nullable|integer|exists:cs_district,district_id',
            'state_id' => 'nullable|integer|exists:cs_state,state_id',
            'pincode' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:250',
            'phone_number2' => 'nullable|string|max:250',
            'fax' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:255',
            'password' => 'nullable|string|min:6|max:100',
            'short_name' => 'nullable|string|max:100',

            // Shipping address
            'shipping_address' => 'nullable|string|max:255',
            'shipping_district_id' => 'nullable|integer|exists:cs_district,district_id',
            'shipping_state_id' => 'nullable|integer|exists:cs_state,state_id',
            'shipping_city_id' => 'nullable|integer|exists:cs_city,city_id',
            'shipping_phonenumber' => 'nullable|string|max:250',
            'shipping_fax' => 'nullable|string|max:100',
            'shipping_email' => 'nullable|email|max:100',

            // Billing address
            'billing_address' => 'nullable|string|max:255',
            'billing_district_id' => 'nullable|integer|exists:cs_district,district_id',
            'billing_state_id' => 'nullable|integer|exists:cs_state,state_id',
            'billing_city_id' => 'nullable|integer|exists:cs_city,city_id',

            'credit_days' => 'nullable|integer|min:0',
            'credit_limit' => 'nullable|numeric|min:0',
            'tin' => 'nullable|string|max:45',
            'aadhaar' => 'nullable|string|max:30',
            'pan' => 'nullable|string|max:45',
            'cst' => 'nullable|string|max:45',
            'gstin' => 'nullable|string|max:100',
            'sez' => 'nullable|string|max:45',
            'currency' => 'nullable|string|max:10',
            'payment_terms' => 'nullable|string|max:255',
            'payment_terms_by' => 'nullable|string|max:45',
            'image_trade_license' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}