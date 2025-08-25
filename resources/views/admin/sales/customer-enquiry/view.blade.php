@extends('adminlte::page')

@section('title', 'View Customer Enquiry')

@section('content_header')
    <h1>Customer Enquiry</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.sales.customer-enquiry.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status" >
        <label>Change Status</label>
       
        <select id="change_status_select" >
            <option value="created" >Created</option>
            @if(!in_array('approved', $enquiry->statusUpdates->pluck('column_value')->toArray()))
                <option value="approved">Approved</option>
            @endif

            @if(!in_array('rejected', $enquiry->statusUpdates->pluck('column_value')->toArray()))
                <option value="rejected">Rejected</option>
            @endif

            @if(!in_array('cancelled', $enquiry->statusUpdates->pluck('column_value')->toArray()))
                <option value="cancelled">Cancelled</option>
            @endif
        </select>
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
        <li class="nav-item">
            <a class="nav-link" id="enquiry-status-tab" data-toggle="tab" href="#enquiryStatus" role="tab">Status</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="enquiry" role="tabpanel">
            <div class="card page-form" >
                <div class="card-body">
                    <div class="row" >
                        <!-- Panel 1 -->
                        <div class="col-md-4" >
                            <div class="pform-panel" style="min-height:140px;" >
                                <div class="pform-row">
                                    <div class="pform-label" >Doc. #</div>
                                    <div class="pform-value" >{{ $enquiry->doc_no }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Doc. Date</div>
                                    <div class="pform-value" >{{ $enquiry->doc_date }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Status</div>
                                    <div class="pform-value" >{{ $enquiry->status }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <div class="col-md-4" >
                            <div class="pform-panel" style="min-height:140px;" >
                                <div class="pform-row" >
                                    <div class="pform-label" >Customer Name</div>
                                    <div class="pform-value" >{{ $enquiry->customer?->customer_name }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Contact No.</div>
                                    <div class="pform-value" >{{ $enquiry->customer?->phone_number }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Address</div>
                                    <div class="pform-value" >{{ $enquiry->customer?->main_address }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>

                        <!-- Panel 2 -->
                        <div class="col-md-4" >
                            <div class="pform-panel" style="min-height:140px;">
                                <div class="pform-row" >
                                    <div class="pform-label" >Type of Service</div>
                                    <div class="pform-value" >{{ ucwords(str_replace(',',', ',$enquiry->service_type)) }}</div>
                                </div>
                                <div class="pform-row" >
                                    <div class="pform-label" >Type of Items</div>
                                    <div class="pform-value" >{{ ucwords(str_replace(',',', ',$enquiry->item_type)) }}</div>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pform-row">
                                <div class="pform-label w100p" >Item Description</div>
                                <div class="pform-value w100p">
                                    <div style="min-height:100px; width:100%; border:1px solid #CCC; padding:10px;" >{{$enquiry->description}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="pform-row">
                                <div class="pform-label w100p" >Remarks</div>
                                <div class="pform-value w100p">
                                    <div style="min-height:100px; width:100%; border:1px solid #CCC; padding:10px;" >{{$enquiry->remarks}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="enquiryAttachment" role="tabpanel">
            <x-attachment-uploader :tableName="$enquiry->getTable()" :rowId="$enquiry->customer_enquiry_id" />
        </div>

        <div class="tab-pane fade" id="enquiryStatus" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5>Status History</h5>
                </div>
                <div class="card-body">
                    @forelse($enquiry->statusUpdates as $log)
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

    .status-details .amount {
        color: #28a745;
        font-weight: bold;
    }


</style>
@stop

@section('js')
<script>
$(document).ready(function () {
    $('#change_status_select').val('{{$enquiry->status}}');

    // Start : Changes Status
    $('#change_status_select').on('change', function() {
        var status = $(this).val();
        var status_text = $(this).find('option:selected').text();
        var enquiry_id = '{{ $enquiry->customer_enquiry_id }}';
       
        showConfirmationModal(
            "Confirm",
            "Do you want to change the status to '<b>" + status_text + "</b>' ?",
            function () {
                $.post("/admin/sales/customer-enquiry/change-status", {
                    enquiry_id: enquiry_id,
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function (res) {
                    document.location = "{{ route('admin.sales.customer-enquiry.index') }}";
                });
            },
            function () {
                $('#change_status_select').val('{{$enquiry->status}}');
            }
        );
        
    });


});
</script>
@stop