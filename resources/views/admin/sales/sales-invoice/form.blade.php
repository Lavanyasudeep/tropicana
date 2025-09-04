@extends('adminlte::page')

@section('title', 'Sales Invoice')

@section('content_header')
    <h1>Sales Invoice</h1>
@endsection

@section('content')

@php

if(isset($invoice)) {
    $page_title = 'Edit';
    $action = route('admin.sales.sales-invoice.update', $invoice->sales_invoice_id);
    $method = 'PUT';

    $doc_no = $invoice->doc_no;
    $doc_date = $invoice->doc_date;
    $status = $invoice->status;
    $customer_id = $invoice->customer_id;
    $service_type = $invoice->service_type;
    $remarks = $invoice->remarks;
    $customer_id = $invoice->customer_id;
    $service_type = explode(',', $invoice->service_type);
    $remarks = $invoice->remarks;
    $total_amount = $invoice->total_amount;
    $cgst_amount = $invoice->cgst_amount;
    $sgst_amount = $invoice->sgst_amount;
    $igst_amount = $invoice->igst_amount;
    $grand_amount = $invoice->grand_amount;
} else {
    $page_title = 'Create';
    $action = route('admin.sales.sales-invoice.store');
    $method = 'POST';

    $doc_no = '';
    $doc_date = date('Y-m-d');
    $status = 'created';
    $customer_id = '';
    $service_type = '';
    $remarks = '';
    $customer_id = '';
    $service_type = [];
    $remarks = '';
    $total_amount = '';
    $cgst_amount = '';
    $sgst_amount = '';
    $igst_amount = '';
    $grand_amount = '';
}

@endphp


<div class="page-sub-header">
    <h3>{{ $page_title }} Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.sales.sales-invoice.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="{{ $action }}">
            @csrf
            @method($method)
            <div class="row">
                <!-- Left Panel: Document Info -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 200px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc. No.</div>
                            <div class="pform-value">
                                <input type="text" name="doc_no" class="form-control" value="{{ old('doc_no', $doc_no) }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc. Date</div>
                            <div class="pform-value">
                                <input type="date" name="doc_date" class="form-control" value="{{ old('doc_date', $doc_date ?? date('Y-m-d')) }}">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Billing Type</div>
                            <div class="pform-value">
                                <input type="text" name="billing_type" id="billing_type" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Status</div>
                            <div class="pform-value">
                                <select name="status" id="status" class="form-control">
                                <option value="created" @selected(old('status', $status) == 'created')>Created</option>
                                <option value="approved" @selected(old('status', $status) == 'approved')>Approved</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear"></div>
                    </div>
                </div>

                <!-- Middle Panel: Customer Info -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 200px;">
                        <div class="pform-row">
                            <div class="pform-label">Customer</div>
                            <div class="pform-value">
                                <select name="customer_id" id="customer_id" class="form-control select2">
                                <option value="">- Select -</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_id }}" {{ old('customer_id', $customer_id) == $customer->customer_id ? 'selected' : '' }}>
                                    {{ $customer->customer_name }} - {{ $customer->phone_number }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Contact No.</div>
                            <div class="pform-value">
                                <input type="text" name="customer_contact_no" id="customer_contact_no" value="{{ old('contact_no', $customer->phone_number ?? '') }}" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Credit Limit</div>
                            <div class="pform-value">
                                <input type="text" name="credit_limit" id="credit_limit" value="" readonly class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Cur. Balance</div>
                            <div class="pform-value">
                                <input type="text" name="current_balance" id="current_balance" value="" readonly class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">GSTIN</div>
                            <div class="pform-value">
                                <input type="text" name="gstin" id="gstin" value="" readonly class="form-control">
                            </div>
                        </div>
                        <div class="pform-clear"></div>
                    </div>
                </div>

                <!-- Right Panel: Vehicle & Delivery -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 200px;">
                        <div class="pform-row">
                            <div class="pform-label">Vehicle Type</div>
                            <div class="pform-value">
                                <input type="text" name="vehicle_type" id="vehicle_type" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Vehicle No.</div>
                            <div class="pform-value">
                                <input type="text" name="vehicle_no" id="vehicle_no" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Driver Name</div>
                            <div class="pform-value">
                                <input type="text" name="driver_name" id="driver_name" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Delivery Address</div>
                            <div class="pform-value">
                                <textarea name="customer_address" id="customer_address" class="form-control">{{ old('address', $customer->main_address ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="pform-clear"></div>
                    </div>
                </div>
            </div>

            <!-- Product Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-list-panel">
                        <table class="page-input-table" id="invoiceItemsTable">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Item Type</th>
                                <th class="text-center">Qty (pallets)</th>
                                <th class="text-right">Rate (₹)</th>
                                <th class="text-right">Tax %</th>
                                <th class="text-right">Total (₹)</th>
                                <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>1</td>
                                <td>
                                    <select name="items[0][item_type]" class="form-control">
                                    <option value="">Select</option>
                                    <option value="frozen">Frozen</option>
                                    <option value="chilled">Chilled</option>
                                    <option value="dry">Dry</option>
                                    </select>
                                </td>
                                <td><input type="number" name="items[0][qty]" class="form-control text-center" placeholder="0"></td>
                                <td><input type="text" name="items[0][rate]" class="form-control text-right" placeholder="0.00"></td>
                                <td><input type="text" name="items[0][tax]" class="form-control text-right" placeholder="0%"></td>
                                <td><input type="text" name="items[0][total]" class="form-control text-right" readonly></td>
                                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">🗑</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <button type="button" class="btn btn-create btn-sm" id="addRowBtn" onclick="addRow()">+ Add Row</button>
                    
                        <div class="row">
                            <div class="col-md-6"><br /><br />
                                <div class="remarks-panel" >
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6"><br /><br />
                                <div class="pform-panel" style="min-height: 350px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Billing Scenario</div>
                                        <div class="pform-value">
                                            <select name="billing_scenario" id="billing_scenario" class="form-control">
                                            <option value="">- Select -</option>
                                            <option value="fixed_start">Fixed Start ≠ 1st</option>
                                            <option value="fixed_end">Fixed End ≠ 1st</option>
                                            <option value="daily_start">Daily Start ≠ Period Start</option>
                                            <option value="daily_end">Daily End ≠ Period End</option>
                                            <option value="weekly_full">Weekly Full Month</option>
                                            <option value="weekly_partial">Weekly Partial Month</option>
                                            <option value="cutoff_overflow">Cut-off Beyond Period</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="pform-row">
                                        <div class="pform-label">Fixed Charges (₹/month)</div>
                                        <div class="pform-value">
                                            <input type="text" name="fixed_charge" id="fixed_charge" class="form-control text-right" placeholder="₹ / month">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Variable Charges (₹/month)</div>
                                        <div class="pform-value">
                                            <input type="text" name="variable_charge" id="variable_charge" class="form-control text-right" placeholder="₹ / unit or day">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">VAS Charges (₹):</div>
                                        <div class="pform-value">
                                            <input type="text" name="vas_charge" id="vas_charge" class="form-control text-right" placeholder="₹ total VAS">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Power Tariff Hike (₹/kWH):</div>
                                        <div class="pform-value">
                                            <input type="text" name="power_hike_charge" id="power_hike_charge" class="form-control text-right" placeholder="₹2.50/kWh">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Power Cut Backup (₹/kWH):</div>
                                        <div class="pform-value">
                                            <input type="text" name="power_cut_charge" id="power_cut_charge" class="form-control text-right" placeholder="₹500/hour">
                                        </div>
                                    </div>

                                    <div class="pform-row">
                                        <div class="pform-label">Temperature Penalty (₹):</div>
                                        <div class="pform-value">
                                            <input type="text" name="temperature_penalty" id="temperature_penalty" class="form-control text-right" placeholder="₹1,000/incident">
                                        </div>
                                    </div>

                                    <div class="pform-row">
                                        <div class="pform-label">Discount (₹):</div>
                                        <div class="pform-value">
                                            <input type="text" name="discount" id="discount" class="form-control text-right" placeholder="0.00">
                                        </div>
                                    </div>

                                    <div class="pform-row">
                                        <div class="pform-label">Net Total (₹):</div>
                                        <div class="pform-value">
                                            <input type="text" name="net_total" id="net_total" class="form-control text-right" readonly>
                                        </div>
                                    </div>

                                    <div class="pform-row">
                                        <div class="pform-label">Amount in Words :</div>
                                        <div class="pform-value">
                                            <input type="text" name="amount_words" id="amount_words" class="form-control text-right" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-save btn-sm float-right">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('css')
<style>
    .sq-item-desc {
        display:none;
    }
</style>
@stop

@section('js')
<script>
let rowCount = 1;

function addRow() {
  rowCount++;
  const table = document.getElementById("invoiceItemsTable").getElementsByTagName("tbody")[0];
  const newRow = document.createElement("tr");

  newRow.innerHTML = `
    <td>${rowCount}</td>
    <td>
      <select name="items[${rowCount - 1}][item_type]" class="form-control">
        <option value="">Select</option>
        <option value="frozen">Frozen</option>
        <option value="chilled">Chilled</option>
        <option value="dry">Dry</option>
      </select>
    </td>
    <td><input type="number" name="items[${rowCount - 1}][qty]" class="form-control text-center" placeholder="0"></td>
    <td><input type="text" name="items[${rowCount - 1}][rate]" class="form-control text-right" placeholder="0.00"></td>
    <td><input type="text" name="items[${rowCount - 1}][tax]" class="form-control text-right" placeholder="0%"></td>
    <td><input type="text" name="items[${rowCount - 1}][total]" class="form-control text-right" readonly></td>
    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">🗑</button></td>
  `;

  table.appendChild(newRow);
}

function removeRow(button) {
  const row = button.closest("tr");
  row.remove();
}
</script>

@endsection
