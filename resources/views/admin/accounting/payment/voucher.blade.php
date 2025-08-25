
<!-- Toggle between Views -->
<div class="voucher-fixed-panel">

    <form id="paymentVoucherForm" method="POST" action="{{ route('admin.accounting.payment.store') }}">
        @csrf

        <div class="row">

            <!-- Left Column -->
            <div class="col-md-6">
                <div class="row">
                    <!-- <div class="col-md-4 voucher-form-group">    
                        <label class="voucher-label">Opening Balance</label><br>
                        <div class="voucher-balance">$1,000.00</div>
                    </div> -->
                    <div class="col-md-4 voucher-form-group" >
                        <label class="voucher-label">Doc. No.</label>
                        <input type="text" class="form-control" value="" readonly>
                    </div>
                    <div class="col-md-4 voucher-form-group" >
                        <label class="voucher-label">Doc. Date</label>
                        <input type="date" class="form-control" name="doc_date" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="col-md-4 voucher-form-group">
                        <label class="voucher-label">Voucher Type</label>
                        <select name="voucher_type" id="voucher_type" class="form-control">
                            <option value="petty_cash">Petty Cash</option>
                            <option value="supplier">Supplier</option>
                            <option value="contra">Contra</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 voucher-form-group">
                        <label class="voucher-label">
                            Supplier
                            <div class="voucher-sup-bal" >Balance : <i class="fas fa-rupee-sign" ></i> 12,33,434.00</div>
                        </label>
                        <select class="form-control" name="supplier_id" id="supplier_id" >
                            <option value="">- Select -</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 voucher-form-group">
                        <label class="voucher-label">
                            Analytical
                            <div class="voucher-sup-bal" >Balance : <i class="fas fa-rupee-sign" ></i> 12,33,434.00</div>
                        </label>
                        <select class="form-control" name="analytical_code" id="analytical_code" >
                            <option value="">- Select -</option>
                            @foreach($analytical as $analytic)
                                <option value="{{ $analytic->analytical_code }}">{{ $analytic->analytical_code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 voucher-form-group">
                        <label class="voucher-label">Paid To</label>
                        <input type="text" class="form-control" name="ledger_balance" />
                    </div>
                    <div class="col-md-8 voucher-form-group">
                        <label class="voucher-label">Remarks</label>
                        <textarea class="form-control" name="remarks"  id="remarks" ></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 voucher-form-group">
                        <label class="voucher-label">Amount</label>
                        <input type="number" class="form-control" name="requested_amount" id="requested_amount">
                    </div>
                    <div class="col-md-6 voucher-form-group">
                        <label class="voucher-label">&nbsp;</label>
                        <button type="submit" class="form-control btn btn-success">Save</button>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-2 voucher-form-group">
                        <label class="voucher-label">Type</label>
                        <select name="payment_mode_id" id="payment_mode_id" class="form-control">
                            <option value="">- Select -</option>
                            @foreach($transactionTypes as $tranType)
                                <option value="{{ $tranType->transaction_type }}">{{ $tranType->transaction_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 voucher-form-group">
                        <label class="voucher-label">A/c From</label>
                        <select name="from_account_code" id="from_account_code" class="form-control">
                            <option value="">- Select -</option>
                            @foreach($accountFrom as $account)
                                <option value="{{ $account->value }}">{{ $account->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 voucher-form-group">
                        <label class="voucher-label">A/c To</label>
                        <select name="to_account_code" id="to_account_code" class="form-control">
                            <option value="">- Select -</option>
                            @foreach($accountTo as $account)
                                <option value="{{ $account->value }}">{{ $account->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 voucher-form-group">
                        <label class="voucher-label">Our Bank</label>
                        <select name="bank_master_id" id="bank_master_id" class="form-control">
                            <option value="">- Select -</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->bank_master_id }}">{{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 voucher-form-group">
                        <label class="voucher-label">Supplier Bank</label>
                        <input type="text" class="form-control" name="supplier_bank" id="supplier_bank" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 voucher-form-group">
                        <label class="voucher-label">Transfer/Cheque No.</label>
                        <input type="text" class="form-control" name="reference_no" id="reference_no">
                    </div>
                    <div class="col-md-6 voucher-form-group">
                        <label class="voucher-label">Paid/Transfer/Cheque Date</label>
                        <input type="date" class="form-control" name="paid_date" value="{{ date('Y-m-d') }}" />
                    </div>
                </div>
            </div>
        </div>

        <div class="voucher-opening-balance">
            <div class="voucher-balance"><i class="fas fa-rupee-sign" ></i> 500.00 Dr.</div>
            <label class="voucher-label">Opening Balance</label>
        </div>
        
        <div class="voucher-closing-balance">
            <div class="voucher-balance"><i class="fas fa-rupee-sign" ></i> 500.00 Dr.</div>
            <label class="voucher-label">Closing Balance</label>
        </div>
    </form>
</div>

@section('css')
<style>
    .voucher-fixed-panel {
        position: fixed;
        bottom: 0;
        left: 250px; /* matches AdminLTE sidebar */
        right: 0;
        background-color: #232e23;
        border-top: 2px solid #093e4f;
        padding: 15px 30px;
        z-index: 1050;
        box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.08);
    }

    .voucher-fixed-panel input[type="text"],
    .voucher-fixed-panel input[type="date"],
    .voucher-fixed-panel select,
    .voucher-fixed-panel textarea {
        padding: 4px 7px !important;
        height: auto !important;
        font-size: 14px;
        border:0px solid #FFF !important;
        border-radius: 2px;
    }

    .voucher-label {
        font-weight: normal !important;
        margin-bottom:0px;
        font-size:14px;
        color:#FFF;
    }

    .voucher-form-group {
        margin-bottom: 5px;
    }

    .voucher-sup-bal {
        color:#fff404;
        font-size:12px;
        position: absolute;
        right:10px;
        top:5px;
    }
    
    .voucher-sup-bal i {
        font-size:10px;
    }

    .voucher-opening-balance {
        background-color:#bad5ba;
        color: #000;
        font-size:16px;
        display: inline-block;
        text-align: center;
        position:absolute;
        right:0;
        top:-38px;
    }

    .voucher-opening-balance .voucher-label {
        color: #000;
        padding: 6px 12px;
        font-weight: bold;
        display: inline-block;
        text-align: center;
        float:right;
    }
    
    .voucher-opening-balance .voucher-balance {
        background-color:red;
        color: #FFF;
        padding: 6px 12px;
        font-weight: bold;
        display: inline-block;
        text-align: center;
        float:right;
    }

    .voucher-opening-balance i {
        font-size:13px;
    }
    
    .voucher-closing-balance {
        background-color:#bad5ba;
        color: #000;
        font-size:16px;
        display: inline-block;
        text-align: center;
        position:absolute;
        right:0;
        bottom:0;
    }

    .voucher-closing-balance .voucher-label {
        color: #000;
        padding: 6px 12px;
        font-weight: bold;
        display: inline-block;
        text-align: center;
        float:right;
    }
    
    .voucher-closing-balance .voucher-balance {
        background-color:green;
        color: #FFF;
        padding: 6px 12px;
        font-weight: bold;
        display: inline-block;
        text-align: center;
        float:right;
    }

    .voucher-closing-balance i {
        font-size:13px;
    }

    .voucher-red-label {
        color: red;
        font-weight: bold;
    }

    #requested_amount {
        padding: 7px !important;
    }
</style>
@stop
