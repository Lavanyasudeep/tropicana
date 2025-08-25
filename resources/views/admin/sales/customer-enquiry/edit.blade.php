@extends('adminlte::page')

@section('title', 'Edit Customer Enquiry')

@section('content_header')
    <h1>Edit Customer Enquiry</h1>
@endsection

@section('content')
@php
    $tableName = 'customer_enquiries';
    $rowId = $customerEnquiry->customer_enquiry_id; // Use existing ID for attachment uploader
@endphp

<div class="page-sub-header">
    <h3>Edit</h3>
    <div class="action-btns">
        <a href="{{ route('admin.sales.customer-enquiry.index') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" >
        <li class="nav-item">
            <a class="nav-link active" id="enquiry-tab" data-toggle="tab" href="#enquiry" role="tab">Enquiry</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="enquiry-attachment-tab" data-toggle="tab" href="#enquiryAttachment" role="tab">Attachment</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="enquiry" role="tabpanel">
            <div class="card page-form page-form-add">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.sales.customer-enquiry.update', $customerEnquiry->customer_enquiry_id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Customer Info -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height:140px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Doc. #</div>
                                        <div class="pform-value">
                                            <input type="text" name="doc_no" value="{{ old('doc_no', $customerEnquiry->doc_no) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Doc. Date</div>
                                        <div class="pform-value">
                                            <input type="date" name="doc_date" value="{{ old('doc_date', $customerEnquiry->doc_date ? $customerEnquiry->doc_date : '') }}" readonly >
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Status</div>
                                        <div class="pform-value">
                                            <select name="status" id="status">
                                                <option value="created" @selected(old('status', $customerEnquiry->status) == 'created')>Created</option>
                                                <option value="approved" @selected(old('status', $customerEnquiry->status) == 'approved')>Approved</option>
                                                <option value="paid" @selected(old('status', $customerEnquiry->status) == 'paid')>Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Info -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height:140px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Customer Name</div>
                                        <div class="pform-value">
                                            <input type="text" name="customer_name" value="{{ old('customer_name', $customerEnquiry->customer?->customer_name) }}" required >
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact No.</div>
                                        <div class="pform-value">
                                            <input type="text" name="contact_no" value="{{ old('contact_no', $customerEnquiry->customer?->phone_number) }}">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Address</div>
                                        <div class="pform-value">
                                            <textarea name="address">{{ old('address', $customerEnquiry->customer?->main_address) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service & Item Type -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height:140px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Type of Service</div>
                                        <div class="pform-value">
                                            @php
                                                $selectedServiceTypes = old('item_type', isset($customerEnquiry) ? explode(',', $customerEnquiry->service_type) : []);
                                            @endphp
                                            <select name="service_type[]" class="select2" multiple>
                                                <option value="rent" @selected(in_array('rent', $selectedServiceTypes)) >Rent</option>
                                                <option value="packing" @selected(in_array('packing', $selectedServiceTypes)) >Packing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Type of Items</div>
                                        <div class="pform-value">
                                            @php
                                                $selectedItemTypes = old('item_type', isset($customerEnquiry) ? explode(',', $customerEnquiry->item_type) : []);
                                            @endphp
                                            <select name="item_type[]" class="select2" multiple>
                                                <option value="frozen" @selected(in_array('frozen', $selectedItemTypes)) >Frozen</option>
                                                <option value="chilled" @selected(in_array('chilled', $selectedItemTypes)) >Chilled</option>
                                                <option value="dry" @selected(in_array('dry', $selectedItemTypes)) >Dry</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description, Remarks & Attachment -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pform-row">
                                    <div class="pform-label w100p" >Item Description</div>
                                    <div class="pform-value w100p">
                                        <textarea name="item_description" rows="3" >{{ old('item_description', $customerEnquiry->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="pform-row">
                                    <div class="pform-label w100p" >Remarks</div>
                                    <div class="pform-value w100p">
                                        <textarea name="remarks" rows="3" >{{ old('remarks', $customerEnquiry->remarks) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-save float-right">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="enquiryAttachment" role="tabpanel">
            <x-attachment-uploader :tableName="$customerEnquiry->getTable()" :rowId="$customerEnquiry->customer_enquiry_id" />
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
@endsection
