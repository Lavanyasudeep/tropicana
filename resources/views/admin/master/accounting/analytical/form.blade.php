@extends('adminlte::page')

@section('title', 'Analytical')

@section('content_header')
    <h1>Analytical</h1>
@endsection

@section('content')
@php
   if(isset($analytical)) {
        $page_title = 'Edit';
        $action = route('admin.master.accounting.analytical.update', $analytical->analytical_id);
        $method = 'PUT';

        $company_id = $analytical->company_id;
        $analytical_code = $analytical->analytical_code;
        $account_code = $analytical->account_code;
        $active = $analytical->active;
    } else {
        $page_title = 'Create';
        $action = route('admin.master.accounting.analytical.store');
        $method = 'POST';

        $company_id = 1;
        $analytical_code = '';
        $account_code = '';
        $active = 1;
    }
@endphp
<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.master.accounting.analytical.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
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
                            <div class="pform-label">Analytical Code</div>
                            <div class="pform-value">
                                <input type="text" name="analytical_code" id="analytical_code" value="{{ old('analytical_code', $analytical_code) }}" >
                            </div>
                        </div>

                        <div class="pform-row">
                            <div class="pform-label">Account Code/Name</div>
                            <div class="pform-value">
                                <select name="account_code" id="account_code" class="select2" >
                                    <option value="">- Select -</option>
                                    @foreach($chart_of_account as $v)
                                        <option value="{{ $v->account_code }}"
                                            @selected(old('account_code', $account_code) == $v->account_code) >
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
