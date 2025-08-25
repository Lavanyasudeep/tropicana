<?php

namespace App\Http\Requests\Master\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('admin.master.inventory.product-attributes.update') ?? $this->id;

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('cs_product_attributes', 'name')->ignore($id, 'product_attribute_id'),
            ],
            'data_type' => 'required|string|in:text,integer,decimal,boolean,date,enum',
            'is_required' => 'nullable|boolean',
            'default_value' => 'nullable|string|max:255',
        ];
    }
}
