@extends('adminlte::page')

@section('title', 'Units')

@section('content_header')
    <h1>Manage Units</h1>
@stop

@section('content')
<div class="row" id="unitCreateForm" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="card-title">Add / Edit Unit</h3>
            </div>
            <div class="card-body">
                <form id="unitForm" action="{{ route('admin.master.general.unit.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Unit Name</label>
                            <input type="text" class="form-control" name="unit" required>
                        </div>
                        <div class="col-md-4">
                            <label>Short Name</label>
                            <input type="text" class="form-control" name="short_name">
                        </div>
                        <div class="col-md-4">
                            <label>Symbol/Sign</label>
                            <input type="text" class="form-control" name="sign">
                        </div>
                        <div class="col-md-4 mt-2">
                            <label>Conversion Unit</label>
                            <input type="text" class="form-control" name="conversion_unit" required>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label>Conversion Quantity</label>
                            <input type="text" class="form-control" name="conversion_quantity">
                        </div>
                        <div class="col-md-4 mt-2">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description">
                        </div>
                        <div class="col-md-4 mt-3">
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

<!-- Action buttons -->
<div class="page-sub-header">
    <h3>Tax List</h3>
    <div class="action-btns" >
        <button class="btn btn-create" onclick="toggleView('create')"><i class="fas fa-plus" ></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')"><i class="fas fa-list" ></i> List View</button>
    </div>
</div>

<!-- List View -->
<div id="tax-list-view" class="card page-list-panel" >
    <div class="card-body">
        <table id="unitTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Unit</th>
                    <th>Short Name</th>
                    <th>Conversion Unit</th>
                    <th>Sign</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(function () {
    let table = $('#unitTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.master.general.unit.index') }}",
        columns: [
            { data: 'unit_id', name: 'unit_id' },
            { data: 'unit', name: 'unit' },
            { data: 'short_name', name: 'short_name' },
            { data: 'conversion_unit', name: 'conversion_unit' },
            { data: 'sign', name: 'sign' },
            { data: 'active', name: 'active' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    $(document).on("click", ".edit-btn", function () {
        const id = $(this).data('id');

        // Fill form fields
        $('input[name="unit"]').val($(this).data('unit'));
        $('input[name="short_name"]').val($(this).data('short-name'));
        $('input[name="sign"]').val($(this).data('sign'));
        $('input[name="conversion_unit"]').val($(this).data('conversion-unit'));
        $('input[name="conversion_quantity"]').val($(this).data('conversion-quantity'));
        $('input[name="description"]').val($(this).data('description'));

        // Change form action and method for update
        const form = $('form');
        form.attr('action', '/admin/master/general/unit/update/' + id);
        if (form.find('input[name="_method"]').length === 0) {
            form.append('<input type="hidden" name="_method" value="PUT">');
        } else {
            form.find('input[name="_method"]').val('PUT');
        }

        // Optionally scroll to form
        window.scrollTo({ top: 0, behavior: 'smooth' });
        document.getElementById('unitCreateForm').style.display = 'block';
    });

    $(document).on("click", "#cancelEditBtn", function () {
        const form = $('#unitForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('input[name="_method"]').remove();
        form.attr('action', "{{ route('admin.master.general.unit.store') }}");
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    $(document).on("click", "#closeEditBtn", function () {
        const form = $('#unitForm');
        form.find('input[type="text"], input[type="number"]').val('');
        form.find('input[name="_method"]').remove();
        form.attr('action', "{{ route('admin.master.general.unit.store') }}");
        document.getElementById('unitCreateForm').style.display = 'none';
    });

    $('#unitTable').on('click', '.toggle-status', function () {
        const button = $(this);
        const id = button.data('id');

        $.post('{{ route('admin.master.general.unit.toggle-status') }}', {
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
    if (view === 'create') {
        $('#unitCreateForm').show();
    } else {
        $('#unitCreateForm').hide();
    }
}
</script>
@stop
