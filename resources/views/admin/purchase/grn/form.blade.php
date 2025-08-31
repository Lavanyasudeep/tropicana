@extends('adminlte::page')

@section('title', 'Create GRN')

@section('content_header')
    <h1>Goods Receipt Note (GRN)</h1>
@endsection

@section('content')

<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.purchase.grn.index') }}" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form id="grnForm">
            @csrf

            <!-- Header Fields -->
            <div class="row">
                <!-- Column 1 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:250px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc No</div>
                            <div class="pform-value">
                                <input type="text" name="doc_no" id="doc_no" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc Date</div>
                            <div class="pform-value">
                                <input type="date" name="doc_date" id="doc_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Customer</div>
                            <div class="pform-value">
                                <select name="customer_id" id="customer_id" class="form-control">
                                    <option value="">-- Select Supplier --</option>
                                    <option value="SUP001">Ocean Fresh Exports Pvt Ltd</option>
                                    <option value="SUP002">Fresh Harvest Distributors</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Invoice No</div>
                            <div class="pform-value">
                                <input type="text" name="invoice_no" id="invoice_no" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Customer Order No</div>
                            <div class="pform-value">
                                <input type="text" name="order_no" id="order_no" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:250px;">
                        <div class="pform-row">
                            <div class="pform-label">Gatepass No</div>
                            <div class="pform-value">
                                <select name="gatepass_no" id="gatepass_no" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="GP001">GP001</option>
                                    <option value="GP002">GP002</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Vehicle No</div>
                            <div class="pform-value">
                                <input type="text" name="vehicle_no" id="vehicle_no" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Vehicle Temperature</div>
                            <div class="pform-value">
                                <input type="text" name="vehicle_temperature" id="vehicle_temperature" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Vehicle Temperature Status</div>
                            <div class="pform-value">
                                <input type="text" name="vehicle_temp_status" id="vehicle_temp_status" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Total Pallets</div>
                            <div class="pform-value">
                                <input type="number" name="total_pallets" id="total_pallets" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Status</div>
                            <div class="pform-value">
                                <select name="status" id="status" class="form-control">
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 3 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:250px;">
                        <div class="pform-row">
                            <div class="pform-label">Warehouse Unit</div>
                            <div class="pform-value">
                                <input type="text" name="warehouse_unit" id="warehouse_unit" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Dock No</div>
                            <div class="pform-value">
                                <input type="text" name="dock_no" id="dock_no" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Dock In Time</div>
                            <div class="pform-value">
                                <input type="text" name="dock_in_time" id="dock_in_time" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Remarks</div>
                            <div class="pform-value">
                                <textarea name="remarks" id="remarks" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="page-list-panel">
                        <table class="page-list-table" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Lot</th>
                                    <th>UOM</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items injected dynamically -->
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dummy data map keyed by customer_id value
    const customerDummyData = {
        "SUP001": {
            invoice_no: "INV-2501",
            order_no: "ORD-501",
            gatepass_no: "GP001",
            vehicle_no: "KL-07-AB-1234",
            vehicle_temperature: "-18°C",
            vehicle_temp_status: "OK",
            total_pallets: 12,
            status: "Pending",
            warehouse_unit: "WU-0005",
            dock_no: "D-07",
            dock_in_time: "10:15",
            remarks: "All products delivered frozen and sealed",
            items: [
                { product: "Frozen Prawns 500g", lot: "BCH-25-001", uom: "Boxes", qty: 60 },
                { product: "Frozen Squid Rings 1kg", lot: "BCH-25-002", uom: "Boxes", qty: 40 }
            ]
        },
        "SUP002": {
            invoice_no: "INV-2502",
            order_no: "ORD-502",
            gatepass_no: "GP002",
            vehicle_no: "KL-07-CD-4521",
            vehicle_temperature: "-16°C",
            vehicle_temp_status: "Slightly High",
            total_pallets: 8,
            status: "Pending",
            warehouse_unit: "WU-0008",
            dock_no: "D-04",
            dock_in_time: "11:20",
            remarks: "Requires QC check before storage",
            items: [
                { product: "Frozen Tuna Steaks 2kg", lot: "BCH-25-010", uom: "Boxes", qty: 50 },
                { product: "Frozen Lobster Tails 1kg", lot: "BCH-25-011", uom: "Boxes", qty: 50 }
            ]
        }
    };

    const customerSelect = document.getElementById('customer_id');

    customerSelect.addEventListener('change', function () {
        const val = this.value;
        const data = customerDummyData[val];

        if (!data) {
            // clear form if no customer selected
            document.getElementById('invoice_no').value = '';
            document.getElementById('order_no').value = '';
            document.getElementById('vehicle_no').value = '';
            document.getElementById('vehicle_temperature').value = '';
            document.getElementById('vehicle_temp_status').value = '';
            document.getElementById('total_pallets').value = '';
            document.getElementById('warehouse_unit').value = '';
            document.getElementById('dock_no').value = '';
            document.getElementById('dock_in_time').value = '';
            document.getElementById('remarks').value = '';
            document.querySelector('#gatepass_no').value = '';
            document.querySelector('#status').value = 'Pending';
            document.querySelector('#itemsTable tbody').innerHTML = '';
            return;
        }

        // fill header fields
        document.getElementById('invoice_no').value = data.invoice_no;
        document.getElementById('order_no').value = data.order_no;
        document.getElementById('vehicle_no').value = data.vehicle_no;
        document.getElementById('vehicle_temperature').value = data.vehicle_temperature;
        document.getElementById('vehicle_temp_status').value = data.vehicle_temp_status;
        document.getElementById('total_pallets').value = data.total_pallets;
        document.getElementById('warehouse_unit').value = data.warehouse_unit;
        document.getElementById('dock_no').value = data.dock_no;
        document.getElementById('dock_in_time').value = data.dock_in_time;
        document.getElementById('remarks').value = data.remarks;

        // select options
        document.querySelector('#gatepass_no').value = data.gatepass_no;
        document.querySelector('#status').value = data.status;

        // fill items table
        const tbody = document.querySelector('#itemsTable tbody');
        tbody.innerHTML = '';
        data.items.forEach(function (item) {
            tbody.innerHTML += `
                <tr>
                    <td>${item.product}</td>
                    <td>${item.lot}</td>
                    <td>${item.uom}</td>
                    <td class="text-right">${item.qty}</td>
                </tr>
            `;
        });
    });
});
</script>

@endsection
