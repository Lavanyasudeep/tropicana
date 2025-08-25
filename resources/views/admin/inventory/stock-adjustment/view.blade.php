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
        <a href="{{ route('admin.inventory.inward.print', $inward->inward_id) }}" target="_blank" class="btn btn-print" ><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.inward.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form">
    <div class="card-body">
        <div class="row">
            <!-- Panel 1: Document Details -->
            <div class="col-md-6">
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
            <div class="col-md-6">
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
                <tr class="total-row">
                    <th colspan="7" class="text-right">Total</th>
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

@endsection

@section('css')
<style>
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        
    });
</script>
@stop