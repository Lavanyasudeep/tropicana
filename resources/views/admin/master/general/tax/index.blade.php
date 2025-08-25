@extends('adminlte::page')

@section('title', 'Tax Master')

@section('content_header')
    <h1>Manage Tax</h1>
@stop

@section('content')

<div class="row" id="taxCreateForm" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Add / Edit Tax</h3>
            </div>
            <div class="card-body">
                <form id="taxForm" action="{{ route('admin.master.general.tax.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tax %</label>
                            <input type="number" step="0.01" class="form-control" name="tax_per" required>
                        </div>
                        <div class="col-md-4">
                            <label>GST Input Account Code</label>
                            <input type="text" class="form-control" name="gst_input_account_code">
                        </div>
                        <div class="col-md-4">
                            <label>GST Output Account Code</label>
                            <input type="text" class="form-control" name="gst_output_account_code">
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
    <h3>Tax List</h3>
    <div class="action-btns" >
        <button class="btn btn-create" onclick="toggleView('create')"><i class="fas fa-plus" ></i> Create</button>
        <button class="btn btn-view" onclick="toggleView('list')"><i class="fas fa-list" ></i> List View</button>
    </div>
</div>

<!-- List View -->
<div id="tax-list-view" class="card page-list-panel" >
    <div class="card-body">
        <table id="taxTable" class="page-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tax %</th>
                    <th>GST Input</th>
                    <th>GST Output</th>
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
        const table = $('#taxTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.master.general.tax.index') }}',
            columns: [
                { data: 'tax_id', name: 'tax_id' },
                { data: 'tax_per', name: 'tax_per' },
                { data: 'gst_input_account_code', name: 'gst_input_account_code' },
                { data: 'gst_output_account_code', name: 'gst_output_account_code' },
                { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[0, 'desc']]
        });

        $(document).on("click", ".edit-btn", function () {
            const id = $(this).data('id');

            $('input[name="tax_per"]').val($(this).data('tax-per'));
            $('input[name="gst_input_account_code"]').val($(this).data('input'));
            $('input[name="gst_output_account_code"]').val($(this).data('output'));

            const form = $('#taxForm');
            form.attr('action', '/admin/master/general/tax/update/' + id);
            if (!form.find('input[name="_method"]').length) {
                form.append('<input type="hidden" name="_method" value="PUT">');
            } else {
                form.find('input[name="_method"]').val('PUT');
            }

            $('#taxCreateForm').show();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        $("#cancelEditBtn, #closeEditBtn").click(function () {
            const form = $('#taxForm');
            form[0].reset();
            form.find('input[name="_method"]').remove();
            form.attr('action', "{{ route('admin.master.general.tax.store') }}");
            $('#taxCreateForm').hide();
        });

        $('#taxTable').on('click', '.toggle-status', function () {
            const button = $(this);
            const id = button.data('id');

            $.post('{{ route('admin.master.general.tax.toggle-status') }}', {
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
            $('#taxCreateForm').show();
        } else {
            $('#taxCreateForm').hide();
        }
    }
</script>
@stop
