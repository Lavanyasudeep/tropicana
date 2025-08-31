@extends('adminlte::page')

@section('title', 'Create Journal Entry')

@section('content_header')
    <h1>Journal Entry</h1>
@endsection

@section('content')

<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.accounting.journal.index') }}" class="btn btn-back"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.accounting.journal.store') }}" id="journalForm">
            @csrf
            <div class="row">

                <!-- Left Panel -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:84px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc. #</div>
                            <div class="pform-value">
                                <input type="text" id="doc_no" name="doc_no" value="{{ $docNo ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc. Date<span class="text-danger">*</span></div>
                            <div class="pform-value">
                                <input type="date" id="doc_date" name="doc_date" value="{{ old('doc_date', date('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Middle Panel -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:84px;">
                        <div class="pform-row">
                            <div class="pform-label">Branch <span class="text-danger">*</span></div>
                            <div class="pform-value">
                                <select name="branch_id" id="branch_id" class="select2">
                                    <option value="">- Select -</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Department <span class="text-danger">*</span></div>
                            <div class="pform-value">
                                <select name="department_id" id="department_id" class="select2">
                                    <option value="">- Select -</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:84px;">
                        <div class="pform-row">
                            <div class="pform-label">Recurring</div>
                            <div class="pform-value">
                                <label class="switch">
                                    <input type="checkbox" name="recurring" value="1">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Journal Table -->
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="page-list-panel" >
                        <table class="page-input-table" id="journalCreateTable" >
                            <thead>
                                <tr>
                                    <th style="width:10%;">Ledger</th>
                                    <th style="width:20%;">A/c Code</th>
                                    <th style="width:15%;">Analytical A/c</th>
                                    <th style="width:25%;">Narration</th>
                                    <th style="width:10%; text-align:right;">Debit</th>
                                    <th style="width:10%; text-align:right;">Credit</th>
                                    <th style="width:10%; text-align:right;">A/c Balance</th>
                                    <th style="width:5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="ledger[]" class="form-control">
                                            <option value="GL">GL</option>
                                            <option value="Customer">Customer</option>
                                            <option value="Supplier">Supplier</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="account_code_select2" >
                                            <select name="account_id[]" class="select2 form-control">
                                                <option value="">- Select Ledger -</option>
                                                @foreach($accounts as $v)
                                                    <option value="{{ $v->value }}">{{ $v->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="customer_id_select2" style="display:none;" >
                                            <select name="customer_id[]" class="select2 form-control">
                                                <option value="">- Select Customer -</option>
                                                @foreach($customers as $v)
                                                    <option value="{{ $v->value }}">{{ $v->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="supplier_id_select2" style="display:none;" >
                                            <select name="supplier_id[]" class="select2 form-control">
                                                <option value="">- Select Supplier -</option>
                                                @foreach($suppliers as $v)
                                                    <option value="{{ $v->value }}">{{ $v->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <select name="analytical_code[]" class="form-control">
                                            <option value="">- Select -</option>
                                            @foreach($analytical as $analytic)
                                                <option value="{{ $analytic->analytical_code }}">{{ $analytic->analytical_code }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="narration[]" class="form-control"></td>
                                    <td><input type="number" step="0.01" name="debit[]" class="form-control text-right" value="0"></td>
                                    <td><input type="number" step="0.01" name="credit[]" class="form-control text-right" value="0"></td>
                                    <td><input type="text" name="balance[]" class="form-control text-right" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm removeRow">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="button" id="addRow" class="btn btn-sm btn-add-row mt-3"><i class="fas fa-plus"></i> Add Row</button>

                        <!-- <div class="row">
                            <div class="col-md-2"><br /><br />
                                <div class="amount" >
                                    <label>Amount</label>
                                    <div>
                                        <input type="number" id="totalDebit" class="form-control text-right mb-2" readonly>
                                        <input type="number" id="totalCredit" class="form-control text-right" readonly>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="mt-3">
                            <button type="submit" class="btn btn-save float-right">Save</button>
                            <a href="{{ route('admin.accounting.journal.index') }}" class="btn btn-cancel float-right mr-2">Cancel</a>
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
$(document).ready(function () {
    function recalcTotals() {
        let debitTotal = 0, creditTotal = 0;
        $('input[name="debit[]"]').each(function(){ debitTotal += parseFloat($(this).val()||0); });
        $('input[name="credit[]"]').each(function(){ creditTotal += parseFloat($(this).val()||0); });
        $('#totalDebit').val(debitTotal.toFixed(2));
        $('#totalCredit').val(creditTotal.toFixed(2));
    }

    $(document).on('input', 'input[name="debit[]"], input[name="credit[]"]', function () {
        recalcTotals();
    });

    // Add row
    $('#addRow').on('click', function () {
        let newRow = $('#journalCreateTable tbody tr:first').clone();
        newRow.find('input').val('');
        newRow.find('select').val('');
        $('#journalCreateTable tbody').append(newRow);

        $('#journalCreateTable tr:last select[name="ledger[]"]').val('GL');
        $('#journalCreateTable tr:last select[name="ledger[]"]').trigger('change');
    });

    // Remove row
    $(document).on('click', '.removeRow', function () {
        if ($('#journalCreateTable tbody tr').length > 1) { 
            $(this).closest('tr').remove();
            recalcTotals();
        } else {
            alert('At least one row is required.');
        }
    });

    $(document).on('change', 'select[name="ledger[]"]', function () {
        $(this).closest('tr').find('.account_code_select2').hide();
        $(this).closest('tr').find('.customer_id_select2').hide();
        $(this).closest('tr').find('.supplier_id_select2').hide();

        var v = $(this).val();
        if (v == 'GL') { 
            $(this).closest('tr').find('.account_code_select2').show();
        } else if (v == 'Customer') { 
            $(this).closest('tr').find('.customer_id_select2').show();
        } else if (v == 'Supplier') { 
            $(this).closest('tr').find('.supplier_id_select2').show();
        }
    });

    

    recalcTotals();
});
</script>
@endsection
