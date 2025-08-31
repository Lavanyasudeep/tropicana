@extends('adminlte::page')

@section('title', 'Customer Contract')

@section('content_header')
    <h1>Customer Contract</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.sales.customer-contract.index') }}" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="contract-tab" data-toggle="tab" href="#contractBasic" role="tab">Basic Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contract-attachment-tab" data-toggle="tab" href="#contractAttachment" role="tab">Attachment</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="contractBasic" role="tabpanel">
            <div class="card page-form page-form-add">
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf

                        <div class="row">
                            <!-- Panel 1 -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 200px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Contract No</div>
                                        <div class="pform-value">
                                            <input type="text" value="CT‑25‑00001" readonly>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Start Date</div>
                                        <div class="pform-value">
                                            <input type="date" value="@php echo date('Y-m-d') @endphp">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">End Date</div>
                                        <div class="pform-value">
                                            <input type="date" value="">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Billing Cycle</div>
                                        <div class="pform-value">
                                            <select class="form-control">
                                                <option>Monthly</option>
                                                <option>Quarterly</option>
                                                <option>Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Billing Method</div>
                                        <div class="pform-value">
                                            <input type="text" value="Manual">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel 2 -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 200px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Customer Name</div>
                                        <div class="pform-value">
                                            <input type="text" value="Acme Cold Storage">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Number</div>
                                        <div class="pform-value">
                                            <input type="text" value="+91 9876543210">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Email</div>
                                        <div class="pform-value">
                                            <input type="text" value="acme@example.com">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contract Type</div>
                                        <div class="pform-value">
                                            <input type="text" value="Storage & Handling">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel 3 -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 200px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Temperature Variance Charge</div>
                                        <div class="pform-value">
                                            <input type="number" step="0" class="form-control" name="temp_var_charge" value="0">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Price Escalation: Revised Power Out Details?</div>
                                        <div class="pform-value">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_required" value="1" checked> Yes
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_required" value="0"> No
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Price Escalation: Power Tariff Hike Details?</div>
                                        <div class="pform-value">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_required" value="1" checked> Yes
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_required" value="0"> No
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Security Deposits</div>
                                        <div class="pform-value">
                                            <input type="text" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="page-list-panel">
                                    <table class="page-input-table" id="contractItemsTable">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Min. Guarantee (pallets)</th>
                                                <th>Temperature to maintain</th>
                                                <th>Storage Charge</th>
                                                <th>Handling Charge</th>
                                                <th><button type="button" onclick="addContractRow()" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input class="form-control" value="Fruits"></td>
                                                <td><input type="number" class="form-control" value="1000"></td>
                                                <td><input type="text" class="form-control" value="+2 to +4 deg. C"></td>
                                                <td><input class="form-control" value="CR184"></td>
                                                <td><input class="form-control" value="CR50"></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row" >
                                        <div class="col-md-6" ><br /><br />
                                            <div class="remarks-panel" >
                                                <label>Remarks</label>
                                                <textarea class="form-control" name="remarks">Includes power tariff escalation clause</textarea>
                                            </div>
                                        </div>
                                    </div>
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
        <div class="tab-pane fade" id="contractAttachment" role="tabpanel">
            <x-attachment-uploader 
                :tableName="'customer-contract'" 
                :rowId="'CT-25-00001'" 
            />
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
let rowIdx = 1;

function addContractRow() {
    let table = document.querySelector("#contractItemsTable tbody");
    let newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td><input class="form-control" value="Sample Product ${rowIdx+1}"></td>
        <td><input type="number" class="form-control" value="500"></td>
        <td><input class="form-control" value="CR${180 + rowIdx}"></td>
        <td><input class="form-control" value="CR${40 + rowIdx}"></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
    `;
    table.appendChild(newRow);
    rowIdx++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>
@endsection
