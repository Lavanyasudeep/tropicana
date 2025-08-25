@extends('adminlte::page')

@section('title', 'Create Packing List')

@section('content_header')
    <h1>Packing List</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Edit</h3>
    <div class="action-btns" >
        <a class="btn btn-success" href="{{ route('admin.inventory.packing-list.index') }}" href="#" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.packing-list.update', $packingList->packing_list_id) }}">
         @csrf
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-3" >
                    <div class="pform-panel" style="min-height:220px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. #</div>
                            <div class="pform-value" >
                                <input type="text" id="doc_no" name="doc_no" value="{{ $packingList->doc_no }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. Date</div>
                            <div class="pform-value" >
                                <input type="date" id="doc_date" name="doc_date" value="{{ $packingList->doc_date??date('Y-m-d') }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Invoice #</div>
                            <div class="pform-value" >
                                <input type="text" id="invoice_no" name="invoice_no" value="{{ $packingList->invoice_no }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Invoice Date</div>
                            <div class="pform-value" >
                                <input type="date" id="invoice_date" name="invoice_date" value="{{ $packingList->invoice_date??date('Y-m-d') }}" >
                            </div>
                        </div>
                         <div class="pform-row" >
                            <div class="pform-label" >Client</div>
                            <div class="pform-value" >
                                <select name="client_id" id="client_id">
                                    <option value="">- Select -</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->client_id }}" {{ $packingList->client_id == $client->client_id? 'selected' : '' }}>{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-3" >
                    <div class="pform-panel" style="min-height:220px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Supplier</div>
                            <div class="pform-value" >
                                <select name="supplier_id" id="supplier_id">
                                    <option value="">- Select -</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_id }}" {{ $packingList->supplier_id == $supplier->supplier_id? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Name</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_name" name="contact_name" value="{{ $packingList->contact_name }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Address</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_address" name="contact_address" value="{{ $packingList->contact_address }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Container #</div>
                            <div class="pform-value" >
                                <input type="text" id="no_of_containers" name="no_of_containers" value="{{ $packingList->container_nos }}" >
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <div class="col-md-3" >
                    <div class="pform-panel" style="min-height:220px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Package Type</div>
                            <div class="pform-value" >
                                <select name="package_type_id" id="package_type_id">
                                    <option value="">- Select -</option>
                                    @foreach($packageTypes as $packageType)
                                        <option value="{{ $packageType->unit_id }}" {{ $packingList->package_type_id == $packageType->unit_id? 'selected' : '' }}>{{ $packageType?->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Date of Loading</div>
                            <div class="pform-value" >
                                <input type="date" id="loading_date" name="loading_date" value="{{ $packingList->loading_date??date('Y-m-d') }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Port of Loading</div>
                            <div class="pform-value" >
                                <select name="loading_port_id" id="loading_port_id">
                                    <option value="">- Select -</option>
                                    @foreach($ports as $port)
                                        <option value="{{ $port->port_id }}" {{ $packingList->loading_port_id == $port->port_id? 'selected' : '' }}>{{ $port->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Port of Discharge</div>
                            <div class="pform-value" >
                                <select name="discharge_port_id" id="discharge_port_id">
                                    <option value="">- Select -</option>
                                    @foreach($ports as $port)
                                        <option value="{{ $port->port_id }}" {{ $packingList->discharge_port_id == $port->port_id? 'selected' : '' }}>{{ $port->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>
             
                <!-- Panel 4 -->
                <div class="col-md-3" >
                    <div class="pform-panel" style="min-height:220px;" >
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
                            <div class="pform-value" >
                                <input type="text" id="vessel_name" name="vessel_name" value="{{ $packingList->vessel_name }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Voyage No.</div>
                            <div class="pform-value" >
                                <input type="text" id="voyage_no" name="voyage_no" value="{{ $packingList->voyage_no }}" >
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>
            </div>

            <table class="table table-striped page-input-table">
                <thead>
                    <tr>
                        <th class="text-center" >#</th>
                        <th>Size</th>
                        <th>No. of Pallets</th>
                        <th>No. of Packages</th>
                        <th>Package Type</th>
                        <th>Cargo Desc.</th>
                        <th>Variety</th>
                        <th>G.W. per Package</th>
                        <th>N.W. per Package</th>
                        <th>G.W. KG with pit weight</th>
                        <th>N.W. KG</th>
                        <th>Class</th>
                        <th>Brand</th>
                        <th class="text-left" >Lot</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packingList->packingListDetails as $k => $v)
                    <tr>
                        <td class="text-center" >
                            <input type="hidden" name="packing_list_detail_ids[]" value="{{ $v->packing_list_detail_id }}" readonly>
                            {{ $k + 1 }}
                        </td>
                        <td>
                            <input type="text" name="item_size_per_package[]" value="{{ $v->item_size_per_package }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="pallet_qty[]" value="{{ $v->pallet_qty }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="package_qty[]" value="{{ $v->package_qty }}" readonly>
                        </td>
                        <td>
                            <select name="package_type_ids[]">
                                <option value="">- Select -</option>
                                @foreach($packageTypes as $packageType)
                                    <option value="{{ $packageType->unit_id }}" {{ $v->package_type_id == $packageType->unit_id ? 'selected' : '' }}>
                                        {{ $packageType?->description }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="product_ids[]" value="{{ $v->product_id }}">
                            <input type="text" name="cargo_description[]" value="{{ $v->cargo_description }}" readonly>
                        </td>
                        <td>
                            <select name="variety_id[]">
                                <option value="">- Select -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->ProductCategoryID }}" {{ $v->variety_id == $category->ProductCategoryID ? 'selected' : '' }}>
                                        {{ $category->ProductCategoryName }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="gw_per_package[]" value="{{ $v->gw_per_package }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="nw_per_package[]" value="{{ $v->nw_per_package }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="gw_with_pallet[]" value="{{ $v->gw_with_pallet }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="nw_kg[]" value="{{ $v->nw_kg }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="class[]" value="{{ $v->class ?? '' }}" readonly>
                        </td>
                        <td>
                            <select name="brand_id[]">
                                <option value="">- Select -</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->brand_id }}" {{ $v->brand_id == $brand->brand_id ? 'selected' : '' }}>
                                        {{ $brand->brand_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="lot_no[]" value="{{ $v->lot_no }}" readonly>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
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