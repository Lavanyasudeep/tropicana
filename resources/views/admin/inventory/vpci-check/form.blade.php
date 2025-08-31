@extends('adminlte::page')

@section('title', 'Create Pre Cooling Inspection Check')

@section('content_header')
    <h1>Pre Cooling Inspection Check</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.vpci-check.index') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="#" id="vcpiForm">
            <div class="row">
                <!-- Panel 1 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 150px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc No.</div>
                            <div class="pform-value"><input type="text" name="pl_no" value="VCPI-2025-0829-001" readonly></div>
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
                        <div class="pform-clear"></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 150px;">
                        <div class="pform-row">
                            <div class="pform-label">Customer</div>
                            <div class="pform-value">
                                <input type="text" id="customer" name="customer" value="Ocean Fresh Exports Pvt Ltd">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Vehicle No.</div>
                            <div class="pform-value">
                                <input type="text" id="vehicle_no" name="vehicle_no" value="KL-07-BD-1123">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Transporter Name</div>
                            <div class="pform-value">
                                <input type="text" id="transporter_name" name="transporter_name" value="ABC Logistics">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Seal No.</div>
                            <div class="pform-value">
                                <input type="text" id="seal_no" name="seal_no" value="SEAL-0829-A">
                            </div>
                        </div>
                        <!-- <div class="pform-row">
                            <div class="pform-label">Arrival Time</div>
                            <div class="pform-value">
                                <input type="time" id="arrival_time" name="arrival_time" value="14:45">
                            </div>
                        </div> -->
                        <div class="pform-clear"></div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 150px;">
                        <div class="pform-row">
                            <div class="pform-label">Body Condition</div>
                            <div class="pform-value">
                                <select id="body_condition" name="body_condition" class="form-control">
                                    <option>Good</option>
                                    <option>Damaged</option>
                                    <option>Rust</option>
                                    <option>Dents</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Insulation Status</div>
                            <div class="pform-value">
                                <select id="insulation_status" name="insulation_status" class="form-control">
                                    <option>Intact</option>
                                    <option>Damaged</option>
                                    <option>Missing</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Cleanliness</div>
                            <div class="pform-value">
                                <select id="cleanliness" name="cleanliness" class="form-control">
                                    <option>Clean</option>
                                    <option>Dirty</option>
                                    <option>Contaminated</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Pre-Cooling Temp (°C)</div>
                            <div class="pform-value">
                                <input type="number" step="0.1" class="form-control" name="measured_temp" value="-16.5">
                            </div>
                        </div>
                        <!-- <div class="pform-row">
                            <div class="pform-label">Required Temp (°C)</div>
                            <div class="pform-value">
                                <input type="number" step="0.1" class="form-control" name="required_temp" value="-18.0">
                            </div>
                        </div> -->
                        <div class="pform-clear"></div>
                    </div>
                </div>
            </div>

            <!-- Table for Multiple Temperature Checks -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-list-panel">
                        <label class="page-input-table-heading" >Check List</label>
                        <table class="page-input-table" id="vcpiCheckTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Time</th>
                                    <th>Temp (°C)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><input name="checks[0][check_no]" class="form-control" value="1"></td>
                                    <td><input name="checks[0][time]" type="time" class="form-control" value="{{ date('H:i') }}"></td>
                                    <td><input name="checks[0][temp]" type="number" step="0.1" class="form-control" value="-17.8"></td>
                                    <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row" >
                            <div class="col-md-12" >
                                <button type="button" onclick="addRow()" class="btn btn-sm btn-create float-right" style="margin-top:15px;" ><i class="fa fa-plus" ></i> Add More</button>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-md-6" ><br /><br />
                                <div class="remarks-panel" >
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks">Vehicle accepted. Temperature within range.</textarea>
                                </div>
                            </div>
                            <div class="col-md-6" ><br /><br />
                                <div class="pform-panel" style="min-height: 120px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Temperature Status</div>
                                        <div class="pform-value">
                                            <select id="temp_status" name="temp_status" class="form-control">
                                                <option>Pass</option>
                                                <option>Fail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Device Used</div>
                                        <div class="pform-value">
                                            <select id="device_used" name="device_used" class="form-control">
                                                <option>Infrared Gun</option>
                                                <option>Probe</option>
                                                <option>Thermometer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Calibration Date</div>
                                        <div class="pform-value">
                                            <input type="date" class="form-control" name="calibration_date" value="2025-07-01">
                                        </div>
                                    </div>
                                    <div class="pform-clear"></div>
                                </div>
                            </div>
                        </div>

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
    let table = document.querySelector("#vcpiCheckTable tbody");
    let newRow = document.createElement("tr");

    newRow.innerHTML = `
        <td>2</td>
        <td><input name="checks[${rowIdx}][check_no]" class="form-control" value="${rowIdx+1}"></td>
        <td><input name="checks[${rowIdx}][time]" type="time" class="form-control" value="{{ date('H:i') }}"></td>
        <td><input name="checks[${rowIdx}][temp]" type="number" step="0.1" class="form-control" value="-18.0"></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
    `;

    table.appendChild(newRow);
    rowIdx++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>
@endsection
