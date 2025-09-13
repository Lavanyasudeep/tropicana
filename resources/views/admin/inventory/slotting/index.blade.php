@extends('adminlte::page')

@section('title', 'Slotting')

@section('content_header')
    <h1>Slotting</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>Slotting</h3>
</div>

<!-- Advance Filter -->
<div class="page-advance-filter" id="putAwayAdvFilterPanel" >
    <form id="putAwayAdvFilterForm" >
        <div class="row">
            <div class="col-md-3" >

            </div>
            <div class="col-md-3 btn-group" role="group" >
                <button type="submit" class="btn btn-success" id="applyAdvFilter" >Filter</button>
                <button type="button" class="btn btn-secondary" id="cancelFltrBtn" >Cancel</button>
                <button type="button" class="btn btn-light" id="closeFltrBtn" >Close</button>
            </div>
        </div>
    </form>
</div>

<!-- Quick Filter -->
<div class="page-quick-filter">
    <div class="row">
        <div class="col-md-1 fltr-title">
            <span>FILTER BY</span>
        </div>
        <div class="col-md-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text pq-fltr-icon" ><i class="fas fa-chevron-down"></i></span>
                </div>
                <select id="clientFlt" class="form-control pq-fltr-select">
                    <option value="">- All Customer -</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->client_id }}">{{ $client->client_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-1">
            <div class="input-group">
                <input type="button" id="fltrSearchBtn" value="Search" class="btn btn-quick-filter-search" />
            </div>
        </div>
    </div>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <div>
      <label class="mb-0 mr-2">Warehouse :</label>
      <ul class="nav nav-tabs d-inline-flex" role="tablist" id="warehouseTabs">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#ca" role="tab">WU-0001</a>
        </li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cb" role="tab">WU-0002</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cc" role="tab">WU-0003</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cd" role="tab">WU-0004</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ce" role="tab">WU-0005</a></li>
      </ul>
    </div>
  </div>

  <div class="card-body tab-content" id="warehouseContent">
    <div class="tab-pane fade show active" id="ca">

        <div class="row">
            <!-- Pallet list -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <strong>Pallets</strong>
                        <input id="palletSearch" class="form-control form-control-sm mt-2" placeholder="Search pallet...">
                    </div>
                    <div class="card-body pallet-list" id="palletList"></div>
                </div>
            </div>

            <!-- Chamber view -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <label>Chamber :</label>
                        <ul class="nav nav-tabs d-inline-flex" role="tablist" id="chamberTabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#ca" role="tab">CR-101</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cb" role="tab">CR-102</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cc" role="tab">CR-103</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cd" role="tab">CR-104</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ce" role="tab">CR-105</a></li>
                        </ul>
                    </div>
                    <div class="card-body racks-grid" id="racksGrid"></div>
                </div>
            </div>
        
        </div>
    </div>
    <!-- Repeat .tab-pane for C-B, C-C, etc. -->
  </div>
</div>

<input type="hidden" id="assignments" name="assignments" value="[]">

<style>
.card-header {
    background-color: #b4c8b5;
    padding-bottom: 0;
}

.card-header-tabs .nav-link {
  padding: 6px 14px;
  font-weight: 500;
  color: #495057;
}

.card-header-tabs .nav-link.active {
  background-color: #f8f9fa;
  border-color: #dee2e6 #dee2e6 #fff;
}

#warehouseTabs, #chamberTabs {
  border-bottom: none;
}

#chamberTabs .nav-link, #warehouseTabs .nav-link { color:#000; }

#warehouseTabs .nav-tabs .nav-link a,
#chamberTabs .nav-tabs .nav-link a { color:#CCC !important; }

/* Chamber label tweak */
#warehouseTabs > label, #chamberTabs > label {
  padding: 7px 15px 0 0;
  font-size: 14px;
}

/* Pallet list */
.pallet-list {
  min-height: 50vh;
  overflow-y: auto;
}
.pallet-item {
  padding: 8px;
  border: 1px solid #ccc;
  margin-bottom: 6px;
  border-radius: 4px;
  background: #e8f8ea;
  cursor: grab;
  font-size: 11px;
  transition: background-color 0.15s ease;
}
.pallet-item:hover {
  background-color: #506c52;
  color: white;
}
.pallet-item.assigned {
  opacity: 0.4;
  font-style: italic;
}
#palletList .pallet-item small {
  font-size: 11px !important;
}

/* Racks grid */
.racks-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
}
.rack {
  border: 1px solid #ddd;
  border-radius: 6px;
  background: #fff;
  display: flex;
  flex-direction: column;
}
.rack-header {
  background: #506c52;
  padding: 4px;
  font-weight: bold;
  text-align: center;
  color: white;
}
.rack-body {
  flex: 1;
  display: grid;
  grid-template-rows: repeat(4, 1fr) auto;
}

.level-label {
  display: block;
  align-items: center;
  justify-content: center;
  font-size: 10px;
  background: #9cbaa1;
  color: white;
  min-height: 36px; 
  width: 12%;
  text-align:center;
  float:left;
  padding-top:10px;
}
.slot {
  border: 1px solid #CCC;
  border-right: 1px solid #ffffff;
  border-left:-1px;
  display: block;
  align-items: center;
  justify-content: center;
  font-size: 9px;         /* slightly smaller font */
  min-height: 36px;       /* reduced height */
  width: 22%;        /* reduced width */
  padding: 2px;
  float:left;
}
.slot.occupied {
  border-color: #af4c4c;
  background: #f1dbdb;
}
.slot.hover {
  border-color: #0d6efd;
  background: #eef5ff;
}

.depth-label {
  font-size: 9px;
  text-align: center;
  padding:4px 0;
  width: 22%; 
  float:right;
}

.depth-row {
   background-color: #9cbaa1;
  color: white;
}

</style>

<script>
const pallets = [
    { pallet_no: 'PAL-0001', product: 'RED JOANPRINCE SMALL', lot: 'LOT001', size: '1L' },
    { pallet_no: 'PAL-0002', product: 'RED JOANPRINCE SMALL', lot: 'LOT001', size: '1L' },
    { pallet_no: 'PAL-0003', product: 'RED JOANPRINCE SMALL', lot: 'LOT001', size: '1L' },
    { pallet_no: 'PAL-0004', product: 'RED JOANPRINCE SMALL', lot: 'LOT001', size: '1L' },
    { pallet_no: 'PAL-0005', product: 'GREEN EMERALD LARGE', lot: 'LOT010', size: '500ml' },
    { pallet_no: 'PAL-0006', product: 'GREEN EMERALD LARGE', lot: 'LOT010', size: '500ml' },
    { pallet_no: 'PAL-0007', product: 'GREEN EMERALD LARGE', lot: 'LOT010', size: '500ml' }
];
const racks = Array.from({length: 8}, (_, i) => `R${i+1}`);
const levels = ['L4','L3','L2','L1'];
const depths = ['D1','D2','D3','D4'];

const palletToSlot = new Map();
const slotToPallet = new Map();

function renderPalletList() {
    const list = document.getElementById('palletList');
    const q = (document.getElementById('palletSearch').value || '').toLowerCase();
    list.innerHTML = '';
    pallets.forEach(p => {
        if(q && !(`${p.pallet_no} ${p.product} ${p.lot}`.toLowerCase().includes(q))) return;
        const assigned = palletToSlot.has(p.pallet_no);
        const div = document.createElement('div');
        div.className = `pallet-item ${assigned ? 'assigned' : ''}`;
        div.draggable = true;
        div.dataset.palletNo = p.pallet_no;
        div.innerHTML = `<strong>${p.pallet_no}</strong><br><small>${p.product} • ${p.lot} • ${p.size}</small>`;
        div.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', p.pallet_no);
        });
        list.appendChild(div);
    });
}

function renderRacks() {
    const grid = document.getElementById('racksGrid');
    grid.innerHTML = '';
    racks.forEach(rackId => {
        const rackEl = document.createElement('div');
        rackEl.className = 'rack';
        rackEl.innerHTML = `<div class="rack-header">Rack: ${rackId}</div>`;
        const body = document.createElement('div');
        body.className = 'rack-body';

        // Levels with slots
        levels.forEach(level => {
            const row = document.createElement('div');
            row.className = 'rack-row';
            const lvlLabel = document.createElement('div');
            lvlLabel.className = 'level-label';
            lvlLabel.textContent = level;
            row.appendChild(lvlLabel);
            depths.forEach(depth => {
                const slotId = `${rackId}-${level}-${depth}`;
                const slot = document.createElement('div');
                slot.className = 'slot';
                slot.id = slotId;
                slot.addEventListener('dragover', e => { e.preventDefault(); slot.classList.add('hover'); });
                slot.addEventListener('dragleave', () => slot.classList.remove('hover'));
                slot.addEventListener('drop', e => {
                    e.preventDefault();
                    slot.classList.remove('hover');
                    const palletNo = e.dataTransfer.getData('text/plain');
                    if(slotToPallet.has(slotId)) return alert('Slot occupied');
                    assignPalletToSlot(palletNo, slotId);
                });
                row.appendChild(slot);
            });
            body.appendChild(row);
        });

        // Depth labels row at bottom
        const depthRow = document.createElement('div');
        depthRow.className = 'depth-row';
        depthRow.appendChild(document.createElement('div')); // empty corner
        depths.forEach(d => {
            const dLabel = document.createElement('div');
            dLabel.className = 'depth-label';
            dLabel.textContent = d;
            depthRow.appendChild(dLabel);
        });
        body.appendChild(depthRow);

        rackEl.appendChild(body);
        grid.appendChild(rackEl);
    });
}

function assignPalletToSlot(palletNo, slotId) {
    // Free previous slot if pallet is already assigned
    if (palletToSlot.has(palletNo)) {
        const prevSlot = palletToSlot.get(palletNo);
        freeSlot(prevSlot);
    }

    // Save the assignment in both maps
    palletToSlot.set(palletNo, slotId);
    slotToPallet.set(slotId, palletNo);

    // Mark slot visually
    const slotEl = document.getElementById(slotId);
    slotEl.classList.add('occupied');
    slotEl.textContent = palletNo;

    // Update hidden field + refresh list
    updateAssignments();
    renderPalletList();
}

function freeSlot(slotId) {
    const palletNo = slotToPallet.get(slotId);
    if (!palletNo) return;
    palletToSlot.delete(palletNo);
    slotToPallet.delete(slotId);
    const slotEl = document.getElementById(slotId);
    slotEl.classList.remove('occupied');
    // Reset text back to level-depth label
    slotEl.textContent = slotId.split('-').slice(1).join('-');
}

function updateAssignments() {
    const arr = [];
    palletToSlot.forEach((slotId, palletNo) => {
        const [rack, level, depth] = slotId.split('-');
        arr.push({ pallet_no: palletNo, rack, level, depth });
    });
    document.getElementById('assignments').value = JSON.stringify(arr);
}

document.getElementById('palletSearch').addEventListener('input', renderPalletList);

renderPalletList();
renderRacks();
</script>
@endsection