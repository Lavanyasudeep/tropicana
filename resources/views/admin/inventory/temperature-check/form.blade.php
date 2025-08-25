@extends('adminlte::page')

@section('title', 'Create Temperature Check')

@section('content_header')
    <h1>Temperature Check</h1>
@endsection

@section('content')
<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.temperature-check.index') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="#" id="temperatureForm">
            <div class="row">
                <!-- Panel 1 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 150px;">
                        <div class="pform-row">
                            <div class="pform-label">Date</div>
                            <div class="pform-value">
                                <input type="date" id="check_date" name="check_date">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Time</div>
                            <div class="pform-value">
                                <input type="time" id="check_time" name="check_time">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Gate Pass No.</div>
                            <div class="pform-value">
                                <input type="text" id="gate_pass_no" name="gate_pass_no">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Customer</div>
                            <div class="pform-value">
                                <input type="text" id="customer" name="customer">
                            </div>
                        </div>
                        <div class="pform-clear"></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 150px;">
                        <div class="pform-row">
                            <div class="pform-label">Vehicle No.</div>
                            <div class="pform-value">
                                <input type="text" id="vehicle_no" name="vehicle_no">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Product</div>
                            <div class="pform-value">
                                <input type="text" id="product" name="product">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">SKU</div>
                            <div class="pform-value">
                                <input type="text" id="sku" name="sku">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Vehicle Set Temp (°C)</div>
                            <div class="pform-value">
                                <input type="number" step="0.1" id="vehicle_set_temp" name="vehicle_set_temp">
                            </div>
                        </div>
                        <div class="pform-clear"></div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 150px;">
                        <div class="pform-row">
                            <div class="pform-label">Remarks</div>
                            <div class="pform-value">
                                <textarea name="remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Received By</div>
                            <div class="pform-value">
                                <input type="text" id="received_by" name="received_by">
                            </div>
                        </div>
                        <div class="pform-clear"></div>
                    </div>
                </div>
            </div>

            <!-- Table for Multiple Temperature Checks -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-list-panel">
                        <table class="page-list-table" id="temperatureCheckTable">
                            <thead>
                                <tr>
                                    <th>Check #</th>
                                    <th>Time</th>
                                    <th>Product Temp (°C)</th>
                                    <th>Name</th>
                                    <th>Driver</th>
                                    <th><button type="button" onclick="addRow()" class="btn btn-sm btn-success">+</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input name="checks[0][check_no]" class="form-control"></td>
                                    <td><input name="checks[0][time]" type="time" class="form-control"></td>
                                    <td><input name="checks[0][product_temp]" type="number" step="0.1" class="form-control"></td>
                                    <td><input name="checks[0][name]" class="form-control"></td>
                                    <td><input name="checks[0][driver]" class="form-control"></td>
                                    <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">-</button></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <a href="{{ route('admin.inventory.temperature-check.index') }}" class="btn btn-save btn-sm float-right" title="save" >Save</a>
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
let rowIdx = 1;

function addRow() {
    let table = document.querySelector("#temperatureCheckTable tbody");
    let newRow = document.createElement("tr");

    newRow.innerHTML = `
        <td><input name="checks[${rowIdx}][check_no]" class="form-control"></td>
        <td><input name="checks[${rowIdx}][time]" type="time" class="form-control"></td>
        <td><input name="checks[${rowIdx}][product_temp]" type="number" step="0.1" class="form-control"></td>
        <td><input name="checks[${rowIdx}][name]" class="form-control"></td>
        <td><input name="checks[${rowIdx}][driver]" class="form-control"></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">-</button></td>
    `;

    table.appendChild(newRow);
    rowIdx++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>
@stop
