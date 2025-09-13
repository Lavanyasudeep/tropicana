@extends('adminlte::page')

@section('title', 'Order/Packing List')

@section('content_header')
    <h1>Order/Packing List</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="#" class="btn btn-import" title="import" id="hdrImportBtn" ><i class="fas fa-file-import" ></i> Import</a>
        <a href="{{ route('admin.inventory.packing-list.index') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" >
        <li class="nav-item">
            <a class="nav-link active" id="packing-list-tab" data-toggle="tab" href="#packingList" role="tab">Basic Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="packinglist-attachment-tab" data-toggle="tab" href="#packingListAttachment" role="tab">Attachment</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="packingList" role="tabpanel">
            <div class="card page-form page-form-add">
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf
                        <div class="row">
                            <!-- Panel 1: Document Info -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 183px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Doc No.</div>
                                        <div class="pform-value"><input type="text" name="pl_no" value="PL-25-00012" readonly></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Doc Date</div>
                                        <div class="pform-value"><input type="date" name="pl_date" value="2025-08-26"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Date of Arrived</div>
                                        <div class="pform-value">
                                            <input type="date" value="" >
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Gate Pass No.</div>
                                        <div class="pform-value">
                                            <select name="gate_pass_id" id="gate_pass_id" class="form-control">
                                                <option value="">- Select -</option>
                                                <option value="GP-25-0045">GP-25-0045</option>
                                                <option value="GP-25-0046">GP-25-0046</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Invoice No.</div>
                                        <div class="pform-value"><input type="text" name="invoice_no" placeholder="Eg: INV-25-0010" readonly></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel 2: Customer Info -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 183px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Customer Name</div>
                                        <div class="pform-value"><input type="text" name="customer_name" placeholder="" readonly></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Number</div>
                                        <div class="pform-value"><input type="text" name="customer_contact" placeholder="" readonly></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Email</div>
                                        <div class="pform-value"><input type="text" name="contact_email" value="" readonly></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Address</div>
                                        <div class="pform-value"><textarea name="customer_address" rows="3" readonly></textarea></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel 3: Shipment Info -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 183px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Transport Mode</div>
                                        <div class="pform-value">
                                            <input type="text" name="transport_mode" placeholder="Eg: Refrigerated Truck, VAN, etc">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Vehicle No.</div>
                                        <div class="pform-value"><input type="text" name="vehicle_no" placeholder="Eg: KL-07-CD-4521" ></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Container No.</div>
                                        <div class="pform-value"><input type="text" name="container_no" placeholder="Eg: CONT-SEA-00987"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Driver Name</div>
                                        <div class="pform-value"><input type="text" name="driver_name" value="" ></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Driver Mobile No.</div>
                                        <div class="pform-value"><input type="text" name="driver_mobile_no" value="" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="page-list-panel">
                                    <table class="page-input-table" id="packingListItemsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item Name</th>
                                                <th>Batch No.</th>
                                                <th>Quantity</th>
                                                <th>UOM</th>
                                                <th>Net Weight</th>
                                                <th>Manufacturing Date</th>
                                                <th>Expiry Date</th>
                                                <th><button type="button" onclick="addRow()" class="btn btn-sm btn-success"><i class="fa fa-plus" ></i></button></th>   
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input type="date" class="form-control" value=""></td>
                                                <td><input type="date" class="form-control" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input type="date" class="form-control" value=""></td>
                                                <td><input type="date" class="form-control" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input type="date" class="form-control" value=""></td>
                                                <td><input type="date" class="form-control" value=""></td>
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
        <div class="tab-pane fade" id="packingListAttachment" role="tabpanel">
            <x-attachment-uploader 
                :tableName="'packing_list'" 
                :rowId="'PL-25-00012'" 
            />
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

let rowIdx = 4;

function addRow() {
    const table = document.querySelector("#packingListItemsTable tbody");
    const rowNumber = table.rows.length + 1;

    const newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td>${rowNumber}</td>
        <td><input class="form-control" value=""></td>
        <td><input class="form-control" value=""></td>
        <td><input type="number" class="form-control" value=""></td>
        <td><input class="form-control" value=""></td>
        <td><input class="form-control" value=""></td>
        <td><input type="date" class="form-control" value=""></td>
        <td><input type="date" class="form-control" value=""></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
    `;
    table.appendChild(newRow);
}

function removeRow(btn) {
    btn.closest('tr').remove();
}

document.addEventListener('DOMContentLoaded', function () {
    const gatePassData = {
        "GP-25-0045": {
            invoice_no: "INV-25-0010",
            customer: {
                name: "Chelur Foods",
                contact: "9876543210",
                email: "chelur@example.com",
                address: "Chelur Industrial Estate, Kochi, Kerala"
            },
            items: [
                { name: "Frozen Peas 5kg", batch: "FP-001", qty: 100, uom: "Bag", weight: "500", mfg: "2025-08-01", exp: "2026-02-01" },
                { name: "Chicken Nuggets 10kg", batch: "CN-002", qty: 50, uom: "Box", weight: "1000", mfg: "2025-07-15", exp: "2026-01-15" },
                { name: "Fish Fillet 2kg", batch: "FF-003", qty: 30, uom: "Pack", weight: "200", mfg: "2025-06-20", exp: "2026-01-20" },
                { name: "Mixed Veg 1kg", batch: "MV-004", qty: 80, uom: "Bag", weight: "100", mfg: "2025-08-10", exp: "2026-02-10" },
                { name: "Ice Cream Tubs", batch: "IC-005", qty: 60, uom: "Tub", weight: "300", mfg: "2025-07-01", exp: "2026-01-01" },
                { name: "Paneer Blocks 5kg", batch: "PB-006", qty: 40, uom: "Block", weight: "500", mfg: "2025-08-05", exp: "2025-12-05" },
                { name: "Frozen Corn 2kg", batch: "FC-007", qty: 90, uom: "Bag", weight: "200", mfg: "2025-07-25", exp: "2026-01-25" },
                { name: "Veg Spring Rolls 1kg", batch: "SR-008", qty: 70, uom: "Box", weight: "100", mfg: "2025-08-12", exp: "2026-02-12" }
            ]
        },
        "GP-25-0046": {
            invoice_no: "INV-25-0011",
            customer: {
                name: "AAA International",
                contact: "9123456789",
                email: "aaa@example.com",
                address: "Plot 45, Export Zone, Mumbai, Maharashtra"
            },
            items: [
                { name: "Fish Fillet 2kg", batch: "FF-003", qty: 30, uom: "Pack", weight: "200", mfg: "2025-06-20", exp: "2026-01-20" },
                { name: "Frozen Momos 2kg", batch: "FM-012", qty: 65, uom: "Box", weight: "200", mfg: "2025-07-22", exp: "2026-01-22" }
            ]
        }
    };
    const gatePassSelect = document.getElementById('gate_pass_id');
    if (!gatePassSelect) {
        console.error("Gate pass select element not found.");
        return;
    }

    gatePassSelect.addEventListener('change', function () {
        const selectedId = this.value;
        const data = gatePassData[selectedId];

        if (!data) {
            console.warn("No data found for selected gate pass:", selectedId);
            return;
        }

        // Fill invoice and customer fields
        document.querySelector('input[name="invoice_no"]').value = data.invoice_no || '';
        document.querySelector('input[name="customer_name"]').value = data.customer.name || '';
        document.querySelector('input[name="customer_contact"]').value = data.customer.contact || '';
        document.querySelector('input[name="contact_email"]').value = data.customer.email || '';
        document.querySelector('textarea[name="customer_address"]').value = data.customer.address || '';

        // Fill packing list table
        const tbody = document.querySelector("#packingListItemsTable tbody");
        tbody.innerHTML = "";

        data.items.forEach((item, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td><input class="form-control" value="${item.name}"></td>
                <td><input class="form-control" value="${item.batch}"></td>
                <td><input class="form-control" value="${item.qty}"></td>
                <td><input class="form-control" value="${item.uom}"></td>
                <td><input class="form-control" value="${item.weight}"></td>
                <td><input type="date" class="form-control" value="${item.mfg}"></td>
                <td><input type="date" class="form-control" value="${item.exp}"></td>
                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
            `;
            tbody.appendChild(row);
        });
    });
});
</script>
