@extends('adminlte::page')

@section('title', 'Create Palletization')

@section('content_header')
    <h1>Palletization</h1>
@endsection

@section('content')

<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.palletization.index') }}" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form id="palletizationForm">
            @csrf

            <!-- Header Fields -->
            <div class="row">
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:182px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc No</div>
                            <div class="pform-value">
                                <input type="text" name="doc_no" id="doc_no" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc Date</div>
                            <div class="pform-value"><input type="date" name="doc_date" value="2025-08-26"></div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Doc Time</div>
                            <div class="pform-value"><input type="time" name="doc_time" value="09:42"></div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Gatepass No.</div>
                            <div class="pform-value">
                                <select name="gatepass_no" id="gatepass_no" class="form-control">
                                    <option value="">- Select -</option>
                                    <option value="GP001">GP-001</option>
                                    <option value="GP002">GP-002</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Order/Packing List</div>
                            <div class="pform-value">
                                <select id="packingListSelect" class="form-control" readonly >
                                    <option value="">- Select -</option>
                                    <option value="PL001">PL-001</option>
                                    <option value="PL002">PL-002</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:182px;">
                        <div class="pform-row">
                            <div class="pform-label">Customer</div>
                            <div class="pform-value">
                                <input type="text" name="customer" id="customer" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Vehicle No</div>
                            <div class="pform-value">
                                <input type="text" name="vehicle_no" id="vehicle_no" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Warehouse Unit</div>
                            <div class="pform-value">
                                <input type="text" name="warehouse_unit" id="warehouse_unit" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Dock No</div>
                            <div class="pform-value">
                                <input type="text" name="dock_no" id="dock_no" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:182px;">
                        <div class="pform-row">
                            <div class="pform-label">Start Time</div>
                            <div class="pform-value"><input type="time" name="start_time" value="09:42"></div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">End Time</div>
                            <div class="pform-value"><input type="time" name="start_time" value="09:42"></div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Team</div>
                            <div class="pform-value">
                                <input type="text" name="team" id="team" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Weight of empty Pallet</div>
                            <div class="pform-value">
                                <input type="number" name="empty_pallet_weight" id="empty_pallet_weight" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Volume of Pallet(m3)</div>
                            <div class="pform-value">
                                <input type="number" name="pallet_volume" id="pallet_volume" class="form-control" value="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-list-panel" id="itemsPageListDiv" >
                        <table class="page-input-table" id="itemsTable">
                            <thead>
                                <tr>
                                    <th style="width:30%;" >Product</th>
                                    <th style="width:20%;" >Lot No.</th>
                                    <th style="width:10%; text-align:center;" >UOM</th>
                                    <th style="width:10%; text-align:center;" >Package Qty</th>
                                    <th style="width:10%; text-align:center;" >Loaded Qty</th>
                                    <th style="width:10%; text-align:center;" >Qty Per Pallet</th>
                                    <th style="width:10%; text-align:center;" >Palletized Qty</th>
                                    <th style="width:10%; text-align:center;" >Volume(m3)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items will be injected here -->
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-save btn-sm float-right">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('css')
<style>
  .remaingDiv { float: left;
    margin: 26px 0 0 10px;
    font-size: 14px; }
  .remaingAddMoreBtn { float: left;
    margin: 17px 0 0 0;
    font-size: 14px; }
</style>
@stop 

@section('js')
<script>
const gatePassData = {
  "GP001": {
    customer: "Ocean Fresh Exports Pvt Ltd",
    vehicle_no: "KL-07-CD-4521",
    packing_list_no: "PL001",
    products: [
      { name: "Frozen Prawns", lot: "LOT-PR-001", uom: "KG", total_qty: 500, assigned_qty: 200, qty_per_pallet: 200, volume_per_unit: 0.004 },
      { name: "Frozen Squid Rings", lot: "LOT-SQ-002", uom: "KG", total_qty: 300, assigned_qty: 150, qty_per_pallet: 100, volume_per_unit: 0.003 },
      { name: "Frozen Crab Meat", lot: "LOT-CR-003", uom: "KG", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.005 }
    ]
  },
  "GP002": {
    customer: "Blue Ocean Seafood Traders",
    vehicle_no: "KL-07-XY-7890",
    packing_list_no: "PL002",
    products: [
      { name: "Frozen Lobster Tails", lot: "LOT-LB-004", uom: "KG", total_qty: 100, assigned_qty: 20, qty_per_pallet: 50, volume_per_unit: 0.006 },
      { name: "Frozen Tuna Steaks", lot: "LOT-TN-005", uom: "KG", total_qty: 150, assigned_qty: 75, qty_per_pallet: 70, volume_per_unit: 0.004 }
    ]
  }
};

document.addEventListener('DOMContentLoaded', function () {
  const gpSelect = document.getElementById('gatepass_no');
  const palletVolumeField = document.getElementById('pallet_volume');
  const itemsPageListDiv = document.querySelector('#itemsPageListDiv');
  const tbody = document.querySelector('#itemsTable tbody');
  let addBtn, volumeStatus;

  gpSelect.addEventListener('change', function () {
    const gp = gatePassData[this.value];
    if (!gp) return;

    document.getElementById('customer').value = gp.customer;
    document.getElementById('vehicle_no').value = gp.vehicle_no;
    document.getElementById('packingListSelect').value = gp.packing_list_no;

    tbody.innerHTML = '';
    if (addBtn) addBtn.remove();
    if (volumeStatus) volumeStatus.remove();

    addBtn = document.createElement('button');
    addBtn.type = 'button';
    addBtn.className = 'btn btn-warning btn-sm remaingAddMoreBtn';
    addBtn.textContent = 'Add Product';
    addBtn.addEventListener('click', () => addProductRow(gp));
    tbody.parentElement.appendChild(addBtn);

    volumeStatus = document.createElement('span');
    volumeStatus.className = 'remaingDiv ';
    tbody.parentElement.appendChild(volumeStatus);

    addProductRow(gp);
  });

  function addProductRow(gp) {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><select class="form-control product-select"><option value="">- Select Product -</option>${gp.products.map(p => `<option value="${p.name}">${p.name}</option>`).join('')}</select></td>
      <td class="lot"></td>
      <td class="uom text-center"></td>
      <td class="total_qty text-center"></td>
      <td class="assigned_qty text-center"></td>
      <td class="qty_per_pallet text-center"></td>
      <td><input type="number" class="form-control palletized_qty" min="0"></td>
      <td class="volume text-center">0.000</td>
    `;
    tbody.appendChild(row);

    const productSelect = row.querySelector('.product-select');
    const qtyInput = row.querySelector('.palletized_qty');

    productSelect.addEventListener('change', function () {
        const product = gp.products.find(p => p.name === this.value);
        if (!product) return;

        // Populate product details
        row.querySelector('.lot').textContent = product.lot;
        row.querySelector('.uom').textContent = product.uom;
        row.querySelector('.total_qty').textContent = product.total_qty;
        row.querySelector('.assigned_qty').textContent = product.assigned_qty;
        row.querySelector('.qty_per_pallet').textContent = product.qty_per_pallet;

        // Calculate default quantity
        const maxVolume = parseFloat(palletVolumeField.value) || 0;
        const otherVolume = getTotalVolumeExcept(row);
        const EPSILON = 0.0001;
        const maxQtyByVolume = Math.floor((maxVolume - otherVolume + EPSILON) / product.volume_per_unit);
        const defaultQty = Math.min(product.qty_per_pallet, maxQtyByVolume);

        qtyInput.value = defaultQty;
        updateVolume(row, product.volume_per_unit);
        checkTotalVolume();

        // ✅ Attach input handler here
        qtyInput.addEventListener('input', function () {
          let qty = parseInt(this.value, 10) || 0;
          
          const totalUsedQty = getTotalUsedQtyExcept(row);
          //const remainingQty = Math.max(product.total_qty - product.assigned_qty - totalUsedQty, 0);
          //const maxQtyPerProduct = Math.min(product.qty_per_pallet, remainingQty);

          const otherVolume = getTotalVolumeExcept(row);
          const remainingVolume = maxVolume - otherVolume;
          const maxQtyByVolume = Math.floor((remainingVolume + EPSILON) / product.volume_per_unit);

          const finalQty = Math.max(0, Math.min(qty, product.qty_per_pallet, maxQtyByVolume));

          console.log(totalUsedQty+','+maxQtyByVolume);
          this.value = finalQty;

          updateVolume(row, product.volume_per_unit);
          checkTotalVolume();
        });
      });

  }

  function updateVolume(row, volumePerUnit) {
    const qty = parseFloat(row.querySelector('.palletized_qty').value) || 0;
    const volume = (qty * volumePerUnit).toFixed(2);
    row.querySelector('.volume').textContent = volume;
  }

  function getUsedQtyBefore(currentRow) {
    let sum = 0;
    for (const row of tbody.querySelectorAll('tr')) {
      if (row === currentRow) break;
      sum += parseInt(row.querySelector('.palletized_qty').value, 10) || 0;
    }
    return sum;
  }

  // function getTotalVolumeExcept(excludeRow) {
  //   let total = 0;
  //   for (const row of tbody.querySelectorAll('tr')) {
  //     if (row === excludeRow) continue;
  //     total += parseFloat(row.querySelector('.volume').textContent) || 0;
  //   }
  //   return total;
  // }

  function getTotalUsedQtyExcept(excludeRow) {
    let sum = 0;
    tbody.querySelectorAll('tr').forEach(row => {
      if (row !== excludeRow) {
        sum += parseInt(row.querySelector('.palletized_qty')?.value || 0);
      }
    });
    return sum;
  }

  function getTotalVolumeExcept(excludeRow) {
    let sum = 0;
    tbody.querySelectorAll('tr').forEach(row => {
      if (row !== excludeRow) {
        sum += parseFloat(row.querySelector('.volume')?.textContent || 0);
      }
    });
    return sum;
  }

  function checkTotalVolume() {
    const maxVolume = parseFloat(palletVolumeField.value) || 0;
    let totalVolume = 0;
    tbody.querySelectorAll('.volume').forEach(cell => {
      totalVolume += parseFloat(cell.textContent) || 0;
    });

    const remaining = (maxVolume - totalVolume).toFixed(2);
    volumeStatus.textContent = totalVolume >= maxVolume
      ? `🟥 Pallet Full (${totalVolume} m³ used)`
      : `🟩 Remaining Volume: ${remaining} m³`;

    addBtn.disabled = totalVolume >= maxVolume;
  }
});
</script>

@endsection
