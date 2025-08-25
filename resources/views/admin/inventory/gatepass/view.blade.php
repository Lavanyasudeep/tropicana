@extends('adminlte::page')

@section('title', 'View Gate Pass')

@section('content_header')
    <h1>Gate Pass</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.gatepass.edit', $gatepass->gate_pass_id) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.gatepass.print', $gatepass->gate_pass_id) }}" target="_blank" class="btn btn-print" ><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.gatepass.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status" >
        <label>Change Status</label>
        <select id="change_status_select" >
            <option value="created" >Created</option>
            @if(!in_array('approved', $gatepass->statusUpdates->pluck('column_value')->toArray()))
                <option value="approved">Approved</option>
            @endif

            @if(!in_array('rejected', $gatepass->statusUpdates->pluck('column_value')->toArray()))
                <option value="rejected">Rejected</option>
            @endif

            @if(!in_array('cancelled', $gatepass->statusUpdates->pluck('column_value')->toArray()))
                <option value="cancelled">Cancelled</option>
            @endif
        </select>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="gatePassTabs" >
  <li class="nav-item">
    <a class="nav-link active" id="gate-pass-tab" data-toggle="tab" href="#gatePass" role="tab">Gate Pass</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="gate-pass-status-tab" data-toggle="tab" href="#gatePassStatus" role="tab">Status</a>
  </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="gatePass" role="tabpanel">
        <div class="card page-form" >
            <div class="card-body">
                <div class="row" >
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:128px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. #</div>
                                <div class="pform-value" >{{ $gatepass->doc_no }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. Date</div>
                                <div class="pform-value" >{{ $gatepass->doc_date }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Status</div>
                                <div class="pform-value" >{{ $gatepass->status }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Client</div>
                                <div class="pform-value" >{{ $gatepass->client->client_name }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:128px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Contact Name</div>
                                <div class="pform-value" >{{ $gatepass->contact_name }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Contact Address</div>
                                <div class="pform-value" >{{ $gatepass->contact_address }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Remarks</div>
                                <div class="pform-value" >{{ $gatepass->remarks }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:128px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Movement Type</div>
                                <div class="pform-value" >{{ $gatepass->movement_type }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Vehicle No</div>
                                <div class="pform-value" >{{ $gatepass->vehicle_no }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Driver Name</div>
                                <div class="pform-value" >{{ $gatepass->driver_name }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Transport Mode</div>
                                <div class="pform-value" >{{ $gatepass->transport_mode }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped page-list-table" >
                    <thead>
                        <tr>
                            <th style="width:2%;" >#</th>
                            <th style="width:5%;" >Item Name</th>
                            <th style="width:5%;" >UOM.</th>
                            <th style="width:5%;"  class="text-center" >Qty</th>
                            <th style="width:5%;" >Returnable?</th>
                            <th style="width:5%;" >Expected Return Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gatepass->gatePassDetails as $k => $v)
                        <tr>
                            <td>{{ $k + 1 }}</td>
                            <td>{{ $v->item_name }}</td>
                            <td>{{ $v->uom }}</td>
                            <td class="text-center" >{{ $v->quantity }}</td>
                            <td>{{ $v->is_returnable? 'Yes' : 'No' }}</td>
                            <td>{{ $v->expected_return_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="gatePassStatus" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                @forelse($gatepass->statusUpdates as $log)
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
@endsection

@section('css')
<style>
    #gatePassTabs { border-bottom: 1px solid #000; }
    #gatePassTabs li.nav-item {  }
    #gatePassTabs li.nav-item a { color:#000; }
    #gatePassTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #gatePassTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }
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

        $('#change_status_select').val('{{$gatepass->status}}');

        // Start : Changes Status
        $('#change_status_select').on('change',function(){
            var status = $(this).val();
            var status_text = $(this).find('option:selected').text();
            var gatepass_id = '{{ $gatepass->gate_pass_id }}';
                    
            showConfirmationModal(
                "Confirm",
                "Do you want to change the status to '<b>"+status_text+"</b>' ?",
                function () { // Yes

                    $.post("/admin/inventory/gatepass/change-status", {
                        gatepass_id: gatepass_id,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (res) {
                        document.location = "{{ route('admin.inventory.gatepass.index') }}";
                    });

                },
                function () { // No

                    $('#change_status_select').val('{{$gatepass->status}}');

                }
            );

        });
        // End : Changes Status
        
    });
</script>
@stop