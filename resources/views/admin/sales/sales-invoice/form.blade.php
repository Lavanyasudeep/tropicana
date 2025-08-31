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
                <!-- Left Info Panel -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 182px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc. No.</div>
                            <div class="pform-value">
                                <input type="text" name="doc_no" class="form-control" value="{{ old('doc_no', $doc_no) }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc. Date</div>
                            <div class="pform-value">
                                <input type="date" name="doc_date" class="form-control" value="{{ old('doc_date', $doc_date??date('Y-m-d')) }}">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Billing Type</div>
                            <div class="pform-value">
                                <input type="text" name="billing_type" id="billing_type" value="" readonly />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Status</div>
                            <div class="pform-value">
                                <select name="status" id="status">
                                    <option value="created" @selected(old('status', $status) == 'created')>Created</option>
                                    <option value="approved" @selected(old('status', $status) == 'approved')>Approved</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Middle Info Panel -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 182px;">
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
                                <input type="text" name="customer_contact_no" id="customer_contact_no" value="{{ old('contact_no',$customer->phone_number) }}"/>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Credit Limit</div>
                            <div class="pform-value">
                                <input type="text" name="driver_name" id="driver_name" value="" readonly />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Cur. Balance</div>
                            <div class="pform-value">
                                <input type="text" name="driver_name" id="driver_name" value="" readonly />
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">GSTIN</div>
                            <div class="pform-value">
                                <input type="text" name="driver_name" id="driver_name" value="" readonly />
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Right Info Panel -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 182px;" >
                        
                        <div class="pform-row">
                            <div class="pform-label">Vehicle Type</div>
                            <div class="pform-value">
                                <input type="text" name="vehicle_no" id="vehicle_no" value=""/>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Vehicle No.</div>
                            <div class="pform-value">
                                <input type="text" name="vehicle_no" id="vehicle_no" value=""/>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Driver Name</div>
                            <div class="pform-value">
                                <input type="text" name="driver_name" id="driver_name" value=""/>
                            </div>
                        </div>
                        <!-- <div class="pform-row">
                            <div class="pform-label">Billing Address</div>
                            <div class="pform-value">
                                <textarea name="customer_address" id="customer_address" >{{ old('address',$customer->main_address) }}</textarea>
                            </div>
                        </div> -->
                        <div class="pform-row">
                            <div class="pform-label">Delivery Address</div>
                            <div class="pform-value">
                                <textarea name="customer_address" id="customer_address" >{{ old('address',$customer->main_address) }}</textarea>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>
            </div>

            <!-- Product Table -->
             <div class="row" >
                <div class="col-md-12" >
                    <div class="page-list-panel">
                        <table class="page-input-table" id="invoiceItemsTable">
                            <thead>
                                <tr>
                                    <th style="width:5%;" >#</th>
                                    <th style="width:5%;" >Date</th>
                                    <th style="width:5%;" class="text-center" >OP</th>
                                    <th style="width:5%;" class="text-center" >In</th>
                                    <th style="width:5%;" class="text-center" >Out</th>
                                    <th style="width:5%;" class="text-center" >CL</th>
                                    <th style="width:5%;" class="text-center" >OP in UOM</th>
                                    <th style="width:5%;" class="text-center" >In in UOM</th>
                                    <th style="width:5%;" class="text-center" >Out in UOM</th>
                                    <th style="width:5%;" class="text-center" >CL in UOM</th>
                                    <th style="width:5%;" class="text-center" >Chargeable Billing UOM</th>
                                    <th style="width:5%;" class="text-center" >Billed Qty</th>
                                    <th style="width:5%;" class="text-right" >Amount</th>
                                    <th style="width:5%;" class="text-center" >Exceed Qty In UOM</th>
                                    <th style="width:5%;" class="text-right" >Exceed Amount</th>
                                    <th style="width:5%;" class="text-center" ></th>
                                </tr>
                            </thead>
                            <tbody id="invoiceItemRows">
                                <tr data-index="1" >
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        <input type="date" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <input type="number" name="items[index][item_name]" class="form-control text-right" value="" />
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-delete" ><i class="fa fa-trash" ></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <button type="button" class="btn btn-create btn-sm" id="addRowBtn">+ Add Row</button>

                        <div class="row" >
                            <div class="col-md-6" ></div>
                            <div class="col-md-6">
                                <br />
                                <table class="table table-striped page-list-table" border="0" >    
                                    <tbody>
                                        <tr>
                                            <td><span><b>Total Amount</b></span></td>
                                            <td class="text-right">
                                                <input type="text" name="total_amount" id="total_amount" value="{{ old('total_amount', $total_amount) }}" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>CGST</span></td>
                                            <td class="text-right">
                                                <input type="text" name="cgst_amount" id="cgst_amount" value="{{ old('cgst_amount', $cgst_amount) }}" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>SGST</span></td>
                                            <td class="text-right">
                                                <input type="text" name="sgst_amount" id="sgst_amount" value="{{ old('sgst_amount', $sgst_amount) }}" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>IGST</span></td>
                                            <td class="text-right">
                                                <input type="text" name="igst_amount" id="igst_amount" value="{{ old('igst_amount', $igst_amount) }}" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span><b>Grand Amount</b></span></td>
                                            <td class="text-right">
                                                <input type="text" name="grand_amount" id="grand_amount" value="{{ old('grand_amount', $grand_amount) }}" class="text-right" readonly autocomplete="off">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
    let rowIdx = 0;
    const units = @json($units);
    const productTypes = @json($productTypes); // contains price_per_day
    const taxes = @json($taxes);

    $(document).ready(function () {
        $('#addRowBtn').click(() => {
            addRow();
        });

        @if (!isset($invoice))
            addRow(); // Add first row on load if creating
        @endif
        
        // Trigger calculation for prefilled rows
        $('#invoiceItemRows tr').each(function () {
            calculateRow($(this));
        });

        $(document).on('change','#customer_id', function(){
            $('#billing_type').val('Day Wise');
            generateDayWiseData();
        });

        @if (!empty($customer_id))
            $('#customer_id').trigger('change');
        @endif
    });

    function generateDayWiseData() {
        var year = 2025;
        var month = 7;

        let tbody = document.getElementById("invoiceItemRows");
        tbody.innerHTML = ""; // clear old rows

        // Get days in the given month
        let daysInMonth = new Date(year, month + 1, 0).getDate() + 1;

        for (let day = 2; day <= daysInMonth; day++) {
            let tr = document.createElement("tr");
            tr.setAttribute("data-index", day);

            // Serial number
            let tdSerial = document.createElement("td");
            tdSerial.textContent = day-1;
            tr.appendChild(tdSerial);

            // Date input
            let tdDate = document.createElement("td");
            let dateInput = document.createElement("input");
            dateInput.type = "date";
            dateInput.className = "form-control text-right";
            dateInput.name = `items[${day}][date]`;

            let dateObj = new Date(year, month, day);
            dateInput.value = dateObj.toISOString().split("T")[0]; // yyyy-mm-dd → 2025-09-01
            tdDate.appendChild(dateInput);
            tr.appendChild(tdDate);

            // 13 number inputs
            for (let i = 1; i <= 13; i++) {
                let td = document.createElement("td");
                let input = document.createElement("input");
                input.type = "number";
                input.className = "form-control text-right";
                input.name = `items[${day}][col${i}]`;
                td.appendChild(input);
                tr.appendChild(td);
            }

            // Delete button
            let tdAction = document.createElement("td");
            let delBtn = document.createElement("a");
            delBtn.href = "#";
            delBtn.className = "btn btn-delete";
            delBtn.innerHTML = '<i class="fa fa-trash"></i>';
            delBtn.onclick = function(e) {
                e.preventDefault();
                tr.remove();
            };
            tdAction.appendChild(delBtn);
            tr.appendChild(tdAction);

            tbody.appendChild(tr);
        }
    }

    function addRow() {
        
    }

    $(document).on('change', '.unit-select', function () {
        $(this).closest('tr').find('input[name$="[unit_qty]"]').val('1');
        $(this).closest('tr').find('input[name$="[pallet_qty]"]').val('1');
        calculateRow($(this).closest('tr'));
    });

    $(document).on('change', '.type-select, .tax-select', function () {
        calculateRow($(this).closest('tr'));
    });
    
    $(document).on('input', '.calc', function () {
        calculateRow($(this).closest('tr'));
    });

    $(document).on('click', '.delete-row', function () {
        $(this).closest('tr').next().remove();
        $(this).closest('tr').remove();
        calculateTotal();
    });

    $(document).on('click', '.add-item-desc-row', function () {
        if($(this).find('i').hasClass('fa-angle-down')) {
            $(this).closest('tr').next().show();
            $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            $(this).closest('tr').next().hide();
            $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    });

    

    function calculateRow($row) {
        let typeRate = parseFloat($row.find('.type-select option:selected').data('rate')) || 0;
        let unitDays = parseFloat($row.find('.unit-select option:selected').data('days')) || 0;
        let unitQty = parseFloat($row.find('input[name$="[unit_qty]"]').val()) || 0;
        let palletQty = parseFloat($row.find('input[name$="[pallet_qty]"]').val()) || 0;
        let taxPercent = parseFloat($row.find('.tax-select').val()) || 0;

        let rate = typeRate * unitDays * unitQty;
        let value = rate * palletQty;
        let taxValue = (value * taxPercent) / 100;
        let netValue = value + taxValue;

        $row.find('input[name$="[rate]"]').val(rate.toFixed(2));
        $row.find('input[name$="[value]"]').val(value.toFixed(2));
        $row.find('input[name$="[tax_value]"]').val(taxValue.toFixed(2));
        $row.find('input[name$="[net_value]"]').val(netValue.toFixed(2));

        calculateTotal();
    }

    function calculateTotal() {
        let totalRate = 0, totalPallet = 0, totalValue = 0, totalTax = 0, totalNet = 0;

        $('#invoiceItemRows tr').each(function () {
            totalRate += parseFloat($(this).find('input[name$="[rate]"]').val()) || 0;
            totalPallet += parseFloat($(this).find('input[name$="[pallet_qty]"]').val()) || 0;
            totalValue += parseFloat($(this).find('input[name$="[value]"]').val()) || 0;
            totalTax += parseFloat($(this).find('input[name$="[tax_value]"]').val()) || 0;
            totalNet += parseFloat($(this).find('input[name$="[net_value]"]').val()) || 0;
        });

        $('#total_rate').text(totalRate.toFixed(2));
        $('#total_pallet').text(totalPallet.toFixed(2));
        $('#total_value').text(totalValue.toFixed(2));
        $('#total_tax').text(totalTax.toFixed(2));
        $('#total_net').text(totalNet.toFixed(2));

        // Assuming CGST and SGST split tax, adjust logic as per your rules
        $('#cgst_amount').val((totalTax / 2).toFixed(2));
        $('#sgst_amount').val((totalTax / 2).toFixed(2));
        $('#igst_amount').val('0.00'); // Or calculate based on customer state
        $('#total_amount').val(totalValue.toFixed(2));
        $('#grand_amount').val(totalNet.toFixed(2));
    }

    // Initial trigger on page load
    $(document).ready(function () {

        $(document).on('change', '#customer_id', function () {
            customerId = $(this).val();

            $('#customer_name').prop('readonly', true);
            $('#customer_contact_no').prop('readonly', true);
            $('#customer_address').prop('readonly', true);

            if(customerId!='') {
                $.post("/admin/master/sales/customer/get-customer-details", {
                    customer_id: customerId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(response) {
                    data = response.customer;

                    $("#customer_name").val(data.customer_name??'');
                    $("#customer_contact_no").val(data.phone_number??'');
                    $("#customer_address").text(data.main_address??'');
                }).fail(function(xhr) {
                    toastr.error(xhr.responseJSON?.message || "Failed to load custoemr details.");
                });
            }
            
        });
    });
</script>
@endsection
