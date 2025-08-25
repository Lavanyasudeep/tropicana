@extends('adminlte::page')

@section('title', 'Customer')

@section('content_header')
    <h1>Customer</h1>
@endsection

@section('content')
@php
   if(isset($customer)) {
        $page_title = 'Edit';
        $action = route('admin.master.sales.customer.update', $customer->customer_id);
        $method = 'PUT';

        $customer_name = $customer->customer_name;
        $company_id = $customer->company_id;
        $branch_id = $customer->branch_id;
        $phone_number = $customer->phone_number;
        $phone_number2 = $customer->phone_number2;
        $email = $customer->email;
        $fax = $customer->fax;
        $website = $customer->website;
        $password = $customer->password;
        $photo = $customer->photo_url;
        $place_id = $customer->place_id;
        $route_id = $customer->route_id;
        $post_office_id = $customer->post_office_id;
        $place_id = $customer->place_id;
        $city_id = $customer->city_id;
        $district_id = $customer->district_id;
        $state_id = $customer->state_id;
        $main_address = $customer->main_address;
        $pincode = $customer->pincode;
        $contact_person = $customer->contact_person;
        $tin = $customer->tin;
        $pan = $customer->pan;
        $aadhaar = $customer->aadhaar;
        $cst = $customer->cst;
        $gstin = $customer->gstin;
        $sez = $customer->sez;
        $shipping_address = $customer->shipping_address;
        $shipping_district_id = $customer->shipping_district_id;
        $shipping_state_id = $customer->shipping_state_id;
        $shipping_city_id = $customer->shipping_city_id;
        $shipping_phonenumber = $customer->shipping_phonenumber;
        $shipping_fax = $customer->shipping_fax;
        $shipping_email = $customer->shipping_email;
        $billing_address = $customer->billing_address;
        $billing_district_id = $customer->billing_district_id;
        $billing_state_id = $customer->billing_state_id;
        $billing_city_id = $customer->billing_city_id;
        $credit_days = $customer->credit_days;
        $credit_limit = $customer->credit_limit;
        $tableName = $customer->getTable(); 
        $rowId = $customer->customer_id;
    } else {
        $page_title = 'Create';
        $action = route('admin.master.sales.customer.store');
        $method = 'POST';

        $customer_name = '';
        $company_id = '';
        $branch_id = '';
        $phone_number = '';
        $phone_number2 = '';
        $email = '';
        $fax = '';
        $website = '';
        $password = '';
        $photo = '';
        $place_id = '';
        $route_id = '';
        $post_office_id = '';
        $city_id = '';
        $district_id = '';
        $state_id = '';
        $main_address = '';
        $pincode = '';
        $contact_person = '';
        $tin = '';
        $pan = '';
        $aadhaar = '';
        $cst = '';
        $gstin = '';
        $sez = '';
        $shipping_address = '';
        $shipping_district_id = '';
        $shipping_state_id = '';
        $shipping_city_id = '';
        $shipping_phonenumber = '';
        $shipping_fax = '';
        $shipping_email = '';
        $billing_address = '';
        $billing_district_id = '';
        $billing_state_id = '';
        $billing_city_id = '';
        $credit_days = '';
        $credit_limit = '';
        $tableName = 'cs_customer';
        $rowId = uniqid();
    }
@endphp
<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.sales.customer.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" >
        <li class="nav-item">
            <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer" role="tab">Customer</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="customer-attachment-tab" data-toggle="tab" href="#customerAttachment" role="tab">Attachment</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="customer" role="tabpanel">
            <div class="card page-form page-form-add">
                <div class="card-body">
                    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:200px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Customer Name</div>
                                        <div class="pform-value">
                                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $customer_name) }}" required>
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
                                        <div class="pform-label">Mobile Number</div>
                                        <div class="pform-value">
                                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $phone_number) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Email-Id</div>
                                        <div class="pform-value">
                                            <input type="text" name="email" id="email" value="{{ old('email', $email) }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:200px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Upload Photo</div>
                                        <div class="pform-value">
                                            <input type="file" name="photo" id="photo">
                                            <br>
                                            <img id="photoPreview" src="{{ old('photo', $photo ?? '') }}" alt="Photo Preview"
                                                        style="margin-top:10px; max-height: 80px; {{ isset($photo) ? '' : 'display:none;' }}">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Website</div>
                                        <div class="pform-value">
                                            <input type="text" name="website" id="website" value="{{ old('website', $website) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Password</div>
                                        <div class="pform-value">
                                            <input type="password" name="password" id="password" value="{{ old('password', $password) }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:350px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Phone Number 2</div>
                                        <div class="pform-value">
                                            <input type="text" name="phone_number2" id="phone_number2" value="{{ old('phone_number2', $phone_number2) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Person</div>
                                        <div class="pform-value">
                                            <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $contact_person) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Address</div>
                                        <div class="pform-value">
                                            <textarea name="main_address" id="main_address" >{{ old('main_address', $main_address) }} </textarea>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Pincode</div>
                                        <div class="pform-value">
                                            <textarea name="pincode" id="pincode" >{{ old('pincode', $pincode) }} </textarea>
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
                                        <div class="pform-label">City</div>
                                        <div class="pform-value">
                                            <select name="city_id" id="city_id">
                                                <option value="">- Select -</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->city_id }}"
                                                        @selected(old('city_id', $city_id) == $city->city_id)
                                                    >
                                                        {{ $city->city_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Place</div>
                                        <div class="pform-value">
                                            <select name="place_id" id="place_id">
                                                <option value="">- Select -</option>
                                                @foreach($places as $place)
                                                    <option value="{{ $place->place_id }}"
                                                        @selected(old('place_id', $place_id) == $place->place_id)
                                                    >
                                                        {{ $place->cplace_name }}
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

                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:350px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Fax</div>
                                        <div class="pform-value">
                                            <input type="text" name="fax" id="fax" value="{{ old('fax', $fax) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">PAN No</div>
                                        <div class="pform-value">
                                            <input type="text" name="pan" id="pan" value="{{ old('pan', $pan) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Aadhaar No</div>
                                        <div class="pform-value">
                                            <input type="text" name="aadhaar" id="aadhaar" value="{{ old('aadhaar', $aadhaar) }}" />
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
                                        <div class="pform-label">CST</div>
                                        <div class="pform-value">
                                            <input type="text" name="cst" id="cst" value="{{ old('cst', $cst) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">SEZ</div>
                                        <div class="pform-value">
                                            <input type="text" name="sez" id="sez" value="{{ old('sez', $sez) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Credit Days</div>
                                        <div class="pform-value">
                                            <input type="text" name="credit_days" id="credit_days" value="{{ old('credit_days', $credit_days) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Credit Limit</div>
                                        <div class="pform-value">
                                            <input type="text" name="credit_limit" id="credit_limit" value="{{ old('credit_limit', $credit_limit) }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:300px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Shipping Address</div>
                                        <div class="pform-value">
                                            <textarea name="shipping_address" id="shipping_address" >{{ old('shipping_address', $shipping_address) }} </textarea>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Shipping State</div>
                                        <div class="pform-value">
                                            <select name="shipping_state_id" id="shipping_state_id">
                                                <option value="">- Select -</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->state_id }}"
                                                        @selected(old('shipping_state_id', $shipping_state_id) == $state->state_id)
                                                    >
                                                        {{ $state->state_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Shipping District</div>
                                        <div class="pform-value">
                                            <select name="shipping_district_id" id="shipping_district_id">
                                                <option value="">- Select -</option>
                                                @foreach($districts as $district)
                                                    <option value="{{ $district->district_id }}"
                                                        @selected(old('shipping_district_id', $shipping_district_id) == $district->district_id)
                                                    >
                                                        {{ $district->district_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Shipping City</div>
                                        <div class="pform-value">
                                            <select name="shipping_city_id" id="shipping_city_id">
                                                <option value="">- Select -</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->city_id }}"
                                                        @selected(old('shipping_city_id', $shipping_city_id) == $city->city_id)
                                                    >
                                                        {{ $city->city_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Shipping Phone Number</div>
                                        <div class="pform-value">
                                            <input type="text" name="shipping_phonenumber" id="shipping_phonenumber" value="{{ old('shipping_phonenumber', $shipping_phonenumber) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Shipping Email-Id</div>
                                        <div class="pform-value">
                                            <input type="text" name="shipping_email" id="shipping_email" value="{{ old('shipping_email', $shipping_email) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Shipping FAX</div>
                                        <div class="pform-value">
                                            <input type="text" name="shipping_fax" id="shipping_fax" value="{{ old('shipping_fax', $shipping_fax) }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>

                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:300px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Billing Address</div>
                                        <div class="pform-value">
                                            <textarea name="billing_address" id="billing_address" >{{ old('billing_address', $billing_address) }} </textarea>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Billing State</div>
                                        <div class="pform-value">
                                            <select name="billing_state_id" id="billing_state_id">
                                                <option value="">- Select -</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->state_id }}"
                                                        @selected(old('billing_state_id', $billing_state_id) == $state->state_id)
                                                    >
                                                        {{ $state->state_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Billing District</div>
                                        <div class="pform-value">
                                            <select name="billing_district_id" id="billing_district_id">
                                                <option value="">- Select -</option>
                                                @foreach($districts as $district)
                                                    <option value="{{ $district->district_id }}"
                                                        @selected(old('billing_district_id', $billing_district_id) == $district->district_id)
                                                    >
                                                        {{ $district->district_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Billing City</div>
                                        <div class="pform-value">
                                            <select name="billing_city_id" id="billing_city_id">
                                                <option value="">- Select -</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->city_id }}"
                                                        @selected(old('billing_city_id', $billing_city_id) == $city->city_id)
                                                    >
                                                        {{ $city->city_name }}
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
        </div>

        <div class="tab-pane fade" id="customerAttachment" role="tabpanel">
            <x-attachment-uploader :tableName="$tableName" :rowId="$rowId" />
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
