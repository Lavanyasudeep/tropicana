@extends('adminlte::page')

@section('title', 'View Customer')

@section('content_header')
    <h1>Customer</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
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
            <div class="card page-form" >
                <div class="card-body">
                    <div class="row" >
                        <!-- Panel 1 -->
                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:200px;" >
                                <div class="pform-row">
                                    <div class="pform-label" >Customer Name</div>
                                    <div class="pform-value" >{{ $customer->customer_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Branch Name</div>
                                    <div class="pform-value" >{{ $customer->branch?->branch_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Mobile Number</div>
                                    <div class="pform-value" >{{ $customer->phone_number }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Email-Id</div>
                                    <div class="pform-value" >{{ $customer->email }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:200px;" >
                                <div class="pform-row" >
                                    <div class="pform-label" >Photo</div>
                                    <div class="pform-value" >
                                        <br/>
                                        <img id="photPreview" src="{{ $customer->photo_url }}" alt="Photo Preview"
                                                        style="margin-top:10px; max-height: 80px;' }}">
                                    </div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Website</div>
                                    <div class="pform-value" >{{ $customer->website }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Password</div>
                                    <div class="pform-value" >{{ $customer->password ? '********' : 'Not Set' }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:200px;">
                                <div class="pform-row" >
                                    <div class="pform-label" >Phone Number 2</div>
                                    <div class="pform-value" >{{ $customer->phone_number2 }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Contact Person</div>
                                    <div class="pform-value" >{{ $customer->contact_person }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Address</div>
                                    <div class="pform-value" >{{ $customer->main_address }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Pincode</div>
                                    <div class="pform-value" >{{ $customer->pincode }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >State</div>
                                    <div class="pform-value" >{{ $customer->state?->state_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >District</div>
                                    <div class="pform-value" >{{ $customer->district?->district_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >City</div>
                                    <div class="pform-value" >{{ $customer->city?->city_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Place</div>
                                    <div class="pform-value" >{{ $customer->place?->place_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Post Office</div>
                                    <div class="pform-value" >{{ $customer->postoffice?->post_office }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:200px;">
                                <div class="pform-row">
                                    <div class="pform-label" >Fax</div>
                                    <div class="pform-value" >{{ $customer->fax }}</div>
                                </div>
                                <div class="pform-row">
                                    <div class="pform-label" >PAN No</div>
                                    <div class="pform-value" >{{ $customer->pan }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Aadhaar No</div>
                                    <div class="pform-value" >{{ $customer->aadhaar }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >GSTIN</div>
                                    <div class="pform-value" >{{ $customer->gstin }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >TIN</div>
                                    <div class="pform-value" >{{ $customer->tin }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >CST</div>
                                    <div class="pform-value" >{{ $customer->cst }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >SEZ</div>
                                    <div class="pform-value" >{{ $customer->sez }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Credit Days</div>
                                    <div class="pform-value" >{{ $customer->credit_days }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Credit Limit</div>
                                    <div class="pform-value" >{{ $customer->credit_limit }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>

                    <div class="row" >
                        <!-- Panel 1 -->
                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:250px;" >
                                <div class="pform-row" >
                                    <div class="pform-label" >Shipping Address</div>
                                    <div class="pform-value" >{{ $customer->shipping_address }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Shipping State</div>
                                    <div class="pform-value" >{{ $customer->shippingState?->state_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Shipping District</div>
                                    <div class="pform-value" >{{ $customer->shippingDistrict?->district_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Shipping City</div>
                                    <div class="pform-value" >{{ $customer->shippingCity?->city_name }}</div>
                                </div>
                                <div class="pform-row">
                                    <div class="pform-label" >Shipping Phone Number</div>
                                    <div class="pform-value" >{{ $customer->shipping_phonenumber }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Shipping Email-Id</div>
                                    <div class="pform-value" >{{ $customer->shipping_email }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Shipping FAX</div>
                                    <div class="pform-value" >{{ $customer->shipping_fax }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:250px;" >
                                <div class="pform-row" >
                                    <div class="pform-label" >Billing Address</div>
                                    <div class="pform-value" >{{ $customer->billing_address }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Billing State</div>
                                    <div class="pform-value" >{{ $customer->billingState?->state_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Billing District</div>
                                    <div class="pform-value" >{{ $customer->billingDistrict?->district_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Billing City</div>
                                    <div class="pform-value" >{{ $customer->billingCity?->city_name }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="customerAttachment" role="tabpanel">
            <x-attachment-uploader :tableName="$customer->getTable()" :rowId="$customer->customer_id" />
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