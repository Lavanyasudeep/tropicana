@extends('adminlte::page')

@section('title', 'Supplier')

@section('content_header')
    <h1>Supplier</h1>
@endsection

@section('content')
@php
   if(isset($supplier)) {
        $page_title = 'Edit';
        $action = route('admin.master.purchase.supplier.update', $supplier->supplier_id);
        $method = 'PUT';

        $supplier_name = $supplier->supplier_name;
        $company_id = $supplier->company_id;
        $branch_id = $supplier->branch_id;
        $mobile = $supplier->mobile;
        $email = $supplier->email;
        $password = $supplier->password;
        $supplier_type_id = $supplier->supplier_type_id;
        $supplier_category_id = $supplier->supplier_category_id;
        $supplier_code = $supplier->supplier_code;
        $supplier_invoice_name = $supplier->supplier_invoice_name;
        $country_id = $supplier->country_id;
        $state_id = $supplier->state_id;
        $district_id = $supplier->district_id;
        $city_id = $supplier->city_id;
        $post_office_id = $supplier->post_office_id;
        $pincode = $supplier->pincode;
        $address = $supplier->address;
        $contact_person = $supplier->contact_person;
        $contact_number = $supplier->contact_number;
        $bank_name = $supplier->bank_name;
        $account_number = $supplier->account_number;
        $ifsc_code = $supplier->ifsc_code;
        $rtgs_code = $supplier->rtgs_code;
        $swift_code = $supplier->swift_code;
        $bank_email = $supplier->bank_email;
        $other_details = $supplier->other_details;
        $aadhaar = $supplier->aadhaar;
        $tin = $supplier->tin;
        $cst = $supplier->cst;
        $gstin = $supplier->gstin;
        $credit_days = $supplier->credit_days;
        $credit_limit = $supplier->credit_limit;
        $terms_of_payment = $supplier->terms_of_payment;
        $tax_percentage = $supplier->tax_percentage;
        $discount_type = $supplier->discount_type;
        $discount_terms = $supplier->discount_terms;
        $discount_definition = $supplier->discount_definition;
        $period_of_discount = $supplier->period_of_discount;
        $vendor_grade = $supplier->vendor_grade;
        $supplier_group = $supplier->supplier_group;
        $group_code = $supplier->group_code;
        $currency = $supplier->currency;
        $no_of_days_for_goods_rcv = $supplier->no_of_days_for_goods_rcv;
        $advance = $supplier->advance;
        $without_tax = $supplier->without_tax;
        $is_branch = $supplier->is_branch;
        $tableName = $supplier->getTable(); 
        $rowId = $supplier->supplier_id;
    } else {
        $page_title = 'Create';
        $action = route('admin.master.purchase.supplier.store');
        $method = 'POST';

        $supplier_name = '';
        $company_id = '';
        $branch_id = '';
        $mobile = '';
        $email = '';
        $password = '';
        $supplier_type_id = '';
        $supplier_category_id = '';
        $supplier_code = '';
        $supplier_invoice_name = '';
        $country_id = '';
        $state_id = '';
        $district_id = '';
        $city_id = '';
        $post_office_id = '';
        $pincode = '';
        $address = '';
        $contact_person = '';
        $contact_number = '';
        $bank_name = '';
        $account_number = '';
        $ifsc_code = '';
        $rtgs_code = '';
        $swift_code = '';
        $bank_email = '';
        $other_details = '';
        $aadhaar = '';
        $tin = '';
        $cst = '';
        $gstin = '';
        $credit_days = '';
        $credit_limit = '';
        $terms_of_payment = '';
        $tax_percentage = '';
        $discount_type = '';
        $discount_terms = '';
        $discount_definition = '';
        $period_of_discount = '';
        $vendor_grade = '';
        $supplier_group = '';
        $group_code = '';
        $currency = '';
        $no_of_days_for_goods_rcv = '';
        $advance = '';
        $without_tax = 0;
        $is_branch = 0;
        $tableName = 'cs_supplier';
        $rowId = uniqid();
    }
@endphp
<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.purchase.supplier.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" >
        <li class="nav-item">
            <a class="nav-link active" id="supplier-tab" data-toggle="tab" href="#supplier" role="tab">Supplier</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="supplier-attachment-tab" data-toggle="tab" href="#supplierAttachment" role="tab">Attachment</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="supplier" role="tabpanel">
            <div class="card page-form page-form-add">
                <div class="card-body">
                    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:200px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Supplier Type</div>
                                        <div class="pform-value">
                                            <select name="supplier_type_id" id="supplier_type_id">
                                                <option value="">- Select -</option>
                                                @foreach($supplierTypes as $supplierType)
                                                    <option value="{{ $supplierType->supplier_type_id }}"
                                                        @selected(old('supplier_type_id', $supplier_type_id) == $supplierType->supplier_type_id)
                                                    >
                                                        {{ $supplierType->supplier_type_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Supplier Category</div>
                                        <div class="pform-value">
                                            <select name="supplier_category_id" id="supplier_category_id">
                                                <option value="">- Select -</option>
                                                @foreach($supplierCategories as $supplierCategory)
                                                    <option value="{{ $supplierCategory->supplier_category_id }}"
                                                        @selected(old('supplier_category_id', $supplier_category_id) == $supplierCategory->supplier_category_id)
                                                    >
                                                        {{ $supplierCategory->supplier_category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Supplier Name</div>
                                        <div class="pform-value">
                                            <input type="text" name="supplier_name" id="supplier_name" value="{{ old('supplier_name', $supplier_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Supplier Code</div>
                                        <div class="pform-value">
                                            <input type="text" name="supplier_code" id="supplier_code" value="{{ old('supplier_code', $supplier_code) }}" required>
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
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:200px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Is Branch</div>
                                        <div class="pform-value">
                                            <div class="form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_branch" id="is_branch" value="1" {{ old('is_branch', $is_branch) ? 'checked' : '' }} >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Without Tax</div>
                                        <div class="pform-value">
                                            <div class="form-switch">
                                                <input class="form-check-input" type="checkbox" name="without_tax" id="without_tax" value="1" {{ old('without_tax', $without_tax) ? 'checked' : '' }} >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Vendor Grade</div>
                                        <div class="pform-value">
                                            <select name="vendor_grade" id="vendor_grade">
                                                <option value="">- Select -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Supplier Group</div>
                                        <div class="pform-value">
                                            <select name="supplier_group" id="supplier_group">
                                                <option value="">- Select -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Group Code</div>
                                        <div class="pform-value">
                                            <input type="text" name="group_code" id="group_code" value="{{ old('group_code', $group_code) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:500px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Mobile Number</div>
                                        <div class="pform-value">
                                            <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $mobile) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Email-Id</div>
                                        <div class="pform-value">
                                            <input type="email" name="email" id="email" value="{{ old('email', $email) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Password</div>
                                        <div class="pform-value">
                                            <input type="password" name="password" id="password" value="{{ old('password', $password) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Person</div>
                                        <div class="pform-value">
                                            <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $contact_person) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Number</div>
                                        <div class="pform-value">
                                            <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $contact_number) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Address</div>
                                        <div class="pform-value">
                                            <textarea name="address" id="address" >{{ old('address', $address) }} </textarea>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Pincode</div>
                                        <div class="pform-value">
                                            <textarea name="pincode" id="pincode" >{{ old('pincode', $pincode) }} </textarea>
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
                                <div class="pform-panel" style="min-height: 500px;" >
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
                                        <div class="pform-label">Is Advance</div>
                                        <div class="pform-value">
                                            <div class="form-switch">
                                                <input class="form-check-input" type="checkbox" name="advance" id="advance" value="1" {{ old('advance', $advance) ? 'checked' : '' }} >
                                            </div>
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
                                    <div class="pform-row">
                                        <div class="pform-label">Goods Receive (No. of Days)</div>
                                        <div class="pform-value">
                                            <input type="text" name="no_of_days_for_goods_rcv" id="no_of_days_for_goods_rcv" value="{{ old('no_of_days_for_goods_rcv', $no_of_days_for_goods_rcv) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Terms Of Payment</div>
                                        <div class="pform-value">
                                            <input type="text" name="terms_of_payment" id="terms_of_payment" value="{{ old('terms_of_payment', $terms_of_payment) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Tax Percentage</div>
                                        <div class="pform-value">
                                            <select name="tax_percentage" id="tax_percentage">
                                                <option value="">- Select -</option>
                                                @foreach($taxes as $tax)
                                                    <option value="{{ $tax->tax_id }}"
                                                        @selected(old('tax_percentage', $tax_percentage) == $tax->tax_per)
                                                    >
                                                        {{ $tax->tax_per }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Discount Type</div>
                                        <div class="pform-value">
                                            <input type="text" name="discount_type" id="discount_type" value="{{ old('discount_type', $discount_type) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Discount Terms</div>
                                        <div class="pform-value">
                                            <input type="text" name="discount_terms" id="discount_terms" value="{{ old('discount_terms', $discount_terms) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Discount Definition</div>
                                        <div class="pform-value">
                                            <input type="text" name="discount_definition" id="discount_definition" value="{{ old('discount_definition', $discount_definition) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Period Of Discount</div>
                                        <div class="pform-value">
                                            <input type="text" name="period_of_discount" id="period_of_discount" value="{{ old('period_of_discount', $period_of_discount) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Currency</div>
                                        <div class="pform-value">
                                            <select name="currency" id="currency">
                                                <option value="">- Select -</option>
                                            </select>
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
                                        <div class="pform-label">Bank Name</div>
                                        <div class="pform-value">
                                            <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $bank_name) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Account Number</div>
                                        <div class="pform-value">
                                            <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $account_number) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">IFSC Code</div>
                                        <div class="pform-value">
                                            <input type="text" name="ifsc_code" id="ifsc_code" value="{{ old('ifsc_code', $ifsc_code) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">RTGS Code</div>
                                        <div class="pform-value">
                                            <input type="text" name="rtgs_code" id="rtgs_code" value="{{ old('rtgs_code', $rtgs_code) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">SWIFT Code</div>
                                        <div class="pform-value">
                                            <input type="text" name="swift_code" id="swift_code" value="{{ old('swift_code', $swift_code) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Bank Email</div>
                                        <div class="pform-value">
                                            <input type="email" name="bank_email" id="bank_email" value="{{ old('bank_email', $bank_email) }}" />
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Other Details</div>
                                        <div class="pform-value">
                                            <input type="text" name="other_details" id="other_details" value="{{ old('other_details', $other_details) }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>

                            <div class="col-md-6" >
                            
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

        <div class="tab-pane fade" id="supplierAttachment" role="tabpanel">
            <x-attachment-uploader :tableName="$tableName" :rowId="$rowId" />
        </div>
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
