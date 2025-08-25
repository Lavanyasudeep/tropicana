@extends('adminlte::page')

@section('title', 'View Branch')

@section('content_header')
    <h1>Branch</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.general.branch.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form" >
    <div class="card-body">
        <div class="row" >
            <!-- Panel 1 -->
            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:250px;" >
                    <div class="pform-row">
                        <div class="pform-label" >Branch Name</div>
                        <div class="pform-value" >{{ $branch->branch_name }}</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label" >Company Name</div>
                        <div class="pform-value" >{{ $branch->company->company_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Contact No</div>
                        <div class="pform-value" >{{ $branch->mobile_number }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Email-Id</div>
                        <div class="pform-value" >{{ $branch->email_id }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:250px;" >
                    <div class="pform-row" >
                        <div class="pform-label" >Address</div>
                        <div class="pform-value" >{{ $branch->address1 }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Country</div>
                        <div class="pform-value" >{{ $branch->company->country->country_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >State</div>
                        <div class="pform-value" >{{ $branch->state->state_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >District</div>
                        <div class="pform-value" >{{ $branch->district->district_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Post Office</div>
                        <div class="pform-value" >{{ $branch->company->postoffice->post_office }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Pincode</div>
                        <div class="pform-value" >{{ $branch->pincode }}</div>
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