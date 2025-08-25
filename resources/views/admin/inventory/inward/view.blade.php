@extends('adminlte::page')

@section('title', 'View Inward')

@section('content_header')
    <h1>Inward</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.inward.edit', $inward->inward_id) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.inward.print', $inward->inward_id) }}" target="_blank" class="btn btn-print" ><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.inward.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status" >
        <label>Change Status</label>
        <select id="change_status_select" >
            <option value="{{ $inward->status }}" selected>{{ ucfirst($inward->status) }}</option>
            @foreach ($nextOptions as $status)
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="inwardTabs" >
  <li class="nav-item">
    <a class="nav-link active" id="inward-tab" data-toggle="tab" href="#inward" role="tab">Inward</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="inward-status-tab" data-toggle="tab" href="#inwardStatus" role="tab">Status</a>
  </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="inward" role="tabpanel">
        <div class="card page-form">
            <div class="card-body">
                <div class="row">
                    <!-- Panel 1: Document Details -->
                    <div class="col-md-{{ $inward->product_variants->isNotEmpty() ? '4' : '6' }}">
                        <div class="pform-panel" style="min-height:165px;">
                            <div class="pform-row">
                                <div class="pform-label">Doc. #</div>
                                <div class="pform-value">{{ $inward->doc_no }}</div>
                            </div>
                            <div class="pform-row">
                                <div class="pform-label">Doc. Date</div>
                                <div class="pform-value">{{ $inward->doc_date }}</div>
                            </div>
                            <div class="pform-row">
                                <div class="pform-label">Packing List</div>
                                <div class="pform-value">{{ $inward->packingList->doc_no ?? '-' }}</div>
                            </div>
                            <div class="pform-row">
                                <div class="pform-label">Client</div>
                                <div class="pform-value">{{ $inward->client->client_name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel 2: GRN and Supplier Info -->
                    <div class="col-md-{{ $inward->product_variants->isNotEmpty() ? '4' : '6' }}">
                        <div class="pform-panel" style="min-height:165px;">
                            <div class="pform-row">
                                <div class="pform-label">GRN No</div>
                                <div class="pform-value">{{ optional($inward->packingList?->grn)->GRNNo ?? '-' }}</div>
                            </div>
                            <div class="pform-row">
                                <div class="pform-label">Supplier Name</div>
                                <div class="pform-value">{{ optional($inward->packingList?->supplier)->supplier_name ?? '-' }}</div>
                            </div>
                            <div class="pform-row">
                                <div class="pform-label">Goods</div>
                                <div class="pform-value">{{ $inward->packingList->goods ?? '-' }}</div>
                            </div>
                            <div class="pform-row">
                                <div class="pform-label">Size</div>
                                <div class="pform-value">{{ $inward->packingList->size ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel 2: Product Specification Info -->
                    @if($inward->product_variants->isNotEmpty())
                        <div class="col-md-4">
                            <div class="pform-panel" style="min-height:165px;">
                                <div class="pform-row">
                                    <h5 style="font-size: 14px; font-weight: bold;" >Product Specifications:</h5>
                                    @foreach($inward->product_variants as $variant)
                                        @if($variant)
                                            @foreach($variant->productSpecifications as $spec)
                                                <div>
                                                    <div class="pform-label">{{ $spec->specification->attribute->name ?? '-' }}</div>
                                                    <div class="pform-value">{{ $spec->specification->prod_attribute_value ?? '-' }}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Assigned Products Table -->
                <table class="table table-bordered mt-3 page-list-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Lot</th>
                            <th>Slot Positions</th>
                            <th>Pallets</th>
                            <th>Size</th>
                            <th>Weight Per Unit</th>
                            <th>Package Type</th>
                            <th>G.W. /Pkg</th>
                            <th>N.W. /Pkg</th>
                            <th>G.W. With Pallet</th>
                            <th>N.W. KG</th>
                            <th>Total Pkg</th>
                            <th>Qty / Pallet</th>
                            <th>Pallet Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $tot_pallet_qty = 0;
                            $tot_package_qty = 0;
                            $tot_gw_per_package = 0;
                            $tot_nw_per_package = 0;
                            $tot_gw_with_pallet = 0;
                            $tot_package_qty_per_pallet = 0;
                            $tot_nw_kg = 0;
                        @endphp
                        @foreach ($inwardDetails as $v)
                        <tr>
                            <td>{{ $v['product_name'] }}</td>
                            <td>{{ $v['batch_no'] }}</td>
                            <td>{{ $v['slot_positions'] }}</td>
                            <td>{{ $v['pallets'] }}</td>
                            <td class="text-center" >{{ $v['item_size_per_package'] }}</td>
                            <td class="text-center" >{{ $v['weight_per_unit'] }}</td>
                            <td>{{ $v['package_types'] }}</td>
                            <td class="text-center" >{{ $v['gw_per_package'] }}</td>
                            <td class="text-center" >{{ $v['nw_per_package'] }}</td>
                            <td class="text-center" >{{ $v['gw_with_pallet'] }}</td>
                            <td class="text-center" >{{ $v['nw_kg'] }}</td>
                            <td class="text-center" >{{ $v['total_quantity'] }}</td>
                            <td class="text-center" >{{ $v['package_qty_per_pallet'] }}</td>
                            <td class="text-center" >{{ $v['pallet_qty'] }}</td>
                        </tr>
                        @php
                            $tot_pallet_qty += $v['pallet_qty'];
                            $tot_package_qty += $v['total_quantity'];
                            $tot_gw_per_package += $v['gw_per_package'];
                            $tot_nw_per_package += $v['nw_per_package'];
                            $tot_gw_with_pallet += $v['gw_with_pallet'];
                            $tot_package_qty_per_pallet += $v['package_qty_per_pallet'];
                            $tot_nw_kg += $v['nw_kg'];
                        @endphp
                        @endforeach
                        <tr class="total-row" >
                            <th colspan="7" class="text-right" >Total</th>
                            <th class="text-center" >{{ $tot_gw_per_package }}</th>
                            <th class="text-center" >{{ $tot_nw_per_package }}</th>
                            <th class="text-center" >{{ $tot_gw_with_pallet }}</th>
                            <th class="text-center" >{{ $tot_nw_kg }}</th>
                            <th class="text-center" >{{ $tot_package_qty }}</th>
                            <th class="text-center" >{{ $tot_package_qty_per_pallet }}</th>
                            <th class="text-center" >{{ $tot_pallet_qty }}</th>
                        </tr>
                    </tbody>
                </table>

                <!-- Summary Table -->
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <table class="table table-striped page-list-table">
                            <tbody>
                                <tr>
                                    <td>Weight of 1 Empty Pallet</td>
                                    <td class="text-right">{{ $inward->packingList->weight_per_pallet }}</td>
                                </tr>
                                <tr>
                                    <td><b>Total No of Pallets</b></td>
                                    <td class="text-right">{{ $tot_pallet_qty }}</td>
                                </tr>
                                <tr>
                                    <td>Total No of Packages Assigned</td>
                                    <td class="text-right">{{ $tot_package_qty }}</td>
                                </tr>
                                <tr>
                                    <td>Total G.W with Pallets Weight</td>
                                    <td class="text-right">{{ $tot_gw_with_pallet }}</td>
                                </tr>
                                <tr>
                                    <td>Total N.W</td>
                                    <td class="text-right">{{ $tot_nw_kg }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="tab-pane fade" id="inwardStatus" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                @foreach ($inward->inwardDetails as $detail)
                    <div class="card card-outline card-primary mb-4">
                        <div class="card-header">
                            <strong>Detail ID:</strong> {{ $detail->inward_detail_id }}
                            @if ($detail->packingListDetail?->product)
                                | <strong>Product:</strong> {{ $detail->packingListDetail->product->product_description }}
                            @endif
                            | <strong>Qty:</strong> {{ $detail->quantity }}
                            | <strong>Location:</strong> {{ $detail->pallet?->pallet_position ?? '' }}
                            | <strong>Status:</strong>
                            <span class="badge bg-{{ $detail->status_color ?? 'secondary' }}">
                                {{ ucfirst($detail->status) }}
                            </span>
                        </div>
                        <div class="card-body">
                            @include('components.status-history', ['logs' => $detail->statusUpdates])
                        </div>
                    </div>
                @endforeach
        </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    #inwardTabs { border-bottom: 1px solid #000; }
    #inwardTabs li.nav-item {  }
    #inwardTabs li.nav-item a { color:#000; }
    #inwardTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #inwardTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }

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

        $('#change_status_select').val('{{$inward->status}}');

        // Start : Changes Status
        $('#change_status_select').on('change',function(){
            var status = $(this).val();
            var status_text = $(this).find('option:selected').text();
            var inward_id = '{{ $inward->inward_id }}';
                    
            showConfirmationModal(
                "Confirm",
                "Do you want to change the status to '<b>"+status_text+"</b>' ?",
                function () { // Yes

                    $.post("/admin/inventory/inward/change-status", {
                        inward_id: inward_id,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (res) {
                        document.location = "{{ route('admin.inventory.inward.index') }}";
                    });

                },
                function () { // No

                    $('#change_status_select').val('{{$inward->status}}');

                }
            );

        });
        // End : Changes Status
        
    });
</script>
@stop