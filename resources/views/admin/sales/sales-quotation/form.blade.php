@extends('adminlte::page')

@section('title', 'Sales Quotation')

@section('content_header')
    <h1>Sales Quotation</h1>
@endsection

@section('content')

@php

if(isset($quotation)) {
    $page_title = 'Edit';
    $action = route('admin.sales.sales-quotation.update', $quotation->sq_id);
    $method = 'PUT';

    $doc_no = $quotation->doc_no;
    $doc_date = $quotation->doc_date;
    $status = $quotation->status;
    $customer_id = $quotation->customer_id;
    $service_type = $quotation->service_type;
    $remarks = $quotation->remarks;
    $service_type = explode(',', $quotation->service_type);
    $remarks = $quotation->remarks;
    $total_amount = $quotation->total_amount;
    $cgst_amount = $quotation->cgst_amount;
    $sgst_amount = $quotation->sgst_amount;
    $igst_amount = $quotation->igst_amount;
    $grand_amount = $quotation->grand_amount;
} else {
    $page_title = 'Create';
    $action = route('admin.sales.sales-quotation.store');
    $method = 'POST';

    $doc_no = '';
    $doc_date = date('Y-m-d');
    $status = 'created';
    $customer_id = '';
    $service_type = '';
    $remarks = '';
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
    <h3>{{ $page_title }}</h3>
    <div class="action-btns">
        <a href="{{ route('admin.sales.sales-quotation.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
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
                    <div class="pform-panel" style="min-height: 174px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc. No</div>
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
                    <div class="pform-panel" style="min-height: 174px;">
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
                            <div class="pform-label">Customer Name</div>
                            <div class="pform-value">
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name',$customer->customer_name) }}" >
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Contact No.</div>
                            <div class="pform-value">
                                <input type="text" name="customer_contact_no" id="customer_contact_no" value="{{ old('contact_no',$customer->phone_number) }}"/>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Address</div>
                            <div class="pform-value">
                                <textarea name="customer_address" id="customer_address" >{{ old('address',$customer->main_address) }}</textarea>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Right Info Panel -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height: 174px;" >
                        <div class="pform-row">
                            <div class="pform-label w100p">Notes/Remarks</div>
                            <div class="pform-value w100p">
                                <textarea name="remarks" style="height:120px !important;" >{{ old('remarks', $remarks) }}</textarea>
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
                        <table class="page-input-table" id="quotationItemsTable">
                            <thead>
                                <tr>
                                    <th style="width:10%;" >Type of Item</th>
                                    <th style="width:20%;" >Description</th>
                                    <th style="width:10%;" >Unit</th>
                                    <th style="width:8%;" class="text-right" >Unit Qty</th>
                                    <th style="width:8%;" class="text-right" >Rate</th>
                                    <th style="width:5%;" class="text-right" >Qty</th>
                                    <th style="width:8%;" class="text-right" >Value</th>
                                    <th style="width:8%;" class="text-right" >Tax %</th>
                                    <th style="width:8%;" class="text-right" >Tax Value</th>
                                    <th style="width:8%;" class="text-right" >Net Value</th>
                                    <th style="width:8%;" class="text-right" ></th>
                                </tr>
                            </thead>
                            <tbody id="quotationItemRows">
                                <!-- rows will be appended here -->
                                 @if(isset($quotation) && $quotation->quotationDetails)
                                    @foreach($quotation->quotationDetails as $idx => $item)
                                        <tr data-index="{{ $idx }}">
                                            <td>
                                                <select name="items[{{ $idx }}][type]" class="form-control select2 type-select">
                                                    <option value="">- Select -</option>
                                                    @foreach ($productTypes as $type)
                                                        <option value="{{ $type->product_type_id }}"
                                                            data-type-name="{{ $type->type_name }}"
                                                            data-rate="{{ $type->rate_per_day }}"
                                                            {{ $item->product_type_id == $type->product_type_id ? 'selected' : '' }}>
                                                            {{ $type->type_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="items[{{ $idx }}][sales_item_id]" class="form-control select2 sales_item_id-select">
                                                    <option value="">- Select -</option>
                                                    @foreach ($salesItems as $product)
                                                        <option value="{{ $product->sales_item_id }}" {{ $item->sales_item_id == $product->sales_item_id ? 'selected' : '' }}>
                                                            {{ $product->sales_item_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="items[{{ $idx }}][unit]" class="form-control select2 unit-select">
                                                    <option value="">- Select -</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->unit_id }}" data-days="{{ $unit->conversion_quantity }}" {{ $item->unit_id == $unit->unit_id ? 'selected' : '' }}>
                                                            {{ $unit->unit }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $idx }}][unit_qty]" class="form-control text-right" value="{{ $item->unit_qty }}">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $idx }}][rate]" class="form-control text-right" value="{{ $item->rate }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $idx }}][pallet_qty]" class="form-control text-right" value="{{ $item->pallet_qty }}">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $idx }}][value]" class="form-control text-right" value="{{ $item->value }}" readonly>
                                            </td>
                                            <td>
                                                <select name="items[{{ $idx }}][tax_percent]" class="form-control select2 tax-select">
                                                    <option value="">- Select -</option>
                                                    @foreach ($taxes as $tax)
                                                        <option value="{{ $tax->tax_per }}" {{ $item->tax_per == $tax->tax_per ? 'selected' : '' }}>
                                                            {{ $tax->tax_per }}%
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $idx }}][tax_value]" class="form-control text-right" value="{{ $item->tax_value }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $idx }}][net_value]" class="form-control text-right" value="{{ $item->net_value }}" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-delete btn-sm delete-row"><i class="fas fa-trash"></i></button>
                                                <button type="button" class="btn btn-arrow btn-sm add-item-desc-row"><i class="fas fa-angle-down"></i></button>
                                            </td>
                                        </tr>
                                        <tr data-index="{{ $idx }}" class="sq-item-desc" >
                                            <td colspan="10" >
                                                <textarea name="items[{{ $idx }}][description]" class="form-control" >{{ $item->description }}</textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <!-- <tfoot>
                                <tr class="total-row">
                                    <th colspan="4" class="text-right">Total</th>
                                    <th id="total_rate" class="text-right"></th>
                                    <th id="total_pallet" class="text-right"></th>
                                    <th id="total_value" class="text-right"></th>
                                    <th></th>
                                    <th id="total_tax" class="text-right"></th>
                                    <th id="total_net" class="text-right"></th>
                                </tr>
                            </tfoot> -->
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

        @if (!isset($quotation))
            addRow(); // Add first row on load if creating
        @endif
        
        // Trigger calculation for prefilled rows
        $('#quotationItemRows tr').each(function () {
            calculateRow($(this));
        });

        @if (!empty($customer_id))
           // $('#customer_id').trigger('change');
        @endif
    });

    function addRow() {
        let row = `
        <tr data-index="${rowIdx}" >
            <td>
                <select name="items[${rowIdx}][type]" class="form-control select2 type-select">
                    <option value="">- Select -</option>
                    ${productTypes.map(t => `<option value="${t.product_type_id}" data-type-name="${t.type_name}" data-rate="${t.rate_per_day}" >${t.type_name}</option>`).join('')}
                </select>
            </td>
            <td>
                <select name="items[${rowIdx}][sales_item_id]" class="form-control select2">
                    <option value="">- Select -</option>
                    @foreach ($salesItems as $product)
                        <option value="{{ $product->sales_item_id }}">{{ $product->sales_item_name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="items[${rowIdx}][unit]" class="form-control select2 unit-select">
                    <option value="">- Select -</option>
                    ${units.map(u => `<option value="${u.unit_id}" data-days="${u.conversion_quantity}">${u.unit}</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="items[${rowIdx}][unit_qty]" class="form-control calc select-val" value="0" min="0"></td>
            <td><input type="number" name="items[${rowIdx}][rate]" class="form-control calc" readonly></td>
            <td><input type="number" name="items[${rowIdx}][pallet_qty]" class="form-control calc select-val" value="0" min="0"></td>
            <td><input type="number" name="items[${rowIdx}][value]" class="form-control text-right" readonly></td>
            <td>
                <select name="items[${rowIdx}][tax_percent]" class="form-control tax-select">
                    <option value="">- Select -</option>
                    ${taxes.map(t => `<option value="${t.tax_per}">${t.tax_per} %</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="items[${rowIdx}][tax_value]" class="form-control text-right" readonly></td>
            <td><input type="number" name="items[${rowIdx}][net_value]" class="form-control text-right" readonly></td>
            <td>
                <button type="button" class="btn btn-delete btn-sm delete-row"><i class="fas fa-trash"></i></button>
                <button type="button" class="btn btn-arrow btn-sm add-item-desc-row"><i class="fas fa-angle-down"></i></button>
            </td>
        </tr>`;
        
        row += `
        <tr data-index="${rowIdx}" class="sq-item-desc" >
            <td colspan="10" >
                <textarea name="items[${rowIdx}][description]" class="form-control "></textarea>
            </td>
        </tr>`;
        $('#quotationItemRows').append(row);
        $('.select2').select2();
        rowIdx++;
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

        $('#quotationItemRows tr').each(function () {
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
