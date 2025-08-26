@extends('adminlte::page')

@section('title', 'Create Palletization')

@section('content_header')
    <h1>Palletization</h1>
@endsection

@section('content')

<div class="page-sub-header">
    <h3>Form</h3>
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
                    <div class="pform-panel" style="min-height:175px;">
                        <div class="pform-row">
                            <div class="pform-label">Doc No</div>
                            <div class="pform-value">
                                <input type="text" name="doc_no" id="doc_no" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Packing List</div>
                            <div class="pform-value">
                                <select id="packingListSelect" class="form-control">
                                <option value="">-- Select --</option>
                                <option value="PL001">Packing List #PL001</option>
                                <option value="PL002">Packing List #PL002</option>
                            </select>
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Gatepass No</div>
                            <div class="pform-value">
                                <input type="text" name="gatepass_no" id="gatepass_no" class="form-control">
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Customer</div>
                            <div class="pform-value">
                                <input type="text" name="customer" id="customer" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="pform-panel" style="min-height:175px;">
                        <div class="pform-row">
                            <div class="pform-label">Vehicle No</div>
                            <div class="pform-value">
                                <input type="text" name="vehicle_no" id="vehicle_no" class="form-control">
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
                    <div class="pform-panel" style="min-height:175px;">
                        <div class="pform-row">
                            <div class="pform-label">Weight of 1 Empty Pallet</div>
                            <div class="pform-value">
                                <input type="number" name="empty_pallet_weight" id="empty_pallet_weight" class="form-control">
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
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="page-list-panel">
                        <table class="page-list-table" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Lot</th>
                                    <th>UOM</th>
                                    <th>Total Qty</th>
                                    <th>Assigned Qty</th>
                                    <th>Total G.W.</th>
                                    <th>Total N.W.</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items will be injected here -->
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <button type="button" id="generatePallets" class="btn btn-primary btn-sm float-right">Generate Pallets</button>
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
$(document).on('input', '.qty-per-pallet', function() {
    let boxes = parseInt($(this).data('boxes'));
    let qtyPerPallet = parseInt($(this).val()) || 0;
    let pallets = qtyPerPallet > 0 ? Math.ceil(boxes / qtyPerPallet) : '';
    $(this).closest('tr').find('.no-of-pallets').text(pallets);

    let total = 0;
    $('.no-of-pallets').each(function(){
        let val = parseInt($(this).text()) || 0;
        total += val;
    });
    $('#total_pallets').val(total);
});

$(document).on('change', '#packingListSelect', function() {
    let packingListId = $(this).val();
    let rows = '';

    // Clear table if nothing selected
    if (!packingListId) {
        $('#itemsTable tbody').empty();
        return;
    }

    // Dummy data sets
    let dummyData = {
        'PL001': [
            {
                product: 'RED JOANPRINCE SMALL',
                lot: '(70)-75UACJH4578126/08/2015_SD174',
                size: '13',
                weight_per_unit: '4',
                package_type: 'Carton',
                no_of_packages: 1098,
                gw_per_package: 4.5,
                nw_per_package: 4,
                total_gw: 4932,
                total_nw: 4392,
                pallet_type: '328'
            },
            {
                product: 'GREEN EMERALD LARGE',
                lot: '(80)-88XYZ1234567/09/2015_SD200',
                size: '15',
                weight_per_unit: '5',
                package_type: 'Crate',
                no_of_packages: 800,
                gw_per_package: 5.2,
                nw_per_package: 4.8,
                total_gw: 4160,
                total_nw: 3840,
                pallet_type: '330'
            }
        ],
        'PL002': [
            {
                product: 'YELLOW SUNBURST MEDIUM',
                lot: '(60)-65ABC9876543/07/2015_SD150',
                size: '14',
                weight_per_unit: '4.2',
                package_type: 'Box',
                no_of_packages: 950,
                gw_per_package: 4.7,
                nw_per_package: 4.3,
                total_gw: 4465,
                total_nw: 4085,
                pallet_type: '329'
            }
        ]
    };

    // Build rows from dummy data
    dummyData[packingListId].forEach(item => {
        rows += `
            <tr>
                <td class="product-cell">${item.product}</td>
                <td class="lot-cell">${item.lot}</td>
                <td class="size-cell">${item.size}</td>
                <td>${item.weight_per_unit}</td>
                <td>${item.package_type}</td>
                <td class="boxes-cell">${item.no_of_packages}</td>
                <td>${item.gw_per_package}</td>
                <td>${item.nw_per_package}</td>
                <td>${item.total_gw}</td>
                <td>${item.total_nw}</td>
                <td>${item.pallet_type}</td>
                <td>
                    <input type="number" class="form-control qty-per-pallet" 
                           data-boxes="${item.no_of_packages}" min="0">
                </td>
                <td class="no-of-pallets"></td>
            </tr>
        `;
    });

    $('#itemsTable tbody').html(rows);
});

$('#generatePallets').on('click', function() {
    let palletData = [];

    $('#itemsTable tbody tr').each(function(index, row) {
        let product = $(row).find('td').eq(0).text();
        let lot = $(row).find('td').eq(1).text();
        let size = $(row).find('td').eq(2).text();
        let boxes = parseInt($(row).find('td').eq(5).text());
        let qtyPerPallet = parseInt($(row).find('.qty-per-pallet').val()) || 0;
        let pallets = qtyPerPallet > 0 ? Math.ceil(boxes / qtyPerPallet) : 0;

        for (let i = 1; i <= pallets; i++) {
            let assignedBoxes = (i < pallets) ? qtyPerPallet : (boxes - qtyPerPallet * (pallets - 1));
            palletData.push({
                palletNo: `P-${index+1}-${i}`,
                product,
                lot,
                size,
                boxes: assignedBoxes
            });
        }
    });

    // Store pallet data in sessionStorage so next page can read it
    sessionStorage.setItem('palletData', JSON.stringify(palletData));

    let palletWindow = window.open('', 'Pallets', 'width=800,height=600');
    let html = `
        <html>
        <head>
            <title>Pallets</title>
            <style>
                body { font-family: Arial, sans-serif; }
                h3 { margin-bottom: 15px; }
                .pallet {
                    display:inline-block;
                    width:120px;
                    height:80px;
                    border:1px solid #333;
                    margin:5px;
                    text-align:center;
                    vertical-align:top;
                    position:relative;
                    padding-top:10px;
                    box-sizing:border-box;
                }
                .pallet strong { display:block; font-size:14px; }
                .tooltip {
                    display:none;
                    position:absolute;
                    top:100%;
                    left:0;
                    background:#fff;
                    border:1px solid #ccc;
                    padding:5px;
                    font-size:12px;
                    width:200px;
                    z-index:10;
                    box-shadow:0 2px 5px rgba(0,0,0,0.2);
                }
                .pallet:hover .tooltip { display:block; }
                .confirm-btn {
                    display:block;
                    margin-top:20px;
                    padding:10px 20px;
                    background:#007bff;
                    color:#fff;
                    border:none;
                    cursor:pointer;
                    font-size:14px;
                }
            </style>
        </head>
        <body>
            <h3>Generated Pallets</h3>
    `;

    palletData.forEach(p => {
        html += `
            <div class="pallet">
                <strong>${p.palletNo}</strong>
                ${p.boxes} boxes
                <div class="tooltip">
                    <div><strong>Product:</strong> ${p.product}</div>
                    <div><strong>Lot:</strong> ${p.lot}</div>
                    <div><strong>Size:</strong> ${p.size}</div>
                </div>
            </div>
        `;
    });

    // Confirm button
    html += `
        <button class="confirm-btn" onclick="confirmPallets()">Confirm</button>
        <script>
            function confirmPallets() {
                // Redirect to palletization index page
                window.opener.location.href = '/admin/inventory/palletization';
                window.close();
            }
        <\/script>
        </body>
        </html>
    `;

    palletWindow.document.write(html);
    palletWindow.document.close();
});

</script>
@endsection
