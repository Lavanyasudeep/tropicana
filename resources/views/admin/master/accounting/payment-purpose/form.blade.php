@extends('adminlte::page')

@section('title', 'Payment Purpose')

@section('content_header')
    <h1>Payment Purpose</h1>
@endsection

@section('content')
@php
   if(isset($paymentPurpose)) {
        $page_title = 'Edit';
        $action = route('admin.master.accounting.payment-purpose.update', $paymentPurpose->purpose_id);
        $method = 'PUT';

        $company_id = $paymentPurpose->company_id;
        $purpose_name = $paymentPurpose->purpose_name;
        $bsheet_account_code = $paymentPurpose->bsheet_account_code;
        $exp_account_code = $paymentPurpose->exp_account_code;
        $active = $paymentPurpose->active;
    } else {
        $page_title = 'Create';
        $action = route('admin.master.accounting.payment-purpose.store');
        $method = 'POST';

        $company_id = 1;
        $purpose_name = '';
        $bsheet_account_code = '';
        $exp_account_code = '';
        $active = 1;
    }
@endphp
<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.accounting.payment-purpose.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @method($method)
            <div class="row">
                <div class="col-md-6" >
                    <div class="pform-panel" >
                        <div class="pform-row">
                            <div class="pform-label">Company</div>
                            <div class="pform-value">
                                <select name="company_id" id="company_id" class="select2" >
                                    <option value="">- Select -</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->company_id }}"
                                            @selected(old('company_id', $company_id) == $company->company_id)
                                        >
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="pform-row">
                            <div class="pform-label">Purpose Name</div>
                            <div class="pform-value">
                                <input type="text" name="purpose_name" id="purpose_name" value="{{ old('purpose_name', $purpose_name) }}" >
                            </div>
                        </div>

                        <div class="pform-row">
                            <div class="pform-label">Balance Sheet A/c</div>
                            <div class="pform-value">
                                <select name="bsheet_account_code" id="bsheet_account_code" class="select2" >
                                    <option value="">- Select -</option>
                                    @foreach($chart_of_account as $v)
                                        <option value="{{ $v->account_code }}"
                                            @selected(old('bsheet_account_code', $bsheet_account_code) == $v->account_code) >
                                            {{ $v->account_code }} - {{ $v->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="pform-row">
                            <div class="pform-label">Expense A/c</div>
                            <div class="pform-value">
                                <select name="exp_account_code" id="exp_account_code" class="select2" >
                                    <option value="">- Select -</option>
                                    @foreach($chart_of_account as $v)
                                        <option value="{{ $v->account_code }}"
                                            @selected(old('exp_account_code', $exp_account_code) == $v->account_code) >
                                            {{ $v->account_code }} - {{ $v->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="pform-row">
                            <div class="pform-label">Active</div>
                            <div class="pform-value">
                                <div class="form-switch">
                                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', $active) ? 'checked' : '' }} >
                                </div>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                    <div class="pform-clear" ></div>
                </div>
            </div>

            <!-- Submit -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-save float-right">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        
    });
</script>
@endsection
