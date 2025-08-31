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
                            <div class="pform-label">Volume of Pallet (m3)</div>
                            <div class="pform-value">
                                <input type="number" name="pallet_capacity" id="pallet_capacity" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Qty Per Pallet</div>
                            <div class="pform-value">
                                <input type="number" name="qty_per_pallet" id="qty_per_pallet" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-list-panel">
                        <table class="page-input-table" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Lot No.</th>
                                    <th style="text-align:center;" >UOM</th>
                                    <th style="text-align:center;" >Total Qty</th>
                                    <th style="text-align:center;" >Loaded Qty</th>
                                    <th style="text-align:center;" >Qty Per Pallet</th>
                                    <th style="text-align:center;" >Palletized Qty</th>
                                    <th style="text-align:center;" >Volume(m3)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items will be injected here -->
                            </tbody>
                        </table>
                        <div id="addProductContainer"></div>
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

@section('js')
<script>
const gatePassData = {
  "GP001": {
    customer: "Ocean Fresh Exports Pvt Ltd",
    vehicle_no: "KL-07-CD-4521",
    packing_list_no: "PL001",
    warehouse_unit: "WU-0001",
    dock_no: "DOCK-001",
    pallet_capacity: 2.5,
    default_qty_per_pallet: 100,
    products: [
      { name: "Frozen Prawns", lot: "LOT-PR-001", uom: "KG", total_qty: 500, assigned_qty: 200, length: 0.5, breadth: 0.4, height: 0.3 },
      { name: "Frozen Squid Rings", lot: "LOT-SQ-002", uom: "KG", total_qty: 300, assigned_qty: 150, length: 0.4, breadth: 0.3, height: 0.2 }
    ]
  },
  "GP002": {
    customer: "Blue Ocean Seafood Traders",
    vehicle_no: "KL-07-XY-7890",
    packing_list_no: "PL002",
    warehouse_unit: "WU-0002",
    dock_no: "DOCK-002",
    pallet_capacity: 3.0,
    default_qty_per_pallet: 120,
    products: [
      { name: "Frozen Lobster Tails", lot: "LOT-LB-004", uom: "KG", total_qty: 100, assigned_qty: 20, length: 0.6, breadth: 0.5, height: 0.4 },
      { name: "Frozen Tuna Steaks", lot: "LOT-TN-005", uom: "KG", total_qty: 150, assigned_qty: 75, length: 0.5, breadth: 0.4, height: 0.3 }
    ]
  }
};

const gpSelect = document.getElementById('gatepass_no');
const tbody = document.querySelector('#itemsTable tbody');

gpSelect.addEventListener('change', function () {
  const gp = gatePassData[this.value];
  if (!gp) return;

  // Autofill header
  document.getElementById('customer').value = gp.customer;
  document.getElementById('vehicle_no').value = gp.vehicle_no;
  document.getElementById('packingListSelect').value = gp.packing_list_no;
  document.getElementById('warehouse_unit').value = gp.warehouse_unit;
  document.getElementById('dock_no').value = gp.dock_no;
  document.getElementById('pallet_capacity').value = gp.pallet_capacity;
  document.getElementById('qty_per_pallet').value = gp.default_qty_per_pallet;

  tbody.innerHTML = '';
  document.getElementById('addProductContainer').innerHTML = '';
  addProductRow(gp);
});

function calculateQtyPerPallet(product, palletCapacity) {
  const unitVolume = product.length * product.breadth * product.height;
  return unitVolume ? Math.floor(palletCapacity / unitVolume) : 0;
}

function bindQtyChange(row, product) {
  const qtyInput = row.querySelector('.qty');
  qtyInput.addEventListener('input', function () {
    const qty = parseInt(this.value, 10) || 0;
    const capacity = qty * product.length * product.breadth * product.height;
    row.querySelector('.capacity-cell').textContent = capacity.toFixed(2);
    checkTotalCapacity();
  });
}

function checkTotalCapacity() {
  const palletCapacity = parseFloat(document.getElementById('pallet_capacity').value) || 0;
  let totalUsed = 0;

  tbody.querySelectorAll('tr').forEach(row => {
    totalUsed += parseFloat(row.querySelector('.capacity').textContent) || 0;
  });

  const container = document.getElementById('addProductContainer');
  let btn = document.getElementById('addProductBtn');

  if (totalUsed < palletCapacity) {
    const remaining = (palletCapacity - totalUsed).toFixed(2);
    if (!btn) {
      btn = document.createElement('button');
      btn.type = 'button';
      btn.id = 'addProductBtn';
      btn.className = 'btn btn-warning btn-sm mt-2';
      btn.textContent = `Add another product (Remaining: ${remaining} m³)`;
      btn.addEventListener('click', () => addProductRow(gatePassData[gpSelect.value]));
      container.appendChild(btn);
    } else {
      btn.textContent = `Add another product (Remaining: ${remaining} m³)`;
    }
  } else if (btn) {
    btn.remove();
  }
}

function addProductRow(gp) {
  const row = document.createElement('tr');
  row.innerHTML = `
    <td>
      <select class="form-control product-select">
        <option value="">- Select Product -</option>
        ${gp.products.map(p => `<option value="${p.name}">${p.name}</option>`).join('')}
      </select>
    </td>
    <td class="lot"></td>
    <td class="uom"></td>
    <td class="total_qty text-center"></td>
    <td class="assigned_qty text-center"></td>
    <td class="qty_per_pallet text-center"></td>
    <td><input type="number" class="form-control quantity" min="0"></td>
    <td class="capacity text-center">0.00</td>
  `;
  tbody.appendChild(row);

  const productSelect = row.querySelector('.product-select');
  const quantityInput = row.querySelector('.quantity');

  productSelect.addEventListener('change', function () {
    const product = gp.products.find(p => p.name === this.value);
    if (!product) return;

    // Fill static fields
    row.querySelector('.lot').textContent = product.lot;
    row.querySelector('.uom').textContent = product.uom;
    row.querySelector('.total_qty').textContent = product.total_qty;
    row.querySelector('.assigned_qty').textContent = product.assigned_qty;

    // Calculate default qty per pallet
    const palletCapacity = parseFloat(document.getElementById('pallet_capacity').value) || 0;
    const unitVolume = product.length * product.breadth * product.height;
    const defaultQty = unitVolume ? Math.floor(palletCapacity / unitVolume) : 0;

    row.querySelector('.qty_per_pallet').textContent = defaultQty;
    quantityInput.value = defaultQty;

    // Calculate initial capacity
    const initialCapacity = defaultQty * unitVolume;
    row.querySelector('.capacity').textContent = initialCapacity.toFixed(2);

    // Bind quantity change
    quantityInput.addEventListener('input', function () {
      const qty = parseInt(this.value, 10) || 0;
      const newCapacity = qty * unitVolume;
      row.querySelector('.capacity').textContent = newCapacity.toFixed(2);
      checkTotalCapacity();
    });

    checkTotalCapacity();
  });
}
  
</script>

@endsection
