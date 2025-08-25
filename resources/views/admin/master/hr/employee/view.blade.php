@extends('adminlte::page')

@section('title', 'View Employee')

@section('content_header')
    <h1>Employee</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.hr.employee.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form" >
    <div class="card-body">
        <div class="row" >
            <!-- Panel 1 -->
            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:140px;" >
                    <div class="pform-row">
                        <div class="pform-label" >First Name</div>
                        <div class="pform-value" >{{ $employee->first_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Last Name</div>
                        <div class="pform-value" >{{ $employee->last_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Date of Birth</div>
                        <div class="pform-value" >{{ $employee->date_of_birth }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Gender</div>
                        <div class="pform-value" >{{ $employee->sex }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:140px;" >
                    <div class="pform-row" >
                        <div class="pform-label" >Photo</div>
                        <div class="pform-value" >
                            <br/>
                            <img id="photPreview" src="{{ $employee->photo_url }}" alt="Photo Preview"
                                            style="margin-top:10px; max-height: 80px;' }}">
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:200px;">
                    <div class="pform-row" >
                        <div class="pform-label" >Payroll No</div>
                        <div class="pform-value" >{{ $employee->payroll_number }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Company</div>
                        <div class="pform-value" >{{ $employee->company?->company_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Branch</div>
                        <div class="pform-value" >{{ $employee->branch?->branch_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Department</div>
                        <div class="pform-value" >{{ $employee->department?->department_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Designation</div>
                        <div class="pform-value" >{{ $employee->designation?->designation_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Date of Joining</div>
                        <div class="pform-value" >{{ $employee->date_of_joining }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Date of Confirmation</div>
                        <div class="pform-value" >{{ $employee->date_of_confirm }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Date of Leaving</div>
                        <div class="pform-value" >{{ $employee->date_of_leaving }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Years of Experience</div>
                        <div class="pform-value" >{{ $employee->years_of_experience }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:200px;">
                    <div class="pform-row" >
                        <div class="pform-label" >Mobile Number</div>
                        <div class="pform-value" >{{ $employee->mobile_number }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Email-Id</div>
                        <div class="pform-value" >{{ $employee->email_id }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Marital Status</div>
                        <div class="pform-value" >{{ $employee->marital_status }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Father Name</div>
                        <div class="pform-value" >{{ $employee->father_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Mother Name</div>
                        <div class="pform-value" >{{ $employee->mother_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Spouse Name</div>
                        <div class="pform-value" >{{ $employee->spouse_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Present Address</div>
                        <div class="pform-value" >{{ $employee->present_address }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Permanent Address</div>
                        <div class="pform-value" >{{ $employee->permanent_address }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
        </div>

        <div class="row" >
            <!-- Panel 1 -->
            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:140px;" >
                    <div class="pform-row">
                        <div class="pform-label" >Emergency Contact No</div>
                        <div class="pform-value" >{{ $employee->emergency_contact_numbers }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Emergency Contact Person Name</div>
                        <div class="pform-value" >{{ $employee->emergency_contact_person_name }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:140px;" >
                    <div class="pform-row">
                        <div class="pform-label" >PAN No</div>
                        <div class="pform-value" >{{ $employee->pan }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Aadhaar No</div>
                        <div class="pform-value" >{{ $employee->aadhaar_card_no }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >PF No</div>
                        <div class="pform-value" >{{ $employee->pf_no }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >ESI No</div>
                        <div class="pform-value" >{{ $employee->esi_no }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
        </div>
    </div>
</div>
        
@endsection

@section('css')
@stop

@section('js')
<script>

</script>
@stop