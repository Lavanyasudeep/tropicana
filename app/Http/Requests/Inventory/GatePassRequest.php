<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class GatePassRequest extends FormRequest
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
            'doc_date' => ['required', 'date'],
            'status' => ['required', 'in:created,approved'],
            'client_id' => ['required', 'exists:cs_client,client_id'],
            'vehicle_no' => ['required', 'string'],
            'movement_type' => ['required', 'in:inward,outward,returnable,non_returnable'],
            'driver_name' => ['nullable', 'string'],
            'transport_mode' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_name' => ['required', 'string'],
            'items.*.uom' => ['required', 'string'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.expected_return_date' => ['nullable', 'date'],
        ];
    }
}
