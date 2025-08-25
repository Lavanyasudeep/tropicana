<!-- resources/views/components/attachment-uploader.blade.php -->

<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-3">Upload Attachments</h5>
        <form id="attachmentForm-{{ $tableName }}-{{ $rowId }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="table_name" value="{{ $tableName }}">
            <input type="hidden" name="row_id" value="{{ $rowId }}">

            <div class="mb-3">
                <input type="file" name="attachments[]" class="form-control" multiple required>
            </div>

            <button type="submit" class="btn btn-success">
                Upload
            </button>
        </form>

        <hr>

        <div id="attachment-list-{{ $tableName }}-{{ $rowId }}">
            <p class="text-muted">Loading attachments...</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formId = '#attachmentForm-{{ $tableName }}-{{ $rowId }}';
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

    $(formId).on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("admin.attachments.upload") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                $(formId)[0].reset();
                loadAttachments();
            },
            error: function(err) {
                alert('Upload failed');
            }
        });
    });

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
