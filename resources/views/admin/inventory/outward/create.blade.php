@extends('adminlte::page')

@section('title', 'Create Outward')

@section('content_header')
    <h1>Outward</h1>
@endsection

@section('content')

@php
    $formAction = '';
    $formMethod = 'POST';

    if (isset($pickList)) {
        // Creating outward from pickList
        $formAction = route('admin.inventory.outward.store', $pickList->picklist_id);
        $formListAction = route('admin.inventory.outward.create', $pickList->picklist_id);
    } else {
        // General create outward
        $formAction = route('admin.inventory.outward.store');
        $formListAction = route('admin.inventory.outward.create');
    }
@endphp

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Create</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.outward.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="#" id="outwardForm">
            @csrf
            @if ($formMethod === 'PUT')
                @method('PUT')
            @endif
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-4" >
                    <div class="pform-panel" >
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. #</div>
                            <div class="pform-value" >
                                <input type="text" id="doc_no" value="OUT-25-0001" readonly>
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
                            <div class="pform-label" >Customer</div>
                            <div class="pform-value" >
                                <select name="customer_id" id="customer_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="4">Australian Foods India Pvt. Ltd.</option>
                                    <option value="5">AAA International</option>
                                    <option value="6">Chelur Foods</option>
                                    <option value="7">PJJ Fruits</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Pick List No</div>
                            <div class="pform-value" >
                                <select name="pick_list_id" id="pick_list_id" class="form-control">
                                    <option value="">--Select --</option>
                                    <option value="1">PL-25-0001</option>
                                    <option value="2">PL-25-0002</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-4" >
                    <div class="pform-panel" >
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Name</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name', $pickList->contact_name ?? '') }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Address</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_address" name="contact_address" value="{{ old('contact_address', $pickList->contact_address ?? '') }}" >
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
                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height:125px;">
                        <div class="pform-row" >
                            <div class="pform-label" >Vehicle No</div>
                            <div class="pform-value" >
                                <input type="text" id="vehicle_no" name="vehicle_no" value="{{ old('vehicle_no') }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Driver</div>
                            <div class="pform-value" >
                                <input type="text" id="driver" name="driver" value="{{ old('driver') }}" >
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-md-12" >
                    <div class="page-list-panel" >
                        <table class="page-list-table" id="outwardCreateTable" >
                            <thead>
                                <tr>
                                    <th class="text-center" >#</th>
                                    <th>Product</th>
                                    <th>Lot</th>
                                    <th>Expiry Date</th>
                                    <th>UOM</th>
                                    <th>Total Qty</th>
                                    <th>Pallet</th>
                                    <th>Location</th>
                                    <th>G.W. KG with pit weight</th>
                                    <th>N.W. KG</th>
                                    <th>Picked Qty</th>
                                    <th>Out Qty</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        
                            <tfoot>
                                <tr class="total-row">
                                    <th colspan="5" class="text-right" >Total :</th>
                                    <th id="total_package_qty" class="text-center"></th>
                                    <th colspan="2"></th>
                                    <th id="total_gw_with_pallet" class="text-center"></th>
                                    <th id="total_nw_kg" class="text-center"></th>
                                    <th id="total_picked_qty" class="text-center"></th>
                                    <th id="total_out_qty" class="text-right"></th>
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
                                            <td><span>Weight of 1 empty pallet (kg)</span></td>
                                            <td class="text-right">
                                                <input 
                                                    type="text" 
                                                    value="15" 
                                                    id="weight_per_pallet" 
                                                    class="text-right" 
                                                    readonly 
                                                    autocomplete="off"
                                                >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span><b>Total No of Pallets</b></span></td>
                                            <td class="text-right">
                                                <input type="text" id="summary_total_pallets" value="" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>Total No of Packages</span></td>
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
const pickListData = {
    "1": {
        customer_id: "6", // Chelur Foods
        contact_name: "Mr. Rajan Nair",
        contact_number: "9876543210",
        contact_address: "Chelur Industrial Estate, Kochi, Kerala",
        items: [
            {
                product: "Frozen Peas 5kg",
                lot: "LOT001",
                expiry: "2026-02-01",
                uom: "Bag",
                total_qty: 100,
                pallet: "PAL-101",
                location: "WU0001-R002-B2-R5-L1-D2",
                gw: 520,
                nw: 500,
                picked_qty: 80
            },
            {
                product: "Chicken Nuggets 10kg",
                lot: "LOT002",
                expiry: "2026-01-15",
                uom: "Box",
                total_qty: 150,
                pallet: "PAL-102",
                location: "WU0001-R001-B1-R3-L2-D1",
                gw: 1020,
                nw: 1000,
                picked_qty: 120
            }
        ]
    },
    "2": {
        customer_id: "4", // Australian Foods India Pvt. Ltd.
        contact_name: "Ms. Anita Sharma",
        contact_number: "9123456789",
        contact_address: "Export Zone, Mumbai, Maharashtra",
        items: [
            {
                product: "Fish Fillet 2kg",
                lot: "LOT010",
                expiry: "2026-01-20",
                uom: "Pack",
                total_qty: 80,
                pallet: "PAL-201",
                location: "WU0001-R003-B1-R1-L3-D4",
                gw: 220,
                nw: 200,
                picked_qty: 60
            },
            {
                product: "Frozen Momos 2kg",
                lot: "LOT015",
                expiry: "2026-01-22",
                uom: "Box",
                total_qty: 100,
                pallet: "PAL-202",
                location: "WU0001-R004-B2-R1-L4-D1",
                gw: 220,
                nw: 200,
                picked_qty: 90
            }
        ]
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const pickListSelect = document.getElementById('pick_list_id');

    pickListSelect.addEventListener('change', function () {
        const selectedId = this.value;
        const data = pickListData[selectedId];
        if (!data) return;

        // Set customer info
        document.getElementById('customer_id').value = data.customer_id;
        document.getElementById('contact_name').value = data.contact_name;
        document.getElementById('contact_address').value = data.contact_address;

        // Populate table
        const tbody = document.querySelector('#outwardCreateTable tbody');
        tbody.innerHTML = '';

        let totalPicked = 0, totalOut = 0, totalGW = 0, totalNW = 0, totalQty = 0;

        data.items.forEach((item, index) => {
            totalQty += item.total_qty;
            totalPicked += item.picked_qty;
            totalOut += item.picked_qty;
            totalGW += item.gw;
            totalNW += item.nw;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="text-center">${index + 1}</td>
                <td>${item.product}</td>
                <td>${item.lot}</td>
                <td>${item.expiry}</td>
                <td>${item.uom}</td>
                <td class="text-center" >${item.total_qty}</td>
                <td>${item.pallet}</td>
                <td>${item.location}</td>
                <td class="text-center">${item.gw}</td>
                <td class="text-center">${item.nw}</td>
                <td class="text-center">${item.picked_qty}</td>
                <td><input type="number" class="form-control out-qty-input text-center" value="${item.picked_qty}" min="0"></td>
            `;
            tbody.appendChild(row);
        });

        // Set summary totals
        document.getElementById('total_package_qty').textContent = totalQty;
        document.getElementById('total_gw_with_pallet').textContent = totalGW;
        document.getElementById('total_nw_kg').textContent = totalNW;
        document.getElementById('total_picked_qty').textContent = totalPicked;
        document.getElementById('total_out_qty').textContent = totalOut;

        document.getElementById('summary_total_pallets').value = data.items.length;
        document.getElementById('summary_total_picked_qty').value = totalPicked;
        document.getElementById('summary_gw_with_pallet').value = totalGW;
        document.getElementById('summary_nw_kg').value = totalNW;

        // Bind input listeners
        document.querySelectorAll('.out-qty-input').forEach(input => {
            input.addEventListener('input', () => {
                let totalOutQty = 0;
                document.querySelectorAll('.out-qty-input').forEach(i => {
                    totalOutQty += parseInt(i.value) || 0;
                });
                document.getElementById('total_out_qty').textContent = totalOutQty;
            });
        });
    });
});
</script>
@stop