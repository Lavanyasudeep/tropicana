@extends('adminlte::page')

@section('title', 'Pre‑Alert')

@section('content_header')
    <h1>Pre‑Alert</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.pre-alert.index') }}" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" >
        <li class="nav-item">
            <a class="nav-link active" id="pre-alert-tab" data-toggle="tab" href="#preAlert" role="tab">Basic Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="prealert-attachment-tab" data-toggle="tab" href="#preAlertAttachment" role="tab">Attachment</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="preAlert" role="tabpanel">

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
                                            <input type="date" value="@php echo date('Y-m-d') @endphp" readonly>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Date of Arriving</div>
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
                                        <div class="pform-label">Customer Name</div>
                                        <div class="pform-value">
                                            <input type="text" value="">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Number</div>
                                        <div class="pform-value">
                                            <input type="text" value="">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Email</div>
                                        <div class="pform-value">
                                            <input type="text" value="">
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
                                    <table class="page-input-table" id="preAlertItemsTable">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Batch No.</th>
                                                <th>Quantity</th>
                                                <th>UOM</th>
                                                <th>Manufacturing Date</th>
                                                <th>Expiry Date</th>
                                                <th><button type="button" onclick="addRow()" class="btn btn-sm btn-success"><i class="fa fa-plus" ></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input class="form-control" value=""></td>
                                                <td><input type="number" class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input type="date" class="form-control" value=""></td>
                                                <td><input type="date" class="form-control" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" value=""></td>
                                                <td><input type="number" class="form-control" value=""></td>
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
        <div class="tab-pane fade" id="preAlertAttachment" role="tabpanel">
            <x-attachment-uploader 
                :tableName="'pre-alert'" 
                :rowId="'PA-25-00012'" 
            />
        </div>
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
        <td><input class="form-control" value="BATCH‑XX‑00${rowIdx+1}"></td>
        <td><input type="number" class="form-control" value="100"></td>
        <td><input class="form-control" value="Box"></td>
        <td><input type="date" class="form-control" value=""></td>
        <td><input type="date" class="form-control" value=""></td>
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
