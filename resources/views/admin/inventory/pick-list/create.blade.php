@extends('adminlte::page')

@section('title', 'Create Pick List')

@section('content_header')
    <h1>Pick List</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Create</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.pick-list.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="#">
         @csrf
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:195px;" >
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
                        <div class="pform-row">
                            <div class="pform-label">Releasing Order #</div>
                            <div class="pform-value">
                                <select name="pre_alert_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="101" >RO‑25‑0001</option>
                                    <option value="102">RO‑25‑0002</option>
                                    <option value="103">RO‑25‑0003</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Dispatch Date</div>
                            <div class="pform-value" >
                                <input type="date" id="dispatch_date" name="dispatch_date" value="@php echo date('Y-m-d') @endphp" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Dispatch Location</div>
                            <div class="pform-value" >
                                <textarea name="dispatch_location" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-6" >
                    <div class="pform-panel" style="min-height:195px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Customer</div>
                            <div class="pform-value" >
                                <select name="customer_id" id="customer_id" class="form-control">
                                    <option value="">-- None (Create New) --</option>
                                    <option value="4">Australian Foods India Pvt. Ltd.</option>
                                    <option value="5">AAA International</option>
                                    <option value="6">Chelur Foods</option>
                                    <option value="7">PJJ Fruits</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Name</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_name" name="contact_name" value="" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Address</div>
                            <div class="pform-value" >
                                <textarea name="contact_address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="pform-row d-none" >
                            <div class="pform-label" >Total Quantity to Pick</div>
                            <div class="pform-value" >
                                <input type="number" id="total_qty" name="total_qty" value="" >
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <!-- <div class="col-md-4" >
                    <div class="pform-panel" style="min-height:220px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Product</div>
                            <div class="pform-value" >
                                <select name="package_type_id" id="package_type_id">
                                    <option value="">- Select -</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->product_master_id }}">{{ $product->product_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Variety</div>
                            <div class="pform-value" >
                                <select name="variety_id" id="variety_id">
                                    <option value="">- Select -</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->ProductCategoryID }}">
                                            {{ $category->ProductCategoryName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Brand</div>
                            <div class="pform-value" >
                                <select name="brand_id" id="brand_id">
                                    <option value="">- Select -</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->brand_id }}">
                                            {{ $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div> -->
            </div>

            <div class="row" >
                <div class="col-md-12" >
                    <div class="page-list-panel" >
                        <table class="page-list-table" id="pickListCreateTable" >
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Lot No.</th>
                                    <th>Expiry Date</th>
                                    <th>Pallet</th>
                                    <th>Location</th>
                                    <th>Pallet-in Date</th>
                                    <th>UOM</th>
                                    <th>Total Qty</th>
                                    <th>Requested Qty</th>
                                    <th>Picked Qty</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <th colspan="9" class="text-right" >Total Picked :</th>
                                    <th id="total_picked_qty" class="text-center"></th>
                                </tr>
                            </tfoot>
                        </table>
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
const releasingOrders = {
    "101": {
        customer_id: "6", // Chelur Foods
        contact_name: "Mr. Rajan Nair",
        contact_address: "Chelur Industrial Estate, Kochi, Kerala",
        total_qty: 250,
        items: [
            { product: "Frozen Peas 5kg", lot: "LOT001", expiry: "2026-02-01", pallet: "PAL-101", location: "WU0001-R002-B2-R5-L1-D2", pallet_in: "2025-08-01", uom: "Bag", total_qty: 100, requested_qty: 80, picked_qty: 80 },
            { product: "Chicken Nuggets 10kg", lot: "LOT002", expiry: "2026-01-15", pallet: "PAL-102", location: "WU0001-R001-B1-R3-L2-D1", pallet_in: "2025-07-15", uom: "Box", total_qty: 150, requested_qty: 120, picked_qty: 120 }
        ]
    },
    "102": {
        customer_id: "4", // Australian Foods India Pvt. Ltd.
        contact_name: "Ms. Anita Sharma",
        contact_address: "Export Zone, Mumbai, Maharashtra",
        total_qty: 180,
        items: [
            { product: "Fish Fillet 2kg", lot: "LOT010", expiry: "2026-01-20", pallet: "PAL-201", location: "WU0001-R003-B1-R1-L3-D4", pallet_in: "2025-06-20", uom: "Pack", total_qty: 80, requested_qty: 60, picked_qty: 60 },
            { product: "Frozen Momos 2kg", lot: "LOT015", expiry: "2026-01-22", pallet: "PAL-202", location: "WU0001-R004-B2-R1-L4-D1", pallet_in: "2025-07-22", uom: "Box", total_qty: 100, requested_qty: 90, picked_qty: 90 }
        ]
    },
    "103": {
        customer_id: "5", // AAA International
        contact_name: "Mr. Faizal Khan",
        contact_address: "Sector 12, Bengaluru, Karnataka",
        total_qty: 200,
        items: [
            { product: "Frozen French Fries 5kg", lot: "LOT013", expiry: "2026-02-03", pallet: "PAL-301", location: "WU0001-R001-B1-R8-L2-D3", pallet_in: "2025-08-03", uom: "Bag", total_qty: 120, requested_qty: 100, picked_qty: 100 },
            { product: "Frozen Biryani Packs 1kg", lot: "LOT014", expiry: "2026-01-28", pallet: "PAL-302", location: "WU0001-R002-B1-R6-L1-D4", pallet_in: "2025-07-28", uom: "Pack", total_qty: 80, requested_qty: 70, picked_qty: 70 }
        ]
    }
};

let pickListTable;

$(document).ready(function () {
    pickListTable = $('#pickListCreateTable').DataTable({
        paging: false,
        searching: false,
        ordering: true,
        info: false
    });

    $('#pickListCreateTable').on('input', '.picked-qty-input', function () {
        let total = 0;
        $('.picked-qty-input').each(function () {
            total += parseInt($(this).val()) || 0;
        });
        $('#total_picked_qty').text(total);
    });

});

document.addEventListener('DOMContentLoaded', function () {
    const roSelect = document.querySelector('select[name="pre_alert_id"]');

    roSelect.addEventListener('change', function () {
        const selectedId = this.value;
        const data = releasingOrders[selectedId];

        if (!data) return;

        // Set customer info
        document.getElementById('customer_id').value = data.customer_id;
        document.getElementById('contact_name').value = data.contact_name;
        document.querySelector('textarea[name="contact_address"]').value = data.contact_address;
        document.getElementById('total_qty').value = data.total_qty;

        // Clear and repopulate DataTable
        pickListTable.clear();

        let totalPicked = 0;

        data.items.forEach((item, index) => {
            totalPicked += item.picked_qty;

            pickListTable.row.add([
                item.product,
                item.lot,
                item.expiry,
                item.pallet,
                item.location,
                item.pallet_in,
                item.uom,
                item.total_qty,
                item.requested_qty,
                `<input type="number" class="form-control picked-qty-input" value="${item.picked_qty}" min="0" data-index="${index}">`
            ]);
        });

        pickListTable.draw();

        document.getElementById('total_picked_qty').textContent = totalPicked;
    });
});

</script>
@stop