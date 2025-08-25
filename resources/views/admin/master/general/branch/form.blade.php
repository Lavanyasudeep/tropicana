@extends('adminlte::page')

@section('title', 'Branch')

@section('content_header')
    <h1>Branch</h1>
@endsection

@section('content')
@php
   if(isset($branch)) {
        $page_title = 'Edit';
        $action = route('admin.master.general.branch.update', $branch->branch_id);
        $method = 'PUT';

        $branch_name = $branch->branch_name;
        $company_id = $branch->company_id;
        $state_id = $branch->state_id;
        $district_id = $branch->district_id;
        $pincode = $branch->pincode;
        $address1 = $branch->address1;
        $phone_number = $branch->phone_number;
        $email_id = $branch->email_id;
        $contact_name = $branch->contact_name;
        $designation = $branch->designation;
    } else {
        $page_title = 'Create';
        $action = route('admin.master.general.branch.store');
        $method = 'POST';

        $branch_name = '';
        $company_id = '';
        $state_id = '';
        $district_id = '';
        $pincode = '';
        $address1 = '';
        $phone_number = '';
        $mobile_number = '';
        $email_id = '';
        $contact_name = '';
        $designation = '';
    }
@endphp
<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.general.branch.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
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
                            <div class="pform-label">Branch Name</div>
                            <div class="pform-value">
                                <input type="text" name="branch_name" id="branch_name" value="{{ old('branch_name', $branch_name) }}" required>
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
                            <div class="pform-label">Contact No.</div>
                            <div class="pform-value">
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $phone_number) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Email-Id</div>
                            <div class="pform-value">
                                <input type="text" name="email_id" id="email_id" value="{{ old('email_id', $email_id) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
                
                <div class="col-md-6">
                    <div class="pform-panel" style="min-height:180px;" >
                        <div class="pform-row">
                            <div class="pform-label">Address</div>
                            <div class="pform-value">
                                <textarea name="address1" id="address1" >{{ old('address1', $address1) }} </textarea>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">State</div>
                            <div class="pform-value">
                                <select name="state_id" id="state_id">
                                    <option value="">- Select -</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->state_id }}"
                                            @selected(old('state_id', $state_id) == $state->state_id)
                                        >
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">District</div>
                            <div class="pform-value">
                                <select name="district_id" id="district_id">
                                    <option value="">- Select -</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->district_id }}"
                                            @selected(old('district_id', $district_id) == $district->district_id)
                                        >
                                            {{ $district->district_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Pincode</div>
                            <div class="pform-value">
                                <input type="text" name="pincode" id="pincode" value="{{ old('pincode', $pincode) }}" />
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
    document.getElementById('logo').addEventListener('change', function (event) {
        const [file] = this.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('logoPreview');
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
