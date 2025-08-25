@extends('adminlte::page')

@section('title', 'Edit Inward')

@section('content_header')
    <h1>Inward</h1>
@endsection

@section('content')

@php
    $formAction = route('admin.inventory.inward.update', $inward->inward_id);
    $formMethod = 'PUT';
    $assigned = session('assigned_product') ?? [];
    $formListAction = route('admin.inventory.inward.edit', $inward->inward_id);
@endphp

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Edit Inward</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.inward.index') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="{{ $formAction }}" id="inwardForm">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Panel 1 -->
                <div class="col-md-6">
                    <div class="pform-panel" style="min-height:165px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc. #</div>
                            <div class="pform-value">
                                <input type="text" id="doc_no" name="doc_no" value="{{ $inward->doc_no }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc. Date</div>
                            <div class="pform-value">
                                <input type="date" id="doc_date" name="doc_date" value="{{ $inward->doc_date }}">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Packing List</div>
                            <div class="pform-value">
                                <select name="packing_list_id" id="packing_list_id" disabled>
                                    <option value="">- Select -</option>
                                    @foreach($packingLists as $v)
                                        <option value="{{ $v->packing_list_id }}"
                                            @selected($inward->packing_list_id == $v->packing_list_id)>
                                            {{ $v->doc_no }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Client</div>
                            <div class="pform-value">
                                <select name="client_id" id="client_id">
                                    <option value="">- Select -</option>
                                    @foreach($clients as $v)
                                        <option value="{{ $v->client_id }}" @selected($inward->client_id == $v->client_id)>
                                            {{ $v->client_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-6">
                    <div class="pform-panel" style="min-height:165px;">
                        <div class="pform-row">
                            <div class="pform-label">GRN No</div>
                            <div class="pform-value">
                                <span id="grn_no">{{ optional($inward->packingList?->grn)?->GRNNo }}</span>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Supplier Name</div>
                            <div class="pform-value">
                                <span id="supplier_name">{{ optional($inward->packingList?->supplier)?->supplier_name }}</span>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Goods</div>
                            <div class="pform-value">
                                <span id="goods">{{ $inward->packingList?->goods }}</span>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Size</div>
                            <div class="pform-value">
                                <span id="size">{{ $inward->packingList?->size }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="page-list-panel">
                        <table class="page-list-table" id="inwardEditTable">
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
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <th colspan="5" class="text-right">Total:</th>
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

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <br />
                                <table class="table table-striped page-list-table" border="0">
                                    <tbody>
                                        <tr>
                                            <td><span>Weight of 1 empty pallet</span></td>
                                            <td class="text-right">
                                                <input type="text" value="{{ $inward->packingList?->weight_per_pallet ?? '' }}" id="weight_per_pallet" class="text-right" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span><b>Total No of Pallets</b></span></td>
                                            <td class="text-right">
                                                <input type="text" id="summary_total_pallets" value="{{ $inward->pallet_qty ?? '' }}" class="text-right" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>Total No of Packages Assigned</span></td>
                                            <td class="text-right">
                                                <input type="text" name="tot_package_qty" id="summary_total_picked_qty" value="{{ $inward->tot_package_qty ?? '' }}" class="text-right" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>Total G.W with Pallets Weight</span></td>
                                            <td class="text-right">
                                                <input type="text" id="summary_gw_with_pallet" value="{{ $inward->gw_with_pallet ?? '' }}" class="text-right" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>Total N.W</span></td>
                                            <td class="text-right">
                                                <input type="text" id="summary_nw_kg" value="{{ $inward->nw_kg ?? '' }}" class="text-right" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="assigned-products-inputs"></div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-save btn-sm float-right">Update</button>
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
    let packingListId = "{{ $inward->packing_list_id ?? '' }}";
    let clientId = "{{ $inward->client_id ?? '' }}";
    const assignedProduct = @json($assignedProduct ?? []);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const isEdit = true;

    let table = $('#inwardEditTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        pageLength: 3,
        ajax: {
            url: '{{ $formListAction }}',
            data: function (d) {
                d.packing_list_id = packingListId;
                d.client_id = clientId;
                d.inward_id = '{{ $inward->inward_id ?? '' }}';
            }
        },
        language: {
            emptyTable: "Please select a packing list to display data."
        },
        columns: [
            { data: 'product_name', name: 'product_name' },
            { data: 'batch_no', name: 'batch_no'},
            { data: 'size', width: '5%' },
            { data: 'weight_per_unit', className: 'weightPerUnit', width: '5%' },
            { data: 'package_type', className: 'packageType' },
            { data: 'gw_per_package', className: 'gwPerPackage', width: '5%' },
            { data: 'nw_per_package', className: 'nwPerPackage', width: '5%' },
            { data: 'gw_with_pallet', className: 'gwWithPallet', width: '5%' },
            { data: 'nw_kg', className: 'nwKg', width: '5%' },
            { data: 'package_qty', className: 'package_qty', width: '5%' },
            {
                data: null,
                className: 'packageQtyPerPallet',
                render: function (data, type, row) {
                    let value = row.package_qty_per_pallet ?? 0;
                    if (assignedProduct[row.packing_list_detail_id]) {
                        value = assignedProduct[row.packing_list_detail_id].package_qty_per_pallet;
                    }
                    return `<input type="text" class="form-control text-center selected-qty" min="0" name="package_qty_per_pallet" value="${value}" data-prev="${value}">`;
                }
            },
            { data: 'pallet_qty', className: 'pallet_qty text-center', defaultContent: 0 },
            {
                data: null,
                className: 'inventory-location',
                render: function (data, type, row) {
                    let selected_locations = '';

                    // Check if data exists for this packing_list_detail_id
                    const product = assignedProduct[row.packing_list_detail_id];
                    if (product && product.selected_slots) {
                        let selected_slots = product.selected_slots;
                        
                        // Parse if it's accidentally stored as a JSON string
                        if (typeof selected_slots === 'string') {
                            try {
                                selected_slots = JSON.parse(selected_slots);
                            } catch (e) {
                                selected_slots = [];
                            }
                        }

                        // If selected_slots is an object, convert it to an array (for map)
                        if (!Array.isArray(selected_slots)) {
                            selected_slots = Object.values(selected_slots);
                        }

                        // Generate comma-separated location labels
                        selected_locations = selected_slots.map(slot => {
                            return slot.location || `${slot.room_name}-${slot.rack_no}-${slot.level_no}-${slot.depth_no}`;
                        }).join(', ');
                    }

                    // Return readonly input field with the selected locations
                    return `<input type="text" name="selected_location[]" class="form-control" readonly value="${selected_locations}">`;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    const assignUrl = `/admin/inventory/inward/${row.inward_id}/reassign/${row.packing_list_detail_id}`;
                    
                    return `
                        <form method="POST" action="${assignUrl}" class="assign-form d-inline">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="product_id" value="${row.product_id}">
                            <input type="hidden" name="package_qty" value="${row.package_qty}">
                            <input type="hidden" name="package_qty_per_pallet" value="">
                            <input type="hidden" name="pallet_qty" value="">
                            <button type="submit" class="btn btn-sm btn-warning reassign-btn">
                                <i class="fas fa-random"></i>&nbsp;&nbsp;Re-Assign
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
        rowCallback: function (row, data) {
            if (data.is_fully_assigned_to_cold_storage) {
                $(row).addClass('table-success');
            }
            calculatePackageQtyPerPallet($(row).find('.packageQtyPerPallet').closest('tr'));
        },
        drawCallback: function () {
            recalculateFooterTotals();
        }
    });

    function calculatePackageQtyPerPallet($row) {
        const weightPerUnit = parseFloat($row.find('td.weightPerUnit').text()) || 0;
        const weightPerPackage = parseFloat($row.find('td.gwPerPackage').text()) || 0;
        const packageQuantity = parseFloat($row.find('td.package_qty').text()) || 0;
        const packageType = $row.find('td.packageType').text().trim();

        let packageCount = (packageType === 'Kg') ? Math.ceil((packageQuantity * weightPerUnit) / weightPerPackage) : parseInt(packageQuantity);
        const perPallet = parseFloat($row.find('input[name="package_qty_per_pallet"]').val()) || 0;
        const $palletCell = $row.find('td.pallet_qty');

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
        let table = $('#inwardEditTable').DataTable();
        const api = table;

        function intVal(i) {
            return typeof i === 'string' ? parseFloat(i.replace(/[^0-9.-]+/g, '')) : typeof i === 'number' ? i : 0;
        }

        const gwPerPackage = 5, nwPerPackage = 6, gwWithPallet = 7, nw = 8, packageQty = 9, palletQty = 11;

        const totals = [gwPerPackage, nwPerPackage, gwWithPallet, nw, packageQty].map(col =>
            api.column(col, { page: 'current' }).data().reduce((a, b) => intVal(a) + intVal(b), 0)
        );

        let totPackagePerPallet = 0, totPalletQty = 0;
        api.rows({ page: 'current' }).every(function () {
            const $row = $(this.node());
            totPackagePerPallet += parseFloat($row.find('input[name="package_qty_per_pallet"]').val()) || 0;
            totPalletQty += parseFloat($row.find('td.pallet_qty').text()) || 0;
        });

        $('#total_gw_per_package').html(totals[0].toLocaleString());
        $('#total_nw_per_package').html(totals[1].toLocaleString());
        $('#total_gw_with_pallet').html(totals[2].toLocaleString());
        $('#total_nw_kg').html(totals[3].toLocaleString());
        $('#total_package_qty').html(totals[4].toLocaleString());
        $('#tot_package_per_pallet_qty').html(totPackagePerPallet.toLocaleString());
        $('#total_pallet_qty').html(totPalletQty);

        $('#summary_total_pallets').val(totPalletQty.toLocaleString());
        $('#summary_total_picked_qty').val(totals[4].toLocaleString());
        $('#summary_gw_with_pallet').val(totals[2].toLocaleString());
        $('#summary_nw_kg').val(totals[3].toLocaleString());
    }

    $(document).on('input', 'input[name="package_qty_per_pallet"]', function () {
        calculatePackageQtyPerPallet($(this).closest('tr'));
        recalculateFooterTotals();
    });
});
</script>

@stop