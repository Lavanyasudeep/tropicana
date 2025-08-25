@extends('adminlte::page')

@section('title', 'Create Journal Entry')

@section('content_header')
    <h1>Journal Entry</h1>
@endsection

@section('content')

<div class="page-sub-header">
    <h3>Create</h3>
    <div class="action-btns">
        <a href="{{ route('admin.accounting.journal.index') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.accounting.journal.store') }}" id="journalForm">
            @csrf
            <div class="row">

                <!-- Left Panel -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:165px;">
                        <div class="pform-row">
                            <div class="pform-label">Document #</div>
                            <div class="pform-value">
                                <input type="text" id="doc_no" name="doc_no" value="{{ $docNo ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Date <span class="text-danger">*</span></div>
                            <div class="pform-value">
                                <input type="date" id="doc_date" name="doc_date" value="{{ old('doc_date', date('Y-m-d')) }}">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Trip STMT #</div>
                            <div class="pform-value">
                                <input type="text" id="trip_stmt_no" name="trip_stmt_no" value="{{ old('trip_stmt_no') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Middle Panel -->
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:165px;">
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
                    <div class="pform-panel" style="min-height:165px;">
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
            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="page-list-table" id="journalCreateTable">
                        <thead>
                            <tr>
                                <th style="width:10%;">Ledger</th>
                                <th style="width:20%;">A/c Code</th>
                                <th style="width:15%;">Analytical A/c</th>
                                <th style="width:25%;">Narration</th>
                                <th style="width:10%; text-align:right;">Debit</th>
                                <th style="width:10%; text-align:right;">Credit</th>
                                <th style="width:10%; text-align:right;">A/c Balance</th>
                                <th style="width:5%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="ledger[]" class="form-control">
                                        <option value="GL">GL</option>
                                        <option value="SL">SL</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="account_code[]" class="select2 form-control">
                                        <option value="">- Select -</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->value }}">{{ $account->label }}</option>
                                        @endforeach
                                    </select>
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
                    <button type="button" id="addRow" class="btn btn-sm btn-primary mt-2">Add Row</button>

                    <div class="row">
                        <div class="col-md-2"><br /><br />
                             <div class="amount" >
                                <label>Amount</label>
                                <div>
                                    <input type="number" id="totalDebit" class="form-control text-right mb-2" readonly>
                                    <input type="number" id="totalCredit" class="form-control text-right" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-save float-right">Save</button>
                        <a href="{{ route('admin.accounting.journal.index') }}" class="btn btn-secondary float-right mr-2">Cancel</a>
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

    recalcTotals();
});
</script>
@endsection
