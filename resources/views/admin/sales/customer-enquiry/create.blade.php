@extends('adminlte::page')

@section('title', 'Customer Enquiry')

@section('content_header')
    <h1>Customer Enquiry Form</h1>
@endsection

@section('content')
@php
    $tableName = 'cs_customer_enquiry'; // or your actual table name
    $rowId = 'temp_' . uniqid(); // temporary ID until the form is saved
@endphp
<div class="page-sub-header">
    <h3>Create</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.sales.customer-enquiry.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.sales.customer-enquiry.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Customer Info -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:180px;" >
                        <div class="pform-row">
                            <div class="pform-label">Doc. #</div>
                            <div class="pform-value">
                                <input type="text" name="doc_no" value="{{ old('doc_no') ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc. Date</div>
                            <div class="pform-value">
                                <input type="date" name="doc_date" value="{{ old('doc_date', date('Y-m-d')) }}" readonly >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Status</div>
                            <div class="pform-value" >
                                <select name="status" id="status">
                                    <option value="created" @selected(old('status') == 'created')>Created</option>
                                    <option value="approved" @selected(old('status') == 'approved')>Approved</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>

                <!-- Service Info -->
                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height:180px;" >
                        <div class="pform-row">
                            <div class="pform-label">Existing Customer</div>
                            <div class="pform-value">
                                <select name="customer_id" id="customer_id" class="form-control select2">
                                    <option value="">-- None (Create New) --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>
                                            {{ $customer->customer_name }} - {{ $customer->phone_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Customer Name</div>
                            <div class="pform-value">
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Contact No.</div>
                            <div class="pform-value">
                                <input type="text" name="contact_no" id="contact_no" value="{{ old('contact_no') }}" />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Address</div>
                            <div class="pform-value">
                                <textarea name="address" id="address" >{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>

                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height:180px;" >
                        
                        <div class="pform-row">
                            <div class="pform-label">Type of Service</div>
                            <div class="pform-value">
                                <select name="service_type[]" class="select2" multiple>
                                    <option value="rent">Rent</option>
                                    <option value="packing">Packing</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Type of Items</div>
                            <div class="pform-value">
                                <select name="item_type[]" class="select2" multiple>
                                    <option value="frozen">Frozen</option>
                                    <option value="chilled">Chilled</option>
                                    <option value="dry">Dry</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <!-- Item Description and Remarks -->
            <div class="row">
                <div class="col-md-12">
                    <div class="pform-row">
                        <div class="pform-label w100p" >Item Description</div>
                        <div class="pform-value w100p">
                            <textarea name="item_description" rows="3" >{{ old('item_description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pform-row">
                        <div class="pform-label w100p" >Remarks</div>
                        <div class="pform-value w100p">
                            <textarea name="remarks" rows="3" >{{ old('remarks') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pform-row">
                        <div class="pform-label w100p" >Attachment</div>
                        <div class="pform-value w100p">
                            <div class="attachment">
                                <x-attachment-uploader :tableName="$tableName" :rowId="$rowId" />
                            </div>
                        </div>
                    </div>
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
        $(document).on('change', '#customer_id', function () {
            customerId = $(this).val();

            $('#customer_name').prop('readonly', true);
            $('#contact_no').prop('readonly', true);
            $('#address').prop('readonly', true);

            if(customerId!='') {
                $.post("/admin/master/sales/customer/get-customer-details", {
                    customer_id: customerId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(response) {
                    data = response.customer;

                    $("#customer_name").val(data.customer_name??'');
                    $("#contact_no").val(data.phone_number??'');
                    $("#address").text(data.main_address??'');
                }).fail(function(xhr) {
                    toastr.error(xhr.responseJSON?.message || "Failed to load custoemr details.");
                });
            }
            
        });
    });
</script>
@endsection
