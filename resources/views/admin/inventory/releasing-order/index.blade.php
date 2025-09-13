@extends('adminlte::page')

@section('title', 'Releasing Order List')

@section('content_header')
    <h1>Releasing Order</h1>
@endsection

@section('content')
@php 
$orders =[
    [
        'document_no' => 'RO‑25‑00003',
        'customer_name' => 'Chelur Foods',
        'created_at' => '2025-08-25',
        'releasing_date' => '2025-08-27',
        'vehicle_no' => 'KL‑09‑EF‑9012',
        'status' => 'Released',
        'items_count' => 5
    ],
    [
        'document_no' => 'RO‑25‑00004',
        'customer_name' => 'AAA International',
        'created_at' => '2025-08-26',
        'releasing_date' => '2025-08-28',
        'vehicle_no' => '',
        'status' => 'Cancelled',
        'items_count' => 0
    ]
];

$orders = collect($orders)->map(function ($order) {
    return (object) $order;
});
@endphp
<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.releasing-order.create') }}" class="btn btn-create"><i class="fas fa-plus"></i> Create</a>
    </div>
</div>


<!-- Advance Filter -->
<div class="page-advance-filter" id="tempAdvFilterPanel" style="display:none;">
    <form id="tempAdvFilterForm">
        <div class="row">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Name">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" placeholder="Date">
            </div>
            <div class="col-md-3 btn-group" role="group">
                <button type="submit" class="btn btn-success">Filter</button>
                <button type="button" class="btn btn-secondary" id="cancelFltrBtn">Cancel</button>
                <button type="button" class="btn btn-light" id="closeFltrBtn">Close</button>
            </div>
        </div>
    </form>
</div>


<!-- Quick Filter -->
<div class="page-quick-filter">
    <div class="row">
        <div class="col-md-1 fltr-title">
            <span>FILTER BY</span>
        </div>
        <div class="col-md-3">
            <input type="date" class="form-control pq-fltr-input" placeholder="Date">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control pq-fltr-input" placeholder="Name">
        </div>
        <div class="col-md-2">
            <select class="form-control pq-fltr-select">
                <option value="">- All Status -</option>
                <option value="Normal">Normal</option>
                <option value="High">High</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control pq-fltr-input" placeholder="Search">
        </div>
        <div class="col-md-1">
            <input type="button" value="Search" class="btn btn-quick-filter-search" />
        </div>
    </div>
</div>

<div class="card page-list-panel">
    <div class="card-body">
        <table class="page-list-table table table-bordered">
            <thead>
                <tr>
                    <th>Doc. #</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Releasing Date</th>
                    <th>No. of Items</th>
                    <th>Vehicle No.</th>
                    <th>Status</th>
                    <th style="width:120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->document_no }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $order->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->releasing_date)->format('d/m/Y') }}</td>
                    <td>{{ $order->items_count }}</td>
                    <td>{{ $order->vehicle_no }}</td>
                    <td>
                        <span class="badge 
                            @if($order->status == 'Created') badge-warning 
                            @elseif($order->status == 'Approved') badge-success 
                            @elseif($order->status == 'Released') badge-primary 
                            @elseif($order->status == 'Cancelled') badge-danger 
                            @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.inventory.releasing-order.edit', 1) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.inventory.releasing-order.print', 1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>
                        <a href="{{ route('admin.inventory.releasing-order.view', 1) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Toggle Advance Filter
    $(document).on("click", '#cancelFltrBtn', function () {
        const form = $('#tempAdvFilterForm');
        form.find('input[type="text"], input[type="date"]').val('');
        form.find('select').val('');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeFltrBtn", function () {
        const form = $('#tempAdvFilterForm');
        form.find('input[type="text"], input[type="date"]').val('');
        form.find('select').val('');
        $('#tempAdvFilterPanel').hide();
    });

    $(document).on("submit", '#tempAdvFilterForm', function(e) {
        e.preventDefault();
        alert('Filter applied (demo only)');
    });

    window.toggleView = function(view) {
        $('#tempAdvFilterPanel').toggle();
    };
});
</script>
@endsection

