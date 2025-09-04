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
        <form id="palletizationForm" action="{{ route('admin.inventory.palletization.view', 1) }}" method="GET">
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
                        <!-- <div class="pform-row">
                            <div class="pform-label">Weight of empty Pallet</div>
                            <div class="pform-value">
                                <input type="number" name="empty_pallet_weight" id="empty_pallet_weight" class="form-control">
                            </div>
                        </div> -->
                        <div class="pform-row">
                            <div class="pform-label">Allowed Volume per Pallet(m3)</div>
                            <div class="pform-value">
                                <input type="number" name="tot_volume" id="tot_volume" class="form-control" value="1.8">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label text-red">Remaining Volume(m3)</div>
                            <div class="pform-value">
                                <input type="text" name="remaining_volume" id="remaining_volume" class="form-control text-red text-right" value="1.8">
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
                                    <th style="width:10%; text-align:center; display:none;" >Package Qty</th>
                                    <th style="width:10%; text-align:center; display:none;" >Loaded Qty</th>
                                    <th style="width:10%; text-align:center; display:none;" >Qty Per Pallet</th>
                                    <th style="width:10%; text-align:center;" >Palletized Qty</th>
                                    <th style="width:10%; text-align:center;" >Volume(m3)</th>
                                    <th style="width:5%; text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items will be injected here -->
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <!-- <button type="submit" class="btn btn-save btn-sm float-right">Print & Save</button> -->
                            <button type="button" class="btn btn-save btn-sm float-right" onclick="printPalletDetails()" >Save & Print</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<div class="tab-pane fade" id="palPallets">
    @php
$pallet = [
    [
        'pallet_no'         => 'PLT-00001',
        'warehouse_unit_no' => 'WU-0005',
        'room_no'           => 'R-102',
        'location'          => 'WU0001-CR001-B2-R5-L1-D2',
        'dock_no'           => 'D-07',
        'product_code'      => 'FRZ-001',
        'product'           => 'Ice Cream Tubs - 35cmx35cmx20cm',
        'lot'               => 'LOT-PR-001',
        'size'              => '500g',
        'package_type'      => 'Carton',
        'no_of_packages'    => 60,
        'total_gw'          => 750,
        'total_nw'          => 720,
        'expiry_date'       => '2026-02-15',
        'uom'               => 'Boxes',
        'palletized_by'     => 'Ramesh Kumar',
        'palletized_time'   => '09:15 – 09:42 (00:27)',
        'supervisor'        => 'Vijay Nair',
        'remarks'           => 'No damage, all boxes sealed',
    ],
    [
        'pallet_no'         => 'PLT-00001',
        'warehouse_unit_no' => 'WU-0005',
        'room_no'           => 'R-102',
        'location'          => 'WU0001-CR001-B2-R5-L1-D2',
        'dock_no'           => 'D-07',
        'product_code'      => 'FRZ-002',
        'product'           => 'Paneer Blocks 5kg - 40cmx30cmx25cm',
        'lot'               => 'LOT-SQ-002',
        'size'              => '1kg',
        'package_type'      => 'Carton',
        'no_of_packages'    => 40,
        'total_gw'          => 500,
        'total_nw'          => 480,
        'expiry_date'       => '2026-03-20',
        'uom'               => 'Boxes',
        'palletized_by'     => 'Ramesh Kumar',
        'palletized_time'   => '09:15 – 09:42 (00:27)',
        'supervisor'        => 'Vijay Nair',
        'remarks'           => 'No damage, all boxes sealed',
    ]
];
@endphp
    @php
        use Endroid\QrCode\Builder\Builder;
        use Endroid\QrCode\Writer\PngWriter;

        // Build QR payload with all items for this pallet
        $qrPayload = [
            'pallet_no' => $pallet[0]['pallet_no'],
            'items'     => $pallet
        ];

        $builder = new Builder(
            writer: new PngWriter(),
            data: json_encode($qrPayload),
            size: 150,
            margin: 5
        );

        $result = $builder->build();
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());
    @endphp

    <div class="card page-form" id="pallet-print">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">Pallet Details</h5>
            <button type="button" class="btn btn-sm btn-print float-right" onclick="printPalletDetails()" title="Print / Download">
                <i class="fas fa-download"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div style="padding:15px; border:1px solid #CCC;" >
                        <!-- Header Section -->
                        <table class="header-section">
                            <tr class="header-left">
                                <!-- Left Column -->
                                <td class="txt-left">
                                    <div class="header-row"><span class="header-label">Warehouse Unit</span> <span class="header-value">: {{ $pallet[0]['warehouse_unit_no'] }}</span></div>
                                    <div class="header-row"><span class="header-label">Chamber No.</span> <span class="header-value">: {{ $pallet[0]['room_no'] }}</span></div>
                                    <div class="header-row"><span class="header-label">Pallet No. </span> <span class="header-value">: {{ $pallet[0]['pallet_no'] }}</span></div>
                                    <div class="header-row"><span class="header-label">Location </span> <span class="header-value">: {{ $pallet[0]['location'] }}</span></div>
                                </td>
                                <!-- Right Column (QR Code) -->
                                <td class="txt-right">
                                    <div class="header-right text-center">
                                        <div class="header-label mb-1">QR Code</div>
                                        <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="qr-img">
                                    </div>
                                </td>
                            </div>                    
                        </table>
                    </div>

                </div>

            </div>
            
            <!-- Items Table -->
            <h6 class="mt-4">Items on this Pallet</h6>
            <table class="table table-bordered table-striped page-list-table print-list-table">
                <thead>
                    <tr>
                        <th style="width:5%;">#</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Lot No.</th>
                        <th>Expiry Date</th>
                        <th class="text-right">Quantity</th>
                        <th>UOM</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pallet as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="text-left">{{ $item['product_code'] }}</td>
                            <td class="text-left">{{ $item['product'] }}</td>
                            <td>{{ $item['lot'] }}</td>
                            <td>{{ $item['expiry_date'] }}</td>
                            <td class="text-right">{{ $item['no_of_packages'] }}</td>
                            <td>{{ $item['uom'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td></td>
                        <td colspan="4" class="text-right">Total</td>
                        <td class="text-right">{{ collect($pallet)->sum('no_of_packages') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
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
    function printPalletDetails() {
        const content = document.getElementById('pallet-print').innerHTML;
        const win = window.open('', '', 'width=900,height=650');
        win.document.write('<html><head><title>Pallet Details</title>');
        win.document.write('<link rel="stylesheet" href="{{ asset('css/custom.css') }}">'); // or Bootstrap
        win.document.write('<style>@media print {.table th, .table td {border:1px solid #000;}}}</style>');
        win.document.write('</head><body>');
        win.document.write(content);
        win.document.write('</body></html>');
        win.document.close();
        win.print();
    }
    
const gatePassData = {
  "GP001": {
    customer: "Chelur Foods",
    vehicle_no: "KL-07-CD-4521",
    packing_list_no: "PL001",
    products: [
      
      { name: "Ice Cream Tubs - 35cmx35cmx20cm", lot: "LOT-PR-001", uom: "Box", total_qty: 500, assigned_qty: 200, qty_per_pallet: 200, volume_per_unit: 0.025 },
      { name: "Paneer Blocks 5kg - 40cmx30cmx25cm", lot: "LOT-SQ-002", uom: "Box", total_qty: 300, assigned_qty: 150, qty_per_pallet: 100, volume_per_unit: 0.03 },
      { name: "Frozen Corn 2kg - 30cmx25cmx15cm", lot: "LOT-CR-003", uom: "Box", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.011 },
      { name: "Veg Spring Rolls 1kg - 28cmx22cmx12cm", lot: "LOT-CR-003", uom: "Box", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.007 },
      { name: "Chicken Seekh Kebab 5kg - 45cmx30cmx20cm", lot: "LOT-CR-003", uom: "Box", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.027 },
      { name: "Fish Fingers 3kg - 35cmx25cmx20cm", lot: "LOT-CR-003", uom: "Box", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.0018 },
      { name: "Frozen Paratha 1kg - 30cmx30cmx10cm", lot: "LOT-CR-003", uom: "Box", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.009 },
      { name: "Frozen Momos 2kg - 32cmx25cmx15cm", lot: "LOT-CR-003", uom: "Box", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.012 },
      { name: "Frozen French Fries 5kg - 50cmx35cmx20cm", lot: "LOT-CR-003", uom: "Box", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.035 },
      { name: "Frozen Pizza Base 2kg - 35cmx35cmx10cm", lot: "LOT-CR-003", uom: "Box", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.0012 },
      { name: "Frozen Biryani Packs 1kg - 25cmx20cmx10cm", lot: "LOT-CR-003", uom: "Box", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.005 }
    ]
  },
  "GP002": {
    customer: "Blue Ocean Seafood Traders",
    vehicle_no: "KL-07-XY-7890",
    packing_list_no: "PL002",
    products: [
      { name: "Frozen Prawns - 35cmx35cmx20cm", lot: "LOT-PR-001", uom: "KG", total_qty: 500, assigned_qty: 200, qty_per_pallet: 200, volume_per_unit: 0.004 },
      { name: "Frozen Squid Rings - 40cmx30cmx25cm", lot: "LOT-SQ-002", uom: "KG", total_qty: 300, assigned_qty: 150, qty_per_pallet: 100, volume_per_unit: 0.003 },
      { name: "Frozen Crab Meat - 30cmx25cmx15cm", lot: "LOT-CR-003", uom: "KG", total_qty: 200, assigned_qty: 50, qty_per_pallet: 100, volume_per_unit: 0.005 },
      { name: "Frozen Lobster Tails - 28cmx22cmx12cm", lot: "LOT-LB-004", uom: "KG", total_qty: 100, assigned_qty: 20, qty_per_pallet: 50, volume_per_unit: 0.006 },
      { name: "Frozen Tuna Steaks - 45cmx30cmx20cm", lot: "LOT-TN-005", uom: "KG", total_qty: 150, assigned_qty: 75, qty_per_pallet: 70, volume_per_unit: 0.004 }
    ]
  }
};

document.addEventListener('DOMContentLoaded', function () {
    const gpSelect = document.getElementById('gatepass_no');
    const palletVolumeField = document.getElementById('tot_volume');
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
        volumeStatus.className = 'remaingDiv d-none';
        tbody.parentElement.appendChild(volumeStatus);

        addProductRow(gp);
    });

    function addProductRow(gp) {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
        <select class="form-control product-select">
            <option value="">- Select Product -</option>
            ${[...new Set(gp.products.map(p => p.name))].map(name => `<option value="${name}">${name}</option>`).join('')}
        </select>
        </td>
        <td class="lot">
        <select class="form-control lot-select" disabled>
            <option value="">- Select Lot -</option>
        </select>
        </td>
        <td class="uom text-center"></td>
        <td class="total_qty text-center" style="display:none;"></td>
        <td class="assigned_qty text-center" style="display:none;"></td>
        <td class="qty_per_pallet text-center" style="display:none;"></td>
        <td><input type="number" class="form-control palletized_qty" min="0"></td>
        <td class="volume text-center">0.000</td>
        <td class="text-center">
        <button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i></button>
        </td>
    `;
    tbody.appendChild(row);

    const productSelect = row.querySelector('.product-select');
    const lotSelect = row.querySelector('.lot-select');
    const qtyInput = row.querySelector('.palletized_qty');
    const uomCell = row.querySelector('.uom');
    const totalQtyCell = row.querySelector('.total_qty');
    const assignedQtyCell = row.querySelector('.assigned_qty');
    const qtyPerPalletCell = row.querySelector('.qty_per_pallet');

    productSelect.addEventListener('change', function () {
        const selectedProduct = this.value;
        const lots = gp.products.filter(p => p.name === selectedProduct);

        lotSelect.innerHTML = `<option value="">- Select Lot -</option>` +
        lots.map(p => `<option value="${p.lot}">${p.lot}</option>`).join('');
        lotSelect.disabled = false;

        // Clear previous values
        uomCell.textContent = '';
        totalQtyCell.textContent = '';
        assignedQtyCell.textContent = '';
        qtyPerPalletCell.textContent = '';
        qtyInput.value = '';
        row.querySelector('.volume').textContent = '0.000';
    });

    lotSelect.addEventListener('change', function () {
        const selectedLot = this.value;
        const selectedProduct = productSelect.value;
        const product = gp.products.find(p => p.name === selectedProduct && p.lot === selectedLot);
        if (!product) return;

        uomCell.textContent = product.uom;
        totalQtyCell.textContent = product.total_qty;
        assignedQtyCell.textContent = product.assigned_qty;
        qtyPerPalletCell.textContent = product.qty_per_pallet;

        const maxVolume = parseFloat(palletVolumeField.value) || 0;
        const otherVolume = getTotalVolumeExcept(row);
        const EPSILON = 0.0001;
        const maxQtyByVolume = Math.floor((maxVolume - otherVolume + EPSILON) / product.volume_per_unit);
        const defaultQty = Math.min(product.qty_per_pallet, maxQtyByVolume);

        qtyInput.value = defaultQty;
        updateVolume(row, product.volume_per_unit);
        checkTotalVolume();

        qtyInput.addEventListener('input', function () {
        let qty = parseInt(this.value, 10) || 0;
        const otherVolume = getTotalVolumeExcept(row);
        const remainingVolume = maxVolume - otherVolume;
        const maxQtyByVolume = Math.floor((remainingVolume + EPSILON) / product.volume_per_unit);
        const finalQty = Math.max(0, Math.min(qty, product.qty_per_pallet, maxQtyByVolume));

        this.value = finalQty;
        updateVolume(row, product.volume_per_unit);
        checkTotalVolume();
        });
    });

    row.querySelector('.delete-row').addEventListener('click', function () {
        row.remove();
        checkTotalVolume();
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

    // ✅ Update the remaining volume field correctly
    document.getElementById('remaining_volume').value = remaining;

    addBtn.disabled = totalVolume >= maxVolume;
  }

  
});
</script>

@endsection
