@extends('adminlte::page')

@section('title', 'Create Payment Voucher')

@section('content_header')
    <h1>Payment Voucher</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>Create</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.accounting.payment.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="{{ route('admin.accounting.payment.store') }}" id="outwardForm">
            @csrf
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height:165px;">
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. #</div>
                            <div class="pform-value" >
                                <input type="text" id="doc_no" value="" readonly>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. Date</div>
                            <div class="pform-value" >
                                <input type="date" id="doc_date" name="doc_date" value="{{ old('doc_date', date('Y-m-d')) }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Requested By</div>
                            <div class="pform-value" >
                                <input type="text" id="requested_by" name="requested_by" value="{{ old('requested_by') }}" />
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Status</div>
                            <div class="pform-value" >
                                <select name="status" id="status">
                                    <option value="created" @selected(old('status') == 'created')>Created</option>
                                    <option value="approved" @selected(old('status') == 'approved')>Approved</option>
                                    <option value="paid" @selected(old('status') == 'paid')>Paid</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height:165px;">
                        <div class="pform-row" >
                            <div class="pform-label" >Voucher Type</div>
                            <div class="pform-value" >
                                <select name="voucher_type" id="voucher_type">
                                    <option value="">- Select -</option>
                                    @foreach($voucherTypes as $type)
                                        <option value="{{ $type->value }}"
                                                @selected(old('voucher_type') == $type->value)>
                                            {{ $type->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Transaction Type</div>
                            <div class="pform-value" >
                                <select name="transaction_type" id="transaction_type" >
                                    <option value="">- Select -</option>
                                    @foreach($tranTypes as $tranType)
                                        <option value="{{ $tranType->transaction_type }}" 
                                            @selected(old('transaction_type') == $tranType->transaction_type) >
                                        {{ ucwords(strtolower($tranType->transaction_type)) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" ><span id="ref_label">Cheque/Ref</span> No.</div>
                            <div class="pform-value" >
                                <input type="text" id="ref_no" name="ref_no" value="{{ old('ref_no') }}">
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" ><span id="ref_date">Cheque/Transfer/Ref</span> Date</div>
                            <div class="pform-value" >
                                <input type="date" id="ref_date" name="ref_date" value="{{ old('ref_date', date('Y-m-d')) }}" />
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height: 165px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Payee</div>
                            <div class="pform-value" >
                                <select name="supplier_id" id="supplier_id" class="select2">
                                    <option value="">- Select -</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_id }}" 
                                                @selected(old('supplier_id') == $supplier->supplier_id) >
                                            {{ $supplier->supplier_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact No.</div>
                            <div class="pform-value" >
                                <span id="grn_no" ><input type="text" id="supplier_contact_no" value="" readonly></span>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Advance</div>
                            <div class="pform-value" >
                                <select name="is_advance" id="is_advance">
                                    <option value="0" @selected(old('is_advance', 'no') == 'no')>No</option>
                                    <option value="1" @selected(old('is_advance') == 'yes')>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Purpose</div>
                            <div class="pform-value" >
                                <select name="purpose_id" id="purpose_id" class="select2" >
                                    <option value="">- Select -</option>
                                    @foreach($purposes as $purpose)
                                        <option value="{{ $purpose->purpose_id }}">{{ $purpose->purpose_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-md-12" >

                    <div class="page-list-panel" >
                        <table class="page-list-table" id="paymentCreateTable" >
                            <thead>
                                <tr>
                                    <th style="width:10%;" >Label</th>
                                    <th style="width:20%;" >Ledger A/c</th>
                                    <th style="width:10%;" class="bank-column" >Bank</th>
                                    <th style="width:10%; text-align:right;" >A/c Balance</th>
                                    <th style="width:10%;" class="analytical-column" >Analytical A/c</th>
                                    <th style="width:20%;" >Narration</th>
                                    <th style="width:10%; text-align:right;" >Debit</th>
                                    <th style="width:10%; text-align:right;" >Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="dr_account">
                                    <td><b><span id="dr_account_label" >Expense</span> A/c</b></td>

                                    <!-- Transfer A/c To -->
                                    <td>
                                        <select name="to_account_code[]" id="to_account_code" class="select2" >
                                            <option value="">- Select -</option>
                                            @foreach($accountTo as $account)
                                                <option value="{{ $account->value }}">{{ $account->label }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <!-- Dr. Bank A/c -->
                                    <td class="bank-column">
                                        <input type="text" name="supplier_bank[]" />
                                    </td>

                                    <!-- balance -->
                                    <td>
                                        <input type="number" step="0.01" name="balance[]" class="text-right" readonly />
                                    </td>

                                    <!-- Analytical A/c -->
                                    <td class="analytical-column">
                                        <select name="analytical_code[]" >
                                            <option value="">- Select -</option>
                                            @foreach($analytical as $analytic)
                                                <option value="{{ $analytic->analytical_code }}">{{ $analytic->analytical_code }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <!-- Narration -->
                                    <td>
                                        <input type="text" name="narration[]" />
                                    </td>

                                    <!-- Debit -->
                                    <td>
                                        <input type="number" step="0.01" name="debit[]" class="text-right" value="0" />
                                    </td>

                                    <!-- Credit -->
                                    <td>
                                        <input type="number" step="0.01" name="credit[]" class="text-right" value="0" />
                                    </td>
                                </tr>
                                <tr class="cr_account">
                                    <td><b><span id="cr_account_label" >Cash/Bank</span> A/c</b></td>

                                    <!-- Transfer A/c From -->
                                    <td>
                                        <select name="from_account_code[]" id="from_account_code" >
                                            <option value="">- Select -</option>
                                            @foreach($accountFrom as $account)
                                                <option value="{{ $account->value }}">{{ $account->label }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <!-- Cr. Bank A/c -->
                                    <td class="bank-column">
                                        <select name="bank_master_id[]" >
                                            <option value="">- Select -</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->bank_master_id }}">{{ $bank->bank_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <!-- balance -->
                                    <td>
                                        <input type="number" step="0.01" name="balance[]" class="text-right" readonly />
                                    </td>

                                    <!-- Analytical A/c -->
                                    <td class="analytical-column">
                                        <select name="analytical_code[]" >
                                            <option value="">- Select -</option>
                                            @foreach($analytical as $analytic)
                                                <option value="{{ $analytic->analytical_code }}">{{ $analytic->analytical_code }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <!-- Narration -->
                                    <td>
                                        <input type="text" name="narration[]" readonly/>
                                    </td>

                                    <!-- Debit -->
                                    <td>
                                        <input type="number" step="0.01" name="debit[]" class="text-right" value="0"  readonly/>
                                    </td>

                                    <!-- Credit -->
                                    <td>
                                        <input type="number" step="0.01" name="credit[]" class="text-right" value="0" readonly/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row" >
                            <div class="col-md-10" ><br /><br />
                                <div class="remarks" >
                                    <label>Remarks</label>
                                    <div>
                                        <textarea style="height:100px; width:100%; border:1px solid #CCC;" name="remarks" id="remarks" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" ><br /><br />
                                <div class="remarks" >
                                    <label>Amount</label>
                                    <div>
                                        <input type="number" class="form-control text-right" name="requested_amount" id="requested_amount" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-12" >
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-save float-right">Save</button>
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
</style>
@stop

@section('js')
<script>

$(document).ready(function () {
    function getLedgerAccountByAccountLabel()
    {
        const advance = $('#is_advance').val();
        const tranType = $('#transaction_type').val();
        const purposeId = $('#purpose_id').val();

        $.ajax({
            url: "/admin/accounting/payment/get-ledger-account-by-account-label",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'advance': advance,
                'tranType': tranType,
                'purposeId': purposeId
            },
            success: function (response) {
                let $from_account_html = `<option value="">- Select -</option>`;
                response.fromAccount.forEach(account => {
                    $from_account_html += `<option value="${ account.value }" selected>${ account.label }</option>`;
                });

                let $to_account_html = `<option value="">- Select -</option>`;
                response.toAccount.forEach(account => {
                    $to_account_html += `<option value="${ account.value }">${ account.label }</option>`;
                });

                // Update ALL select boxes with name from_account_code[] and to_account_code[]
                $('select[name="from_account_code[]"]').html($from_account_html);
                $('select[name="to_account_code[]"]').html($to_account_html);

                $('#from_account_code').trigger('change');
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || "Error in getting ledger Account");
            }
        });
    }

    // Column toggle logic
    function toggleColumn() {
        const tranType = $('#transaction_type').val();
        const supplierId = $('#supplier_id').val();
       
        if(tranType != 'cash' && tranType != '') {
            $('.bank-column').show();
            $('#cr_account_label').text('Bank');
        } else {
            $('.bank-column').hide();
            $('#cr_account_label').text('Cash');
        }

        if(supplierId == 1) {
            $('.analytical-column').show();
        } else {
            $('.analytical-column').hide();
        }
    }

    $(document).on('change', '#voucher_type', function () {
        const type = $(this).val();

        if(type === 'petty_cash') {
            $('#transaction_type').val('cash');
            $('#transaction_type').trigger('change');
            $('#supplier_id').val(1);
            $('#supplier_id').trigger('change');
            $('#ref_no').attr('readonly', true);
            $('#ref_date').attr('readonly', true);
        } else {
            $('#supplier_id').val('').trigger('change');
        }
    });

    $(document).on('change', '#is_advance', function () {
        const isAdvance = $(this).val();

        if(isAdvance) {
            $('#dr_account_label').text('Advance');
        } else {
            $('#dr_account_label').text('Expense');
        }

        //getLedgerAccountByAccountLabel();
        if(isAdvance) {
            $.post("/admin/accounting/payment/get-payment-purpose", {
                is_advance: isAdvance,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function(response) {
                let purposeData = response.purpose;

                let purposeHtml = `<option value="">- Select -</option>`;
                $.each(purposeData, function (index, purpose) {
                    purposeHtml += `<option value="${purpose.purpose_id}">
                                        ${purpose.purpose_name}
                                    </option>`;
                });

                $('#purpose_id').html(purposeHtml);
            }).fail(function(xhr) {
                toastr.error(xhr.responseJSON?.message || "Failed to load payment purpose data.");
            });
        }
    });

    $(document).on('change', '#supplier_id', function () {
        supplierId = $(this).val();

        if(supplierId != 1) {
            $('#analytical_code').val('');
        }

        toggleColumn();

        if(supplierId!='') {
            $.post("/admin/master/purchase/supplier/get-supplier-details", {
                supplier_id: supplierId,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function(response) {
                data = response.supplier;

                $("#supplier_contact_no").val(data.mobile??'');
            }).fail(function(xhr) {
                toastr.error(xhr.responseJSON?.message || "Failed to load supplier details.");
            });
        }
        
    });

    $(document).on('change', '#purpose_id', function () {
        getLedgerAccountByAccountLabel();
    });

    // On change
    $(document).on('change', '#transaction_type', function () {
        const tranType = $(this).val();

        toggleColumn();

        const labels = {
            'cheque': { refLabel: 'Cheque', refDate: 'Cheque' },
            'transfer': { refLabel: 'Ref', refDate: 'Transfer' }
        };

        const fallback = { refLabel: 'Ref', refDate: 'Ref' };
        const selected = labels[tranType] || fallback;

        $('#ref_label').text(selected.refLabel);
        $('#ref_date').text(selected.refDate);

        if(tranType === 'cash') {
            $('supplier_bank').val('');
            $('#bank_master_id').val('');
        } 

        getLedgerAccountByAccountLabel();
    });

    $(document).on('change', '#to_account_code, #from_account_code', function () {
        var tr = $(this).closest('tr');
        const accountCode = $(this).val();

        $.ajax({
            url: "/admin/accounting/payment/get-ledger-account-balance",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'accountCode': accountCode
            },
            success: function (response) {
                tr.find('input[name="balance[]"]').val(response.account_balance);
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || "Error in getting Ledger Account Balance");
            }
        });
    });

    // On page load
    toggleColumn();
    $('#is_advance').trigger('change');

    $(document).on('input', '.dr_account input[name="debit[]"]', function () {
        const value = $(this).val();

        $('#requested_amount').val(value);
        $('.cr_account input[name="credit[]"]').val(value);
    });

});
</script>
@stop