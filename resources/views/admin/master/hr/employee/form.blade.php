@extends('adminlte::page')

@section('title', 'Employee')

@section('content_header')
    <h1>Employee</h1>
@endsection

@section('content')
@php
   if(isset($employee)) {
        $page_title = 'Edit';
        $action = route('admin.master.hr.employee.update', $employee->employee_id);
        $method = 'PUT';

        $employee_name = $employee->employee_name;
        $company_id = $employee->company_id;
        $branch_id = $employee->branch_id;
        $department_id = $employee->department_id;
        $division_id = $employee->division_id;
        $first_name = $employee->first_name;
        $last_name = $employee->last_name;
        $date_of_birth = $employee->date_of_birth;
        $mobile_number = $employee->mobile_number;
        $email_id = $employee->email_id;
        $photo = $employee->photo_url;
        $sex = $employee->sex;
        $marital_status = $employee->marital_status;
        $father_name = $employee->father_name;
        $mother_name = $employee->mother_name;
        $spouse_name = $employee->spouse_name;
        $present_address = $employee->present_address;
        $permanent_address = $employee->permanent_address;
        $pf_no = $employee->pf_no;
        $esi_no = $employee->esi_no;
        $pan = $employee->pan;
        $aadhaar_card_no = $employee->aadhaar_card_no;
        $emergency_contact_numbers = $employee->emergency_contact_numbers;
        $emergency_contact_person_name = $employee->emergency_contact_person_name;
        $payroll_number = $employee->payroll_number;
        $years_of_experience = $employee->years_of_experience;
        $date_of_joining = $employee->date_of_joining;
        $date_of_confirm = $employee->date_of_confirm;
        $date_of_leaving = $employee->date_of_leaving;
        $designation_id = $employee->designation_id;
        $is_md = $employee->is_md;
    } else {
        $page_title = 'Create';
        $action = route('admin.master.hr.employee.store');
        $method = 'POST';

        $employee_name = '';
        $company_id = '';
        $branch_id = '';
        $department_id = '';
        $division_id = '';
        $first_name = '';
        $last_name = '';
        $date_of_birth = '';
        $mobile_number = '';
        $email_id = '';
        $photo = '';
        $sex = '';
        $marital_status = '';
        $father_name = '';
        $mother_name = '';
        $spouse_name = '';
        $present_address = '';
        $permanent_address = '';
        $pf_no = '';
        $esi_no = '';
        $pan = '';
        $aadhaar_card_no = '';
        $emergency_contact_numbers = '';
        $emergency_contact_person_name = '';
        $payroll_number = '';
        $years_of_experience = '';
        $date_of_joining = '';
        $date_of_confirm = '';
        $date_of_leaving = '';
        $designation_id = '';
        $is_md = '';
    }
@endphp
<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.hr.employee.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @method($method)
            <div class="row">
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:180px;" >
                        <div class="pform-row">
                            <div class="pform-label">First Name</div>
                            <div class="pform-value">
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $first_name) }}" required>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Last Name</div>
                            <div class="pform-value">
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $last_name) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Date of Birth</div>
                            <div class="pform-value">
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $date_of_birth) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Gender</div>
                            <div class="pform-value">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" id="male" value="male" checked>
                                    <label class="form-check-label" for="male"><strong>Male</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" id="female" value="female">
                                    <label class="form-check-label" for="female"><strong>Female</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" id="other" value="other">
                                    <label class="form-check-label" for="other"><strong>Other</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
                
                <div class="col-md-6">
                    <div class="pform-panel" style="min-height:180px;" >
                        <div class="pform-row">
                            <div class="pform-label">Upload Photo</div>
                            <div class="pform-value">
                                <input type="file" name="photo" id="photo">
                                <br>
                                <img id="photoPreview" src="{{ old('photo', $photo ?? '') }}" alt="Photo Preview"
                                            style="margin-top:10px; max-height: 80px; {{ isset($photo) ? '' : 'display:none;' }}">
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:320px;" >
                        <div class="pform-row">
                            <div class="pform-label">Payroll No</div>
                            <div class="pform-value">
                                <input type="text" id="payroll_number" value="{{ old('payroll_number', $payroll_number) }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Company</div>
                            <div class="pform-value">
                                <select name="company_id" id="company_id">
                                    <option value="">- Select -</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->company_id }}"
                                            @selected(old('company_id', $company_id) == $company->company_id)
                                        >
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Branch</div>
                            <div class="pform-value">
                                <select name="branch_id" id="branch_id">
                                    <option value="">- Select -</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->branch_id }}"
                                            @selected(old('branch_id', $branch_id) == $branch->branch_id)
                                        >
                                            {{ $branch->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Department</div>
                            <div class="pform-value">
                                <select name="department_id" id="department_id">
                                    <option value="">- Select -</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->department_id }}"
                                            @selected(old('department_id', $department_id) == $department->department_id)
                                        >
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Designation</div>
                            <div class="pform-value">
                                <select name="designation_id" id="designation_id">
                                    <option value="">- Select -</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->designation_id }}"
                                            @selected(old('designation_id', $designation_id) == $designation->designation_id)
                                        >
                                            {{ $designation->designation_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Date of Joining</div>
                            <div class="pform-value">
                                <input type="date" name="date_of_joining" id="date_of_joining" value="{{ old('date_of_joining', $date_of_joining) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Date of Confirmation</div>
                            <div class="pform-value">
                                <input type="date" name="date_of_confirm" id="date_of_confirm" value="{{ old('date_of_confirm', $date_of_confirm) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Date of Leaving</div>
                            <div class="pform-value">
                                <input type="date" name="date_of_leaving" id="date_of_leaving" value="{{ old('date_of_leaving', $date_of_leaving) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Years of Experience</div>
                            <div class="pform-value">
                                <input type="number" name="years_of_experience" id="years_of_experience" value="{{ old('years_of_experience', $years_of_experience) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>

                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:320px;" >
                        
                        <div class="pform-row">
                            <div class="pform-label">Mobile Number</div>
                            <div class="pform-value">
                                <input type="text" name="mobile_number" id="mobile_number" value="{{ old('mobile_number', $mobile_number) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Email-Id</div>
                            <div class="pform-value">
                                <input type="text" name="email_id" id="email_id" value="{{ old('email_id', $email_id) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Marital Status</div>
                            <div class="pform-value">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="marital_status" id="single" value="single" checked>
                                    <label class="form-check-label" for="single"><strong>Single</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="marital_status" id="married" value="married">
                                    <label class="form-check-label" for="married"><strong>Married</strong></label>
                                </div>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Father Name</div>
                            <div class="pform-value">
                                <input type="text" name="father_name" id="father_name" value="{{ old('father_name', $father_name) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Mother Name</div>
                            <div class="pform-value">
                                <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', $mother_name) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Spouse Name</div>
                            <div class="pform-value">
                                <input type="text" name="spouse_name" id="spouse_name" value="{{ old('spouse_name', $spouse_name) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Present Address</div>
                            <div class="pform-value">
                                <textarea name="present_address" id="present_address" >{{ old('present_address', $present_address) }} </textarea>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Permanent Address</div>
                            <div class="pform-value">
                                <textarea name="permanent_address" id="permanent_address" >{{ old('permanent_address', $permanent_address) }} </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:150px;" >
                        <div class="pform-row">
                            <div class="pform-label">Emergency Contact No</div>
                            <div class="pform-value">
                                <input type="text" name="emergency_contact_numbers" id="emergency_contact_numbers" value="{{ old('emergency_contact_numbers', $emergency_contact_numbers) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Emergency Contact Person Name</div>
                            <div class="pform-value">
                                <input type="text" name="emergency_contact_person_name" id="emergency_contact_person_name" value="{{ old('emergency_contact_person_name', $emergency_contact_person_name) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>

                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:150px;" >
                        <div class="pform-row">
                            <div class="pform-label">PAN No</div>
                            <div class="pform-value">
                                <input type="text" name="pan" id="pan" value="{{ old('pan', $pan) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Aadhaar No</div>
                            <div class="pform-value">
                                <input type="text" name="aadhaar_card_no" id="aadhaar_card_no" value="{{ old('aadhaar_card_no', $aadhaar_card_no) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">PF No</div>
                            <div class="pform-value">
                                <input type="text" name="pf_no" id="pf_no" value="{{ old('pf_no', $pf_no) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">ESI No</div>
                            <div class="pform-value">
                                <input type="text" name="esi_no" id="esi_no" value="{{ old('esi_no', $esi_no) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
            <!-- Submit -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-save float-right">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    document.getElementById('photo').addEventListener('change', function (event) {
        const [file] = this.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('photoPreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    $(document).ready(function () {
        $(document).on('change', '#country_id', function () {
            countryId = $(this).val();

            if(countryId!='') {
                $.post("/admin/master/general/state/get-state-list", {
                    country_id: countryId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(response) {
                    let stateDropdown = $('#state_id');
                    stateDropdown.empty();
                    stateDropdown.append(`<option value="">- Select -</option>`);
                    $.each(response.state, function(key, state) {
                        stateDropdown.append(`<option value="${state.state_id}">${state.state_name}</option>`);
                    });
                }).fail(function(xhr) {
                    toastr.error(xhr.responseJSON?.message || "Failed to load state lists.");
                });
            }
            
        });
    });
</script>
@endsection
