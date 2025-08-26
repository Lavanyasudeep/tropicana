@extends('adminlte::page')

@section('title', 'Put Away')

@section('content_header')
    <h1>Put Away</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>Put Away</h3>
</div>

<div class="row">
  <!-- Pallet List -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <strong>Pallets</strong>
        <input id="palletSearch" class="form-control form-control-sm mt-2" placeholder="Search pallet...">
      </div>
      <div class="card-body pallet-list" id="palletList"></div>
    </div>
  </div>

  <!-- Room Visualization -->
  <div class="col-md-8">
    <div class="card">
      <div class="card-header"><strong>Room Visualization</strong></div>
      <div class="card-body racks-grid" id="racksGrid"></div>
    </div>
  </div>
</div>

<input type="hidden" id="assignments" name="assignments" value="[]">

<style>
  .pallet-list {
  max-height: 75vh;
  overflow-y: auto;
}
.pallet-item {
  padding: 8px;
  border: 1px solid #ccc;
  margin-bottom: 6px;
  border-radius: 4px;
  background: #f8f9fa;
  cursor: grab;
}
.pallet-item.assigned {
  opacity: 0.6;
}
.racks-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
}
.rack {
  border: 1px solid #ddd;
  border-radius: 6px;
}
.rack-header {
  background: #f5f5f5;
  padding: 4px;
  font-weight: bold;
  text-align: center;
}
.rack-slots {
  display: grid;
  grid-template-rows: repeat(4, 1fr);
  gap: 6px;
  padding: 6px;
}
.rack-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 6px;
}
.slot {
  border: 1px dashed #aaa;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  background: #fff;
}
.slot.occupied {
  border: 1px solid #4caf50;
  background: #e8f5e9;
}
.slot.hover {
  border-color: #0d6efd;
  background: #eef5ff;
}

</style>
<script>
  // Dummy pallets (use your existing array in PHP if you prefer)
  const pallets = [
    { pallet_no: 'P-1-1', product: 'RED JOANPRINCE SMALL', lot: 'LOT001', size: '1L', packages: 100 },
    { pallet_no: 'P-1-2', product: 'RED JOANPRINCE SMALL', lot: 'LOT001', size: '1L', packages: 100 },
    { pallet_no: 'P-1-3', product: 'RED JOANPRINCE SMALL', lot: 'LOT001', size: '1L', packages: 100 },
    { pallet_no: 'P-1-4', product: 'RED JOANPRINCE SMALL', lot: 'LOT001', size: '1L', packages: 100 },
    { pallet_no: 'P-1-5', product: 'RED JOANPRINCE SMALL', lot: 'LOT001', size: '1L', packages: 100 },
    { pallet_no: 'P-2-1', product: 'GREEN EMERALD LARGE', lot: 'LOT010', size: '500ml', packages: 200 },
    { pallet_no: 'P-2-2', product: 'GREEN EMERALD LARGE', lot: 'LOT010', size: '500ml', packages: 200 },
    { pallet_no: 'P-2-3', product: 'GREEN EMERALD LARGE', lot: 'LOT010', size: '500ml', packages: 200 },
    { pallet_no: 'P-2-4', product: 'GREEN EMERALD LARGE', lot: 'LOT010', size: '500ml', packages: 200 }
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
    div.innerHTML = `<strong>${p.pallet_no}</strong><br><small>${p.product} • ${p.lot} • ${p.size} • ${p.qty}</small>`;
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
    rackEl.innerHTML = `<div class="rack-header">${rackId}</div>`;
    const slotsWrap = document.createElement('div');
    slotsWrap.className = 'rack-slots';
    levels.forEach(level => {
      const row = document.createElement('div');
      row.className = 'rack-row';
      depths.forEach(depth => {
        const slotId = `${rackId}-${level}-${depth}`;
        const slotEl = document.createElement('div');
        slotEl.className = 'slot';
        slotEl.id = slotId;
        slotEl.textContent = `${level}-${depth}`;
        slotEl.addEventListener('dragover', e => { e.preventDefault(); slotEl.classList.add('hover'); });
        slotEl.addEventListener('dragleave', () => slotEl.classList.remove('hover'));
        slotEl.addEventListener('drop', e => {
          e.preventDefault();
          slotEl.classList.remove('hover');
          const palletNo = e.dataTransfer.getData('text/plain');
          if(slotToPallet.has(slotId)) return alert('Slot occupied');
          assignPalletToSlot(palletNo, slotId);
        });
        row.appendChild(slotEl);
      });
      slotsWrap.appendChild(row);
    });
    rackEl.appendChild(slotsWrap);
    grid.appendChild(rackEl);
  });
}

function assignPalletToSlot(palletNo, slotId) {
  if(palletToSlot.has(palletNo)) {
    const prevSlot = palletToSlot.get(palletNo);
    freeSlot(prevSlot);
  }
  palletToSlot.set(palletNo, slotId);
  slotToPallet.set(slotId, palletNo);
  const slotEl = document.getElementById(slotId);
  slotEl.classList.add('occupied');
  slotEl.textContent = palletNo;
  updateAssignments();
  renderPalletList();
}

function freeSlot(slotId) {
  const palletNo = slotToPallet.get(slotId);
  if(!palletNo) return;
  palletToSlot.delete(palletNo);
  slotToPallet.delete(slotId);
  const slotEl = document.getElementById(slotId);
  slotEl.classList.remove('occupied');
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