@extends('adminlte::page')

@section('title', 'Create Put Away')

@section('content_header')
    <h1>Put Away</h1>
@endsection

@section('content')

<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.put-away.index') }}" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card page-form page-form-add">
    <div class="card-body">
        <form id="pputAwayForm" action="{{ route('admin.inventory.put-away.view', 1) }}" method="GET">
            @csrf

            <!-- Header Fields -->
            <div class="row">
                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:182px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc No</div>
                            <div class="pform-value">
                                <input type="text" name="doc_no" id="doc_no" value="PUT-25-00004" class="form-control" readonly>
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
                        <div class="pform-row">
                            <div class="pform-label">Pallet No</div>
                            <div class="pform-value">
                                <select name="pallet_no" class="form-control">
                                    <option value="">- Select -</option>
                                    <option value="PLT-00001">PLT-00001</option>
                                    <option value="PLT-00002">PLT-00002</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:182px;">
                        <div class="pform-row">
                            <div class="pform-label">Chamber No</div>
                            <div class="pform-value">
                                <input type="text" name="chamber_no" id="chamber_no" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Pallet Location</div>
                            <div class="pform-value">
                                <input type="text" name="pallet_location" id="pallet_location" class="form-control">
                            </div>
                        </div>
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
                                    <th style="width:10%; text-align:center;" >Qty</th>
                                    <th style="width:10%; text-align:center;" >Expiry Date</th>
                                    <th style="width:10%; text-align:center;" >Manufact. Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items will be injected here -->
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <button type="button" class="btn btn-save btn-sm float-right">Save</button>
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
    customer: "Chelur Foods",
    vehicle_no: "KL-07-CD-4521",
    packing_list_no: "PL001",
    warehouse_unit: "WU-0001",
    dock_no: "D-01",
    pallets: {
      "PLT-00001": {
        chamber_no: "CR-001",
        pallet_location: "WU0001-CR001-B1-R3-L2-D1",
        items: [
          { product: "Ice Cream Tubs", lot: "LOT-PR-001", uom: "Box", qty: 200, expiry: "2026-02-01", mfg: "2025-08-01" },
          { product: "Paneer Blocks", lot: "LOT-SQ-002", uom: "Box", qty: 150, expiry: "2026-01-15", mfg: "2025-07-15" }
        ]
      },
      "PLT-00002": {
        chamber_no: "CR-002",
        pallet_location: "WU0001-CR002-B2-R5-L1-D2",
        items: [
          { product: "Frozen Corn", lot: "LOT-CR-003", uom: "Box", qty: 50, expiry: "2026-01-20", mfg: "2025-07-20" },
          { product: "Veg Spring Rolls", lot: "LOT-CR-004", uom: "Box", qty: 50, expiry: "2026-01-25", mfg: "2025-07-25" }
        ]
      }
    }
  },
  "GP002": {
    customer: "Blue Ocean Seafood Traders",
    vehicle_no: "KL-07-XY-7890",
    packing_list_no: "PL002",
    warehouse_unit: "WU-0002",
    dock_no: "D-02",
    pallets: {
      "PLT-00003": {
        chamber_no: "CR-003",
        pallet_location: "WU0002-CR003-B1-R1-L3-D4",
        items: [
          { product: "Frozen Prawns", lot: "LOT-PR-005", uom: "KG", qty: 200, expiry: "2026-03-01", mfg: "2025-08-01" }
        ]
      }
    }
  }
};

document.getElementById('gatepass_no').addEventListener('change', function () {
  const gp = gatePassData[this.value];
  if (!gp) return;

  document.getElementById('customer').value = gp.customer;
  document.getElementById('vehicle_no').value = gp.vehicle_no;
  document.getElementById('packingListSelect').value = gp.packing_list_no;
  document.getElementById('warehouse_unit').value = gp.warehouse_unit;
  document.getElementById('dock_no').value = gp.dock_no;

  const palletSelect = document.querySelector('select[name="pallet_no"]');
  palletSelect.innerHTML = `<option value="">- Select -</option>` +
    Object.keys(gp.pallets).map(p => `<option value="${p}">${p}</option>`).join('');

  // Clear chamber, location, and item table
  document.getElementById('chamber_no').value = '';
  document.getElementById('pallet_location').value = '';
  document.querySelector('#itemsTable tbody').innerHTML = '';
});

document.querySelector('select[name="pallet_no"]').addEventListener('change', function () {
  const gpId = document.getElementById('gatepass_no').value;
  const gp = gatePassData[gpId];
  const pallet = gp?.pallets?.[this.value];
  if (!pallet) return;

  document.getElementById('chamber_no').value = pallet.chamber_no;
  document.getElementById('pallet_location').value = pallet.pallet_location;

  const tbody = document.querySelector('#itemsTable tbody');
  tbody.innerHTML = '';

  pallet.items.forEach(item => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.product}</td>
      <td>${item.lot}</td>
      <td class="text-center">${item.uom}</td>
      <td class="text-center">${item.qty}</td>
      <td class="text-center">${item.expiry}</td>
      <td class="text-center">${item.mfg}</td>
    `;
    tbody.appendChild(row);
  });
});

</script>

@endsection
