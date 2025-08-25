@extends('adminlte::page')

@section('title', 'View Company')

@section('content_header')
    <h1>Company</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.general.company.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form" >
    <div class="card-body">
        <div class="row" >
            <!-- Panel 1 -->
            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:140px;" >
                    <div class="pform-row">
                        <div class="pform-label" >Company Name</div>
                        <div class="pform-value" >{{ $company->company_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Contact No.</div>
                        <div class="pform-value" >{{ $company->phone_number }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Contact No- 2</div>
                        <div class="pform-value" >{{ $company->mobile_number }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Email-Id</div>
                        <div class="pform-value" >{{ $company->email_id }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:140px;" >
                    <div class="pform-row" >
                        <div class="pform-label" >Logo</div>
                        <div class="pform-value" >
                            <br/>
                            <img id="logoPreview" src="{{ asset('storage/'.$company->logo) }}" alt="Logo Preview"
                                            style="margin-top:10px; max-height: 80px;' }}">
                        </div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:200px;">
                    <div class="pform-row" >
                        <div class="pform-label" >Website</div>
                        <div class="pform-value" >{{ $company->website }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >GSTIN</div>
                        <div class="pform-value" >{{ $company->gstin }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >TIN</div>
                        <div class="pform-value" >{{ $company->tin }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >FSSAI NO</div>
                        <div class="pform-value" >{{ $company->fssai_no }}</div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <div class="col-md-6" >
                <div class="pform-panel" style="min-height:200px;">
                    <div class="pform-row" >
                        <div class="pform-label" >Address</div>
                        <div class="pform-value" >{{ $company->address }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Country</div>
                        <div class="pform-value" >{{ $company->country->country_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >State</div>
                        <div class="pform-value" >{{ $company->state->state_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >District</div>
                        <div class="pform-value" >{{ $company->district->district_name }}</div>
                    </div>
                    <div class="pform-row" >
                        <div class="pform-label" >Post Office</div>
                        <div class="pform-value" >{{ $company->postoffice->post_office }}</div>
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