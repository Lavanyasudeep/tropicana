@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>User</h1>
@endsection

@section('content')
@php
   if(isset($user)) {
        $page_title = 'Edit';
        $action = route('admin.master.hr.user.update', $user->id);
        $method = 'PUT';

        $company_id = $user->company_id;
        $branch_id = $user->branch_id;
        $department_id = $user->department_id;
        $employee_id = $user->employee_id;
        $role_id = $user->role_id;
        $name = $user->name;
        $email = $user->email;
        $password = $user->password;
    } else {
        $page_title = 'Create';
        $action = route('admin.master.hr.employee.store');
        $method = 'POST';

        $company_id = '';
        $branch_id = '';
        $department_id = '';
        $employee_id = '';
        $role_id = '';
        $name = '';
        $email = '';
        $password = '';
    }
@endphp
<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.hr.user.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @method($method)
            <div class="row">
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:250px;" >
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
                            <div class="pform-label">Employee</div>
                            <div class="pform-value">
                                <select name="employee_id" id="employee_id">
                                    <option value="">- Select -</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->employee_id }}"
                                            @selected(old('employee_id', $employee_id) == $employee->employee_id)
                                        >
                                            {{ $employee->emp_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Role</div>
                            <div class="pform-value">
                                <select name="role_id" id="role_id">
                                    <option value="">- Select -</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->role_id }}"
                                            @selected(old('role_id', $role_id) == $role->role_id)
                                        >
                                            {{ $role->role_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">User Name</div>
                            <div class="pform-value">
                                <input type="text" name="name" id="name" value="{{ old('name', $name) }}" >
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">User Email</div>
                            <div class="pform-value">
                                <input type="email" name="email" id="email" value="{{ old('email', $email) }}" >
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Password</div>
                            <div class="pform-value">
                                <input type="password" name="password" id="password" value="{{ old('password', $password) }}" >
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
