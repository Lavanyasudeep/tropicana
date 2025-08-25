@extends('adminlte::page')

@section('title', 'Company')

@section('content_header')
    <h1>Company</h1>
@endsection

@section('content')
@php
   if(isset($company)) {
        $page_title = 'Edit';
        $action = route('admin.master.general.company.update', $company->company_id);
        $method = 'PUT';

        $company_name = $company->company_name;
        $country_id = $company->country_id;
        $state_id = $company->state_id;
        $district_id = $company->district_id;
        $post_office_id = $company->post_office_id;
        $gstin = $company->gstin;
        $logo = asset('storage/'.$company->logo);
        $tin = $company->tin;
        $fssai_no = $company->fssai_no;
        $address = $company->address;
        $phone_number = $company->phone_number;
        $mobile_number = $company->mobile_number;
        $email_id = $company->email_id;
        $website = $company->website;
    } else {
        $page_title = 'Create';
        $action = route('admin.master.general.company.store');
        $method = 'POST';

        $company_name = '';
        $country_id = '';
        $state_id = '';
        $district_id = '';
        $post_office_id = '';
        $gstin = '';
        $logo = '';
        $tin = '';
        $fssai_no = '';
        $address = '';
        $phone_number = '';
        $mobile_number = '';
        $email_id = '';
        $website = '';
    }
@endphp
<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.general.company.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
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
                            <div class="pform-label">Company Name</div>
                            <div class="pform-value">
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $company_name) }}" required>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Contact No.</div>
                            <div class="pform-value">
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $phone_number) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Contact No- 2</div>
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
                    </div>
                    <div class="pform-clear" ></div>
                </div>
                
                <div class="col-md-6">
                    <div class="pform-panel" style="min-height:180px;" >
                        <div class="pform-row">
                            <div class="pform-label">Upload Logo</div>
                            <div class="pform-value">
                                <input type="file" name="logo" id="logo">
                                <br>
                                <img id="logoPreview" src="{{ old('logo', $logo ?? '') }}" alt="Logo Preview"
                                            style="margin-top:10px; max-height: 80px; {{ isset($logo) ? '' : 'display:none;' }}">
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:200px;" >
                        
                        <div class="pform-row">
                            <div class="pform-label">Website</div>
                            <div class="pform-value">
                                <input type="text" name="website" id="website" value="{{ old('website', $website) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">GSTIN</div>
                            <div class="pform-value">
                                <input type="text" name="gstin" id="gstin" value="{{ old('gstin', $gstin) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">TIN</div>
                            <div class="pform-value">
                                <input type="text" name="tin" id="tin" value="{{ old('tin', $tin) }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">FSSAI NO</div>
                            <div class="pform-value">
                                <input type="text" name="fssai_no" id="fssai_no" value="{{ old('fssai_no', $fssai_no) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>

                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:200px;" >
                        
                        <div class="pform-row">
                            <div class="pform-label">Address</div>
                            <div class="pform-value">
                                <textarea name="address" id="address" >{{ old('address', $address) }} </textarea>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Country</div>
                            <div class="pform-value">
                                <select name="country_id" id="country_id">
                                    <option value="">- Select -</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->country_id }}"
                                            @selected(old('country_id', $country_id) == $country->country_id)
                                        >
                                            {{ $country->country_name }}
                                        </option>
                                    @endforeach
                                </select>
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
                            <div class="pform-label">Post Office</div>
                            <div class="pform-value">
                                <select name="post_office_id" id="post_office_id">
                                    <option value="">- Select -</option>
                                    @foreach($postOffices as $postOffice)
                                        <option value="{{ $postOffice->post_office_id }}"
                                            @selected(old('post_office_id', $post_office_id) == $postOffice->post_office_id)
                                        >
                                            {{ $postOffice->post_office }}
                                        </option>
                                    @endforeach
                                </select>
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
