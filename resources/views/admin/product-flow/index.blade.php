@extends('adminlte::page') 

@section('title', 'Product Flow')

@section('content_header')
    <h1>Flowboard</h1>
@stop

@section('content')
<div class="page-sub-header" >
    <h3>Product Flow</h3>
</div>

<div class="row">
    {{-- In Card --}}
    <div class="col-md-4">
        <div class="card bg-info">
            <div class="card-header"><strong>In</strong></div>
            <div class="card-body p-2" style="max-height: 400px; overflow-y: auto;">
                @forelse ($inwardProducts as $product)
                    <div class="card mb-2">
                        <div class="card-body p-2" style="color:black;">
                            <h6>{{ $product['product_name'] }}</h6>
                            <small>Qty: {{ $product['total_qty'] }}</small>
                            <div class="mt-2">
                                <a href="#" class="btn btn-sm btn-warning">Pick</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No inward products.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Picked Card --}}
    <div class="col-md-4">
        <div class="card bg-warning">
            <div class="card-header"><strong>Picked</strong></div>
            <div class="card-body p-2" style="max-height: 400px; overflow-y: auto;">
                @forelse ($pickedProducts as $product)
                    <div class="card mb-2">
                        <div class="card-body p-2" style="color:black;">
                            <h6>{{ $product['product_name'] }}</h6>
                            <small>Qty: {{ $product['total_qty'] }}</small>
                            <div class="mt-2">
                                <a href="#" class="btn btn-sm btn-success">Move to Out</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No picked products.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Out Card --}}
    <div class="col-md-4">
        <div class="card bg-success">
            <div class="card-header"><strong>Out</strong></div>
            <div class="card-body p-2" style="color:black;">
                @forelse ($outwardProducts as $product)
                    <div class="card mb-2">
                        <div class="card-body p-2">
                            <h6>{{ $product['product_name'] }}</h6>
                            <small>Qty: {{ $product['total_qty'] }}</small>
                            <div class="mt-2">
                                <a href="#" class="btn btn-sm btn-primary">Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No outward products.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
