<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get employee_id from route if available (for update scenario)
        $employeeId = $this->route('employee')?->employee_id ?? null;

        return [
            'company_id'        => 'required|exists:cs_company,company_id',
            'branch_id'         => 'required|exists:cs_branch,branch_id',
            'department_id'     => 'nullable|exists:cs_department,department_id',
            'division_id'       => 'nullable|exists:cs_division,division_id',
            'designation_id'    => 'nullable|exists:cs_designation,designation_id',

            'first_name'        => 'required|string|max:200',
            'last_name'         => 'nullable|string|max:200',
            'date_of_birth'     => 'nullable|date|before:today',
            'mobile_number'     => 'nullable|string|max:20',
            'email_id'          => 'nullable|email|max:250|unique:cs_employee,email_id,' . $employeeId . ',employee_id',
            'photo'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'sex'               => 'nullable|in:male,female,other',
            'marital_status'    => 'nullable|in:single,married,divorced,widowed',

            'father_name'       => 'nullable|string|max:250',
            'mother_name'       => 'nullable|string|max:250',
            'spouse_name'       => 'nullable|string|max:100',

            'present_address'   => 'nullable|string',
            'permanent_address' => 'nullable|string',

            'pf_no'             => 'nullable|string|max:50',
            'esi_no'            => 'nullable|string|max:50',
            'pan'               => 'nullable|string|max:50|unique:cs_employee,pan,' . $employeeId . ',employee_id',
            'aadhaar_card_no'   => 'nullable|string|max:20|unique:cs_employee,aadhaar_card_no,' . $employeeId . ',employee_id',

            'emergency_contact_numbers'      => 'nullable|string|max:30',
            'emergency_contact_person_name'  => 'nullable|string|max:250',

            'employee_category_id' => 'nullable|string|max:250',
            'payroll_number'       => 'nullable|string|max:20',
            'years_of_experience'  => 'nullable|numeric|min:0',

            'date_of_joining'      => 'required|date',
            'date_of_confirm'      => 'nullable|date|after_or_equal:date_of_joining',
            'date_of_leaving'      => 'nullable|date|after:date_of_confirm',

            'is_md'        => 'nullable|boolean',
            'verified'     => 'nullable|boolean',
            'active'       => 'nullable|in:1,0',
            'del_status'   => 'nullable|in:1,0',

            'short_name'   => 'nullable|string|max:10',
            'sort_order'   => 'nullable|integer',
        ];
    }
}
