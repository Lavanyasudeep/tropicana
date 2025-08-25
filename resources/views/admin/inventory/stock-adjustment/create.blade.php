@extends('adminlte::page')

@section('title', 'Create Stock Adjustment')

@section('content_header')
    <h1>Stock Adjustment</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Create</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.stock-adjustment.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.stock-adjustment.store') }}" id="stockAdjForm">
            @csrf
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height:250px;">
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. #</div>
                            <div class="pform-value" >
                                <input type="text" id="doc_no" value="" readonly>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. Date</div>
                            <div class="pform-value" >
                                <input type="date" id="doc_date" name="doc_date" value="{{ old('doc_date', date('Y-m-d')) }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Client</div>
                            <div class="pform-value" >
                                <select name="client_id" id="client_id">
                                    <option value="">- Select -</option>
                                    @foreach($clients as $v)
                                        <option value="{{ $v->client_id }}"
                                            @selected(old('client_id', $v->client_id))>
                                            {{ $v->client_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Reason</div>
                            <div class="pform-value" >
                               <input type="text" id="reason" name="reason" value="{{ old('reason') }}"/>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Remarks</div>
                            <div class="pform-value" >
                               <textarea style="height:100px !important; width:100%; border:1px solid #CCC;" name="remarks" id="remarks" >{{ old('remarks') }}</textarea>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-8" >
                    <div class="pform-panel" style="min-height:250px; max-height:250px; overflow-y:auto;">
                        <div class="page-quick-filter" style="margin-bottom:0;" >
                            <div class="row">
                                <div class="col-md-2 fltr-title">
                                    <span>FILTER BY</span>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text pq-fltr-icon"><i class="fas fa-calendar-alt fa-lg"></i></span>
                                        </div>
                                        <input type="text" id="fltrDateRangePicker" class="form-control pq-fltr-input" placeholder="Date Range" readonly style="background-color: white; cursor: pointer;" />
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text pq-fltr-icon"><i class="fas fa-search fa-lg"></i></span>
                                        </div>
                                        <input type="text" id="fltrSearchBox" class="form-control pq-fltr-input" placeholder="Search Products..." >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="page-add-panel" >
                            <table class="page-add-table table table-sm" id="stockAdjProdAddTable" >
                                <thead >
                                    <tr>
                                        <th style="width:25%;" >Product</th>
                                        <th style="width:25%;" >Lot</th>
                                        <th style="width:10%; text-align:center;" >Avl Qty</th>
                                        <th style="width:10%; text-align:center;" >Grn Qty</th>
                                        <th style="width:20%;" >Grn No</th>
                                        <th style="width:10%; text-align:center;" ></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-md-12" >
                    <div class="page-list-panel" >
                        <table class="page-list-table" id="stockAdjCreateTable" >
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Lot No.</th>
                                    <th>Package Type</th>
                                    <th>Weight Per Unit</th>
                                    <th style="display:none;">G.W. per Package</th>
                                    <th style="display:none;">N.W. per Package</th>
                                    <th style="display:none;">Qty Per Full Pallet</th>
                                    <th style="display:none;">Qty Per Half Pallet</th>
                                    <th>Adjust In/Out</th>
                                    <th>Adjust Qty</th>
                                    <th>Pallet Qty</th>
                                    <th style="display:none;">Pallet Weight</th>
                                    <th style="display:none;">G.W. KG with pit weight</th>
                                    <th style="display:none;">N.W. KG</th>
                                    <th>Reason</th>
                                    <th>Inventory Location</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot style="display:none;" >
                                <tr class="total-row" >
                                    <th colspan="7" class="text-right" >Total:</th>
                                    <!-- <th id="total_gw_per_package" class="text-center"></th>
                                    <th id="total_nw_per_package" class="text-center"></th>
                                    <th id="total_gw_with_pallet" class="text-center"></th>
                                    <th id="total_nw_kg" class="text-center"></th> -->
                                    <th id="tot_package_per_full_pallet_qty" class="text-center"></th>
                                    <th id="tot_package_per_half_pallet_qty" class="text-center"></th>
                                    <th id="total_package_qty" class="text-center"></th>
                                    <th id="total_pallet_qty" class="text-center"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="row" >
                            <div class="col-md-6" ></div>
                            <div class="col-md-6">
                                <br />
                                <table class="table table-striped page-list-table" border="0">    
                                    <tbody>
                                        <tr>
                                            <td><span><b>Total No. of Pallets</b></span></td>
                                            <td class="text-right">
                                                <input type="text" id="summary_total_pallets" value="" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>Total No. of Packages Adjusted</span></td>
                                            <td class="text-right">
                                                <input type="text" name="tot_package_qty" id="summary_total_picked_qty" value="" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>Total G.W with Pallets Weight</span></td>
                                            <td class="text-right">
                                                <input type="text" id="summary_gw_with_pallet" value="" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>Total N.W</span></td>
                                            <td class="text-right">
                                                <input type="text" id="summary_nw_kg" value="" class="text-right" autocomplete="off">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div id="assigned-products-inputs"></div>
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
    #stockAdjProdAddTable {  }
    #stockAdjProdAddTable th { font-size:11px; }
    #stockAdjProdAddTable td { font-size:11px; }
</style>
@stop

@section('js')
<script>
$(document).ready(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const packingListDetail = @json($packingListDetail);
    let adjustmentProducts = @json($adjustmentProducts) || {};
    const stockAdjustmentReasons = @json($stockAdjustmentReasons);
   
    let stockAdjCreateTable = $('#stockAdjCreateTable').DataTable({
        processing: true,
        serverSide: false,  // local processing
        searching: true,
        lengthMenu: [10, 20, 50, 100],
        pageLength: 20,
        info: false,
        columns: [
            { data: 'product_name' },
            { data: 'batch_no' },
            { data: 'package_type', className: 'packageType' },
            { data: 'weight_per_unit', className: 'weightPerUnit, text-center'},
            { data: 'gw_per_package', className: 'gwPerPackage' },
            { data: 'nw_per_package', className: 'nwPerPackage' },
            { data: 'package_qty_per_full_pallet', className: 'packageQtyPerFullPallet'},
            { data: 'package_qty_per_half_pallet', className: 'packageQtyPerHalfPallet'},
            {
                data: 'in_out',
                className: 'text-center',
                render: function(data, type, row) {
                    const inOut = (row.in_out || '').toLowerCase();
                    const selectedIn = inOut === 'in' ? 'selected' : '';
                    const selectedOut = inOut === 'out' ? 'selected' : '';
                    return `
                        <select class="form-control form-control-sm in_out_option" name="in_out_option[${row.packing_list_detail_id ?? ''}]">
                            <option value="In" ${selectedIn}>In</option>
                            <option value="Out" ${selectedOut}>Out</option>
                        </select>
                    `;
                }
            },
            { data: 'package_qty', className: 'packageQty' },
            { data: 'pallet_qty', className: 'palletQty, text-center'},
            { data: 'pallet_weight', className: 'palletWeight'},
            { data: 'gw_with_pallet', className: 'gwWithPallet'},
            { data: 'nw_kg', className: 'nwKg' },
            { data: 'reason', className: 'reason'},
            { data: 'selected_location' },
            { data: 'action', orderable: false, searchable: false, render: function(data, type, row) {

                var addedProductsDataJson = JSON.stringify(row.addedProductsData);
                if (addedProductsDataJson) {
                    addedProductsDataJson = addedProductsDataJson.replace(/"/g, '&quot;');
                }
                //const csrfTokenInput = `<input type="hidden" name="_token" value="${csrfToken}">`;
                let assignButton = '';
                if (row.in_out === 'in') {
                    //const assignUrl = `/admin/inventory/stock-adjustment/${row.packing_list_id}/assign/${row.packing_list_detail_id}`;

                    assignButton = `
                            <input type="hidden" name="packing_list_id" value="${row.packing_list_id}">
                            <input type="hidden" name="packing_list_detail_id" value="${row.packing_list_detail_id}">
                            <input type="hidden" name="product_id" value="${row.product_id}">
                            <input type="hidden" name="package_qty" value="">
                            <input type="hidden" name="movement_type" value="${row.in_out}">
                            <input type="hidden" name="package_qty_per_full_pallet" value="${row.package_qty_per_full_pallet}">
                            <input type="hidden" name="package_qty_per_half_pallet" value="${row.package_qty_per_half_pallet}">
                            <input type="hidden" name="reason" value="">
                            <input type="hidden" name="adjustment_products" value="${addedProductsDataJson}" >
                            <button type="button" class="btn btn-info btn-sm" onclick="return checkPackageQty(this)" >
                                Select Slot
                            </button>`;
                } else if (row.in_out === 'out') {
                    //const reassignUrl = `/admin/inventory/stock-adjustment/${row.packing_list_id}/reassign/${row.packing_list_detail_id}`;

                    assignButton = `
                            <input type="hidden" name="packing_list_id" value="${row.packing_list_id}">
                            <input type="hidden" name="packing_list_detail_id" value="${row.packing_list_detail_id}">
                            <input type="hidden" name="product_id" value="${row.product_id}">
                            <input type="hidden" name="package_qty" value="">
                            <input type="hidden" name="movement_type" value="${row.in_out}">
                            <input type="hidden" name="package_qty_per_full_pallet" value="${row.package_qty_per_full_pallet}">
                            <input type="hidden" name="package_qty_per_half_pallet" value="${row.package_qty_per_half_pallet}">
                            <input type="hidden" name="reason" value="">
                            <input type="hidden" name="adjustment_products" value="${addedProductsDataJson}" >
                            <button type="button" class="btn btn-warning btn-sm" onclick="return checkPackageQty(this)" >
                                Select Slot
                            </button>`;
                }

                // Close button common to both
                const closeButton = `
                    <button type="button" class="btn btn-danger btn-sm removeProductBtn" data-packing-list-detail-id="${row.packing_list_detail_id}">
                        Cancel
                    </button>`;

                return `${assignButton} ${closeButton}`;
            } }
        ],
        columnDefs: [
            {
                targets: [4, 5, 6, 7, 11, 12, 13],
                visible: false
            },
            {
                targets: [3, 4, 5, 6, 7, 8],
                className: 'text-center'
            }
        ],
        rowCallback: function (row, data) {
            // calculatePackageQtyPerPallet($(row).find('.packageQtyPerFullPallet').closest('tr'));
            // calculatePackageQtyPerHalfPallet($(row).find('.packageQtyPerHalfPallet').closest('tr'));
        },
        drawCallback: function () {
            recalculateFooterTotals();
        }
    });

    $('#fltrDateRangePicker').daterangepicker({
        opens: 'right',
        autoUpdateInput: true,
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        },
        startDate: moment().subtract(2, 'months'),
        endDate: moment(),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });

    $(document).on('click', '#fltrSearchBtn', function () {
        table.ajax.reload();
    });

    let productAddTable = $('#stockAdjProdAddTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        paging: false,
        ajax: {
            url: '{{ route("admin.inventory.stock-adjustment.create") }}', 
            data: function (d) {
                let range = $('#fltrDateRangePicker').val();
                if (range) {
                    let dates = range.split(' - ');

                    // Function to convert dd/mm/yyyy to yyyy-mm-dd
                    function formatDate(dateStr) {
                        let parts = dateStr.split('/');
                        return `${parts[2]}-${parts[1]}-${parts[0]}`; // yyyy-mm-dd
                    }

                    d.from_date = formatDate(dates[0]);
                    d.to_date = formatDate(dates[1]);
                }
                d.client_flt = $('#client_id').val();
                d.quick_search = $('#fltrSearchBox').val();
            }
        },
        language: {
            emptyTable: "Please select a client to display data."
        },
        columns: [
            { data: 'product_name', name: 'product_name', orderable: false },
            { data: 'batch_no', name: 'batch_no' },
            { data: 'tot_avl_qty', name: 'available_qty' },
            { data: 'grn_qty', name: 'grn_qty' },
            { data: 'grn_no', name: 'grn_no' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button type="button" class="btn btn-primary btn-sm addProductBtn"
                            data-packing-list-detail-id="${row.packing_list_detail_id}" >
                            <i class="fas fa-plus"></i> Add
                        </button>
                    `;
                }
            }
        ],
        columnDefs: [
            {
                targets: [2, 3],
                className: 'text-center'
            }
        ],
        destroy: true
    });

    $('#client_id').on('change', function () {
        productAddTable.ajax.reload();
    });

    $('#stockAdjProdAddTable').on('click', '.addProductBtn', function () {
        const btn = $(this);
        const packingListDetailId = btn.data('packing-list-detail-id');

        const reasonOptions = stockAdjustmentReasons.map(r => 
                        `<option value="${r.value}">${r.label}</option>`
                    ).join('');
                    
        // ✅ Prevent duplicates
        if (adjustmentProducts[packingListDetailId]) {
            alert('This product is already added to the table.');
            return;
        }

        // ✅ Get details from packingListDetail object (keyed by id)
        const rowData = packingListDetail[packingListDetailId];
        
        if (!rowData) {
            alert('Product details not found!');
            return;
        }

        // ✅ Mark as selected
        adjustmentProducts[packingListDetailId] = rowData;

       
        
        // ✅ Add row to DataTable
        stockAdjCreateTable.row.add({
            packing_list_id : rowData.packing_list_id, 
            packing_list_detail_id : packingListDetailId, 
            product_id: rowData.product_id, 
            in_out: 'in',
            product_name: rowData.product?.product_description ?? '',
            batch_no: rowData.lot_no ?? '',
            weight_per_unit: rowData.item_size_per_package ?? '',
            package_type: rowData.package_type?.unit ?? '',
            gw_per_package: rowData.gw_per_package ?? '',
            nw_per_package: rowData.nw_per_package ?? '',
            package_qty_per_full_pallet: rowData.package_qty_per_full_pallet ?? '',
            package_qty_per_half_pallet: rowData.package_qty_per_half_pallet ?? '',
            package_qty: `<input type="number" class="form-control text-center package_qty" min="0" name="package_qty[${packingListDetailId}]" value="">`,
            pallet_qty: `<span class="pallet_qty text-center">0</span>`,
            pallet_weight: rowData.packing_list?.weight_per_pallet?? 0,
            gw_with_pallet: '',
            nw_kg: '',
            reason: `
                <select class="form-control reason" name="reason[${packingListDetailId}]">
                    <option value="">- Select -</option>
                    ${reasonOptions}
                </select>
            `,
            selected_location: `<input type="text" class="form-control" readonly name="selected_location[${packingListDetailId}]" value="">`,
            action: '',
            addedProductsData: adjustmentProducts
        }).draw();
        
    });

    $('#stockAdjCreateTable').on('click', '.removeProductBtn', function () {
        const btn = $(this);
        const packingListDetailId = btn.data('packing-list-detail-id');

        // ✅ Unmark from selected list
        delete adjustmentProducts[packingListDetailId];

        // ✅ Remove from table
        stockAdjCreateTable
            .row(btn.closest('tr'))
            .remove()
            .draw();

        $.post('{{ route("admin.inventory.stock-adjustment.remove-adjustment-product") }}',  {
                _token: $('meta[name="csrf-token"]').attr('content'),
                packing_list_detail_id: packingListDetailId,
            }, 
            function(response) {
                console.log(response);
            }
        );
            
    });

    $(document).on('change', 'select.in_out_option', function () {
        const select = $(this);
        const newValue = select.val().toLowerCase();  // "in" or "out"

        // Get the DataTable row for this select
        const tr = select.closest('tr');
        const row = stockAdjCreateTable.row(tr);


        if (!row.node()) {
            console.error('Row not found!');
            return;
        }

        // Get current data
        const data = row.data();

        console.log('- in_out_option -');
        console.log(data);

        // Update in_out property
        data.in_out = newValue;

        // Set updated data back into DataTable and redraw only this row
        row.data(data).draw(false);

        // Optionally recalculate footer totals if needed
        recalculateFooterTotals();
    });

    $(document).on('input', 'td.packageQty input', function () {
        let table = $('#stockAdjCreateTable').DataTable();
        let rowData = table.row($(this).closest('tr')).data(); // Get full row data

        const packageQuantity = parseFloat($(this).val()) || 0;
        const perFullPallet = parseFloat(rowData.package_qty_per_full_pallet) || 0;
        const perHalfPallet = parseFloat(rowData.package_qty_per_half_pallet) || 0;
        const palletQuantity = parseFloat(rowData.pallet_qty) || 0;
        const weightPerPallet = parseFloat(rowData.pallet_weight) || 0;

        const gwPerPackage = parseFloat(rowData.gw_per_package) || 0;
        const nwPerPackage = parseFloat(rowData.nw_per_package) || 0;
        
        const gwWithPallet = (gwPerPackage * packageQuantity) + (palletQuantity * weightPerPallet);
        const nwKg = nwPerPackage * packageQuantity;

        $(this).closest('tr').find('input[name="package_qty_per_full_pallet"]').val(perFullPallet);
        $(this).closest('tr').find('input[name="package_qty_per_half_pallet"]').val(perHalfPallet);
        $(this).closest('tr').find('input[name="package_qty"]').val(packageQuantity);

        $(this).closest('tr').find('td.gwWithPallet').text(gwWithPallet);
        $(this).closest('tr').find('td.nwKg').text(nwKg);

        recalculateFooterTotals();
    });

    $(document).on('change', 'select.reason', function () {
        $(this).closest('tr').find('input[name="reason"]').val($(this).val());
    });

    // $(document).on('input', 'td.packageQtyPerPallet input', function () {
    //     // ✅ Manually trigger footer callback
    //     // $('#inwardCreateTable').DataTable().draw(false);
    //     calculatePackageQtyPerPallet($(this).closest('tr'));
    //     recalculateFooterTotals();
    // });

    // function calculatePackageQtyPerPallet($row) {
    //     const weightPerUnit = parseFloat($row.find('td.weightPerUnit').text()) || 0;
    //     const weightPerPackage = parseFloat($row.find('td.gwPerPackage').text()) || 0;
    //     const packageQuantity = parseFloat($row.find('td.packageQty input').val()) || 0;
    //     const packageType = $row.find('td.packageType').text().trim();

    //     let packageCount;
    //     if (packageType === 'Kg') {
    //         packageCount = Math.ceil((packageQuantity * weightPerUnit) / weightPerPackage);
    //     } else {
    //         packageCount = parseInt(packageQuantity) || 0;
    //     }

    //     const perFullPallet = parseFloat($row.find('td.packageQtyPerFullPallet').text()) || 0;
    //     const perHalfPallet = parseFloat($row.find('td.packageQtyPerHalfPallet').text()) || 0;
    //     const $palletCell = $row.find('td.palletQty');

    //     $row.find('input[name="package_qty_per_full_pallet"]').val(perFullPallet);
    //     $row.find('input[name="package_qty_per_half_pallet"]').val(perHalfPallet);

    //     // if (perPallet > 0) {
    //     //     const palletQty = Math.ceil(packageCount / perPallet);
    //     //     $palletCell.text(palletQty);
    //     //     $row.find('input[name="pallet_qty"]').val(palletQty);
    //     // } else {
    //     //     $palletCell.text('0');
    //     // }

    //     $row.find('input[name="package_qty"]').val(packageQuantity);
    // }

    $(function () {
        Object.entries(adjustmentProducts).forEach(([id, rowData]) => {
            let selected_slots = rowData.selected_slots?? [];
            
            const reasonOptions = stockAdjustmentReasons.map(r => 
                `<option value="${r.value}" ${rowData.reason == r.value ? 'selected' : ''}>${r.label}</option>`
            ).join('');

            if (typeof selected_slots === 'string') {
                selected_slots = JSON.parse(selected_slots);
            }

            const selected_locations = [];

            Object.values(selected_slots).forEach((slot) => {
                const locationText = slot.location || `${slot.room_name}-${slot.rack_no}-${slot.level_no}-${slot.depth_no}`;
                selected_locations.push(locationText);
            });

            if (selected_locations.length === 0) {
                selected_locations.push('No location selected');
            }

            const slotCount = Object.values(selected_slots).length;
           
            stockAdjCreateTable.row.add({
                packing_list_id: rowData.packing_list_id,
                packing_list_detail_id: id,
                product_id: rowData.product_id,
                in_out: rowData.movement_type ?? 'in',
                product_name: rowData.product?.product_description ?? '',
                batch_no: rowData.lot_no ?? '',
                weight_per_unit: rowData.item_size_per_package ?? '',
                package_type: rowData.package_type?.unit ?? '',
                gw_per_package: rowData.gw_per_package ?? '',
                nw_per_package: rowData.nw_per_package ?? '',
                package_qty_per_full_pallet: rowData.package_qty_per_full_pallet ?? '',
                package_qty_per_half_pallet: rowData.package_qty_per_half_pallet ?? '',
                package_qty: `<input type="number" class="form-control text-center package_qty" min="0" name="package_qty[${id}]" value="${rowData.package_qty}">`,
                pallet_qty: `<span class="pallet_qty text-center">${slotCount??0}</span>`,
                pallet_weight: rowData.packing_list?.weight_per_pallet?? 0,
                gw_with_pallet: '',
                nw_kg: '',
                reason: `
                    <select class="form-control reason" name="reason[${id}]">
                        <option value="">- Select -</option>
                        ${reasonOptions}
                    </select>
                `,
                selected_location: `<input type="text" class="form-control" readonly name="selected_location[${id}]" value="${selected_locations.join(', ')}">`,
                action: ''
            });
        });

        stockAdjCreateTable.draw();

        $('td.packageQty input').trigger('input');
    });
    

    function recalculateFooterTotals() {
        let table = $('#stockAdjCreateTable').DataTable();

        let totPackageQty = 0;
        let totPackagePerFullPallet = 0;
        let totPackagePerHalfPallet = 0;
        let totPalletQty = 0;
        let totGWWithPallet = 0;
        let totNWKg = 0;

        table.rows({ page: 'current' }).every(function () {
            const $row = $(this.node());

            const packageQty = parseFloat($row.find('td.packageQty input').val()) || 0;
            const perFullPallet = parseFloat($row.find('td.packageQtyPerFullPallet').text()) || 0;
            const perHalfPallet = parseFloat($row.find('td.packageQtyPerHalfPallet').text()) || 0;
            const palletQty = parseFloat($row.find('td.palletQty').text()) || 0;
            const gwWithPallet = parseFloat($row.find('td.gwWithPallet').text()) || 0;
            const nwKg = parseFloat($row.find('td.nwKg').text()) || 0;

            totPackageQty += packageQty;
            totPackagePerFullPallet += perFullPallet;
            totPackagePerHalfPallet += perHalfPallet;
            totPalletQty += palletQty;
            totGWWithPallet += gwWithPallet;
            totNWKg += nwKg;
        });

        $('#total_package_qty').html(totPackageQty.toLocaleString());
        $('#tot_package_per_full_pallet_qty').html(totPackagePerFullPallet.toLocaleString());
        $('#tot_package_per_half_pallet_qty').html(totPackagePerHalfPallet.toLocaleString());
        $('#total_pallet_qty').html(totPalletQty.toLocaleString());

        $('#summary_total_pallets').val(totPalletQty);
        $('#summary_total_picked_qty').val(totPackageQty);
        $('#summary_gw_with_pallet').val(totGWWithPallet.toFixed(2));
        $('#summary_nw_kg').val(totNWKg.toFixed(2));
    }

});

/*
function checkPackageQty(button) {
    var td = button.closest('td');
    const packageQty = td.querySelector('input[name="package_qty"]').value.trim();

    if (!packageQty) {

        alert("Please enter Package quantity");
        return false; // Stop form submission

    } else {

        if(confirm("Are you sure you want to proceed?")) {
            const assignUrl = `/admin/inventory/stock-adjustment`;

            const form = $('<form>', {
                action: '${assignUrl}', // route('example.store')
                method: 'POST'
            });

            form.append(td.clone().html());

            $('body').append(form);
            form.trigger('submit');
        }
        
    }
}*/
function checkPackageQty(button) {
    var td = button.closest('td');
    const packageQtyInput = td.querySelector('input[name="package_qty"]');
    const packageQty = packageQtyInput?.value.trim();

    if (!packageQty) {
        alert("Please enter Package quantity");
        return false; // Stop form submission
    }

    if (confirm("Are you sure you want to proceed?")) {
        const packing_list_id = $(td).find('input[name="packing_list_id"]').val();
        const packing_list_detail_id = $(td).find('input[name="packing_list_detail_id"]').val();
        const movement_type = $(td).find('input[name="movement_type"]').val();
        var assignUrl = '';

        if(movement_type == 'in') {
            assignUrl = `/admin/inventory/stock-adjustment/${packing_list_id}/assign/${packing_list_detail_id}`;
        } else {
            assignUrl = `/admin/inventory/stock-adjustment/${packing_list_id}/reassign/${packing_list_detail_id}`;
        }

        // Create form
        const form = $('<form>', {
            action: assignUrl,
            method: 'POST'
        });

        // Append CSRF
        form.append($('<input>', {
            type: 'hidden',
            name: '_token',
            value: $('meta[name="csrf-token"]').attr('content')
        }));

        // Append all hidden fields from TD
        $(td).find('input[type="hidden"], input[name="package_qty"]').each(function () {
            form.append($('<input>', {
                type: 'hidden',
                name: $(this).attr('name'),
                value: $(this).val()
            }));
        });

        // Append to body and submit
        $('body').append(form);
        form.trigger('submit');
    }
}
</script>
@stop