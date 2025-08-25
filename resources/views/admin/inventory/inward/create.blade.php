@extends('adminlte::page')

@section('title', 'Create Inward')

@section('content_header')
    <h1>Inward</h1>
@endsection

@section('content')

@php
    $formAction = '';
    $formMethod = 'POST';

    if (isset($packingList)) {
        // Creating inward from packingList
        $formAction = route('admin.inventory.inward.store', $packingList->packing_list_id);
        $formListAction = route('admin.inventory.inward.create', $packingList->packing_list_id);
    } else {
        // General create inward
        $formAction = route('admin.inventory.inward.store');
        $formListAction = route('admin.inventory.inward.create');
    }

    if (session()->has('assigned_product')) {
        $assigned = session('assigned_product');
    }
@endphp

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Create</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.inward.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="{{ $formAction }}" id="outwardForm">
            @csrf
            @if ($formMethod === 'PUT')
                @method('PUT')
            @endif
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:165px;">
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. #</div>
                            <div class="pform-value" >
                                <input type="text" id="doc_no" value="" readonly>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. Date</div>
                            <div class="pform-value" >
                                <input type="date" id="doc_date" name="doc_date" value="@php echo date('Y-m-d') @endphp" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Packing List</div>
                            <div class="pform-value" >
                                <select name="packing_list_id" id="packing_list_id">
                                    <option value="">- Select -</option>
                                    @foreach($packingLists as $v)
                                        <option value="{{ $v->packing_list_id }}"
                                            @selected(old('packing_list_id', optional($packingList)?->packing_list_id) == $v->packing_list_id) >
                                            {{ $v->doc_no }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Client</div>
                            <div class="pform-value" >
                                <select name="client_id" id="client_id">
                                    <option value="">- Select -</option>
                                    @foreach($clients as $v)
                                        <option value="{{ $v->client_id }}"
                                            @selected(old('client_id', optional($packingList)?->client_id) == $v->client_id)
                                        >
                                            {{ $v->client_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:165px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Grn No</div>
                            <div class="pform-value" >
                                <span id="grn_no" >{{ optional($packingList?->grn)?->GRNNo }}</span>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Supplier Name</div>
                            <div class="pform-value" >
                                <span id="supplier_name" >{{ optional($packingList?->supplier)?->supplier_name }}</span>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">GOODS</div>
                            <div class="pform-value">
                                <span id="goods" >{{ optional($packingList)?->goods ?? '' }}</span>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Size</div>
                            <div class="pform-value">
                                <span id="size" >{{ optional($packingList)?->size ?? '' }}</span>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <div class="col-md-4 d-none" >
                    <div class="pform-panel" style="min-height:165px;" >
                        <div class="pform-row">
                            <div class="pform-label">Package Type</div>
                            <div class="pform-value">
                                <span id="package_types" >{{ optional($packingList)?->packageTypes ?? '' }}</span>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Date of Loading</div>
                            <div class="pform-value">
                                <span id="loading_date" >{{ optional($packingList)?->loading_date ?? '' }}</span>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Weight Per Pallet</div>
                            <div class="pform-value" >
                                <span id="weight_per_pallet" >{{ optional($packingList)?->weight_per_pallet }}</span>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Total No of Pallets</div>
                            <div class="pform-value" >
                                <span id="tot_pallet_qty" >{{ optional($packingList)?->tot_pallet_qty }}</span>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Total No of Package</div>
                            <div class="pform-value" >
                                <span id="tot_package" >{{ optional($packingList)?->tot_package }}</span>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-md-12" >
                    <div class="page-list-panel" >
                        <table class="page-list-table" id="inwardCreateTable" >
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Lot</th>
                                    <th>Size</th>
                                    <th>Weight Per Unit</th>
                                    <th>Package Type</th>
                                    <th>G.W. per Package</th>
                                    <th>N.W. per Package</th>
                                    <th>G.W. KG with pit weight</th>
                                    <th>N.W. KG</th>
                                    <th>Total Packages</th>
                                    <th>Qty Per Pallet</th>
                                    <th>Pallet Qty</th>
                                    <th>Inventory Location</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th></th>
                                    <th></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><input type="text" class="form-control column-search" placeholder="Search"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <th colspan="5" class="text-right" >Total:</th>
                                    <th id="total_gw_per_package" class="text-center"></th>
                                    <th id="total_nw_per_package" class="text-center"></th>
                                    <th id="total_gw_with_pallet" class="text-center"></th>
                                    <th id="total_nw_kg" class="text-center"></th>
                                    <th id="total_package_qty" class="text-center"></th>
                                    <th id="tot_package_per_pallet_qty" class="text-center"></th>
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
                                            <td><span>Weight of 1 empty pallet</span></td>
                                            <td class="text-right">
                                                <input type="text" value="{{ optional($packingList)?->weight_per_pallet ?? '' }}" id="weight_per_pallet" class="text-right" readonly="readonly" autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span><b>Total No of Pallets</b></span></td>
                                            <td class="text-right">
                                                <input type="text" id="summary_total_pallets" value="" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>Total No of Packages Assigned</span></td>
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
</style>
@stop

@section('js')
<script>
$(document).ready(function () {
    let packingListId = "{{ $packingList?->packing_list_id ?? '' }}";
    let clientId = "{{ $packingList?->client_id ?? '' }}";
    const assignedProduct = @json($assignedProduct)??{};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
   
    let table = $('#inwardCreateTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        pageLength: 3,
        ajax: {
            url: '{{ $formListAction }}',
            data: function (d) {
                d.packing_list_id = packingListId || $('#packing_list_id').val();
                d.client_id = clientId || $('#client_id').val();
            }
        },
        language: {
            emptyTable: "Please select a packing list to display data."
        },
        columns: [
            { data: 'product_name', name: 'product_name'},
            { data: 'batch_no', name: 'batch_no' },
            { data: 'size', name: 'size', width: '5%' },
            { data: 'weight_per_unit', name: 'weight_per_unit', className: 'weightPerUnit', width: '5%' },
            { data: 'package_type', name: 'package_type', className: 'packageType' },
            { data: 'gw_per_package', name: 'gw_per_package', className: 'gwPerPackage', width: '5%' },
            { data: 'nw_per_package', name: 'nw_per_package', className: 'nwPerPackage', width: '5%' },
            { data: 'gw_with_pallet', name: 'gw_with_pallet', className: 'gwWithPallet', width: '5%' },
            { data: 'nw_kg', name: 'nw_kg', className: 'nwKg', width: '5%' },
            { data: 'package_qty', name: 'package_qty', className: 'packageQty', width: '5%' },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'packageQtyPerPallet',
                width: '5%',
                render: function (data, type, row) {
                    var value = row.package_qty_per_pallet ?? 0;
                    if (assignedProduct && assignedProduct[row.packing_list_detail_id] && row.packing_list_detail_id == assignedProduct[row.packing_list_detail_id].packing_list_detail_id) {
                        value = assignedProduct[row.packing_list_detail_id].package_qty_per_pallet;
                    }

                    return `<input type="text" class="form-control text-center selected-qty" 
                            min="0" name="package_qty_per_pallet" value="${value}" data-prev="${value}" >`;
                }
            },
            { data: 'pallet_qty', name: 'pallet_qty', className: 'palletQty text-center', width: '5%', defaultContent: 0 },
            {
                data: null,
                className: 'inventory-location',
                render: function (data, type, row) {
                    const isDisabled = row.is_fully_assigned_to_cold_storage ? 'disabled' : '';

                    if (assignedProduct && assignedProduct[row.packing_list_detail_id] && row.packing_list_detail_id == assignedProduct[row.packing_list_detail_id].packing_list_detail_id) {
                        let selected_slots = assignedProduct[row.packing_list_detail_id].selected_slots;
                        
                        if (typeof selected_slots === 'string') {
                            selected_slots = JSON.parse(selected_slots);
                        }

                        const selected_locations = [];

                        Object.values(selected_slots).forEach((slot, index) => {
                            const locationText = slot.location || `${slot.room_name}-${slot.rack_no}-${slot.level_no}-${slot.depth_no}`;
                            selected_locations.push(`${locationText}`);
                        });
                        
                        return `<input type="text" name="selected_location[]" class="form-control isDisabled" readonly value="${selected_locations.join(', ')}">`;
                    }

                    // Default to pallet_positions
                    return `<input type="text" name="selected_location[]" class="form-control isDisabled" readonly value="${row.pallet_positions || ''}">`;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    const isDisabled = row.is_fully_assigned_to_cold_storage ? 'disabled' : '';
                    
                    const assignUrl = `/admin/inventory/inward/${row.packing_list_id}/assign/${row.packing_list_detail_id}`;

                    return `
                        <form method="POST" action="${assignUrl}" class="assign-form d-inline">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="product_id" value="${row.product_id}">
                            <input type="hidden" name="package_qty" value="${row.package_qty}">
                            <input type="hidden" name="package_qty_per_pallet" value="">
                            <input type="hidden" name="pallet_qty" value="">
                            <button type="submit" class="btn btn-info btn-sm ${isDisabled}">
                                <i class="fas fa-box"></i>&nbsp;&nbsp;Assign
                            </button>
                        </form>
                    `;
                }
            }
        ],
        columnDefs: [
            {
                targets: [2, 3, 5, 6, 7, 8, 9, 10, 11],
                className: 'text-center'
            }
        ],
        order: [[0, 'desc']],
        rowCallback: function (row, data) {
            if (data.is_fully_assigned_to_cold_storage) {
                $(row).addClass('table-success');
            }
            calculatePackageQtyPerPallet($(row).find('.packageQtyPerPallet').closest('tr'));
            //$(row).find('.packageQtyPerPallet').trigger('input');
        },
        initComplete: function () {
            if (!packingListId && !$('#packing_list_id').val()) {
                //alert("Please select a packing list to display data.");
            }
        },
        footerCallback: function () {
            recalculateFooterTotals();
        }
    });

    $('#inwardCreateTable thead').on('keyup change', '.column-search', function () {
        let colIndex = $(this).parent().index();
        table.column(colIndex).search(this.value).draw();
    });


    $(document).on('change', '#packing_list_id', function () {
        table.ajax.reload();
        const packingListId = $(this).val();

        $.post("/admin/inventory/packing-list/get-packing-list-details", {
            packing_list_id: packingListId,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(response) {
            const data = response.packingList;

            $("#client_id").val(data.client_id);
            $("#grn_no").text(data.grn_no || '-');
            $("#supplier_name").text(data.supplier_name || '-');
            $("#goods").text(data.goods || '-');
            $("#size").text(data.size || '-');
            $("#package_types").text(data.package_types || '-');
            $("#loading_date").text(data.loading_date || '-');
            $("#weight_per_pallet").val(data.weight_per_pallet || '-');
        }).fail(function(xhr) {
            toastr.error(xhr.responseJSON?.message || "Failed to load packing list details.");
        });
    });

    $(document).on('input', 'input[name="package_qty_per_pallet"]', function () {
        // ✅ Manually trigger footer callback
        // $('#inwardCreateTable').DataTable().draw(false);
        calculatePackageQtyPerPallet($(this).closest('tr'));
        recalculateFooterTotals();
    });

    function calculatePackageQtyPerPallet($row) {

        const weightPerUnit = parseFloat($row.find('td.weightPerUnit').text()) || 0;
        const weightPerPackage = parseFloat($row.find('td.gwPerPackage').text()) || 0;
        const packageQuantity = parseFloat($row.find('td.packageQty').text()) || 0;
        const packageType = $row.find('td.packageType').text().trim();

        let packageCount;
        if (packageType === 'Kg') {
            packageCount = Math.ceil((packageQuantity * weightPerUnit) / weightPerPackage);
        } else {
            packageCount = parseInt(packageQuantity) || 0;
        }

        const perPallet = parseFloat($row.find('input[name="package_qty_per_pallet"]').val()) || 0;
        const $palletCell = $row.find('td.palletQty');

        $row.find('input[name="package_qty_per_pallet"]').val(perPallet);

        if (perPallet > 0) {
            const palletQty = Math.ceil(packageCount / perPallet);
            $palletCell.text(palletQty);
            $row.find('input[name="pallet_qty"]').val(palletQty);
        } else {
            $palletCell.text('0');
        }
    }

    function recalculateFooterTotals() {
        let table = $('#inwardCreateTable').DataTable();
        const api = table;

        function intVal(i) {
            return typeof i === 'string'
                ? parseFloat(i.replace(/[^0-9.-]+/g, ''))
                : typeof i === 'number'
                    ? i
                    : 0;
        }

        const gwPerPackage = 5;
        const nwPerPackage = 6;
        const gwWithPallet = 7;
        const nw = 8;
        const packageQty = 9;
        const packagePerPallet = 10;
        const palletQty = 11;

        let totGwPerPackage = api.column(gwPerPackage, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
        let totNwPerPackage = api.column(nwPerPackage, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
        let totGwWithPallet = api.column(gwWithPallet, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
        let totNw = api.column(nw, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
        let totPackageQty = api.column(packageQty, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0);
        let totPackagePerPallet = 0;
        let totPalletQty = 0;

        api.rows({ page: 'current' }).every(function () {
            const $row = $(this.node());
            const qty = parseFloat($row.find('input[name="package_qty_per_pallet"]').val()) || 0;
            totPackagePerPallet += qty;

            const pallet = parseFloat($row.find('td.palletQty').text()) || 0;
            totPalletQty += pallet;
        });
            
        // Calculate across all pages (grand total)
        let grandPallet = 0;
        let totalPackage = 0;
        let grandGw = 0;
        let grandNw = 0;

        api.rows().every(function () {
            const $row = $(this.node());

            grandPallet += parseFloat($row.find('td.palletQty').text()) || 0;
            totalPackage += parseFloat($row.find('td').eq(packageQty).text()) || 0;
            grandGw += parseFloat($row.find('td').eq(gwWithPallet).text()) || 0;
            grandNw += parseFloat($row.find('td').eq(nw).text()) || 0;
        });

        $('#total_gw_per_package').html(totGwPerPackage.toLocaleString());
        $('#total_nw_per_package').html(totNwPerPackage.toLocaleString());
        $('#total_gw_with_pallet').html(totGwWithPallet.toLocaleString());
        $('#total_nw_kg').html(totNw.toLocaleString());
        $('#total_package_qty').html(totPackageQty.toLocaleString());
        $('#tot_package_per_pallet_qty').html(totPackagePerPallet.toLocaleString());
        $('#total_pallet_qty').html(totPalletQty);

        $('#summary_total_pallets').val(grandPallet.toLocaleString());
        $('#summary_total_picked_qty').val(totalPackage.toLocaleString());
        $('#summary_gw_with_pallet').val(grandGw.toLocaleString());
        $('#summary_nw_kg').val(grandNw.toLocaleString());
    }

    // $(document).on('submit', '#InwardForm', function() {
    //     updateAssignedItems();  
    // });

    // // Optionally also update totals when assigned_qty is edited
    // $(document).on('input', 'input[name="assigned_qty[]"]', function () {
    //     updateTotals();
    // });

    // function updateAssignedItems() {
    //     assigned = [];

    //     $('#inwardCreateTable tbody tr').each(function() {
    //         const $row = $(this);

    //         assigned.push({
    //             stock_id: checkbox.data('stock-id'),
    //             packing_list_detail_id: checkbox.data('packing-list-detail-id'),
    //             package_qty: checkbox.data('package-qty'),
    //             assign_qty: parseFloat($row.find('.assigned-qty').val()) || 0
    //         });
    //     });

    //     if(assigned.length === 0){
    //         alert('Please assign at least one product.');
    //         return;
    //     }

    //     // Now update hidden inputs
    //     let hiddenInputsHtml = '';

    //     assigned.forEach(function(item, index) {
    //         hiddenInputsHtml += `
    //             <input type="hidden" name="selected_items[${index}][stock_id]" value="${item.stock_id}">
    //             <input type="hidden" name="selected_items[${index}][packing_list_detail_id]" value="${item.packing_list_detail_id}">
    //             <input type="hidden" name="selected_items[${index}][package_qty]" value="${item.package_qty}">
    //             <input type="hidden" name="selected_items[${index}][pick_qty]" value="${item.pick_qty}">
    //         `;
    //     });

    //     $('#assigned-products-inputs').html(hiddenInputsHtml);

    //     updateTotals();
    // }

});
</script>
@stop