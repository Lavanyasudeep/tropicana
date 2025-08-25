@extends('adminlte::page')

@section('title', 'View User')

@section('content_header')
    <h1>User</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.hr.user.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form" >
    <div class="card-body">
        <div class="row" >
            <!-- Panel 1 -->
            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:140px;" >
                    <div class="pform-row">
                        <div class="pform-label" >Company Name</div>
                        <div class="pform-value" >{{ $user->company->company_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Branch</div>
                        <div class="pform-value" >{{ $user->branch->branch_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Employee Name</div>
                        <div class="pform-value" >{{ $user->employee->employee_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Designation</div>
                        <div class="pform-value" >{{ $user->employee->designation?->designation_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Role</div>
                        <div class="pform-value" >{{ $user->role->role_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >User Name</div>
                        <div class="pform-value" >{{ $user->name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Email</div>
                        <div class="pform-value" >{{ $user->email }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Password</div>
                        <div class="pform-value" >{{ $user->password ? '********' : 'Not Set' }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:200px;">
                    <div class="pform-row" >
                        <div class="pform-label" >Mobile Number</div>
                        <div class="pform-value" >{{ $user->employee->mobile_number }}</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label" >Emergency Contact No</div>
                        <div class="pform-value" >{{ $user->employee->emergency_contact_numbers }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Emergency Contact Person Name</div>
                        <div class="pform-value" >{{ $user->employee->emergency_contact_person_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Permanent Address</div>
                        <div class="pform-value" >{{ $user->employee->permanent_address }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Present Address</div>
                        <div class="pform-value" >{{ $user->employee->present_address }}</div>
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