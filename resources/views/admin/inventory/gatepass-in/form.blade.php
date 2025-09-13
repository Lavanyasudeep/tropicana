@extends('adminlte::page')

@section('title', 'Gatepass‑In')

@section('content_header')
    <h1>Gatepass‑In</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.gatepass-in.index') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" >
        <li class="nav-item">
            <a class="nav-link active" id="gatepass-in-tab" data-toggle="tab" href="#gatepassIn" role="tab">Gatepass In</a>
        </li>
        @if(Route::currentRouteName() === 'admin.inventory.gatepass-in.edit')
            <li class="nav-item">
                <a class="nav-link" id="truck-out-tab" data-toggle="tab" href="#truck_out" role="tab">Truck Out</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" id="gatepassin-attachment-tab" data-toggle="tab" href="#gatepassInAttachment" role="tab">Attachment</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="gatepassIn" role="tabpanel">
            <div class="card page-form page-form-add">
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf
                        <div class="row">
                            <!-- Panel 1 -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 250px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Doc. No.</div>
                                        <div class="pform-value"><input type="text" value="GPI‑25‑00001" readonly></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Doc. Date</div>
                                        <div class="pform-value"><input type="date" value="2025-08-26"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Time In</div>
                                        <div class="pform-value"><input type="time" value="09:42"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Customer</div>
                                        <div class="pform-value">
                                            <select name="customer_id" class="form-control">
                                                <option value="">-- Select Customer --</option>
                                                <option value="1" >Chelur Foods</option>
                                                <option value="2">Australian Foods India Pvt. Ltd.</option>
                                                <option value="3">AAA International</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Pre‑Alert #</div>
                                        <div class="pform-value">
                                            <select name="pre_alert_id" class="form-control">
                                                <option value="">-- Select Pre‑Alert --</option>
                                                <option value="101" >PA‑25‑0789</option>
                                                <option value="102">PA‑25‑0790</option>
                                                <option value="103">PA‑25‑0791</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Invoice No #</div>
                                        <div class="pform-value"><input type="text" value=""></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel 2 -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 250px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Transport Mode</div>
                                        <div class="pform-value"><input type="text" value=""></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Transporter / STN No.</div>
                                        <div class="pform-value"><input type="text" value=""></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Vehicle Type</div>
                                        <div class="pform-value">
                                            <select name="vehicle_type" class="form-control">
                                                <option value="">-- Select Type --</option>
                                                <option value="Refrigerated Truck" >Refrigerated Truck</option>
                                                <option value="Container">Container</option>
                                                <option value="Open Truck">Open Truck</option>
                                                <option value="Van">Van</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Vehicle No.</div>
                                        <div class="pform-value"><input type="text" value=""></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Driver Name</div>
                                        <div class="pform-value"><input type="text" value=""></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Driver Contact</div>
                                        <div class="pform-value"><input type="text" value=""></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Vehicle Temperature (°C)</div>
                                        <div class="pform-value"><input type="number" step="0.1" name="vehicle_temperature" value=""></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel 3 -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 250px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Product Type</div>
                                        <div class="pform-value"><input type="text" placeholder="Frozen, Dry, etc." ></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Gross Weight (KG)</div>
                                        <div class="pform-value"><input type="number" step="0.01" value=""></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Dock No.</div>
                                        <div class="pform-value"><input type="text" value=""></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Security Name</div>
                                        <div class="pform-value"><input type="text" value=""></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Remarks</div>
                                        <div class="pform-value"><textarea rows="3"></textarea></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="page-list-panel">
                                    <table class="page-input-table" id="gatepassInItemsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item Name</th>
                                                <th>Batch No.</th>
                                                <th>Packing Qty</th>
                                                <th>UOM</th>
                                                <th><button type="button" onclick="addRow()" class="btn btn-sm btn-success"><i class="fa fa-plus" ></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input type="number" class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input type="number" class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input type="number" class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
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

        <div class="tab-pane fade" id="truck_out">
            <div class="card page-form page-form-add">
                <div class="card-header"><h5>Truck-Out Details</h5></div>
                <div class="card-body">
                    <form id="truckOutForm" action="#" method="POST">
                        @csrf

                        <div class="row">

                            <!-- Seal & Dispatch -->
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height: 120px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Seal No</div>
                                        <div class="pform-value">
                                            <input type="text" name="seal_no" class="form-control" placeholder="SEAL-0001">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Dispatch Time</div>
                                        <div class="pform-value">
                                            <input type="time" name="dispatch_time" class="form-control" value="{{ date('H:i') }}">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Dispatch Date</div>
                                        <div class="pform-value">
                                            <input type="date" name="dispatch_date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Remarks & Status -->
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height: 120px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Remarks</div>
                                        <div class="pform-value">
                                            <textarea name="remarks" class="form-control" rows="3" placeholder="Any special instructions or notes..."></textarea>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Status</div>
                                        <div class="pform-value">
                                            <select name="status" class="form-control">
                                                <option value="arrived">Arrived</option>
                                                <option value="inward_processing">Inward Processing</option>
                                                <option value="waiting">Waiting</option>
                                                <option value="truck_out">Truck Out</option>
                                                <option value="pending">Pending</option>
                                                <option value="dispatched">Dispatched</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-3 text-right">
                            <button type="submit" class="btn btn-primary">Save Truck-Out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="gatepassInAttachment" role="tabpanel">
            <x-attachment-uploader 
                :tableName="'gatepass_in'" 
                :rowId="'GPI-25-00045'" 
            />
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
const preAlertProducts = {
    "101": [
        { name: "Frozen Peas 5kg", batch: "FP-001", qty: 100, uom: "Bag" },
        { name: "Chicken Nuggets 10kg", batch: "CN-002", qty: 50, uom: "Box" }
    ],
    "102": [
        { name: "Fish Fillet 2kg", batch: "FF-003", qty: 30, uom: "Pack" },
        { name: "Mixed Veg 1kg", batch: "MV-004", qty: 80, uom: "Bag" }
    ],
    "103": [
        { name: "Ice Cream Tubs", batch: "IC-005", qty: 60, uom: "Tub" },
        { name: "Paneer Blocks 5kg", batch: "PB-006", qty: 40, uom: "Block" }
    ]
};

let rowIdx = 3;
function addRow() {
    const table = document.querySelector("#gatepassInItemsTable tbody");
    const newRow = document.createElement("tr");
    const rowNumber = table.rows.length + 1;

    newRow.innerHTML = `
        <td>${rowNumber}</td>
        <td><input class="form-control" value=""></td>
        <td><input class="form-control" value=""></td>
        <td><input type="number" class="form-control" value=""></td>
        <td><input class="form-control" value=""></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
    `;
    table.appendChild(newRow);
}

function removeRow(btn) {
    btn.closest('tr').remove();
}

document.querySelector('select[name="pre_alert_id"]').addEventListener('change', function () {
    const selectedId = this.value;
    const products = preAlertProducts[selectedId] || [];

    const tbody = document.querySelector("#gatepassInItemsTable tbody");
    tbody.innerHTML = ""; // Clear existing rows

    products.forEach((product, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${index + 1}</td>
            <td><input class="form-control" value="${product.name}"></td>
            <td><input class="form-control" value="${product.batch}"></td>
            <td><input type="number" class="form-control" value="${product.qty}"></td>
            <td><input class="form-control" value="${product.uom}"></td>
            <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
        `;
        tbody.appendChild(row);
    });
});

</script>
@endsection
