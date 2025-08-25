@extends('adminlte::page')

@section('title', 'Chart of Accounts')

@section('content_header')
    <h1>Chart of Accounts</h1>
@endsection

@section('content')
    <!-- Toggle between Views -->
    <div class="page-sub-header">
        <h3>List</h3>
    </div>

    <!-- Quick Filter -->
    <div class="page-quick-filter">
        <div class="row">
            <div class="col-md-1 fltr-title">
                <span>FILTER BY</span>
            </div>
            <div class="col-md-3 input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon"><i class="fas fa-search fa-lg"></i></span>
                </div>
                <input type="text" id="searchQuery" class="form-control pq-fltr-input" placeholder="Type here" >
            </div>
            <div class="col-md-1 input-group">
                <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" onclick="searchAccount()"/>
            </div>
        </div>
    </div>

    <div class="card page-list-panel" >
        <div class="card-body" >

            <div id="finderTree" class="chartOfAccountPanel" >

                <!-- Level 1 -->
                <div class="ca-col" id="level1Column">
                    <div class="ca-col-header" >
                        <h5>Level 1
                            <!-- <button class="btn btn-sm btn-create" onclick="openForm('level1')">+ Add</button> -->
                        </h5>
                    </div>
                    <ul>
                        @foreach($level1s as $level1)
                            <li id="ca-ul-li-{{$level1->level_1_id}}" >
                                <a href="javascript:void(0)" onclick="loadLevel2({{ $level1->level_1_id }})" >
                                    <i class="fas fa-folder" ></i> {{ $level1->description }} <span>Code : {{ $level1->code }}</span>
                                </a>
                                <button class="btn btn-sm btn-warning btn-edit" onclick="editItem('level1', {{ $level1->level_1_id }})" title="Edit" >
                                    <i class="fas fa-pen"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Level 2 and onward columns -->
                <div class="ca-col" id="dynamicColumns" ></div>

                <!-- Level 3 explicitly (optional) -->
                <div class="ca-col" id="level3-column" ></div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="accountModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit</h5>
                    <button type="button" class="btn btn-sm btn-close" data-dismiss="modal" >&times;</button>
                </div>
                <form id="accountForm">
                    @csrf
                    <input type="hidden" name="type">
                    <input type="hidden" name="account_id">
                    <input type="hidden" name="level1_id">
                    <input type="hidden" name="level2_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('css')
<style>
    .chartOfAccountPanel { display:flex; }
    .chartOfAccountPanel .ca-col { width:33.33%; float:left; border:1px solid #CCC; margin-left:-1px; }
    .chartOfAccountPanel .ca-col-header { margin:0; padding:15px; min-height:62px; background-color:#1b5f76; color:#fff; font-size:16px; }
    .chartOfAccountPanel .ca-col-header h5 { margin:0; padding:0; font-size:16px; }
    .chartOfAccountPanel .ca-col-header button { float:right; }
    .chartOfAccountPanel ul { list-style-type:none; margin:0; padding:0; }
    .chartOfAccountPanel ul li { margin:0; padding:0; border-bottom:1px solid #CCC; position:relative; }
    .chartOfAccountPanel ul li a { color:#000; font-size:16px; padding:5px 10px; width: 100%; display: block; }
    .chartOfAccountPanel ul li a i { margin-right:5px; color:#333; }
    .chartOfAccountPanel ul li a span { font-size:12px; display:block; }
    .chartOfAccountPanel ul li .btn-edit { font-size:12px; float:right; position:absolute; top:4px; right:4px; }
    .chartOfAccountPanel ul li.active { background-color:#dbdfe0; color:#000; }
    .chartOfAccountPanel ul li:hover { background-color:#dbdfe0; color:#000; } 
</style>
@endpush

@push('js')
<script>
function loadLevel2(level1_id) {
    
    $('#ca-ul-li-'+level1_id).closest('ul').find('li a i.fa-folder-open').removeClass('fa-folder-open').addClass('fa-folder');
    $('#ca-ul-li-'+level1_id+' i').removeClass('fa-folder').addClass('fa-folder-open');
    
    $('#ca-ul-li-'+level1_id).closest('ul').find('li').removeClass('active');
    $('#ca-ul-li-'+level1_id).addClass('active');

    $.get("{{ route('admin.master.accounting.chart-of-account.level2') }}", { level1_id }, function(html) {
        $('#dynamicColumns').html(html);
    });
}

function loadAccounts(level2_id) {
    $('#ca-ul-li-l2-'+level2_id).closest('ul').find('li').removeClass('active');
    $('#ca-ul-li-l2-'+level2_id).addClass('active');

    $.get("{{ route('admin.master.accounting.chart-of-account.accounts') }}", { level2_id }, function(html) {
        $('#level3-column').html(html);
    });
}

function openForm(type, level1Id = null, level2Id = null) {
    $('#accountForm')[0].reset();
    $('#accountForm input[name=type]').val(type);
    $('#accountForm input[name=level1_id]').val(level1Id);
    $('#accountForm input[name=level2_id]').val(level2Id);
    $('#accountModal').modal('show');
}

function editItem(type, id) {
    $.get("{{ url('admin/master/accounting/chart-of-account/edit') }}/" + type + "/" + id, function(data) {
        $('#accountForm input[name=type]').val(type);
        $('#accountForm input[name=name]').val(data.name);
        $('#accountForm input[name=code]').val(data.code);
        if(type=='level1' || type == 'account' || type == 'level2') {
            $('#accountForm input[name=level1_id]').val(data.level_1_id);
        }
        if(type == 'account') {
            $('#accountForm input[name=account_id]').val(data.account_id);
        }
        if(type == 'account') {
            $('#accountForm input[name=level2_id]').val(data.level_2_id);
        }
        $('#accountModal').modal('show');
    });
}

$('#accountForm').on('submit', function(e) {
    e.preventDefault();
    $.post("{{ route('admin.master.accounting.chart-of-account.store') }}", $(this).serialize(), function() {
        location.reload(); // or refresh specific column
    });
});

function searchAccount() {
    const q = $('#searchQuery').val();
    if (!q) return;

    $.get("{{ route('admin.master.accounting.chart-of-account.search') }}", { q }, function(data) {
        if (data.found) {
            // Step 1: Load Level 2 for this Level 1
            loadLevel2(data.level1_id);

            // Wait for level 2 to load before loading level 3
            setTimeout(() => {
                loadAccounts(data.level2_id);

                // Wait again before highlighting
                setTimeout(() => {
                    highlightAccount(data.account_id);
                }, 500);
            }, 500);
        } else {
            alert("No account found matching: " + q);
        }
    });
}

function highlightAccount(account_id) {
    const selector = `[data-account-id="${account_id}"]`;
    const el = $(selector);
    if (el.length) {
        el.addClass('bg-warning');
        el[0].scrollIntoView({ behavior: "smooth", block: "center" });
        setTimeout(() => el.removeClass('bg-warning'), 3000);
    }
}

</script>
@endpush
