@extends('adminlte::page')

@section('title', 'View Receipt Voucher')

@section('content_header')
    <h1>Receipt Voucher</h1>
@endsection

@section('content')

@if($receipt->is_advance)
    @include('admin.accounting.receipt.settlement-modal')
@endif

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.accounting.receipt.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status" >
        <label>Change Status</label>
       
        <select id="change_status_select" >
            <option value="created" >Created</option>
            <option value="requested" >Requested</option>
            @if(!in_array('approved', $receipt->statusUpdates->pluck('column_value')->toArray()))
                <option value="approved">Approved</option>
            @endif

            @if(!in_array('settled', $receipt->statusUpdates->pluck('column_value')->toArray()))
                <option value="settled">Settled</option>
            @endif

            @if(!in_array('rejected', $receipt->statusUpdates->pluck('column_value')->toArray()))
                <option value="rejected">Rejected</option>
            @endif

            @if(!in_array('paid', $receipt->statusUpdates->pluck('column_value')->toArray()))
                <option value="paid">Paid</option>
            @endif

            @if(!in_array('cancelled', $receipt->statusUpdates->pluck('column_value')->toArray()))
                <option value="cancelled">Cancelled</option>
            @endif
        </select>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="receiptTabs" >
  <li class="nav-item">
    <a class="nav-link active" id="receipt-tab" data-toggle="tab" href="#receipt" role="tab">Receipt</a>
  </li>
  @if($receipt->is_advance)
    <li class="nav-item">
        <a class="nav-link" id="settlement-tab" data-toggle="tab" href="#settlement" role="tab">Settlement</a>
    </li>
  @endif
  <li class="nav-item">
    <a class="nav-link" id="receipt-attachment-tab" data-toggle="tab" href="#receiptAttachment" role="tab">Attachment</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="receipt-status-tab" data-toggle="tab" href="#receiptStatus" role="tab">Status</a>
  </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="receipt" role="tabpanel">
        <div class="card page-form" >
            <div class="card-body">
                <div class="row" >
                    <!-- Panel 1 -->
                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. #</div>
                                <div class="pform-value" >{{ $receipt->doc_no }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. Date</div>
                                <div class="pform-value" >{{ $receipt->doc_date }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Requested By</div>
                                <div class="pform-value" >{{ $receipt->requestedBy?->name??'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Status</div>
                                <div class="pform-value" >{{ $receipt->status }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>

                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Voucher Type</div>
                                <div class="pform-value" >{{ $receipt->voucher_type_label }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Transaction Type</div>
                                <div class="pform-value" >{{ optional($receipt->transactionType)->transaction_type? ucfirst($receipt->transactionType->transaction_type) : '' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" ><span id="ref_label">Cheque/Ref</span> No.</div>
                                <div class="pform-value" >{{ $receipt->ref_no??'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" ><span id="ref_date">Cheque/Transfer/Ref</span> Date</div>
                                <div class="pform-value" >{{ $receipt->ref_date??'Nil' }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>

                    <!-- Panel 2 -->
                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Payee</div>
                                <div class="pform-value" >{{ $receipt->payee?->customer_name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Contact No.</div>
                                <div class="pform-value" >{{ $receipt->payee?->Mobile?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Purpose</div>
                                <div class="pform-value" >{{ $receipt->purpose?->purpose_name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Advance</div>
                                <div class="pform-value" >{{ $receipt->is_advance?'Yes' : 'No' }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Requested By</div>
                                <div class="pform-value" >{{ $receipt->requestedBy?->name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Requested Date</div>
                                <div class="pform-value" >{{ $receipt->requested_date?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Requested Amount</div>
                                <div class="pform-value" >{{ $receipt->requested_amount?? 'Nil' }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                    
                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Approved By</div>
                                <div class="pform-value" >{{ $receipt->approvedBy?->name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Approved Date</div>
                                <div class="pform-value" >{{ $receipt->approved_date?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Approved Amount</div>
                                <div class="pform-value" >{{ $receipt->approved_amount?? 'Nil' }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>

                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Paid By</div>
                                <div class="pform-value" >{{ $receipt->paidBy?->name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Paid Date</div>
                                <div class="pform-value" >{{ $receipt->paid_date?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Paid Amount</div>
                                <div class="pform-value" >{{ $receipt->paid_amount?? 'Nil' }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-12" >
                        <table class="page-view-table" id="receiptCreateTable" >
                            <thead>
                                <tr>
                                    <th style="width:10%;" >Label</th>
                                    <th style="width:10%;" >Ledger A/c</th>
                                    <th style="width:10%;" class="bank-column" >Bank</th>
                                    <th style="width:10%;" class="analytical-column" >Analytical A/c</th>
                                    <th style="width:20%;" >Narration</th>
                                    <th style="width:5%; text-align:right;" >Debit</th>
                                    <th style="width:5%; text-align:right;" >Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="dr_account">
                                    <td><b><span id="dr_account_label" >Expense</span> A/c</b></td>
                                    <td>{{ $receipt->toAccount->account_name }}</td>
                                    <td class="bank-column">{{ $receipt->customer_bank }}</td>
                                    <td class="analytical-column">{{ $receipt->analytical_code }}</td>
                                    <td>{{ $receipt->narration }}</td>
                                    <td style="text-align:right;" >{{ $receipt->requested_amount }}</td>
                                    <td style="text-align:right;" >0</td>
                                </tr>
                                <tr class="cr_account">
                                    <td><b><span class="cr_account_label" >Cash/Bank</span> A/c</b></td>
                                    <td>{{ $receipt->fromAccount->account_name }}</td>
                                    <td class="bank-column">{{ $receipt->bankMaster?->bank_name }}</td>
                                    <td class="analytical-column">{{ $receipt->analytical_code }}</td>
                                    <td></td>
                                    <td style="text-align:right;" >0</td>
                                    <td style="text-align:right;" >{{ $receipt->requested_amount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-6" ><br /><br />
                        <div class="remarks" >
                            <label>Remarks</label>
                            <div style="height:100px; width:100%; border:1px solid #CCC; padding:15px;" >{{ $receipt->remarks }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($receipt->is_advance)
        <div class="tab-pane fade" id="settlement" role="tabpanel">
            <div class="card page-form" >
                <div class="card-header">
                    <h5>Settlement History</h5>
                    <div class="action-btns" >
                        @if($receipt->settlements->sum('amount') < $receipt->requested_amount)
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#settlementModal">
                                <i class="fas fa-plus"></i> Create
                            </button>
                         @else
                            <span class="badge badge-success">Fully Settled</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" >
                        <div class="col-md-12" >
                            <table class="page-view-table" id="receiptSettlementTable" >
                                <thead>
                                    <tr>
                                        <!-- <th style="width:10%;" >Label</th> -->
                                        <th style="width:15%;" >Ledger A/c</th>
                                        <th style="width:15%;" class="analytical-column" >Analytical A/c</th>
                                        <th style="width:30%;" >Narration</th>
                                        <th style="width:15%; text-align:right;" >Debit</th>
                                        <th style="width:15%; text-align:right;" >Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($receipt->settlements) > 0)
                                        @foreach($receipt->settlements as $settlement)
                                            @php
                                                $totalDebit = $receipt->settlements->where('tran_type', 'DR')->sum('amount');
                                                $totalCredit = $receipt->settlements->where('tran_type', 'CR')->sum('amount') * -1;
                                            @endphp
                                            <tr class="dr_account">
                                                <td>{{ $settlement->account->account_name }}</td>
                                                <td class="analytical-column">{{ $settlement->analytical_code }}</td>
                                                <td>{{ $settlement->narration }}</td>
                                                <td style="text-align:right;">{{ $settlement->tran_type=='DR'? number_format($settlement->amount, 2) : '0.00' }}</td>
                                                <td style="text-align:right;">{{ $settlement->tran_type=='CR'? number_format($settlement->amount * -1, 2) : '0.00' }}</td>
                                            </tr>
                                        @endforeach

                                        {{-- Total Row --}}
                                        <tr class="table-footer">
                                            <td colspan="@if($settlement->analytical_code) 3 @else 2 @endif" class="text-right font-weight-bold">Total</td>
                                            <td style="text-align:right; font-weight:bold;">{{ number_format($totalDebit, 2) }}</td>
                                            <td style="text-align:right; font-weight:bold;">{{ number_format($totalCredit, 2) }}</td>
                                        </tr>
                                    @else
                                        <tr class="empty-row">
                                            <td colspan="5" class="text-center text-muted">No settlement entries yet.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="tab-pane fade" id="receiptAttachment" role="tabpanel">
        <x-attachment-uploader :tableName="$receipt->getTable()" :rowId="$receipt->receipt_voucher_id" />
    </div>

    <div class="tab-pane fade" id="receiptStatus" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                @forelse($receipt->statusUpdates as $log)
                    <div class="status-log-entry">
                        <img src="{{ $log->creator?->avatar_url }}" class="avatar" alt="{{ $log->creator?->name }}">
                        <div class="status-details">
                            <strong>{{ $log->creator?->name }}</strong>
                            <span class="status">{{ ucfirst($log->column_value) }}</span>
                            <span class="description">{{ $log->description }}</span>
                            @php
                                $amount = $receiptAmounts[$log->column_value] ?? null;
                            @endphp
                            @if($amount)
                                <span class="amount">₹{{ number_format($amount, 2) }}</span>
                            @endif
                            <span class="date">{{ $log->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No status history found.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@section('css')
<style>
    #receiptTabs { border-bottom: 1px solid #000; }
    #receiptTabs li.nav-item {  }
    #receiptTabs li.nav-item a { color:#000; }
    #receiptTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #receiptTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }

    .status-log-entry {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .status-log-entry .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .status-details {
        font-size: 14px;
    }

    .status-details .amount {
        color: #28a745;
        font-weight: bold;
    }


</style>
@stop

@section('js')
<script>
$(document).ready(function () {
    var receipt = @json($receipt);

    // Column toggle logic
    function toggleColumn() {
        if(receipt && receipt.transaction_type === 'bank') {
            $('.bank-column').show();
            $('.cr_account_label').text('Bank');
        } else {
            $('.bank-column').hide();
            $('.cr_account_label').text('Cash');
        }

        if(receipt && receipt.customer_id === 1) {
            $('.analytical-column').show();
        } else {
            $('.analytical-column').hide();
        }

        if(receipt && receipt.transaction_type != '') {
            const tranType = receipt.transaction_type;

            const labels = {
                'cheque': { refLabel: 'Cheque', refDate: 'Cheque' },
                'transfer': { refLabel: 'Ref', refDate: 'Transfer' }
            };

            const fallback = { refLabel: 'Ref', refDate: 'Ref' };
            const selected = labels[tranType] || fallback;

            $('#ref_label').text(selected.refLabel);
            $('#ref_date').text(selected.refDate);
        }
    }

    // On page load
    toggleColumn();

    $('#change_status_select').val('{{$receipt->status}}');

    // Start : Changes Status
    $('#change_status_select').on('change', function() {
        var status = $(this).val();
        var status_text = $(this).find('option:selected').text();
        var receipt_id = '{{ $receipt->receipt_voucher_id }}';
       
        // if (status == 'settled') {
        //     $(this).val('{{$receipt->status}}');
        //     $('#settlementModal').modal('show');
        //     return;
        // }

        if (status != 'settled') {
            showConfirmationModal(
                "Confirm",
                "Do you want to change the status to '<b>" + status_text + "</b>' ?",
                function () {
                    $.post("/admin/accounting/receipt/change-status", {
                        receipt_id: receipt_id,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (res) {
                        document.location = "{{ route('admin.accounting.receipt.index') }}";
                    });
                },
                function () {
                    $('#change_status_select').val('{{$receipt->status}}');
                }
            );
        }
    });

    // End : Changes Status

    

});
</script>
@stop