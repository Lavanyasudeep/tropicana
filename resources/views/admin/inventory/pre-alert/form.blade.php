@extends('adminlte::page')

@section('title', 'Pre‑Alert')

@section('content_header')
    <h1>Pre‑Alert</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.pre-alert.index') }}" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="#">
            @csrf

            <div class="row">
                <!-- Panel 1 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 150px;">
                        <div class="pform-row">
                            <div class="pform-label">Document #</div>
                            <div class="pform-value">
                                <input type="text" value="PA‑25‑00001" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Document Date</div>
                            <div class="pform-value">
                                <input type="date" value="2025-08-25">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Sales Quotation #</div>
                            <div class="pform-value">
                                <input type="text" value="SQ‑25‑00045">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Client</div>
                            <div class="pform-value">
                                <select>
                                    <option selected>ABC Cold Storage Ltd.</option>
                                    <option>XYZ Foods Pvt. Ltd.</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 150px;">
                        <div class="pform-row">
                            <div class="pform-label">Contact Name</div>
                            <div class="pform-value">
                                <input type="text" value="John Mathew">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Contact Address</div>
                            <div class="pform-value">
                                <input type="text" value="Warehouse Road, Kochi">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Remarks</div>
                            <div class="pform-value">
                                <textarea rows="3">Handle with care — perishable goods</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 150px;">
                        <div class="pform-row">
                            <div class="pform-label">Vehicle No.</div>
                            <div class="pform-value">
                                <input type="text" value="KL‑07‑AB‑1234">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Driver Name</div>
                            <div class="pform-value">
                                <input type="text" value="Ramesh Kumar">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Transport Mode</div>
                            <div class="pform-value">
                                <input type="text" value="Refrigerated Truck">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="page-list-panel">
                        <table class="page-list-table" id="preAlertItemsTable">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>UOM</th>
                                    <th>Qty</th>
                                    <th>Batch No.</th>
                                    <th>Cold Storage Location</th>
                                    <th><button type="button" onclick="addRow()" class="btn btn-sm btn-success">+</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input class="form-control" value="Frozen Prawns"></td>
                                    <td><input class="form-control" value="KG"></td>
                                    <td><input type="number" class="form-control" value="500"></td>
                                    <td><input class="form-control" value="BATCH‑PR‑001"></td>
                                    <td><input class="form-control" value="Cold Room A1"></td>
                                    <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">-</button></td>
                                </tr>
                                <tr>
                                    <td><input class="form-control" value="Frozen Green Peas"></td>
                                    <td><input class="form-control" value="KG"></td>
                                    <td><input type="number" class="form-control" value="300"></td>
                                    <td><input class="form-control" value="BATCH‑GP‑002"></td>
                                    <td><input class="form-control" value="Cold Room B2"></td>
                                    <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">-</button></td>
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
@endsection

@section('js')
<script>
let rowIdx = 2;

function addRow() {
    let table = document.querySelector("#preAlertItemsTable tbody");
    let newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td><input class="form-control" value="Sample Item ${rowIdx+1}"></td>
        <td><input class="form-control" value="KG"></td>
        <td><input type="number" class="form-control" value="100"></td>
        <td><input class="form-control" value="BATCH‑XX‑00${rowIdx+1}"></td>
        <td><input class="form-control" value="Cold Room C${rowIdx+1}"></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">-</button></td>
    `;
    table.appendChild(newRow);
    rowIdx++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>
@endsection
