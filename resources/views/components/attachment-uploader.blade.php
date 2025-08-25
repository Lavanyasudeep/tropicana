<div class="card mb-4">
    <div class="card-body">
        <h6 class="mb-3">Upload Attachments</h6>
        <div class="mb-3">
            <input 
                type="file" 
                id="filepond-{{ $tableName }}-{{ $rowId }}" 
                name="attachments[]" 
                multiple >
        </div>

        <hr>

        <div id="attachment-list-{{ $tableName }}-{{ $rowId }}">
            <p class="text-muted">Loading attachments...</p>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginFileValidateSize,
        FilePondPluginImagePreview
    );

    const pond = FilePond.create(
        document.querySelector('#filepond-{{ $tableName }}-{{ $rowId }}'),
        {
            allowMultiple: true,
            maxFileSize: '5MB',
            server: {
                process: {
                    url: '{{ route("admin.attachments.upload") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    ondata: (formData) => {
                        formData.append('table_name', '{{ $tableName }}');
                        formData.append('row_id', '{{ $rowId }}');
                        return formData;
                    }
                }
            },
            labelIdle: `Drag & Drop your files or <span class="filepond--label-action">Browse</span>`,
            instantUpload: true
        }
    );

    pond.on('processfile', () => loadAttachments());

    const listId = '#attachment-list-{{ $tableName }}-{{ $rowId }}';

    function loadAttachments() {
        $.get('{{ route("admin.attachments.list") }}', {
            table_name: '{{ $tableName }}',
            row_id: '{{ $rowId }}'
        }, function(data) {
            if (data.length === 0) {
                $(listId).html('<p class="text-muted">No attachments uploaded yet.</p>');
                return;
            }

            let html = '<ul class="list-group">';
            data.forEach(function(item) {
                html += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="/storage/${item.file_name}" target="_blank">${item.file_name.split('/').pop()}</a>
                        <button class="btn btn-sm btn-danger" data-id="${item.attachment_id}">Delete</button>
                    </li>
                `;
            });
            html += '</ul>';
            $(listId).html(html);
        });
    }

    $(document).on('click', `${listId} .btn-danger`, function() {
        const id = $(this).data('id');
        if (!confirm('Delete this attachment?')) return;

        $.ajax({
            url: `/admin/attachments/${id}`,
            method: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: loadAttachments
        });
    });

    loadAttachments();
});
</script>
@endpush
