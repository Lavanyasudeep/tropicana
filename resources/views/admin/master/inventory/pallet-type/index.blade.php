@extends('adminlte::page')

@section('title', 'Pallet Type Master')

@section('content_header')
    <h1>Manage Pallet Types</h1>
@stop

@section('content')

<div class="row" id="palletTypeCreateForm" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Add / Edit Pallet Type</h3>
            </div>
            <div class="card-body">
                <form id="palletTypeForm" action="{{ route('admin.master.inventory.pallet-type.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Type Name</label>
                            <input type="text" class="form-control" name="type_name" required>
                        </div>
                        <div class="col-md-8">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
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
    <h3>Pallet Type List</h3>
    <div class="action-btns">
        <button class="btn btn-create" onclick="toggleView('create')"><i class="fas fa-plus"></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')"><i class="fas fa-list"></i> List View</button>
    </div>
</div>

<!-- List View -->
<div id="palletType-list-view" class="card page-list-panel">
    <div class="card-body">
        <table id="palletTypeTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type Name</th>
                    <th>Description</th>
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
    $(function() {
        const table = $('#palletTypeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.master.inventory.pallet-type.index') }}',
            columns: [
                { data: 'pallet_type_id', name: 'pallet_type_id' },
                { data: 'type_name', name: 'type_name' },
                { data: 'description', name: 'description' },
                { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[0, 'desc']]
        });

        $(document).on("click", ".edit-btn", function () {
            const id = $(this).data('id');
            $('input[name="type_name"]').val($(this).data('type-name'));
            $('input[name="description"]').val($(this).data('description'));

            const form = $('#palletTypeForm');
            form.attr('action', '/admin/master/inventory/pallet-type/update/' + id);
            if (!form.find('input[name="_method"]').length) {
                form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $('#palletTypeCreateForm').show();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        $("#cancelEditBtn, #closeEditBtn").click(function () {
            const form = $('#palletTypeForm');
            form[0].reset();
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.inventory.pallet-type.store') }}");
            $('#palletTypeCreateForm').hide();
        });

        $('#palletTypeTable').on('click', '.toggle-status', function () {
            const button = $(this);
            const id = button.data('id');

            $.post('{{ route('admin.master.inventory.pallet-type.toggle-status') }}', {
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
            $('#palletTypeCreateForm').show();
        } else {
            $('#palletTypeCreateForm').hide();
        }
    }
</script>
@stop
