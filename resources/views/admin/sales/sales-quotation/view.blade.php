@extends('adminlte::page')

@section('title', 'View Sales Quotation')

@section('content_header')
    <h1>Sales Quotation</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.sales.sales-quotation.edit', $quotation->sq_id) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.sales.sales-quotation.print', $quotation->sq_id) }}" target="_blank" class="btn btn-print" ><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.sales.sales-quotation.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status" >
        <label>Change Status</label>
        <select id="change_status_select" >
            <option value="created" >Created</option>
            @if(!in_array('approved', $quotation->statusUpdates->pluck('column_value')->toArray()))
                <option value="approved">Approved</option>
            @endif

            @if(!in_array('rejected', $quotation->statusUpdates->pluck('column_value')->toArray()))
                <option value="rejected">Rejected</option>
            @endif

            @if(!in_array('cancelled', $quotation->statusUpdates->pluck('column_value')->toArray()))
                <option value="cancelled">Cancelled</option>
            @endif
        </select>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" id="salesQuotationTabs" >
    <li class="nav-item">
        <a class="nav-link active" id="sales-quotation-tab" data-toggle="tab" href="#salesQuotation" role="tab">Sales Quotation</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="sales-quotation-status-tab" data-toggle="tab" href="#quotationStatus" role="tab">Status</a>
    </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="salesQuotation" role="tabpanel">
            <div class="card page-form">
                <div class="card-body">
                    <div class="row">
                        <!-- Panel 1: Document Details -->
                        <div class="col-md-4">
                            <div class="pform-panel" style="min-height:120px;">
                                <div class="pform-row">
                                    <div class="pform-label">Doc. #</div>
                                    <div class="pform-value">{{ $quotation->doc_no }}</div>
                                </div>
                                <div class="pform-row">
                                    <div class="pform-label">Doc. Date</div>
                                    <div class="pform-value">{{ $quotation->doc_date }}</div>
                                </div>
                                <div class="pform-row">
                                    <div class="pform-label">Status</div>
                                    <div class="pform-value">{{ $quotation->status ?? '' }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <!-- Panel 2: GRN and Supplier Info -->
                        <div class="col-md-4">
                            <div class="pform-panel" style="min-height:120px;">
                                <div class="pform-row">
                                    <div class="pform-label">Customer Name</div>
                                    <div class="pform-value">{{ optional($quotation)->customer?->customer_name ?? '' }}</div>
                                </div>
                                <div class="pform-row">
                                    <div class="pform-label">Contact No.</div>
                                    <div class="pform-value">{{ optional($quotation)->customer?->phone_number ?? '' }}</div>
                                </div>
                                <div class="pform-row">
                                    <div class="pform-label">Address</div>
                                    <div class="pform-value">{{ $quotation->customer?->main_address ?? '' }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="pform-panel" style="min-height:120px;">
                                <div class="pform-row" >
                                    <div class="pform-label w100p" >Remarks</div>
                                    <div class="pform-value w100p" >{{ $quotation->remarks }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="pform-clear" ></div>
                    </div>

                    <!-- Assigned Products Table -->
                    <table class="table table-bordered mt-3 page-list-table">
                        <thead>
                            <tr>
                                <th style="width:10%;" >Type of Item</th>
                                <th style="width:20%;" >Description</th>
                                <th style="width:10%;" >Unit</th>
                                <th style="width:8%;" class="text-right" >Unit Qty</th>
                                <th style="width:8%;" class="text-right" >Rate</th>
                                <th style="width:8%;" class="text-right" >Qty</th>
                                <th style="width:8%;" class="text-right" >Value</th>
                                <th style="width:8%;" class="text-right" >Tax %</th>
                                <th style="width:8%;" class="text-right" >Tax Value</th>
                                <th style="width:8%;" class="text-right" >Net Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tot_pallet_qty = 0;
                                $tot_rate = 0;
                                $tot_value = 0;
                                $tot_tax_value = 0;
                                $tot_net_value = 0;
                            @endphp
                            @foreach ($quotation->quotationDetails as $v)
                            <tr>
                                <td>{{ $v->productType->type_name }}</td>
                                <td>{{ $v->salesItem->sales_item_name }}</td>
                                <td>{{ $v->unit->unit }}</td>
                                <td class="text-right" >{{ $v->unit_qty }}</td>
                                <td class="text-right" >{{ $v->rate }}</td>
                                <td class="text-right" >{{ $v->pallet_qty }}</td>
                                <td class="text-right" >{{ $v->value }}</td>
                                <td class="text-right" >{{ $v->tax_per }}</td>
                                <td class="text-right" >{{ $v->tax_value }}</td>
                                <td class="text-right" >{{ $v->net_value }}</td>
                            </tr>
                            <tr>
                                <td colspan="10" style="text-align:left;" >{!! nl2br($v->description) !!}</td>
                            </tr>
                            @php
                                $tot_pallet_qty += $v->pallet_qty;
                                $tot_rate += $v->rate;
                                $tot_value += $v->value;
                                $tot_tax_value += $v->tax_value;
                                $tot_net_value += $v->net_value;
                            @endphp
                            @endforeach
                            <tr class="total-row" >
                                <td colspan="4" class="text-right" >Total</td>
                                <td class="text-right" >{{ $tot_rate }}</td>
                                <td class="text-right" >{{ $tot_pallet_qty }}</td>
                                <td class="text-right" >{{ $tot_value }}</td>
                                <td></td>
                                <td class="text-right" >{{ $tot_tax_value }}</td>
                                <td class="text-right" >{{ $tot_net_value }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Summary Table -->
                    <div class="row mt-4">
                        <div class="col-md-5 offset-md-7">
                            <table class="table table-striped page-list-table">
                                <tbody>
                                    <tr>
                                        <td><b>Total Amount</b></td>
                                        <td class="text-right">{{ $quotation->total_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>CGST</td>
                                        <td class="text-right">{{ $quotation->cgst_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>SGST</td>
                                        <td class="text-right">{{ $quotation->sgst_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>IGST</td>
                                        <td class="text-right">{{ $quotation->igst_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Grand Total</b></td>
                                        <td class="text-right">{{ $quotation->grand_amount }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="quotationStatus" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5>Status History</h5>
                </div>
                <div class="card-body">
                    @forelse($quotation->statusUpdates as $log)
                        <div class="status-log-entry">
                            <img src="{{ $log->creator?->avatar_url }}" class="avatar" alt="{{ $log->creator?->name }}">
                            <div class="status-details">
                                <strong>{{ $log->creator?->name }}</strong>
                                <span class="status">{{ ucfirst($log->column_value) }}</span>
                                <span class="description">{{ $log->description }}</span>
                                <span class="date">{{ $log->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No status history found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    #quotationTabs { border-bottom: 1px solid #000; }
    #quotationTabs li.nav-item {  }
    #quotationTabs li.nav-item a { color:#000; }
    #quotationTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #quotationTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }

    .status-log-entry {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .status-log-entry .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .status-details {
        font-size: 14px;
    }

</style>
@stop

@section('js')
<script>
    $(document).ready(function() {

        $('#change_status_select').val('{{$quotation->status}}');

        // Start : Changes Status
        $('#change_status_select').on('change',function(){
            var status = $(this).val();
            var status_text = $(this).find('option:selected').text();
            var quotation_id = '{{ $quotation->quotation_id }}';
                    
            showConfirmationModal(
                "Confirm",
                "Do you want to change the status to '<b>"+status_text+"</b>' ?",
                function () { // Yes

                    $.post("/admin/sales/sales-quotation/change-status", {
                        quotation_id: quotation_id,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (res) {
                        document.location = "{{ route('admin.sales.sales-quotation.index') }}";
                    });

                },
                function () { // No

                    $('#change_status_select').val('{{$quotation->status}}');

                }
            );

        });
        // End : Changes Status
        
    });
</script>
@stop