@extends('adminlte::page')

@section('title', 'View Palletization')

@section('content_header')
    <h1>Palletization</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.palletization.edit', 1) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.palletization.print', 1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.palletization.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status">
        <label>Change Status</label>
        <select id="change_status_select">
            <option value="created">Created</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs" role="tablist" id="palletizationTabs">
    <li class="nav-item">
        <a class="nav-link active" id="palletization-tab" data-toggle="tab" href="#palletizationDetails" role="tab">Palletization</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#palletizationQRCodes" role="tab">Pallet QRCode</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="palletization-status-tab" data-toggle="tab" href="#palletizationStatus" role="tab">Status</a>
    </li>
</ul>

<div class="tab-content">
    <!-- Palletization Details Tab -->
    <div class="tab-pane fade show active" id="palletizationDetails" role="tabpanel">
        <div class="card page-form">
            <div class="card-body">
                <div class="row">
                    <!-- Panel 1 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:128px;">
                            <div class="pform-row"><div class="pform-label">Doc No</div><div class="pform-value">PAL-25-00001</div></div>
                            <div class="pform-row"><div class="pform-label">Date</div><div class="pform-value">25/08/2025</div></div>
                            <div class="pform-row"><div class="pform-label">Packing List No</div><div class="pform-value">PKG-25-00005</div></div>
                            <div class="pform-row"><div class="pform-label">Gate Pass No</div><div class="pform-value">GP-1001</div></div>
                        </div>
                    </div>
                    <!-- Panel 2 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:128px;">
                            <div class="pform-row"><div class="pform-label">Vehicle No</div><div class="pform-value">KL-07-AB-1234</div></div>
                            <div class="pform-row"><div class="pform-label">Client</div><div class="pform-value">ABC Foods Ltd</div></div>
                            <div class="pform-row"><div class="pform-label">Supplier</div><div class="pform-value">LMG Grupa</div></div>
                            <div class="pform-row"><div class="pform-label">Warehouse Unit</div><div class="pform-value">Unit 3</div></div>
                        </div>
                    </div>
                    <!-- Panel 3 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:128px;">
                            <div class="pform-row"><div class="pform-label">Weight of 1 Empty Pallet</div><div class="pform-value">28</div></div>
                            <div class="pform-row"><div class="pform-label">Total No of Pallets</div><div class="pform-value">12</div></div>
                            <div class="pform-row"><div class="pform-label">Total Packages</div><div class="pform-value">1200</div></div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped page-list-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Lot</th>
                            <th>Size</th>
                            <th>Weight/Unit</th>
                            <th>Package Type</th>
                            <th>No. of Packages</th>
                            <th>G.W./Package</th>
                            <th>N.W./Package</th>
                            <th>Total G.W.</th>
                            <th>Total N.W.</th>
                            <th>Pallet No</th> {{-- Pallet number at the end --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        // Dummy pallet-wise data
                        $pallets = [
                            'P-1-1' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-1-2' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-1-3' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-1-4' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-1-5' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-1-6' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-1-7' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-1-8' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-1-9' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-1-10' => [
                                ['product' => 'RED JOANPRINCE SMALL', 'lot' => 'LOT001', 'size' => '1L', 'weight_per_unit' => '1.05', 'package_type' => 'Carton', 'no_of_packages' => 100, 'gw_per_package' => '10.5', 'nw_per_package' => '10', 'total_gw' => '525', 'total_nw' => '500'],
                            ],
                            'P-2-1' => [
                                ['product' => 'GREEN EMERALD LARGE', 'lot' => 'LOT010', 'size' => '500ml', 'weight_per_unit' => '0.55', 'package_type' => 'Crate', 'no_of_packages' => 200, 'gw_per_package' => '6.6', 'nw_per_package' => '6', 'total_gw' => '264', 'total_nw' => '240'],
                            ],
                            'P-2-2' => [
                                ['product' => 'GREEN EMERALD LARGE', 'lot' => 'LOT010', 'size' => '500ml', 'weight_per_unit' => '0.55', 'package_type' => 'Crate', 'no_of_packages' => 200, 'gw_per_package' => '6.6', 'nw_per_package' => '6', 'total_gw' => '264', 'total_nw' => '240'],
                            ],
                            'P-2-3' => [
                                ['product' => 'GREEN EMERALD LARGE', 'lot' => 'LOT010', 'size' => '500ml', 'weight_per_unit' => '0.55', 'package_type' => 'Crate', 'no_of_packages' => 200, 'gw_per_package' => '6.6', 'nw_per_package' => '6', 'total_gw' => '264', 'total_nw' => '240'],
                            ],
                            'P-2-4' => [
                                ['product' => 'GREEN EMERALD LARGE', 'lot' => 'LOT010', 'size' => '500ml', 'weight_per_unit' => '0.55', 'package_type' => 'Crate', 'no_of_packages' => 200, 'gw_per_package' => '6.6', 'nw_per_package' => '6', 'total_gw' => '264', 'total_nw' => '240'],
                            ],
                        ];
                        @endphp

                        @foreach($pallets as $palletName => $items)
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item['product'] }}</td>
                                    <td>{{ $item['lot'] }}</td>
                                    <td>{{ $item['size'] }}</td>
                                    <td>{{ $item['weight_per_unit'] }}</td>
                                    <td>{{ $item['package_type'] }}</td>
                                    <td>{{ $item['no_of_packages'] }}</td>
                                    <td>{{ $item['gw_per_package'] }}</td>
                                    <td>{{ $item['nw_per_package'] }}</td>
                                    <td>{{ $item['total_gw'] }}</td>
                                    <td>{{ $item['total_nw'] }}</td>
                                    <td>{{ $palletName }}</td> {{-- Pallet number shown last --}}
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="tab-pane fade" id="palletizationQRCodes" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Pallet QR Codes</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Pallet No</th>
                            <th>QR Code</th>
                            <th>Product</th>
                            <th>Lot No</th>
                            <th>Size</th>
                            <th>Package Type</th>
                            <th>No. of Packages</th>
                            <th>Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            use Endroid\QrCode\Builder\Builder;
                            use Endroid\QrCode\Writer\PngWriter;

                            $qrCodes = [];

                            foreach ($pallets as $palletNo => $items) {
                                $first = $items[0];
                                $qrData = json_encode([
                                    'pallet_no'      => $palletNo,
                                    'product'        => $first['product'],
                                    'lot'            => $first['lot'],
                                    'size'           => $first['size'],
                                    'package_type'   => $first['package_type'],
                                    'no_of_packages' => $first['no_of_packages'],
                                    'total_gw'       => $first['total_gw'],
                                    'total_nw'       => $first['total_nw']
                                ]);

                                $builder = new Builder(
                                    writer: new PngWriter(),
                                    data: $qrData,
                                    size: 150,
                                    margin: 5
                                );

                                $result = $builder->build();
                                $qrCodes[$palletNo] = 'data:image/png;base64,' . base64_encode($result->getString());
                            }
                            @endphp
                        @foreach($pallets as $palletNo => $items)
                        @php $first = $items[0]; @endphp
                            <tr>
                                <td>{{ $palletNo }}</td>
                                <td>
                                    <img src="{{ $qrCodes[$palletNo] }}" width="100" height="100" alt="QR Code">
                                </td>
                                <td>{{ $first['product'] }}</td>
                                <td>{{ $first['lot'] }}</td>
                                <td>{{ $first['size'] }}</td>
                                <td>{{ $first['package_type'] }}</td>
                                <td>{{ $first['no_of_packages'] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="printQRCode('{{ $qrCodes[$palletNo] }}')">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Status Tab -->
    <div class="tab-pane fade" id="palletizationStatus" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5>Status History</h5>
            </div>
            <div class="card-body">
                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="John Smith">
                    <div class="status-details">
                        <strong>John Smith</strong>
                        <span class="status">Created</span>
                        <span class="description">Palletization record created</span>
                        <span class="date">25 Aug 2025 10:15</span>
                    </div>
                </div>
                <div class="status-log-entry">
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Jane Doe">
                    <div class="status-details">
                        <strong>Jane Doe</strong>
                        <span class="status">Approved</span>
                        <span class="description">Verified by supervisor</span>
                        <span class="date">25 Aug 2025 11:00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    #palletizationTabs { border-bottom: 1px solid #000; }
    #palletizationTabs li.nav-item a { color:#000; }
    #palletizationTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    .status-log-entry { display: flex; align-items: center; margin-bottom: 15px; }
    .status-log-entry .avatar { width: 40px; height: 40px; border-radius: 50%; margin-right: 10px; }
    .status-details { font-size: 14px; }
    .status-details .status { font-weight: bold; margin-left: 5px; }
    .status-details .date { display: block; font-size: 12px; color: #666; }
</style>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#change_status_select').on('change', function(){
        var status = $(this).val();
        var status_text = $(this).find('option:selected').text();
        if(confirm("Do you want to change the status to '" + status_text + "'?")) {
            alert("Status changed to: " + status_text + " (demo only)");
        } else {
            $(this).val('created');
        }
    });
});

function printQRCode(qrSrc) {
    let printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print QR Code</title></head><body>');
    printWindow.document.write('<img src="' + qrSrc + '" style="width:150px;height:150px;">');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
</script>
@endsection
