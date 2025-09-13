@extends('adminlte::page')

@section('title', 'Releasing Order')

@section('content_header')
    <h1>Releasing Order</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.releasing-order.index') }}" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" >
        <li class="nav-item">
            <a class="nav-link active" id="releasing-order-tab" data-toggle="tab" href="#releasingOrder" role="tab">Basic Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="releasingorder-attachment-tab" data-toggle="tab" href="#releasingOrderAttachment" role="tab">Attachment</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="releasingOrder" role="tabpanel">

            <div class="card page-form page-form-add">
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf

                        <div class="row">
                            <!-- Panel 1 -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 150px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Doc. #</div>
                                        <div class="pform-value">
                                            <input type="text" value="RO‑25‑00001" readonly>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Doc. Date</div>
                                        <div class="pform-value">
                                            <input type="date" value="@php echo date('Y-m-d') @endphp" readonly>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Date of Releasing</div>
                                        <div class="pform-value">
                                            <input type="date" value="" >
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Ref. No.</div>
                                        <div class="pform-value">
                                            <input type="text" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel 2 -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 150px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Existing Customer</div>
                                        <div class="pform-value">
                                            <select name="customer_id" id="customer_id" class="form-control select2">
                                                <option value="">-- None (Create New) --</option>
                                                <option value="3">PJJ Fruits</option>
                                                <option value="4">Australian Foods India Pvt. Ltd.</option>
                                                <option value="5">AAA International</option>
                                                <option value="6">Chelur Foods</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Customer Name</div>
                                        <div class="pform-value">
                                            <input type="text" name="customer_name" value="">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Number</div>
                                        <div class="pform-value">
                                            <input type="text" name="contact_number" value="">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Email</div>
                                        <div class="pform-value">
                                            <input type="text" name="contact_email"  value="">
                                        </div>
                                    </div>
                                    <!-- <div class="pform-row d-none">
                                        <div class="pform-label">Remarks</div>
                                        <div class="pform-value">
                                            <textarea rows="3">Handle with care — perishable goods</textarea>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <!-- Panel 3 -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 150px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Address</div>
                                        <div class="pform-value">
                                            <textarea rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Transport Mode</div>
                                        <div class="pform-value">
                                            <input type="text" placeholder="Refrigerated Truck, VAN, etc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="page-list-panel">
                                    <table class="page-input-table" id="releasingOrderItemsTable">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Batch No.</th>
                                                <th>Qty</th>
                                                <th>UOM</th>
                                                <th><button type="button" onclick="addRow()" class="btn btn-sm btn-success"><i class="fa fa-plus" ></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control item-select" onchange="autoFillRow(this)">
                                                        <option value="">Select Item</option>
                                                        <option value="Frozen Peas 5kg">Frozen Peas 5kg</option>
                                                        <option value="Chicken Nuggets 10kg">Chicken Nuggets 10kg</option>
                                                        <option value="Fish Fillet 2kg">Fish Fillet 2kg</option>
                                                        <option value="Mixed Veg 1kg">Mixed Veg 1kg</option>
                                                        <option value="Ice Cream Tubs">Ice Cream Tubs</option>
                                                        <option value="Paneer Blocks 5kg">Paneer Blocks 5kg</option>
                                                        <option value="Frozen Corn 2kg">Frozen Corn 2kg</option>
                                                        <option value="Veg Spring Rolls 1kg">Veg Spring Rolls 1kg</option>
                                                        <option value="Chicken Seekh Kebab 5kg">Chicken Seekh Kebab 5kg</option>
                                                        <option value="Fish Fingers 3kg">Fish Fingers 3kg</option>
                                                        <option value="Frozen Paratha 1kg">Frozen Paratha 1kg</option>
                                                        <option value="Frozen Momos 2kg">Frozen Momos 2kg</option>
                                                        <option value="Frozen French Fries 5kg">Frozen French Fries 5kg</option>
                                                        <option value="Frozen Biryani Packs 1kg">Frozen Biryani Packs 1kg</option>
                                                        <option value="Frozen Pizza Base 2kg">Frozen Pizza Base 2kg</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control batch" value=""></td>
                                                <td><input type="number" class="form-control qty" value=""></td>
                                                <td><input class="form-control uom" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control item-select" onchange="autoFillRow(this)">
                                                        <option value="">Select Item</option>
                                                        <option value="Frozen Peas 5kg">Frozen Peas 5kg</option>
                                                        <option value="Chicken Nuggets 10kg">Chicken Nuggets 10kg</option>
                                                        <option value="Fish Fillet 2kg">Fish Fillet 2kg</option>
                                                        <option value="Mixed Veg 1kg">Mixed Veg 1kg</option>
                                                        <option value="Ice Cream Tubs">Ice Cream Tubs</option>
                                                        <option value="Paneer Blocks 5kg">Paneer Blocks 5kg</option>
                                                        <option value="Frozen Corn 2kg">Frozen Corn 2kg</option>
                                                        <option value="Veg Spring Rolls 1kg">Veg Spring Rolls 1kg</option>
                                                        <option value="Chicken Seekh Kebab 5kg">Chicken Seekh Kebab 5kg</option>
                                                        <option value="Fish Fingers 3kg">Fish Fingers 3kg</option>
                                                        <option value="Frozen Paratha 1kg">Frozen Paratha 1kg</option>
                                                        <option value="Frozen Momos 2kg">Frozen Momos 2kg</option>
                                                        <option value="Frozen French Fries 5kg">Frozen French Fries 5kg</option>
                                                        <option value="Frozen Biryani Packs 1kg">Frozen Biryani Packs 1kg</option>
                                                        <option value="Frozen Pizza Base 2kg">Frozen Pizza Base 2kg</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control batch" value=""></td>
                                                <td><input type="number" class="form-control qty" value=""></td>
                                                <td><input class="form-control uom" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
                                        </tbody>
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
        </div>

        <!-- Attachment Tab -->
        <div class="tab-pane fade" id="releasingOrderAttachment" role="tabpanel">
            <x-attachment-uploader 
                :tableName="'releasing_order'" 
                :rowId="'RO-25-00012'" 
            />
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    const customerData = {
    3: {
        name: "PJJ Fruits",
        phone: "94356345784",
        email: "info@pjj.com"
    },
    4: {
        name: "Australian Foods India Pvt. Ltd.",
        phone: "09447121606",
        email: "info@afipl.com"
    },
    5: {
        name: "AAA International",
        phone: "63825737845",
        email: "info@aaa.com"
    },
    6: {
        name: "Chelur Foods",
        phone: "87823567734",
        email: "info@chelurfood.com"
    }
};

const productData = {
    "Frozen Peas 5kg": {
        batch: "FP-001",
        qty: 100,
        uom: "Bag",
        mfg: "2025-08-01",
        exp: "2026-02-01"
    },
    "Chicken Nuggets 10kg": {
        batch: "CN-002",
        qty: 50,
        uom: "Box",
        mfg: "2025-07-15",
        exp: "2026-01-15"
    },
    "Fish Fillet 2kg": {
        batch: "FF-003",
        qty: 30,
        uom: "Pack",
        mfg: "2025-06-20",
        exp: "2026-01-20"
    },
    "Mixed Veg 1kg": {
        batch: "MV-004",
        qty: 80,
        uom: "Bag",
        mfg: "2025-08-10",
        exp: "2026-02-10"
    },
    "Ice Cream Tubs": {
        batch: "IC-005",
        qty: 60,
        uom: "Tub",
        mfg: "2025-07-01",
        exp: "2026-01-01"
    },
    "Paneer Blocks 5kg": {
        batch: "PB-006",
        qty: 40,
        uom: "Block",
        mfg: "2025-08-05",
        exp: "2025-12-05"
    },
    "Frozen Corn 2kg": {
        batch: "FC-007",
        qty: 90,
        uom: "Bag",
        mfg: "2025-07-25",
        exp: "2026-01-25"
    },
    "Veg Spring Rolls 1kg": {
        batch: "SR-008",
        qty: 70,
        uom: "Box",
        mfg: "2025-08-12",
        exp: "2026-02-12"
    },
    "Chicken Seekh Kebab 5kg": {
        batch: "SK-009",
        qty: 45,
        uom: "Pack",
        mfg: "2025-07-18",
        exp: "2026-01-18"
    },
    "Fish Fingers 3kg": {
        batch: "FFG-010",
        qty: 55,
        uom: "Box",
        mfg: "2025-06-30",
        exp: "2026-01-30"
    },
    "Frozen Paratha 1kg": {
        batch: "FPTH-011",
        qty: 85,
        uom: "Pack",
        mfg: "2025-08-08",
        exp: "2026-02-08"
    },
    "Frozen Momos 2kg": {
        batch: "FM-012",
        qty: 65,
        uom: "Box",
        mfg: "2025-07-22",
        exp: "2026-01-22"
    },
    "Frozen French Fries 5kg": {
        batch: "FFF-013",
        qty: 120,
        uom: "Bag",
        mfg: "2025-08-03",
        exp: "2026-02-03"
    },
    "Frozen Biryani Packs 1kg": {
        batch: "FBP-014",
        qty: 75,
        uom: "Pack",
        mfg: "2025-07-28",
        exp: "2026-01-28"
    },
    "Frozen Pizza Base 2kg": {
        batch: "FPB-015",
        qty: 60,
        uom: "Box",
        mfg: "2025-08-06",
        exp: "2026-02-06"
    }
};

let rowIdx = 2;

function addRow() {
    const table = document.querySelector("#releasingOrderItemsTable tbody");
    const newRow = document.createElement("tr");

    const itemOptions = Object.keys(productData)
        .map(item => `<option value="${item}">${item}</option>`)
        .join('');

    newRow.innerHTML = `
        <td>
            <select class="form-control" onchange="autoFillRow(this)">
                <option value="">Select Item</option>
                ${itemOptions}
            </select>
        </td>
        <td><input class="form-control batch" value=""></td>
        <td><input type="number" class="form-control qty" value=""></td>
        <td><input class="form-control uom" value=""></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
    `;
    table.appendChild(newRow);
    rowIdx++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}

function autoFillRow(select) {
    const selected = select.value;
    const row = select.closest('tr');

    if (productData[selected]) {
        row.querySelector('.batch').value = productData[selected].batch;
        row.querySelector('.qty').value = productData[selected].qty;
        row.querySelector('.uom').value = productData[selected].uom;
        row.querySelector('.mfg').value = productData[selected].mfg;
        row.querySelector('.exp').value = productData[selected].exp;
    } else {
        row.querySelector('.batch').value = '';
        row.querySelector('.qty').value = '';
        row.querySelector('.uom').value = '';
        row.querySelector('.mfg').value = '';
        row.querySelector('.exp').value = '';
    }
}

$(document).ready(function () {
    $('#customer_id').select2().on('change', function () {
        const selectedId = $(this).val();
        const data = customerData[selectedId];

        $('input[name="customer_name"]').val(data?.name || '');
        $('input[name="contact_number"]').val(data?.phone || '');
        $('input[name="contact_email"]').val(data?.email || '');
    });
});
</script>
@endsection
