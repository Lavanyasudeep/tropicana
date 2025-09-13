@extends('adminlte::page')

@section('title', 'Location Master')

@section('content_header')
    <h1>Manage Regional Locations</h1>
@stop

@section('content')

<!-- Create/Edit Form -->
<div class="row" id="locationCreateForm" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Add / Edit Location</h3>
            </div>
            <div class="card-body">
                <form id="locationForm" action="{{ route('admin.master.general.location.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Location Code</label>
                            <input type="text" class="form-control" name="location_code" required placeholder="e.g. TVM">
                        </div>
                        <div class="col-md-8">
                            <label>Location Name</label>
                            <input type="text" class="form-control" name="location_name" required placeholder="e.g. Thiruvananthapuram">
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
    <h3>Location List</h3>
    <div class="action-btns">
        <button class="btn btn-create" onclick="toggleView('create')"><i class="fas fa-plus"></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')"><i class="fas fa-list"></i> List View</button>
    </div>
</div>

<!-- List View -->
<div id="location-list-view" class="card page-list-panel">
    <div class="card-body">
        <table id="locationTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Location Code</th>
                    <th>Location Name</th>
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
    $(document).ready(function() {
    
        const table = $('#locationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.master.general.location.index') }}',
            columns: [
                { data: 'location_id', name: 'location_id' },
                { data: 'location_code', name: 'location_code' },
                { data: 'location_name', name: 'location_name' },
                { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[0, 'desc']]
        });

        $(document).on("click", ".edit-btn", function () {
            const id = $(this).data('id');

            $('input[name="location_code"]').val($(this).data('code'));
            $('input[name="location_name"]').val($(this).data('name'));

            const form = $('#locationForm');
            form.attr('action', '/admin/master/general/location/update/' + id);
            if (!form.find('input[name="_method"]').length) {
                form.append('<input type="hidden" name="_method" value="PUT">');
            } else {
                form.find('input[name="_method"]').val('PUT');
            }

            $('#locationCreateForm').show();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        $("#cancelEditBtn, #closeEditBtn").click(function () {
            const form = $('#locationForm');
            form[0].reset();
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.general.location.store') }}");
            $('#locationCreateForm').hide();
        });

        $('#locationTable').on('click', '.toggle-status', function () {
            const button = $(this);
            const id = button.data('id');

            $.post('{{ route('admin.master.general.location.toggle-status') }}', {
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
            $('#locationCreateForm').show();
        } else {
            $('#locationCreateForm').hide();
        }
    }
</script>
@stop
