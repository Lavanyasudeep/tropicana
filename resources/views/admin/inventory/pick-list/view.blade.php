@extends('adminlte::page')

@section('title', 'View Picking List')

@section('content_header')
    <h1>Picking List</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.pick-list.print', $pickList->picklist_id) }}" target="_blank" class="btn btn-print"><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.pick-list.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>

    <div class="action-status" >
        <label>Change Status</label>
        <select id="change_status_select" >
            <option value="{{ $pickList->status }}" selected>{{ ucfirst($pickList->status) }}</option>
            @foreach ($nextOptions as $status)
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
</div>


<ul class="nav nav-tabs" role="tablist" id="pickListTabs" >
  <li class="nav-item">
    <a class="nav-link active" id="picklist-tab" data-toggle="tab" href="#picklist" role="tab">Picklist</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="picklist-status-tab" data-toggle="tab" href="#picklistStatus" role="tab">Status</a>
  </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="picklist" role="tabpanel">
        <div class="card page-form" >
            <div class="card-body">
                <div class="row" >
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:128px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. #</div>
                                <div class="pform-value" >{{ $pickList->doc_no }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. Date</div>
                                <div class="pform-value" >{{ $pickList->doc_date }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Dispatch Date</div>
                                <div class="pform-value" >{{ $pickList->dispatch_date }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Dispatch Location</div>
                                <div class="pform-value" >{{ $pickList->dispatch_location }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Status</div>
                                <div class="pform-value" >{{ $pickList->status }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:128px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Client</div>
                                <div class="pform-value" >{{ $pickList->client->client_name }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Contact Name</div>
                                <div class="pform-value" >{{ $pickList->contact_name }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Contact Address</div>
                                <div class="pform-value" >{{ $pickList->contact_address }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>

                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:128px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >No of Items Picked</div>
                                <div class="pform-value" >{{ $pickList->pickListDetails->count() }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Total Package Qty</div>
                                <div class="pform-value" >{{ $pickList->tot_package_qty }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >No of Pallets</div>
                                <div class="pform-value" >{{ $pickList->pallet_qty }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped page-list-table" >
                    <thead>
                        <tr>
                            <th style="width:2%;" >#</th>
                            <th style="width:15%;" >Product</th>
                            <th style="width:10%;" >Lot No.</th>
                            <th style="width:5%;" >Package Type</th>
                            <th style="width:5%;" class="text-center" >Size</th>
                            <th style="width:5%;" class="text-center" >G.W. per Package</th>
                            <th style="width:5%;" class="text-center" >N.W. per Package</th>
                            <th style="width:5%;" class="text-center" >G.W. KG with pit weight</th>
                            <th style="width:5%;" class="text-center" >N.W. KG</th>
                            <th style="width:10%;" >Slot</th>
                            <!-- <th style="width:5%;" >Pallet</th> -->
                            <th style="width:5%;" >Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $tot_qty = 0;
                            $tot_gw_per_package = 0;
                            $tot_nw_per_package = 0;
                            $tot_gw_with_pallet = 0;
                            $tot_nw_kg = 0;
                        @endphp
                        @foreach($pickListDetails as $k => $v)
                        <tr>
                            <td>{{ $k + 1 }}</td>
                            <td>{{ $v->packingListDetail->cargo_description }}</td>
                            <td>{{ $v->packingListDetail->lot_no }}</td>
                            <td>{{ $v->packingListDetail->packageType?->description }}</td>
                            <td class="text-center" >{{ $v->packingListDetail->item_size_per_package }}</td>
                            <td class="text-center" >{{ $v->packingListDetail->gw_per_package }}</td>
                            <td class="text-center" >{{ $v->packingListDetail->nw_per_package }}</td>
                            <td class="text-center" >{{ $v->packingListDetail->gw_with_pallet }}</td>
                            <td class="text-center" >{{ $v->packingListDetail->nw_kg }}</td>
                            <td>{{ $v->room->name }}-{{ $v->rack->name }}-{{ $v->slot->level_no??'' }}-{{ $v->slot->depth_no??'' }}</td>
                            <!-- <td>{{ $v->pallet->name }}</td> -->
                            <td class="text-center">{{ $v->quantity??'' }}</td>
                        </tr>
                        @php 
                            $tot_qty += $v->quantity; 
                            $tot_gw_per_package += $v->packingListDetail->gw_per_package; 
                            $tot_nw_per_package += $v->packingListDetail->nw_per_package; 
                            $tot_gw_with_pallet += $v->packingListDetail->gw_with_pallet; 
                            $tot_nw_kg += $v->packingListDetail->nw_kg; 
                        @endphp
                        @endforeach
                        <tr class="total-row" >
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-left" >Total</td>
                            <td class="text-center" >{{ $tot_gw_per_package }}</td>
                            <td class="text-center" >{{ $tot_nw_per_package }}</td>
                            <td class="text-center" >{{ $tot_gw_with_pallet }}</td>
                            <td class="text-center" >{{ $tot_nw_kg }}</td>
                            <td></td>
                            <td class="text-center" >{{ $tot_qty }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="picklistStatus" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                @foreach($pickList->pickListDetails as $detail)
                    @forelse($detail->statusUpdates as $log)
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
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    #pickListTabs { border-bottom: 1px solid #000; }
    #pickListTabs li.nav-item {  }
    #pickListTabs li.nav-item a { color:#000; }
    #pickListTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #pickListTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }
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

        $('#change_status_select').val('{{$pickList->status}}');

        // Start : Changes Status
        $('#change_status_select').on('change',function(){
            var status = $(this).val();
            var status_text = $(this).find('option:selected').text();
            var picklist_id = '{{ $pickList->picklist_id }}';
                    
            showConfirmationModal(
                "Confirm",
                "Do you want to change the status to '<b>"+status_text+"</b>' ?",
                function () { // Yes

                    $.post("/admin/inventory/pick-list/change-status", {
                        picklist_id: picklist_id,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (res) {
                        document.location = "{{ route('admin.inventory.pick-list.index') }}";
                    });

                },
                function () { // No

                    $('#change_status_select').val('{{$pickList->status}}');

                }
            );

        });
        // End : Changes Status
        
    });
</script>
@stop