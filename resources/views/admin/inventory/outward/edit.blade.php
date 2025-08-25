@extends('adminlte::page')

@section('title', 'Edit Outward')

@section('content_header')
    <h1>Outward</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Edit</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.outward.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.outward.update', $outward->outward_id) }}" id="outwardEditForm">
         @csrf
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-4" >
                    <div class="pform-panel" >
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. #</div>
                            <div class="pform-value" >
                                <input type="text" id="doc_no" value="{{ $outward->doc_no }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. Date</div>
                            <div class="pform-value" >
                                <input type="date" id="doc_date" name="doc_date" value="{{ $outward->doc_date??date('Y-m-d') }}" >
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
                                        <option value="{{ $client->client_id }}" {{ $outward->client_id == $client->client_id? 'selected' : '' }}>{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-4" >
                    <div class="pform-panel" >
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
                                <input type="text" id="contact_name" name="contact_name" value="{{ $outward->contact_name }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Address</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_address" name="contact_address" value="{{ $outward->contact_address }}" >
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
                            <div class="pform-value" >{{ $outward->pickList->pickListDetails[0]->packingList->goods??'' }}</div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Size</div>
                            <div class="pform-value" >{{ $outward->pickList->pickListDetails[0]->packingList->size??'' }}</div>
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

                <!-- Panel 5 -->
                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height:125px;">
                        <div class="pform-row" >
                            <div class="pform-label" >Vehicle No</div>
                            <div class="pform-value" >
                                <input type="text" id="vehicle_no" name="vehicle_no" value="{{ old('vehicle_no', $outward->vehicle_no ?? '') }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Driver</div>
                            <div class="pform-value" >
                                <input type="text" id="driver" name="driver" value="{{ old('driver', $outward->driver ?? '') }}" >
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>
            </div>
            
            <div class="row" >
                <div class="col-md-12" >
                    <div class="page-list-panel" >
                        <table class="page-list-table" id="outwardEditTable" >
                            <thead>
                                <tr>
                                    <th class="text-center" >#</th>
                                    <th>Product</th>
                                    <th>Lot</th>
                                    <th>Size</th>
                                    <th>Package Type</th>
                                    <th>Slot</th>
                                    <th>Pallet</th>
                                    <th>G.W. per Package</th>
                                    <th>N.W. per Package</th>
                                    <th>G.W. KG with pit weight</th>
                                    <th>N.W. KG</th>
                                    <th>Total Packages</th>
                                    <th>No. of Packages Picked</th>
                                    <!-- <th></th> -->
                                </tr>
                                <tr>
                                    <th></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <!-- <th></th> -->
                                </tr>
                            </thead>
                            <tbody></tbody>
                        
                            <tfoot>
                                <tr class="total-row">
                                    <th colspan="7" class="text-right">Total Selected:</th>
                                    <th id="total_gw_per_package" class="text-center"></th>
                                    <th id="total_nw_per_package" class="text-center"></th>
                                    <th id="total_gw_with_pallet" class="text-center"></th>
                                    <th id="total_nw_kg" class="text-center"></th>
                                    <th id="total_package_qty" class="text-center"></th>
                                    <th id="total_picked_qty" class="text-center"></th>
                                    <!-- <th></th> -->
                                </tr>
                            </tfoot>
                        </table>
                        <a id="btn-add-selected-products" class="btn btn-success mt-2">Add Products</a>

                        <div class="row" >
                            <div class="col-md-6" ></div>
                            <div class="col-md-6" >
                                <br />
                                <table class="table table-striped page-list-table" border="0">    
                                    <tbody>
                                        <tr>
                                            <td><span>Weight of 1 empty pallet</span></td>
                                            <td class="text-right" ><input type="text" value="{{ $outward->packing_lists?->pluck('weight_per_pallet')->implode(', ') }}" class="text-right" readonly="readonly" autocomplete="off"></td>
                                        </tr>
                                        <tr>
                                            <td><span><b>Total No of Pallets</b></span></td>
                                            <td class="text-right" ><input type="text" id="summary_total_pallets" value="" class="text-right" readonly autocomplete="off"></td>
                                        </tr>
                                        <tr>
                                            <td><span>Total No of Packages Picked</span></td>
                                            <td class="text-right" ><input type="text" name="tot_package_qty" id="summary_total_picked_qty" value="" class="text-right" readonly autocomplete="off"></td>
                                        </tr>
                                        <tr>
                                            <td><span>Total G.W with Pallets Weight</span></td>
                                            <td class="text-right" ><input type="text" id="summary_gw_with_pallet" value="" class="text-right" readonly autocomplete="off"></td>
                                        </tr>
                                        <tr>
                                            <td><span>Total N.W</span></td>
                                            <td class="text-right" ><input type="text" id="summary_nw_kg" value="" class="text-right" autocomplete="off"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="selected-products-inputs"></div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-save btn-sm float-right">Save</button>
                        </div>
                    </div>
                </div>
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
$(document).ready(function () {
    let client_id = "{{ $outward->client_id }}";
    let onlyPicked = 1;
    let selected= [];

    let table = $('#outwardEditTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        lengthMenu: [10, 20, 50, 100],
        pageLength: 20,
        ajax: {
            url: '{{ route("admin.inventory.outward.edit", $outward->outward_id) }}',
            data: function (d) {
                d.client_id = client_id;
                d.only_picked = onlyPicked;
            }
        },
        language: {
            emptyTable: "Please select a client to display data."
        },
        columns: [
            { data: 'pick', name: 'pick', width: '5%', orderable: false, searchable: false },
            { data: 'product_name', name: 'product_name'},
            { data: 'batch_no', name: 'batch_no' },
            { data: 'size', name: 'size' },
            { data: 'package_type', name: 'package_type' },
            // { data: 'room.name', name: 'room.name' },
            // { data: 'rack.name', name: 'rack.name' },
            // { data: 'slot.name', name: 'slot.name' },
            { data: 'slot_position', name: 'slot_position' },
            { data: 'pallet.name', name: 'pallet.name' },
            { data: 'gw_per_package', name: 'gw_per_package', className: 'gw_per_package'},
            { data: 'nw_per_package', name: 'nw_per_package', className: 'nw_per_package'},
            { data: 'gw_with_pallet', name: 'gw_with_pallet', className: 'gw_with_pallet'},
            { data: 'nw_kg', name: 'nw_kg', className: 'nw_kg'},
            { data: 'out_qty', name: 'out_qty', className: 'out_qty' },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'pick-qty',
                render: function (data, type, row) {
                    const value = row.pick_qty??0;
                    return `<input type="text" class="form-control text-center selected-qty" 
                        min="0" value="${value}" data-prev="${value}" readonly>`;
                }
            }
            // {
            //     data: null,
            //     orderable: false,
            //     searchable: false,
            //     render: function (data, type, row) {
            //         const value = row.pick_qty??0;
            //         return `<button type="button" class="btn btn-sm btn-danger remove-row">&times;</button>`;
            //     }
            // }
        ],
        columnDefs: [
            {
                targets: [0, 3, 5, 6, 7, 8, 9, 10, 11, 12],
                className: 'text-center'
            }
        ],
        order: [[0, 'desc']],
        initComplete: function () {
            // optional: only clear on initial load
            // table.clear().draw();
            updateSelectedItems();
        },
        drawCallback: function () {
            updateSelectedItems();
        },
    });

    $(document).on('click', '#btn-add-selected-products', function () {
        onlyPicked = 0; 
        table.ajax.reload(); 
        $(this).hide(); 
    });

    $('#outwardEditTable thead').on('keyup change', '.column-search', function () {
        let colIndex = $(this).parent().index();
        table.column(colIndex).search(this.value).draw();
    });

    $(document).on('change', '.pick-check', function (e) {
        e.preventDefault();
        const row = $(this).closest('tr');
        const packageQty = parseInt($(this).data('package-qty')) || 0;
        
        if($(this).is(':checked'))
                row.find('.selected-qty').val(packageQty);
        else
            row.find('.selected-qty').val('0');

        updateSelectedItems();
    });

    $(document).on('submit', '#outwardEditForm', function() {
        updateSelectedItems();  
    });

    // Remove row on button click
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
        updateTotals();
    });

    // Optionally also update totals when picked_qty is edited
    $(document).on('input', 'input[name="picked_qty[]"]', function () {
        updateTotals();
    });

    function updateSelectedItems() {
        selected = [];

        $('#outwardEditTable tbody tr').each(function() {
            const $row = $(this);
            const checkbox = $row.find('.pick-check');

            if (checkbox.is(':checked')) {
                selected.push({
                    outward_detail_id: checkbox.data('outward-detail-id'),
                    packing_list_detail_id: checkbox.data('packing-list-detail-id'),
                    pallet_id: checkbox.data('pallet-id'),
                    package_qty: checkbox.data('package-qty'),
                    pick_qty: parseFloat($row.find('.selected-qty').val()) || 0
                });
            } 
        });

        // if(selected.length === 0){
        //     alert('Please select at least one product.');
        //     return;
        // }

        // Now update hidden inputs
        let hiddenInputsHtml = '';

        selected.forEach(function(item, index) {
            hiddenInputsHtml += `
                <input type="hidden" name="selected_items[${index}][pallet_id]" value="${item.pallet_id}">
                <input type="hidden" name="selected_items[${index}][outward_detail_id]" value="${item.outward_detail_id}">
                <input type="hidden" name="selected_items[${index}][packing_list_detail_id]" value="${item.packing_list_detail_id}">
                <input type="hidden" name="selected_items[${index}][package_qty]" value="${item.package_qty}">
                <input type="hidden" name="selected_items[${index}][pick_qty]" value="${item.pick_qty}">
            `;
        });

        $('#selected-products-inputs').html(hiddenInputsHtml);

        updateTotals();
    }

    function updateTotals() {
        let totalGW = 0, totalNW = 0, totalGWWithPallet = 0, totalNWKg = 0, totalQty = 0, totalPicked = 0, totalPalletQty = 0;
        let palletNames = {}; // for unique pallet counting

        table.rows().every(function () {
            const row = this.data();
            const $rowNode = $(this.node());
            const checkbox = $rowNode.find('.pick-check');

            if (checkbox.is(':checked')) {
                const gwPerPackage = parseFloat(row.gw_per_package) || 0;
                const nwPerPackage = parseFloat(row.nw_per_package) || 0;
                const gwWithPallet = parseFloat(row.gw_with_pallet) || 0;
                const nwKg = parseFloat(row.nw_kg) || 0;
                const packageQty = parseFloat(row.out_qty) || 0;
                
                const pickedQty = parseFloat($rowNode.find('.selected-qty').val()) || 0;

                totalGW += gwPerPackage;
                totalNW += nwPerPackage;
                totalGWWithPallet += gwWithPallet;
                totalNWKg += nwKg;
                totalQty += packageQty;
                totalPicked += pickedQty;

                if (row.pallet && row.pallet.name) {
                    palletNames[row.pallet.name] = true;
                }
            }
        });

        totalPalletQty = Object.keys(palletNames).length;

        // Update table footer
        $('#total_gw_per_package').text(totalGW.toFixed(2));
        $('#total_nw_per_package').text(totalNW.toFixed(2));
        $('#total_gw_with_pallet').text(totalGWWithPallet.toFixed(2));
        $('#total_nw_kg').text(totalNWKg.toFixed(2));
        $('#total_package_qty').text(totalQty);
        $('#total_picked_qty').text(totalPicked);

        // Update summary section inputs
        $('#summary_total_pallets').val(totalPalletQty);
        $('#summary_total_picked_qty').val(totalPicked);
        $('#summary_gw_with_pallet').val(totalGWWithPallet.toFixed(2));
        $('#summary_nw_kg').val(totalNWKg.toFixed(2));
    }
});
</script>
@stop