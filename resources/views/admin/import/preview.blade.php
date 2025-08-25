@extends('adminlte::page')

@section('title', 'Import')

@section('content_header')
    <h1>Import</h1>
@stop

@section('content')

<div class="row">
    <!-- Left Panel -->
    <div class="col-md-12">
        <div class="card" >
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">Import Preview</h3>
                <a href="{{ route('admin.bulk-import.new') }}" class="btn btn-success" style="float:right;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bulk-import.processImport') }}">
                    @csrf
                    <input type="hidden" name="fields" value="{{ json_encode($fields) }}">
                    <input type="hidden" name="rows" value="{{ json_encode($rows) }}">

                    <table class="table table-bordered">
                        @foreach ($fields as $table=>$columns)
                            <thead>
                                <tr>
                                    @foreach ($columns as $field)
                                        <th>{{ ucfirst($field) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows[$table] as $fieldvalues)
                                    <tr>
                                        @foreach ($fieldvalues as $i => $value)
                                            <td>{{ $fieldvalues[$i] ?? '' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        @endforeach
                    </table>

                    <button class="btn btn-success mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
