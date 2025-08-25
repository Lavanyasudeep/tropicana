@extends('adminlte::page')

@section('title', 'View Packing List')

@section('content_header')
    <h1>Packing List</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.pre-alert.edit', $packingList->packing_list_id) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.pre-alert.print', $packingList->packing_list_id) }}" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.pre-alert.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form" >
    <div class="card-body">
        <div class="row" >
            <div class="col-md-3" >
                <div class="pform-panel" style="min-height:210px;" >
                    <div class="pform-row" >
                        <div class="pform-label" >Doc. #</div>
                        <div class="pform-value" >{{ $packingList->doc_no }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Doc. Date</div>
                        <div class="pform-value" >{{ $packingList->doc_date }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Invoice #</div>
                        <div class="pform-value" >{{ $packingList->invoice_no }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Invoice Date</div>
                        <div class="pform-value" >{{ $packingList->invoice_date }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Status</div>
                        <div class="pform-value" >{{ $packingList->status }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
            <div class="col-md-3" >
                <div class="pform-panel" style="min-height:210px;" >
                    <div class="pform-row" >
                        <div class="pform-label" >Supplier</div>
                        <div class="pform-value" >{{ $packingList->supplier->supplier_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Client</div>
                        <div class="pform-value" >{{ $packingList->client->client_name?? '' }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Notify</div>
                        <div class="pform-value" >{{ $packingList->contact_person }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Container #</div>
                        <div class="pform-value" >{{ $packingList->container_nos }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-3" >
                <div class="pform-panel" style="min-height:210px;" >
                    <div class="pform-row" >
                        <div class="pform-label" >Package Type</div>
                        <div class="pform-value" >{{ $packingList->package_types }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Date of Loading</div>
                        <div class="pform-value" >{{ $packingList->loading_date }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Port of Loading</div>
                        <div class="pform-value" >{{ $packingList->loading_port_id }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Port of Discharge</div>
                        <div class="pform-value" >{{ $packingList->discharge_port_id }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-3" >
                <div class="pform-panel" style="min-height:210px;" >
                    <div class="pform-row" >
                        <div class="pform-label" >GOODS</div>
                        <div class="pform-value" >{{ $packingList->goods }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Size</div>
                        <div class="pform-value" >{{ $packingList->size }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >BL. No.</div>
                        <div class="pform-value" ></div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Name of Vessel</div>
                        <div class="pform-value" >{{ $packingList->vessel_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Voyage No.</div>
                        <div class="pform-value" >{{ $packingList->voyage_no }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
        </div>

        <table class="table table-striped page-list-table" >
            <thead>
                <tr>
                    <th style="width:2%;" >#</th>
                    <th style="width:5%;" class="text-center" >Size</th>
                    <th style="width:5%;" class="text-center" >No. of Pallets</th>
                    <th style="width:5%;" class="text-center" >No. of Packages</th>
                    <th style="width:5%;" class="text-left" >Package Type</th>
                    <th style="width:5%;" class="text-left" >Cargo Desc.</th>
                    <th style="width:5%;" class="text-left" >Variety</th>
                    <th style="width:5%;" class="text-center" >G.W. per Package</th>
                    <th style="width:5%;" class="text-center" >N.W. per Package</th>
                    <th style="width:5%;" class="text-center" >G.W. KG with pit weight</th>
                    <th style="width:5%;" class="text-center" >N.W. KG</th>
                    <th style="width:5%;" class="text-left" >Class</th>
                    <th style="width:5%;" class="text-left" >Brand</th>
                    <th style="width:5%;" class="text-left" >Lot</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $tot_pallet_qty = 0;
                    $tot_package_qty = 0;
                    $tot_gw_per_package = 0;
                    $tot_nw_per_package = 0;
                    $tot_gw_with_pallet = 0;
                    $tot_nw_kg = 0;
                @endphp
                @foreach($packingListDetail as $k => $v)
                <tr>
                    <td>{{ $k + 1 }}</td>
                    <td class="text-center" >{{ $v->item_size_per_package }}</td>
                    <td class="text-center" >{{ $v->pallet_qty }}</td>
                    <td class="text-center" >{{ $v->package_qty }}</td>
                    <td class="text-left" >{{ $v->packageType?->description }}</td>
                    <td class="text-left" >{{ $v->cargo_description }}</td>
                    <td class="text-left" >{{ $v->variety->ProductCategoryName }}</td>
                    <td class="text-center" >{{ $v->gw_per_package }}</td>
                    <td class="text-center" >{{ $v->nw_per_package }}</td>
                    <td class="text-center" >{{ $v->gw_with_pallet }}</td>
                    <td class="text-center" >{{ $v->nw_kg }}</td>
                    <td class="text-left" >{{ $v->class??'' }}</td>
                    <td class="text-left" >{{ $v->brand->brand_name??'' }}</td>
                    <td class="text-left" >{{ $v->lot_no }}</td>
                </tr>

                @php 
                    $tot_pallet_qty += $v->pallet_qty; 
                    $tot_package_qty += $v->package_qty; 
                    $tot_gw_per_package += $v->gw_per_package; 
                    $tot_nw_per_package += $v->nw_per_package; 
                    $tot_gw_with_pallet += $v->gw_with_pallet; 
                    $tot_nw_kg += $v->nw_kg; 
                @endphp
                @endforeach
                <tr class="total-row" >
                    <td></td>
                    <td class="text-left" >Total</td>
                    <td class="text-center" >{{ $tot_pallet_qty }}</td>
                    <td class="text-center" >{{ $tot_package_qty }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center" >{{ $tot_gw_per_package }}</td>
                    <td class="text-center" >{{ $tot_nw_per_package }}</td>
                    <td class="text-center" >{{ $tot_gw_with_pallet }}</td>
                    <td class="text-center" >{{ $tot_nw_kg }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
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