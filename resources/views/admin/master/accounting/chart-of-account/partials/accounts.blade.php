<h5 class="ca-col-header">
    Account - {{ $level2->description }}
    <button class="btn btn-sm btn-create" onclick="openForm('account', {{ $level2->level_1_id }}, {{ $level2->level_2_id }})">+ Add</button>
</h5>
<ul>
    @foreach($accounts as $account)
    <li>
        <a href="javascript:void(0)" >
            {{ $account->account_name }}<span>Code : {{ $account->account_code }}</span>
        </a>
        <button class="btn btn-sm btn-warning btn-edit" onclick="editItem('account', {{ $account->account_id }})" title="Edit" >
            <i class="fas fa-pen"></i>
        </button>
    </li>
    @endforeach
</ul>