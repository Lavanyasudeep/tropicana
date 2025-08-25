@extends('adminlte::page')

@section('title', 'Product Attributes')

@section('content_header')
    <h1>Product Attributes</h1>
@stop

@section('content')
<div class="row" id="attributeCreateForm" style="display: none;">
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Add / Edit Attribute</h3>
            </div>
            <div class="card-body">
                <form id="attributeForm" method="POST" action="{{ route('admin.master.inventory.product-attributes.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Attribute Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required />
                        </div>
                        <div class="col-md-4">
                            <label for="data_type">Input Type <span class="text-danger">*</span></label>
                            <select class="form-control" name="data_type" id="data_type" required>
                                <option value="text">String</option>
                                <option value="number">Number</option>
                                <option value="color">Color</option>
                                <option value="date">Date</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="default_value">Default Value</label>
                            <input type="text" class="form-control" name="default_value" id="default_value" />
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="is_required">Is Required</label>
                            <select name="is_required" class="form-control">
                                <option value="0">Optional</option>
                                <option value="1">Required</option>
                            </select>
                        </div>

                        <div class="col-md-8 d-flex align-items-end justify-content-end">
                            <button type="submit" class="btn btn-success mr-2">Save</button>
                            <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
                            <button type="button" class="btn btn-default" id="closeEditBtn">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Controls -->
<div class="page-sub-header mt-3">
    <h3>Attributes List</h3>
    <div class="action-btns">
        <button class="btn btn-primary" onclick="toggleView('create')"><i class="fas fa-plus"></i> Create</button>
    </div>
</div>

<!-- List View -->
<div class="card page-list-panel" id="attribute-list-view">
    <div class="card-body">
        <table id="attributeTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Attribute</th>
                    <th>Type</th>
                    <th>Default</th>
                    <th>Required</th>
                    <th>Status</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        const table = $('#attributeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.master.inventory.product-attributes.index') }}',
            columns: [
                { data: 'product_attribute_id' },
                { data: 'name' },
                { data: 'data_type' },
                { data: 'default_value' },
                { data: 'is_required', render: d => d == 1 ? 'Yes' : 'No' },
                { data: 'status', render: d => d == 1 ? 'Active' : 'Inactive' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });

        $('#data_type').on('change', function () {
            const selected = $(this).val();
            const defaultField = $('#default_value');

            if (selected === 'boolean') {
                defaultField.replaceWith(`
                    <select class="form-control" name="default_value" id="default_value">
                        <option value="">-- Select --</option>
                        <option value="true">True</option>
                        <option value="false">False</option>
                    </select>
                `);
            } else if (selected === 'date') {
                defaultField.replaceWith('<input type="date" class="form-control" name="default_value" id="default_value" />');
            } else {
                defaultField.replaceWith('<input type="text" class="form-control" name="default_value" id="default_value" />');
            }
        });

        $('#cancelEditBtn').on('click', function () {
            $('#attributeForm')[0].reset();
            $('#attributeForm').attr('action', '{{ route('admin.master.inventory.product-attributes.store') }}');
            $('#attributeForm').find('input[name="_method"]').remove();
        });

        $('#closeEditBtn').on('click', function () {
            $('#attributeForm')[0].reset();
            $('#attributeForm').attr('action', '{{ route('admin.master.inventory.product-attributes.store') }}');
            $('#attributeForm').find('input[name="_method"]').remove();
            $('#attributeCreateForm').hide();
        });
    });

    function editAttribute(id) {
        $.get('/admin/master/inventory/product-attributes/' + id + '/edit', function (data) {
            $('#attributeCreateForm').slideDown();
            $('#attributeForm').attr('action', '/admin/master/inventory/product-attributes/update/' + id);
            
            if ($('#attributeForm').find('input[name="_method"]').length === 0) {
                $('#attributeForm').append('<input type="hidden" name="_method" value="PUT">');
            } else {
                $('#attributeForm').find('input[name="_method"]').val('PUT');
            }

            $('input[name="name"]').val(data.name);
            $('#data_type').val(data.data_type).trigger('change');
            $('#default_value').val(data.default_value);
            $('select[name="is_required"]').val(data.is_required);
        });
    }

    function toggleView(view) {
        if (view === 'create') {
            $('#attributeCreateForm').slideDown();
        }
    }
</script>
@stop
