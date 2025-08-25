<h5 class="ca-col-header">
    Level 2 - {{ $level1->description }}
    <button class="btn btn-sm btn-create" onclick="openForm('level2', {{ $level1->level_1_id }}, null)">+ Add</button>
</h5>
<ul>
    @foreach($level2s as $level2)
    <li id="ca-ul-li-l2-{{ $level2->level_2_id }}" >
        <a href="javascript:void(0)" onclick="loadAccounts({{ $level2->level_2_id }})">
            {{ $level2->description }}<span>Code : {{ $level2->code }}</span>
        </a>
        <button class="btn btn-sm btn-warning btn-edit" onclick="editItem('level2', {{ $level2->level_2_id }})" title="Edit" >
            <i class="fas fa-pen"></i>
        </button>
    </li>
    @endforeach
</ul>