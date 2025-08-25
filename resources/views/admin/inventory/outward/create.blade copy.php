@extends('adminlte::page')

@section('title', 'Create Outward')

@section('content_header')
    <h1>Outward</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="d-flex justify-content-between align-items-center page-list-title">
    <h3>Create</h3>
    <div class="page-list-action-btns" >
        <a href="{{ route('admin.inventory.pick-list.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.outward.store') }}">
         @csrf
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:220px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. #</div>
                            <div class="pform-value" >
                                <input type="text" id="doc_no" name="doc_no" value="" readonly>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. Date</div>
                            <div class="pform-value" >
                                <input type="date" id="doc_date" name="doc_date" value="@php echo date('Y-m-d') @endphp" >
                            </div>
                        </div>
                        <div class="pform-row d-none" >
                            <div class="pform-label" >Invoice #</div>
                            <div class="pform-value" >
                                <input type="text" id="invoice_no" name="invoice_no" value="" >
                            </div>
                        </div>
                        <div class="pform-row d-none" >
                            <div class="pform-label" >Invoice Date</div>
                            <div class="pform-value" >
                                <input type="date" id="invoice_date" name="invoice_date" value="@php echo date('Y-m-d') @endphp" >
                            </div>
                        </div>
                         <div class="pform-row" >
                            <div class="pform-label" >Client</div>
                            <div class="pform-value" >
                                <select name="client_id" id="client_id">
                                    <option value="">- Select -</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->client_id }}" {{ $pickList->client_id == $client->client_id? 'selected' : '' }}>{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:220px;" >
                        <div class="pform-row d-none" >
                            <div class="pform-label" >Customer</div>
                            <div class="pform-value" >
                                <select name="supplier_id" id="supplier_id">
                                    <option value="">- Select -</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Name</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_name" name="contact_name" value="{{ $pickList->contact_name }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Address</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_address" name="contact_address" value="{{ $pickList->contact_address }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Container #</div>
                            <div class="pform-value" >
                                <input type="text" id="no_of_containers" name="no_of_containers" value="" >
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <div class="col-md-3 d-none" >
                    <div class="pform-panel" style="min-height:220px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Package Type</div>
                            <div class="pform-value" >
                                <select name="package_type_id" id="package_type_id">
                                    <option value="">- Select -</option>
                                    @foreach($packageTypes as $packageType)
                                        <option value="{{ $packageType->unit_id }}">{{ $packageType?->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Date of Loading</div>
                            <div class="pform-value" >
                                <input type="date" id="loading_date" name="loading_date" value="@php echo date('Y-m-d') @endphp" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Port of Loading</div>
                            <div class="pform-value" >
                                <select name="loading_port_id" id="loading_port_id">
                                    <option value="">- Select -</option>
                                    @foreach($ports as $port)
                                        <option value="{{ $port->port_id }}">{{ $port->Name }}</option>
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
                                        <option value="{{ $port->port_id }}">{{ $port->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>
             
                <!-- Panel 4 -->
                <div class="col-md-3 d-none" >
                    <div class="pform-panel" style="min-height:220px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >GOODS</div>
                            <div class="pform-value" >{{ $pickList->pickListDetails[0]->packingList->goods??'' }}</div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Size</div>
                            <div class="pform-value" >{{ $pickList->pickListDetails[0]->packingList->size??'' }}</div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >BL. No.</div>
                            <div class="pform-value" ></div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Name of Vessel</div>
                            <div class="pform-value" >
                                <input type="text" id="vessel_name" name="vessel_name" value="" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Voyage No.</div>
                            <div class="pform-value" >
                                <input type="text" id="voyage_no" name="voyage_no" value="" >
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
                    @foreach($pickList->pickListDetails as $k => $v)
                    <tr>
                        <td class="text-center" >{{ $k + 1 }}</td>
                        <td>
                            <input type="text" name="item_size_per_package[]" value="{{ $v->packingListDetail->item_size_per_package }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="pallet_qty[]" value="{{ $v->packingListDetail->pallet_qty }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="package_qty[]" value="{{ $v->packingListDetail->package_qty }}" readonly>
                        </td>
                        <td>
                            <select name="package_type_id[]">
                                <option value="">- Select -</option>
                                @foreach($packageTypes as $packageType)
                                    <option value="{{ $packageType->unit_id }}" {{ $v->packingListDetail->package_type_id == $packageType->unit_id ? 'selected' : '' }}>
                                        {{ $packageType?->description }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="product_ids[]" value="{{ $v->packingListDetail->product_id }}">
                            <input type="text" name="cargo_description[]" value="{{ $v->packingListDetail->cargo_description }}" readonly>
                        </td>
                        <td>
                            <select name="variety_id[]">
                                <option value="">- Select -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->ProductCategoryID }}" {{ $v->packingListDetail->variety_id == $category->ProductCategoryID ? 'selected' : '' }}>
                                        {{ $category->ProductCategoryName }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="gw_per_package[]" value="{{ $v->packingListDetail->gw_per_package }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="nw_per_package[]" value="{{ $v->packingListDetail->nw_per_package }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="gw_with_pallet[]" value="{{ $v->packingListDetail->gw_with_pallet }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="nw_kg[]" value="{{ $v->packingListDetail->nw_kg }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="class[]" value="{{ $v->packingListDetail->class ?? '' }}" readonly>
                        </td>
                        <td>
                            <select name="brand_id[]">
                                <option value="">- Select -</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->brand_id }}" {{ $v->packingListDetail->brand_id == $brand->brand_id ? 'selected' : '' }}>
                                        {{ $brand->brand_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="lot_no[]" value="{{ $v->packingListDetail->lot_no }}" readonly>
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