@extends('adminlte::page')

@section('title', 'View Journal')

@section('content_header')
    <h1>Journal</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.accounting.journal.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status" >
        <label>Change Status</label>
       
        <select id="change_status_select" >
            <option value="created" >Created</option>
            <option value="requested" >Requested</option>
            @if(!in_array('approved', $journal->statusUpdates->pluck('column_value')->toArray()))
                <option value="approved">Approved</option>
            @endif

            @if(!in_array('rejected', $journal->statusUpdates->pluck('column_value')->toArray()))
                <option value="rejected">Rejected</option>
            @endif

            @if(!in_array('paid', $journal->statusUpdates->pluck('column_value')->toArray()))
                <option value="paid">Paid</option>
            @endif

            @if(!in_array('cancelled', $journal->statusUpdates->pluck('column_value')->toArray()))
                <option value="cancelled">Cancelled</option>
            @endif
        </select>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="journalTabs" >
  <li class="nav-item">
    <a class="nav-link active" id="journal-tab" data-toggle="tab" href="#journal" role="tab">Journal</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="journal-status-tab" data-toggle="tab" href="#journalStatus" role="tab">Status</a>
  </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="journal" role="tabpanel">
        <div class="card page-form" >
            <div class="card-body">
                <div class="row" >
                    <!-- Panel 1 -->
                    <div class="col-md-6" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. #</div>
                                <div class="pform-value" >{{ $journal->doc_no }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. Date</div>
                                <div class="pform-value" >{{ $journal->doc_date }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Requested By</div>
                                <div class="pform-value" >{{ $journal->requestedBy?->name??'Nil' }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Status</div>
                                <div class="pform-value" >{{ $journal->status }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>

                    <div class="col-md-6" >
                        <div class="pform-panel" >
                            <div class="pform-row" >
                                <div class="pform-label" >Company</div>
                                <div class="pform-value" >{{ $journal->company?->company_name }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Branch</div>
                                <div class="pform-value" >{{ $journal->branch?->branch_name }}</div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Department</div>
                                <div class="pform-value" >{{ $journal->department?->department_name }}</div>
                            </div>
                            <div class="pform-clear" ></div>
                        </div>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-12" >
                        <table class="page-view-table" id="journalCreateTable" >
                            <thead>
                                <tr>
                                    <th style="width:10%;" >Ledger</th>
                                    <th style="width:10%;" >A/c</th>
                                    <th style="width:10%;" class="bank-column" >Bank</th>
                                    <th style="width:10%;" class="analytical-column" >Employee</th>
                                    <th style="width:10%;" class="analytical-column" >Analytical</th>
                                    <th style="width:20%;" >Narration</th>
                                    <th style="width:5%; text-align:right;" >Debit</th>
                                    <th style="width:5%; text-align:right;" >Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($journal->journalDetails as $journalDtl)
                                    @php
                                        $totalDebit = $journalDtl->journalDtl->where('tran_type', 'D')->sum('amount');
                                        $totalCredit = $journalDtl->journalDtl->where('tran_type', 'C')->sum('amount') * -1;
                                    @endphp
                                    <tr class="account">
                                        <td>{{ $journalDtl->account_type }}</td>
                                        <td>{{ $journalDtl->account->account_name }}</td>
                                        <td>{{ $journalDtl->supplier_bank }}</td>
                                        <td></td>
                                        <td>{{ $journalDtl->analytical->analytical_code }}</td>
                                        <td>{{ $journalDtl->narration }}</td>
                                        <td style="text-align:right;" >{{ $journalDtl->tran_type == 'D'??$journalDtl->amount }}</td>
                                        <td style="text-align:right;" >{{ $journalDtl->tran_type == 'C'??$journalDtl->amount }}</td>
                                    </tr>
                                @endforeach
                                {{-- Total Row --}}
                                <tr class="table-footer">
                                    <td colspan="@if($settlement->analytical_code) 3 @else 2 @endif" class="text-right font-weight-bold">Total</td>
                                    <td style="text-align:right; font-weight:bold;">{{ number_format($totalDebit, 2) }}</td>
                                    <td style="text-align:right; font-weight:bold;">{{ number_format($totalCredit, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="journalStatus" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                @forelse($journal->statusUpdates as $log)
                    <div class="status-log-entry">
                        <img src="{{ $log->creator?->avatar_url }}" class="avatar" alt="{{ $log->creator?->name }}">
                        <div class="status-details">
                            <strong>{{ $log->creator?->name }}</strong>
                            <span class="status">{{ ucfirst($log->column_value) }}</span>
                            <span class="description">{{ $log->description }}</span>
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
    #journalTabs { border-bottom: 1px solid #000; }
    #journalTabs li.nav-item {  }
    #journalTabs li.nav-item a { color:#000; }
    #journalTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #journalTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }

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
    var journal = @json($journal);

    $('#change_status_select').val('{{$journal->status}}');

    // Start : Changes Status
    $('#change_status_select').on('change', function() {
        var status = $(this).val();
        var status_text = $(this).find('option:selected').text();
        var journal_id = '{{ $journal->journal_id }}';
       
        showConfirmationModal(
            "Confirm",
            "Do you want to change the status to '<b>" + status_text + "</b>' ?",
            function () {
                $.post("/admin/accounting/journal/change-status", {
                    journal_id: journal_id,
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function (res) {
                    document.location = "{{ route('admin.accounting.journal.index') }}";
                });
            },
            function () {
                $('#change_status_select').val('{{$journal->status}}');
            }
        );
    });

    // End : Changes Status

    

});
</script>
@stop