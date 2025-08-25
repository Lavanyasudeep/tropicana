@extends('adminlte::page')

@section('title', 'Chart of Accounts')

@section('content_header')
    <h1>Chart of Accounts</h1>
@endsection

@section('content')
<!-- Toggle between Views -->
<!-- <div class="page-sub-header">
    <h3></h3>
</div> -->

<div class="card page-list-panel" style="margin-top:15px;" >
    <div class="card-body" >

        <div id="chart-tree">
            <ul>
                @foreach($level1s as $level1)
                <li>
                    <strong>{{ $level1->description }}</strong>
                    <button class="btn btn-xs btn-default ca-btn-add" onclick="openForm('level2', {{ $level1->level_1_id }}, 0)"><i class="fa fa-plus" ></i> Add Child</button>
                    <button class="btn btn-xs btn-default ca-btn-edit" onclick="editAccount('level1', {{ $level1->level_1_id }})"><i class="fa fa-pen" ></i> Edit</button>
                    <button class="btn btn-xs btn-default ca-btn-view-sub" ><i class="fa fa-angle-down" ></i></button>
                    <ul>
                        @foreach($level1->level2s as $level2)
                        <li>
                            <strong>{{ $level2->description }}</strong>
                            <button class="btn btn-xs btn-default ca-btn-add" onclick="openForm('account', {{ $level2->level_1_id }}, {{ $level2->level_2_id }})"><i class="fa fa-plus" ></i> Add Child</button>
                            <button class="btn btn-xs btn-default ca-btn-edit" onclick="editAccount('level2', {{ $level2->level_2_id }})"><i class="fa fa-pen" ></i> Edit</button>
                            <button class="btn btn-xs btn-default ca-btn-view-sub" ><i class="fa fa-angle-down" ></i></button>
                            <ul>
                                @foreach($level2->accounts as $acc)
                                <li>
                                    {{ $acc->account_name }}
                                    <button class="btn btn-xs btn-default ca-btn-edit" onclick="editAccount('account', {{ $acc->account_id }})"><i class="fa fa-pen" ></i> Edit</button>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="accountModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="accountForm" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Account</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="ca_form_type" id="ca_form_type">
                <input type="hidden" name="account_id" id="account_id">
                <input type="hidden" name="level_1_id" id="level_1_id">
                <input type="hidden" name="level_2_id" id="level_2_id">

                <div class="form-group">
                    <label for="account_name">Account Name</label>
                    <input type="text" name="account_name" id="account_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="account_code">Account Code</label>
                    <input type="text" name="account_code" id="account_code" class="form-control">
                </div>
                <!-- Add other fields like is_cash_or_bank, etc. -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-save">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection

@push('css')
<style>
    #chart-tree { margin-top:10px; }
    #chart-tree ul {  }
    #chart-tree ul li { margin-bottom:8px; font-size:14px; }
    #chart-tree ul li ul { display:none; }
    #chart-tree ul li strong { margin-bottom:5px; font-size:14px; display: inline-block; margin-right:10px; }
    #chart-tree ul li .ca-btn-add { visibility: hidden; padding:2px 4px; }
    #chart-tree ul li .ca-btn-edit { visibility: hidden; padding:2px 4px; }
    #chart-tree ul li .ca-btn-view-sub { visibility: hidden; padding:2px 4px; }
    #chart-tree ul li .ca-btn-add i { margin-right:3px; }
    #chart-tree ul li .ca-btn-edit i { margin-right:3px; }

    #chart-tree ul li:hover>button.ca-btn-add { visibility:visible; }
    #chart-tree ul li:hover>button.ca-btn-edit { visibility:visible; }
    #chart-tree ul li:hover>button.ca-btn-view-sub { visibility:visible; }

    .ca-btn-add { font-size:12px; }
    .ca-btn-edit { font-size:12px; }
    .ca-btn-add i { font-size:12px; }
    .ca-btn-edit i { font-size:12px; }
</style>
@endpush

@push('js')
<script>
function openForm(type, level_1_id, level_2_id) {
    $('#accountModal').find('.modal-title').text('Create');
    $('#accountForm')[0].reset();
    $('#account_id').val('');
    $('#level_1_id').val(0);
    $('#level_2_id').val(0);
    $('#ca_form_type').val(type);
    if(type === 'level2') {
        $('#level_1_id').val(level_1_id);
        $('#level_2_id').val(0);
    } else if(type === 'account') {
        $('#level_1_id').val(level_1_id);
        $('#level_2_id').val(level_2_id);
    }
    $('#accountModal').modal('show');
}

function editAccount(type, id) {
    $('#accountModal').find('.modal-title').text('Edit');
    $('#ca_form_type').val(type);
    $.get("{{ url('admin/master/accounting/chart-of-account') }}/edit/" + type + "/" + id, function(data) {
        $('#account_id').val(data.account_id);
        $('#account_name').val(data.account_name);
        $('#account_code').val(data.account_code);
        $('#level_1_id').val(data.level_1_id);
        $('#level_2_id').val(data.level_2_id);
        $('#accountModal').modal('show');
    });
}

$('#chart-tree ul li .ca-btn-view-sub').on('click', function(e) {
    e.preventDefault();
    if($(this).find('i').hasClass('fa-angle-down')) {
        $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
        $(this).closest('li').find('ul:first').show();
    } else {
        $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
        $(this).closest('li').find('ul:first').hide();
    }
});

$('#accountForm').on('submit', function(e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.ajax({
        url: "{{ route('admin.master.accounting.chart-of-account.store') }}",
        method: "POST",
        data: formData + "&_token=" + $('meta[name="csrf-token"]').attr('content'), // ✅ append CSRF token
        success: function(response) {
            location.reload();
        }
    });
});
</script>
@endpush
