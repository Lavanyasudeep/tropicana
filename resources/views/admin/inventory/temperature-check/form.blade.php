@extends('adminlte::page')

@section('title', 'Create Temperature Check')

@section('content_header')
    <h1>Temperature Check</h1>
@endsection

@section('content')
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
                    <div class="pform-panel" style="min-height: 200px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc No.</div>
                            <div class="pform-value"><input type="text" name="pl_no" value="TC-25-0001" readonly></div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc Date</div>
                            <div class="pform-value">
                                <input type="date" id="check_date" name="check_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc Time</div>
                            <div class="pform-value">
                                <input type="time" id="check_time" name="check_time" value="{{ date('H:i') }}">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Gate Pass No.</div>
                            <div class="pform-value">
                                <select id="gate_pass_no" name="gate_pass_no" class="form-control">
                                    <option value="">-- Select Gate Pass --</option>
                                    <option value="GP-25-0045" selected>GP-25-0045</option>
                                    <option value="GP-25-0046">GP-25-0046</option>
                                    <option value="GP-25-0047">GP-25-0047</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Customer</div>
                            <div class="pform-value">
                                <input type="text" id="customer" name="customer" value="Ocean Fresh Exports Pvt Ltd">
                            </div>
                        </div>
                        <div class="pform-clear"></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 200px;">
                        <div class="pform-row">
                            <div class="pform-label">Vehicle No.</div>
                            <div class="pform-value">
                                <input type="text" id="vehicle_no" name="vehicle_no" value="KL-07-CD-4521">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Product</div>
                            <div class="pform-value">
                                <input type="text" id="product" name="product" value="Frozen Prawns">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Total Qty</div>
                            <div class="pform-value">
                                <input type="number" id="sku" name="sku" value="500">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Vehicle Set Temp (°C)</div>
                            <div class="pform-value">
                                <input type="number" step="0.1" id="vehicle_set_temp" name="vehicle_set_temp" value="-18.5">
                            </div>
                        </div>
                        <div class="pform-clear"></div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 200px;">
                        <div class="pform-row">
                            <div class="pform-label">Remarks</div>
                            <div class="pform-value">
                                <textarea name="remarks" rows="3">Temperature within range, seals intact.</textarea>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Received By</div>
                            <div class="pform-value">
                                <select id="received_by" name="received_by" class="form-control">
                                    <option value="">-- Select Employee --</option>
                                    <option value="EMP001" selected>John Mathew</option>
                                    <option value="EMP002">Anil Kumar</option>
                                    <option value="EMP003">Priya Nair</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Checked By</div>
                            <div class="pform-value">
                                <select id="checked_by" name="checked_by" class="form-control">
                                    <option value="">-- Select Employee --</option>
                                    <option value="EMP004" selected>Ravi Menon</option>
                                    <option value="EMP005">Suresh Babu</option>
                                    <option value="EMP006">Lakshmi Devi</option>
                                </select>
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
                        <table class="page-input-table" id="temperatureCheckTable">
                            <thead>
                                <tr>
                                    <th style="width:5%;" >#</th>
                                    <th style="width:60%;" >Product</th>
                                    <th style="width:15%;" >Time</th>
                                    <th style="width:15%; text-align:right;" >Product Temp (°C)</th>
                                    <th style="width:10%;" ><button type="button" onclick="addRow()" class="btn btn-sm btn-success"><i class="fa fa-plus" ></i></button></th>  
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input name="checks[0][check_no]" class="form-control" value="1"></td>
                                    <td>
                                        <select name="checks[0][product_name]" class="form-control">
                                            <option value="">-- Select Product --</option>
                                            <option value="Frozen Prawns" selected>Frozen Prawns</option>
                                            <option value="Frozen Squid Rings">Frozen Squid Rings</option>
                                            <option value="Frozen Crab Meat">Frozen Crab Meat</option>
                                        </select>
                                    </td>
                                    <td><input name="checks[0][time]" type="time" class="form-control" value="{{ date('H:i') }}"></td>
                                    <td><input name="checks[0][product_temp]" type="number" step="0.1" class="form-control" value="-17.8"></td>
                                    <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-save btn-sm float-right" title="save">Save</button>
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
        <td><input name="checks[${rowIdx}][check_no]" class="form-control" value="${rowIdx+1}"></td>
        <td>
            <select name="checks[${rowIdx}][product_name]" class="form-control">
                <option value="">-- Select Product --</option>
                <option value="Frozen Prawns">Frozen Prawns</option>
                <option value="Frozen Squid Rings">Frozen Squid Rings</option>
                <option value="Frozen Crab Meat">Frozen Crab Meat</option>
            </select>
        </td>
        <td><input name="checks[${rowIdx}][time]" type="time" class="form-control" value="{{ date('H:i') }}"></td>
        <td><input name="checks[${rowIdx}][product_temp]" type="number" step="0.1" class="form-control" value="-18.0"></td>
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
