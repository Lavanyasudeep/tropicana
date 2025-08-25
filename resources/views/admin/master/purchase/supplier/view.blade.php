@extends('adminlte::page')

@section('title', 'View Supplier')

@section('content_header')
    <h1>Supplier</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
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
            <div class="card page-form" >
                <div class="card-body">
                    <div class="row" >
                        <!-- Panel 1 -->
                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:200px;" >
                                <div class="pform-row">
                                    <div class="pform-label" >Supplier Type</div>
                                    <div class="pform-value" >{{ $supplier->supplierType?->supplier_type_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Supplier Category</div>
                                    <div class="pform-value" >{{ $supplier->supplierCategory?->supplier_category_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Supplier Name</div>
                                    <div class="pform-value" >{{ $supplier->supplier_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Supplier Code</div>
                                    <div class="pform-value" >{{ $supplier->supplier_code }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Branch</div>
                                    <div class="pform-value" >{{ $supplier->branch?->branch_name }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:200px;" >
                                <div class="pform-row" >
                                    <div class="pform-label" >Is Branch</div>
                                    <div class="pform-value" >{{ $supplier->is_branch? 'Yes' : 'No' }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Without Tax</div>
                                    <div class="pform-value" >{{ $supplier->without_tax? 'Yes' : 'No' }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Vendor Grade</div>
                                    <div class="pform-value" >{{ $supplier->vendor_grade }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Supplier Group</div>
                                    <div class="pform-value" >{{ $supplier->supplier_group }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Group Code</div>
                                    <div class="pform-value" >{{ $supplier->group_code }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:430px;">
                                <div class="pform-row" >
                                    <div class="pform-label" >Mobile Number</div>
                                    <div class="pform-value" >{{ $supplier->mobile }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Email-Id</div>
                                    <div class="pform-value" >{{ $supplier->email }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Password</div>
                                    <div class="pform-value" >{{ $supplier->password ? '********' : 'Not Set' }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Contact Person</div>
                                    <div class="pform-value" >{{ $supplier->contact_person }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Contact Number</div>
                                    <div class="pform-value" >{{ $supplier->contact_number }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Address</div>
                                    <div class="pform-value" >{{ $supplier->address }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Pincode</div>
                                    <div class="pform-value" >{{ $supplier->pincode }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Country</div>
                                    <div class="pform-value" >{{ $supplier->country?->country_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >State</div>
                                    <div class="pform-value" >{{ $supplier->state?->state_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >District</div>
                                    <div class="pform-value" >{{ $supplier->district?->district_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >City</div>
                                    <div class="pform-value" >{{ $supplier->city?->city_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Post Office</div>
                                    <div class="pform-value" >{{ $supplier->postoffice?->post_office }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="pform-panel" style="min-height:430px;">
                                <div class="pform-row" >
                                    <div class="pform-label" >Aadhaar No</div>
                                    <div class="pform-value" >{{ $supplier->aadhaar }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >GSTIN</div>
                                    <div class="pform-value" >{{ $supplier->gstin }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >TIN</div>
                                    <div class="pform-value" >{{ $supplier->tin }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >CST</div>
                                    <div class="pform-value" >{{ $supplier->cst }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Is Advance</div>
                                    <div class="pform-value" >{{ $supplier->advance? 'Yes' : 'No' }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Credit Days</div>
                                    <div class="pform-value" >{{ $supplier->credit_days }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Credit Limit</div>
                                    <div class="pform-value" >{{ $supplier->credit_limit }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Goods Receive (No. of Days)</div>
                                    <div class="pform-value" >{{ $supplier->no_of_days_for_goods_rcv }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Terms Of Payment</div>
                                    <div class="pform-value" >{{ $supplier->terms_of_payment }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Tax Percentage</div>
                                    <div class="pform-value" >{{ $supplier->tax_per }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Discount Type</div>
                                    <div class="pform-value" >{{ $supplier->discount_type }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Discount Definition</div>
                                    <div class="pform-value" >{{ $supplier->discount_definition }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Period Of Discount</div>
                                    <div class="pform-value" >{{ $supplier->period_of_discount }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Currency</div>
                                    <div class="pform-value" >{{ $supplier->currency }}</div>
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
                                    <div class="pform-label" >Bank Name</div>
                                    <div class="pform-value" >{{ $supplier->bank_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Account Number</div>
                                    <div class="pform-value" >{{ $supplier->account_number }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >IFSC Code</div>
                                    <div class="pform-value" >{{ $supplier->ifsc_code }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >RTGS Code</div>
                                    <div class="pform-value" >{{ $supplier->rtgs_code }}</div>
                                </div>
                                <div class="pform-row">
                                    <div class="pform-label" >SWIFT Code</div>
                                    <div class="pform-value" >{{ $supplier->swift_code }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Bank Email</div>
                                    <div class="pform-value" >{{ $supplier->bank_email }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Other Details</div>
                                    <div class="pform-value" >{{ $supplier->other_details }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                        <div class="col-md-6" >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="supplierAttachment" role="tabpanel">
            <x-attachment-uploader :tableName="$supplier->getTable()" :rowId="$supplier->supplier_id" />
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