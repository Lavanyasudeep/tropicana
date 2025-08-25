@extends('adminlte::page')

@section('title', 'View Analytical')

@section('content_header')
    <h1>Analytical</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.accounting.analytical.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form" >
    <div class="card-body">
        <div class="row" >
            
            <div class="col-md-6" >
                <div class="pform-panel" >
                    <div class="pform-row">
                        <div class="pform-label" >Company Name</div>
                        <div class="pform-value" >{{ $analytical->company->company_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Analytical Code</div>
                        <div class="pform-value" >{{ $analytical->analytical_code }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Account Name</div>
                        <div class="pform-value" >{{ $analytical->chartOfAccount->account_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Active</div>
                        <div class="pform-value" >{{ $analytical->active? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="pform-panel" >
                    <div class="pform-row">
                        <div class="pform-label" >Created By</div>
                        <div class="pform-value" >{{ $analytical->createdBy->name?? 'Nil' }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Created Date</div>
                        <div class="pform-value" >{{ $analytical->created_at?? 'Nil' }}</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label" >Updated By</div>
                        <div class="pform-value" >{{ $analytical->updatedBy->name?? 'Nil' }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Updated Date</div>
                        <div class="pform-value" >{{ $analytical->updated_at?? 'Nil' }}</div>
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