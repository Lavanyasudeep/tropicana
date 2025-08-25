@extends('adminlte::page')

@section('title', 'View Outward')

@section('content_header')
    <h1>Outward</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.outward.edit', $outward->outward_id) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.outward.print', $outward->outward_id) }}" target="_blank" class="btn btn-print" ><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.outward.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status" >
        <label>Change Status</label>
        <select id="change_status_select" >
            <option value="{{ $outward->status }}" selected>{{ ucfirst($outward->status) }}</option>
            @foreach ($nextOptions as $status)
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="outwardTabs" >
  <li class="nav-item">
    <a class="nav-link active" id="outward-tab" data-toggle="tab" href="#outward" role="tab">Outward</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="outward-status-tab" data-toggle="tab" href="#outwardStatus" role="tab">Status</a>
  </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="outward" role="tabpanel">
        <div class="card page-form" >
            <div class="card-body">
                <div class="row" >
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:128px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. #</div>
                                <div class="pform-value" >{{ $outward->doc_no }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. Date</div>
                                <div class="pform-value" >{{ $outward->doc_date }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Status</div>
                                <div class="pform-value" >{{ $outward->status }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:128px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Client</div>
                                <div class="pform-value" >{{ $outward->client->client_name }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Contact Name</div>
                                <div class="pform-value" >{{ $outward->contact_name }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Contact Address</div>
                                <div class="pform-value" >{{ $outward->contact_address }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:128px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Vehicle No</div>
                                <div class="pform-value" >{{ $outward->vehicle_no }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Driver</div>
                                <div class="pform-value" >{{ $outward->driver }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped page-list-table" >
                    <thead>
                        <tr>
                            <th style="width:2%;" >#</th>
                            <th style="width:5%;" >Product</th>
                            <th style="width:5%;" >Lot No.</th>
                            <!-- <th style="width:5%;" class="text-center" >Size</th> -->
                            <th style="width:5%;" >Package Type</th>
                            <th style="width:5%;" >Slot</th>
                            <th style="width:5%;" class="text-center" >Pallet</th>
                            <th style="width:5%;" class="text-center" >Item Numbers per Package</th>
                            <th style="width:5%;" class="text-center" >G.W. per Package</th>
                            <th style="width:5%;" class="text-center" >N.W. per Package</th>
                            <th style="width:5%;" class="text-center" >G.W. KG with pit weight</th>
                            <th style="width:5%;" class="text-center" >N.W. KG</th>
                            <th style="width:5%;" >Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $tot_pallet_qty = 0;
                            $tot_qty = 0;
                            $tot_gw_per_package = 0;
                            $tot_nw_per_package = 0;
                            $tot_gw_with_pallet = 0;
                            $tot_nw_kg = 0;
                        @endphp
                        @foreach($outwardDetails as $k => $v)
                        <tr>
                            <td>{{ $k + 1 }}</td>
                            <td>{{ $v->pickListDetail->packingListDetail->cargo_description }}</td>
                            <td>{{ $v->pickListDetail->packingListDetail->lot_no }}</td>
                            <!-- <td class="text-center" >{{ $v->pickListDetail->packingListDetail->item_size_per_package }}</td> -->
                            <td>{{ $v->pickListDetail->packingListDetail->packageType?->description }}</td>
                            <td class="text-center" >{{ $v->pickListDetail->room->name }}-{{ $v->pickListDetail->rack->name }}-{{ $v->pickListDetail->slot->level_no }}-{{ $v->pickListDetail->slot->depth_no }}</td>
                            <td class="text-center" >{{ $v->pickListDetail->pallet->name }}</td>
                            <td class="text-center" >{{ $v->pickListDetail->packingListDetail->item_size_per_package }}</td>
                            <td class="text-center" >{{ $v->pickListDetail->packingListDetail->gw_per_package }}</td>
                            <td class="text-center" >{{ $v->pickListDetail->packingListDetail->nw_per_package }}</td>
                            <td class="text-center" >{{ $v->pickListDetail->packingListDetail->gw_with_pallet }}</td>
                            <td class="text-center" >{{ $v->pickListDetail->packingListDetail->nw_kg }}</td>
                            <td class="text-center">{{ $v->quantity??'' }}</td>
                        </tr>
                        @php 
                            $tot_pallet_qty += $outward->pallet_qty??0; 
                            $tot_qty += $v->quantity; 
                            $tot_gw_per_package += $v->pickListDetail->packingListDetail->gw_per_package; 
                            $tot_nw_per_package += $v->pickListDetail->packingListDetail->nw_per_package; 
                            $tot_gw_with_pallet += $v->pickListDetail->packingListDetail->gw_with_pallet; 
                            $tot_nw_kg += $v->pickListDetail->packingListDetail->nw_kg; 
                        @endphp
                        @endforeach
                        <tr class="total-row" >
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-left" >Total</td>
                            <td class="text-center" >{{ $tot_gw_per_package }}</td>
                            <td class="text-center" >{{ $tot_nw_per_package }}</td>
                            <td class="text-center" >{{ $tot_gw_with_pallet }}</td>
                            <td class="text-center" >{{ $tot_nw_kg }}</td>
                            <td class="text-center" >{{ $tot_qty }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="row" >
                    <div class="col-md-6" ></div>
                    <div class="col-md-6" >
                        <br />
                        <table class="table table-striped page-list-table" border="0">    
                            <tbody>
                                <tr>
                                    <td><span>Weight of 1 empty pallet</span></td>
                                    <td class="text-right" >{{ $outward->packing_lists?->pluck('weight_per_pallet')->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <td><span><b>Total No. of Pallets</b></span></td>
                                    <td class="text-right" >{{ $tot_pallet_qty }}</td>
                                </tr>
                                <tr>
                                    <td><span>Total No. of Packages Picked</span></td>
                                    <td class="text-right" >{{ $tot_qty }}</td>
                                </tr>
                                <tr>
                                    <td><span>Total G.W with Pallets Weight</span></td>
                                    <td class="text-right" >{{ $tot_gw_with_pallet }}</td>
                                </tr>
                                <tr>
                                    <td><span>Total N.W</span></td>
                                    <td class="text-right" >{{ $tot_nw_kg }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="outwardStatus" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                @foreach($outward->outwardDetails as $detail)
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
    #outwardTabs { border-bottom: 1px solid #000; }
    #outwardTabs li.nav-item {  }
    #outwardTabs li.nav-item a { color:#000; }
    #outwardTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #outwardTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }
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

        $('#change_status_select').val('{{$outward->status}}');

        // Start : Changes Status
        $('#change_status_select').on('change',function(){
            var status = $(this).val();
            var status_text = $(this).find('option:selected').text();
            var outward_id = '{{ $outward->outward_id }}';
                    
            showConfirmationModal(
                "Confirm",
                "Do you want to change the status to '<b>"+status_text+"</b>' ?",
                function () { // Yes

                    $.post("/admin/inventory/outward/change-status", {
                        outward_id: outward_id,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (res) {
                        document.location = "{{ route('admin.inventory.outward.index') }}";
                    });

                },
                function () { // No

                    $('#change_status_select').val('{{$outward->status}}');

                }
            );

        });
        // End : Changes Status
        
    });
</script>
@stop