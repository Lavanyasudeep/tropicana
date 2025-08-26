@extends('adminlte::page')

@section('title', 'Warehouse Units')

@section('content_header')
    <h1>Manage Warehouse Units</h1>
@stop

@section('content')

<div class="row" id="warehouseCreateForm">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">Add / Edit Warehouse Unit</h3>
            </div>
            <div class="card-body">
                <form id="warehouseForm" action="{{ route('admin.master.inventory.warehouse-unit.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="wu_id">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Warehouse Unit No</label>
                            <input type="text" class="form-control" name="wu_no" required>
                        </div>
                        <div class="col-md-4">
                            <label>Warehouse Unit Name</label>
                            <input type="text" class="form-control" name="wu_name" required>
                        </div>
                        <div class="col-md-4">
                            <label>Temperature Range (°C)</label>
                            <input type="text" class="form-control" name="temperature_range" required>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Storage Product Type</label>
                            <select class="form-control" name="storage_product_type_id" required>
                                <option value="">-- Select Product Type --</option>
                                @foreach($productTypes as $type)
                                    <option value="{{ $type->product_type_id }}">{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>No. of Docks</label>
                            <input type="number" min="0" class="form-control" name="no_of_docks">
                        </div>
                        <div class="col-md-4">
                            <label>No. of Rooms</label>
                            <input type="number" min="0" class="form-control" name="no_of_rooms">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4" style="margin-top: 30px;">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
                            <button type="button" class="btn btn-default" id="closeEditBtn">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>List</h3>
    <div class="action-btns">
        <button class="btn btn-create" onclick="toggleView('create')" title="Create New"><i class="fas fa-plus"></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')" title="List View"><i class="fas fa-list"></i> List View</button>
    </div>
</div>

<!-- List View -->
<div id="warehouse-list-view" class="card page-list-panel">
    <div class="card-body">
        <table id="warehouseTable" class="page-list-table">
            <thead>
                <tr>
                    <th style="width:5%;">#</th>
                    <th style="width:15%;">Unit No</th>
                    <th style="width:20%;">Name</th>
                    <th style="width:15%;">Temperature</th>
                    <th style="width:20%;">Product Type</th>
                    <th style="width:10%;">Status</th>
                    <th style="width:15%;">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('css')
<style>
    #warehouseCreateForm { display:none; }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        const table = $('#warehouseTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.master.inventory.warehouse-unit.index') }}',
            columns: [
                { data: 'wu_id', name: 'wu_id', width: '5%' },
                { data: 'wu_no', name: 'wu_no', width: '15%' },
                { data: 'wu_name', name: 'wu_name', width: '20%' },
                { data: 'temperature_range', name: 'temperature_range', width: '15%' },
                { data: 'storage_product_type', name: 'storage_product_type', width: '20%' },
                { data: 'Status', name: 'Status', width: '10%', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', width: '15%', orderable: false, searchable: false }
            ],
            columnDefs: [
                { targets: [0,5,6], className: 'text-center' }
            ],
            order: [[0, 'desc']]
        });

        $(document).on("click", ".edit-btn", function () {
            const id = $(this).data('id');

            $('input[name="wu_no"]').val($(this).data('wu_no'));
            $('input[name="wu_name"]').val($(this).data('wu_name'));
            $('input[name="temperature_range"]').val($(this).data('temperature_range'));
            $('select[name="storage_product_type_id"]').val($(this).data('storage_product_type_id'));
            $('input[name="no_of_docks"]').val($(this).data('no_of_docks'));
            $('input[name="no_of_rooms"]').val($(this).data('no_of_rooms'));
            $('select[name="status"]').val($(this).data('status'));

            const form = $('#warehouseForm');
            form.attr('action', '/admin/master/inventory/warehouse-units/update/' + id);
            if (form.find('input[name="_method"]').length === 0) {
                form.append('<input type="hidden" name="_method" value="PUT">');
            } else {
                form.find('input[name="_method"]').val('PUT');
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
            $('#warehouseCreateForm').show();
        });

        $(document).on("click", "#cancelEditBtn", function () {
            const form = $('#warehouseForm');
            form.trigger('reset');
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.warehouse-unit.store') }}");
        });

        $(document).on("click", "#closeEditBtn", function () {
            const form = $('#warehouseForm');
            form.trigger('reset');
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.warehouse-unit.store') }}");
            $('#warehouseCreateForm').hide();
        });

        $('#warehouseTable').on('click', '.toggle-status', function () {
            const button = $(this);
            const id = button.data('id');

            $.post('{{ route('admin.master.inventory.warehouse-unit.toggle-status') }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function (res) {
                if (res.success) {
                    button.toggleClass('btn-success btn-secondary')
                        .text(res.status ? 'Active' : 'Inactive');
                }
            });
        });
    });

    function toggleView(view) {
        if (view === 'list') {
            $('#warehouse-list-view').show();
            $('#warehouseCreateForm').hide();
        } else if (view === 'create') {
            $('#warehouseCreateForm').show();
        }
    }
</script>
@stop
