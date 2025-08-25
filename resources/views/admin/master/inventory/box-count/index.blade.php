@extends('adminlte::page') 

@section('title', 'Box Count Management')

@section('content_header')
    <h1>Manage Product Wise Box Count</h1>
@stop

@section('content')
<div class="page-sub-header">
    <h3>List</h3>
</div>

<div class="card page-list-panel">
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.master.inventory.box-count.update') }}" id="boxCountForm">
            @csrf
            <table class="page-list-table" id="boxCountTable" >
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Icon</th>
                        <th>Purchase Unit</th>
                        <th>Weight Per Box</th>
                        <th>Box Capacity Per Full Pallet</th>
                        <th>Box Capacity Per Half Pallet</th>
                    </tr>
                </thead>
            </table>

            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        var table = $('#boxCountTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.master.inventory.box-count.index') }}",
            columns: [
                { data: 'product.product_description', name: 'product.product_description', defaultContent: 'N/A' },
                { data: 'svg_icon', name: 'svg_icon', orderable: false, searchable: false },
                { data: 'purchaseunit.conversion_unit', name: 'purchaseunit.conversion_unit', defaultContent: 'N/A' },
                { data: 'weight_per_box', name: 'weight_per_box', orderable: false, searchable: false },
                { data: 'box_capacity_per_full_pallet', name: 'box_capacity_per_full_pallet', orderable: false, searchable: false },
                { data: 'box_capacity_per_half_pallet', name: 'box_capacity_per_half_pallet', orderable: false, searchable: false }
            ],
            responsive: true,
            autoWidth: false,
            drawCallback: function(settings) {
                // Initialize any plugins or handlers after table draw
            }
        });

        // Prevent form submission from interfering with DataTables
        $('#boxCountForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var table = $('#boxCountTable').DataTable();

            // Serialize all form inputs from the DataTable
            var formData = table.$('input,select,textarea').serialize();

            // Append the CSRF token to the formData
            formData += '&_token=' + $('meta[name="csrf-token"]').attr('content');

            // Submit the form via AJAX
            $.ajax({
                url: '/admin/box-count/update',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        table.draw(false); // Redraw table without resetting paging
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message || 'An error occurred');
                }
            });
        });
    });
</script>
@stop