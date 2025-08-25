@extends('adminlte::page')

@section('title', 'View Payment Purpose')

@section('content_header')
    <h1>Payment Purpose</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.accounting.payment-purpose.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form" >
    <div class="card-body">
        <div class="row" >
            
            <div class="col-md-6" >
                <div class="pform-panel" >
                    <div class="pform-row">
                        <div class="pform-label" >Company Name</div>
                        <div class="pform-value" >{{ $paymentPurpose->company->company_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Purpose Name</div>
                        <div class="pform-value" >{{ $paymentPurpose->purpose_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Balance Sheet A/c</div>
                        <div class="pform-value" >{{ $paymentPurpose->bSheetAccount->account_name.'-'.$paymentPurpose->bsheet_account_code }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Expense A/c</div>
                        <div class="pform-value" >{{ $paymentPurpose->expAccount->account_name.'-'.$paymentPurpose->exp_account_code }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Active</div>
                        <div class="pform-value" >{{ $paymentPurpose->active? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="pform-panel" >
                    <div class="pform-row">
                        <div class="pform-label" >Created By</div>
                        <div class="pform-value" >{{ $paymentPurpose->createdBy->name?? 'Nil' }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Created Date</div>
                        <div class="pform-value" >{{ $paymentPurpose->created_at?? 'Nil' }}</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label" >Updated By</div>
                        <div class="pform-value" >{{ $paymentPurpose->updatedBy->name?? 'Nil' }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Updated Date</div>
                        <div class="pform-value" >{{ $paymentPurpose->updated_at?? 'Nil' }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
        </div>
    </div>
</div>
        
@endsection

@section('css')
@stop

@section('js')
<script>

</script>
@stop