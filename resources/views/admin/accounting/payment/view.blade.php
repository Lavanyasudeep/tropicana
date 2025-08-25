@extends('adminlte::page')

@section('title', 'View Payment Voucher')

@section('content_header')
    <h1>Payment Voucher</h1>
@endsection

@section('content')

@if($payment->is_advance)
    @include('admin.accounting.payment.settlement-modal')
@endif

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.accounting.payment.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status" >
        <label>Change Status</label>
       
        <select id="change_status_select" >
            <option value="created" >Created</option>
            <option value="requested" >Requested</option>
            @if(!in_array('approved', $payment->statusUpdates->pluck('column_value')->toArray()))
                <option value="approved">Approved</option>
            @endif

            @if(!in_array('settled', $payment->statusUpdates->pluck('column_value')->toArray()))
                <option value="settled">Settled</option>
            @endif

            @if(!in_array('rejected', $payment->statusUpdates->pluck('column_value')->toArray()))
                <option value="rejected">Rejected</option>
            @endif

            @if(!in_array('paid', $payment->statusUpdates->pluck('column_value')->toArray()))
                <option value="paid">Paid</option>
            @endif

            @if(!in_array('cancelled', $payment->statusUpdates->pluck('column_value')->toArray()))
                <option value="cancelled">Cancelled</option>
            @endif
        </select>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="paymentTabs" >
  <li class="nav-item">
    <a class="nav-link active" id="payment-tab" data-toggle="tab" href="#payment" role="tab">Payment</a>
  </li>
  @if($payment->is_advance)
    <li class="nav-item">
        <a class="nav-link" id="settlement-tab" data-toggle="tab" href="#settlement" role="tab">Settlement</a>
    </li>
  @endif
  <li class="nav-item">
    <a class="nav-link" id="payment-attachment-tab" data-toggle="tab" href="#paymentAttachment" role="tab">Attachment</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="payment-status-tab" data-toggle="tab" href="#paymentStatus" role="tab">Status</a>
  </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="payment" role="tabpanel">
        <div class="card page-form" >
            <div class="card-body">
                <div class="row" >
                    <!-- Panel 1 -->
                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. #</div>
                                <div class="pform-value" >{{ $payment->doc_no }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. Date</div>
                                <div class="pform-value" >{{ $payment->doc_date }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Requested By</div>
                                <div class="pform-value" >{{ $payment->requestedBy?->name??'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Status</div>
                                <div class="pform-value" >{{ $payment->status }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>

                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Voucher Type</div>
                                <div class="pform-value" >{{ $payment->voucher_type_label }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Transaction Type</div>
                                <div class="pform-value" >{{ optional($payment->transactionType)->transaction_type? ucfirst($payment->transactionType->transaction_type) : '' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" ><span id="ref_label">Cheque/Ref</span> No.</div>
                                <div class="pform-value" >{{ $payment->ref_no??'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" ><span id="ref_date">Cheque/Transfer/Ref</span> Date</div>
                                <div class="pform-value" >{{ $payment->ref_date??'Nil' }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>

                    <!-- Panel 2 -->
                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Payee</div>
                                <div class="pform-value" >{{ $payment->payee?->supplier_name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Contact No.</div>
                                <div class="pform-value" >{{ $payment->payee?->Mobile?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Purpose</div>
                                <div class="pform-value" >{{ $payment->purpose?->purpose_name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Advance</div>
                                <div class="pform-value" >{{ $payment->is_advance?'Yes' : 'No' }}</div>
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
                                <div class="pform-value" >{{ $payment->requestedBy?->name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Requested Date</div>
                                <div class="pform-value" >{{ $payment->requested_date?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Requested Amount</div>
                                <div class="pform-value" >{{ $payment->requested_amount?? 'Nil' }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                    
                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Approved By</div>
                                <div class="pform-value" >{{ $payment->approvedBy?->name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Approved Date</div>
                                <div class="pform-value" >{{ $payment->approved_date?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Approved Amount</div>
                                <div class="pform-value" >{{ $payment->approved_amount?? 'Nil' }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>

                    <div class="col-md-4" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Paid By</div>
                                <div class="pform-value" >{{ $payment->paidBy?->name?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Paid Date</div>
                                <div class="pform-value" >{{ $payment->paid_date?? 'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Paid Amount</div>
                                <div class="pform-value" >{{ $payment->paid_amount?? 'Nil' }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-12" >
                        <table class="page-view-table" id="paymentCreateTable" >
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
                                    <td>{{ $payment->toAccount->account_name }}</td>
                                    <td class="bank-column">{{ $payment->supplier_bank }}</td>
                                    <td class="analytical-column">{{ $payment->analytical_code }}</td>
                                    <td>{{ $payment->narration }}</td>
                                    <td style="text-align:right;" >{{ $payment->requested_amount }}</td>
                                    <td style="text-align:right;" >0</td>
                                </tr>
                                <tr class="cr_account">
                                    <td><b><span class="cr_account_label" >Cash/Bank</span> A/c</b></td>
                                    <td>{{ $payment->fromAccount->account_name }}</td>
                                    <td class="bank-column">{{ $payment->bankMaster?->bank_name }}</td>
                                    <td class="analytical-column">{{ $payment->analytical_code }}</td>
                                    <td></td>
                                    <td style="text-align:right;" >0</td>
                                    <td style="text-align:right;" >{{ $payment->requested_amount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-6" ><br /><br />
                        <div class="remarks" >
                            <label>Remarks</label>
                            <div style="height:100px; width:100%; border:1px solid #CCC; padding:15px;" >{{ $payment->remarks }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($payment->is_advance)
        <div class="tab-pane fade" id="settlement" role="tabpanel">
            <div class="card page-form" >
                <div class="card-header">
                    <h5>Settlement History</h5>
                    <div class="action-btns" >
                        @if($payment->settlements->sum('amount') < $payment->requested_amount)
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
                            <table class="page-view-table" id="paymentSettlementTable" >
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
                                    @if(count($payment->settlements) > 0)
                                        @foreach($payment->settlements as $settlement)
                                            @php
                                                $totalDebit = $payment->settlements->where('tran_type', 'DR')->sum('amount');
                                                $totalCredit = $payment->settlements->where('tran_type', 'CR')->sum('amount') * -1;
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

    <div class="tab-pane fade" id="paymentAttachment" role="tabpanel">
        <x-attachment-uploader :tableName="$payment->getTable()" :rowId="$payment->payment_voucher_id" />
    </div>

    <div class="tab-pane fade" id="paymentStatus" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                @forelse($payment->statusUpdates as $log)
                    <div class="status-log-entry">
                        <img src="{{ $log->creator?->avatar_url }}" class="avatar" alt="{{ $log->creator?->name }}">
                        <div class="status-details">
                            <strong>{{ $log->creator?->name }}</strong>
                            <span class="status">{{ ucfirst($log->column_value) }}</span>
                            <span class="description">{{ $log->description }}</span>
                            @php
                                $amount = $paymentAmounts[$log->column_value] ?? null;
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
    #paymentTabs { border-bottom: 1px solid #000; }
    #paymentTabs li.nav-item {  }
    #paymentTabs li.nav-item a { color:#000; }
    #paymentTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #paymentTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }

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
    var payment = @json($payment);

    // Column toggle logic
    function toggleColumn() {
        if(payment && payment.transaction_type === 'bank') {
            $('.bank-column').show();
            $('.cr_account_label').text('Bank');
        } else {
            $('.bank-column').hide();
            $('.cr_account_label').text('Cash');
        }

        if(payment && payment.supplier_id === 1) {
            $('.analytical-column').show();
        } else {
            $('.analytical-column').hide();
        }

        if(payment && payment.transaction_type != '') {
            const tranType = payment.transaction_type;

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

    $('#change_status_select').val('{{$payment->status}}');

    // Start : Changes Status
    $('#change_status_select').on('change', function() {
        var status = $(this).val();
        var status_text = $(this).find('option:selected').text();
        var payment_id = '{{ $payment->payment_voucher_id }}';
       
        // if (status == 'settled') {
        //     $(this).val('{{$payment->status}}');
        //     $('#settlementModal').modal('show');
        //     return;
        // }

        if (status != 'settled') {
            showConfirmationModal(
                "Confirm",
                "Do you want to change the status to '<b>" + status_text + "</b>' ?",
                function () {
                    $.post("/admin/accounting/payment/change-status", {
                        payment_id: payment_id,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function (res) {
                        document.location = "{{ route('admin.accounting.payment.index') }}";
                    });
                },
                function () {
                    $('#change_status_select').val('{{$payment->status}}');
                }
            );
        }
    });

    // End : Changes Status

    

});
</script>
@stop