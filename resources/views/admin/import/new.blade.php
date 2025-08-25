@extends('adminlte::page')

@section('title', 'Import')

@section('content_header')
    <h1>Manage Cold Storage Data Import</h1>
@stop

@section('content')
<div class="d-flex justify-content-between align-items-center my-3">
    <h4>Import New</h4>
</div>

<div class="row">
    <!-- Left Panel -->
    <div class="col-md-3">
        <div class="card" >
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">Add Column Header</h3>
            </div>
            <div class="card-body">
                <label for="table-select">Select Table</label>
                <div class="d-flex gap-2">
                    <select name="tables[]" id="table-select" multiple class="form-control" >
                        <option value="">-- select --</option>
                        @foreach($tableNames as $table)
                            <option value="{{ $table }}">{{ ucfirst($table) }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="field-select-container" class="mt-3">
                    <!-- Will load checkboxes dynamically based on selected table -->
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">Excel Grid Preview</h3>
            </div>
            <div class="card-body">
                <!-- Action Buttons -->
                <form id="download-form" method="POST" action="{{ route('admin.bulk-import.downloadTemplate') }}">
                    @csrf
                    <input type="hidden" name="selected_fields" id="selected-fields">
                    <button class="btn btn-primary mb-2">Download</button>
                </form>

                <!-- Upload form -->
                <form method="POST" action="{{ route('admin.bulk-import.previewUpload') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="selected_fields_upload" id="selected-fields-hidden">
                    <input type="file" name="import_file" required>
                    <button class="btn btn-success">Import</button>

                    <!-- Excel Grid (Always Visible) -->
                    <table class="table table-bordered mt-3" style="overflow-y:auto; overflow-x: auto;">
                        <thead>
                            <tr id="excel-headers">
                                <th class="text-muted" colspan="5" id="default-placeholder">
                                    Select fields from left to generate Excel template.
                                </th>
                            </tr>
                        </thead>
                        <tbody id="excel-body">
                            <tr>
                                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .cursor-pointer { cursor: pointer; }
    .selected-field-item {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 15px;
    }
    #field-select-container {
        height: 300px; 
        width: 100%; 
        border: 1px solid #ccc; 
        overflow-y: auto; 
        padding: 10px;
    }
</style>
@stop

@section('js')
<script>
    let selectedFields = {};

    $(document).ready(function () {
        $('#table-select').select2({
            placeholder: "Choose a table",
            width: '100%'
        });

        const tableFields = @json($tableFields);

        // function renderFieldsUI() {
            $('#table-select').on('change', function () {
                const selectedTables = $(this).val() || [];

                let allCheckboxesHtml = '';

                selectedTables.forEach(table => {
                    const fields = tableFields[table] || [];
                    let checkboxGroup = `<div class="table-group"><strong>${table}</strong>`;

                    fields.forEach(field => {
                        checkboxGroup += `<div>
                            <input type="checkbox" class="field-checkbox" data-table="${table}" value="${field}"> ${field}
                        </div>`;
                    });

                    checkboxGroup += '</div>';
                    allCheckboxesHtml += checkboxGroup;
                });

                $('#field-select-container').html(allCheckboxesHtml);
            });

            // Handle checkbox changes
            $(document).on('change', '.field-checkbox', function () {
                const table = $(this).data('table');
                const field = $(this).val();

                if (!selectedFields[table]) {
                    selectedFields[table] = [];
                }

                if (this.checked) {
                    if (!selectedFields[table].includes(field)) {
                        selectedFields[table].push(field);
                    }
                } else {
                    selectedFields[table] = selectedFields[table].filter(f => f !== field);
                    if (selectedFields[table].length === 0) {
                        delete selectedFields[table];
                    }
                }

                $('#selected-fields').val(JSON.stringify(selectedFields));
                $('#selected-fields-hidden').val(JSON.stringify(selectedFields));

                updateExcelGrid();
            });
        // }

        function updateExcelGrid() {
            const headers = document.getElementById('excel-headers');
            const body = document.getElementById('excel-body');

            headers.innerHTML = '';
            body.innerHTML = '';

            const flatFields = Object.values(selectedFields).flat();

            if (flatFields.length === 0) {
                headers.innerHTML = `<th class="text-muted">No fields selected</th>`;
                return;
            }

            flatFields.forEach(field => {
                let th = document.createElement('th');
                th.innerText = field;
                headers.appendChild(th);
            });

            for (let i = 0; i < 4; i++) {
                let tr = document.createElement('tr');
                flatFields.forEach(() => {
                    let td = document.createElement('td');
                    td.innerHTML = '&nbsp;';
                    tr.appendChild(td);
                });
                body.appendChild(tr);
            }
        }

        // 🔥 Fix for download template
        $('#download-form').on('submit', function () {
            $('#selected-fields').val(JSON.stringify(selectedFields));
        });

        // 🔥 Fix for import file upload
        $('form[action*="previewUpload"]').on('submit', function () {
            $('#selected-fields-hidden').val(JSON.stringify(selectedFields));
        });
    });
</script>

@stop
