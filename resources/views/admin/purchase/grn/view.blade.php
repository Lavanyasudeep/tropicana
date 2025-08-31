@extends('adminlte::page')

@section('title', 'View GRN')

@section('content_header')
    <h1>GRN</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.purchase.grn.edit', 1) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.purchase.grn.print', 1) }}" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.purchase.grn.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
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
<ul class="nav nav-tabs" role="tablist" id="grnTabs">
    <li class="nav-item">
        <a class="nav-link active" id="grn-tab" data-toggle="tab" href="#grnDetails" role="tab">GRN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="grn-pallet-tab" data-toggle="tab" href="#grnPalletDetails" role="tab">GRN with pallet</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="grn-status-tab" data-toggle="tab" href="#grnStatus" role="tab">Status</a>
    </li>
</ul>

<div class="tab-content">

    <!-- GRN Details Tab -->
    <div class="tab-pane fade show active" id="grnDetails" role="tabpanel">
        <div class="card page-form">
            <div class="card-body">
                <div class="row">
                    <!-- Panel 1 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:228px;">
                            <div class="pform-row"><div class="pform-label">Doc No</div><div class="pform-value">GRN-25-00001</div></div>
                            <div class="pform-row"><div class="pform-label">Doc Date</div><div class="pform-value">25/08/2025</div></div>
                            <div class="pform-row"><div class="pform-label">Invoice No</div><div class="pform-value">INV-250100</div></div>
                            <div class="pform-row"><div class="pform-label">Customer Order No</div><div class="pform-value">ORD-90876</div></div>
                            <div class="pform-row"><div class="pform-label">Status</div><div class="pform-value"><span class="badge badge-success">Completed</span></div></div>
                        </div>
                    </div>
                    <!-- Panel 2 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:228px;">
                            <div class="pform-row"><div class="pform-label">Customer</div><div class="pform-value">ABC Foods Ltd</div></div>
                            <div class="pform-row"><div class="pform-label">Packing List No</div><div class="pform-value">PKG-25-00005</div></div>
                            <div class="pform-row"><div class="pform-label">Gate Pass No</div><div class="pform-value">GP-1001</div></div>
                            <div class="pform-row"><div class="pform-label">Vehicle No</div><div class="pform-value">KL-07-AB-1234</div></div>
                            <div class="pform-row"><div class="pform-label">Vehicle Temperature</div><div class="pform-value">-18°C</div></div>
                            <div class="pform-row"><div class="pform-label">Vehicle Temperature Status</div><div class="pform-value">OK</div></div>
                        </div>
                    </div>
                    <!-- Panel 3 -->
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:228px;">
                            <div class="pform-row"><div class="pform-label">Warehouse Unit</div><div class="pform-value">WU-0028</div></div>
                            <div class="pform-row"><div class="pform-label">Dock No</div><div class="pform-value">D-12</div></div>
                            <div class="pform-row"><div class="pform-label">Dock In Time</div><div class="pform-value">12:00</div></div>
                            <div class="pform-row"><div class="pform-label">Total Pallets</div><div class="pform-value">8</div></div>
                            <div class="pform-row"><div class="pform-label">Remarks</div><div class="pform-value">All items passed QC inspection</div></div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped page-list-table mt-3">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Lot</th>
                            <th>Qty</th>
                            <th>UOM</th>
                            <th>Total G.W.</th>
                            <th>Total N.W.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $products = [
                                'RED JOANPRINCE SMALL' => [[
                                    'product' => 'RED JOANPRINCE SMALL',
                                    'lot' => 'LOT001',
                                    'no_of_packages' => 100,
                                    'package_type' => 'Carton',
                                    'total_gw' => '525',
                                    'total_nw' => '500',
                                ]],
                                'GREEN EMERALD LARGE' => [[
                                    'product' => 'GREEN EMERALD LARGE',
                                    'lot' => 'LOT010',
                                    'no_of_packages' => 200,
                                    'package_type' => 'Crate',
                                    'total_gw' => '264',
                                    'total_nw' => '240',
                                ]],
                                'BLUE OCEAN MEDIUM' => [[
                                    'product' => 'BLUE OCEAN MEDIUM',
                                    'lot' => 'LOT015',
                                    'no_of_packages' => 150,
                                    'package_type' => 'Sack',
                                    'total_gw' => '180',
                                    'total_nw' => '150',
                                ]],
                                'YELLOW SUNBURST XL' => [[
                                    'product' => 'YELLOW SUNBURST XL',
                                    'lot' => 'LOT020',
                                    'no_of_packages' => 80,
                                    'package_type' => 'Carton',
                                    'total_gw' => '400',
                                    'total_nw' => '380',
                                ]],
                                'ORANGE BLAZE SMALL' => [[
                                    'product' => 'ORANGE BLAZE SMALL',
                                    'lot' => 'LOT025',
                                    'no_of_packages' => 100,
                                    'package_type' => 'Crate',
                                    'total_gw' => '260',
                                    'total_nw' => '250',
                                ]],
                                'PURPLE REGALIA' => [[
                                    'product' => 'PURPLE REGALIA',
                                    'lot' => 'LOT030',
                                    'no_of_packages' => 140,
                                    'package_type' => 'Carton',
                                    'total_gw' => '420',
                                    'total_nw' => '400',
                                ]],
                                'WHITE CRYSTAL LARGE' => [[
                                    'product' => 'WHITE CRYSTAL LARGE',
                                    'lot' => 'LOT035',
                                    'no_of_packages' => 60,
                                    'package_type' => 'Bag',
                                    'total_gw' => '120',
                                    'total_nw' => '115',
                                ]],
                                'BLACK DIAMOND MEDIUM' => [[
                                    'product' => 'BLACK DIAMOND MEDIUM',
                                    'lot' => 'LOT040',
                                    'no_of_packages' => 90,
                                    'package_type' => 'Crate',
                                    'total_gw' => '220',
                                    'total_nw' => '210',
                                ]],
                                'SILVER MIST SMALL' => [[
                                    'product' => 'SILVER MIST SMALL',
                                    'lot' => 'LOT045',
                                    'no_of_packages' => 110,
                                    'package_type' => 'Carton',
                                    'total_gw' => '330',
                                    'total_nw' => '320',
                                ]],
                                'GOLDEN PEARL XL' => [[
                                    'product' => 'GOLDEN PEARL XL',
                                    'lot' => 'LOT050',
                                    'no_of_packages' => 130,
                                    'package_type' => 'Crate',
                                    'total_gw' => '390',
                                    'total_nw' => '375',
                                ]],
                            ];
                        @endphp

                        @foreach($products as $productName => $items)
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item['product'] }}</td>
                                    <td>{{ $item['lot'] }}</td>
                                    <td>{{ $item['no_of_packages'] }}</td>
                                    <td>{{ $item['package_type'] }}</td>
                                    <td>{{ $item['total_gw'] }}</td>
                                    <td>{{ $item['total_nw'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pallet Wise GRN Details Tab -->
    <div class="tab-pane fade" id="grnPalletDetails" role="tabpanel">
        @php
        use Carbon\Carbon;

        function formatRange($start, $end) {
            $s = Carbon::createFromFormat('H:i', $start);
            $e = Carbon::createFromFormat('H:i', $end);
            $diff = $s->diff($e);
            return sprintf('%s – %s (%02d:%02d)', $start, $end, $diff->h, $diff->i);
        }

        $pallets = [
            // RED JOANPRINCE SMALL – 3 pallets
            'P-1-1' => [[
                'product'=>'RED JOANPRINCE SMALL','lot'=>'LOT001','package_type'=>'Carton','no_of_packages'=>60,
                'total_gw'=>'315','total_nw'=>'300','room'=>'R-01','pallet_no'=>'PAL-0001',
                'palletized_by'=>'Ramesh Kumar','palletization_time'=>'09:10',
                'palletization_start'=>'09:10','palletization_end'=>'10:00',
                'put_away_by'=>'Ajay Menon','put_away_time'=>'10:00',
                'putaway_start'=>'10:00','putaway_end'=>'10:50'
            ]],
            'P-1-2' => [[
                'product'=>'RED JOANPRINCE SMALL','lot'=>'LOT001','package_type'=>'Carton','no_of_packages'=>40,
                'total_gw'=>'210','total_nw'=>'200','room'=>'R-01','pallet_no'=>'PAL-0002',
                'palletized_by'=>'Sunil Varma','palletization_time'=>'09:15',
                'palletization_start'=>'09:15','palletization_end'=>'10:05',
                'put_away_by'=>'Anil Kumar','put_away_time'=>'10:05',
                'putaway_start'=>'10:05','putaway_end'=>'10:55'
            ]],
            'P-1-3' => [[
                'product'=>'RED JOANPRINCE SMALL','lot'=>'LOT001','package_type'=>'Carton','no_of_packages'=>50,
                'total_gw'=>'262.5','total_nw'=>'250','room'=>'R-02','pallet_no'=>'PAL-0003',
                'palletized_by'=>'Vijay Nair','palletization_time'=>'09:20',
                'palletization_start'=>'09:20','palletization_end'=>'10:10',
                'put_away_by'=>'Kiran Das','put_away_time'=>'10:10',
                'putaway_start'=>'10:10','putaway_end'=>'11:00'
            ]],

            // GREEN EMERALD LARGE – 2 pallets
            'P-2-1' => [[
                'product'=>'GREEN EMERALD LARGE','lot'=>'LOT010','package_type'=>'Crate','no_of_packages'=>120,
                'total_gw'=>'396','total_nw'=>'360','room'=>'R-03','pallet_no'=>'PAL-0004',
                'palletized_by'=>'Anoop Joseph','palletization_time'=>'09:25',
                'palletization_start'=>'09:25','palletization_end'=>'10:15',
                'put_away_by'=>'Rahul Dev','put_away_time'=>'10:15',
                'putaway_start'=>'10:15','putaway_end'=>'11:05'
            ]],
            'P-2-2' => [[
                'product'=>'GREEN EMERALD LARGE','lot'=>'LOT010','package_type'=>'Crate','no_of_packages'=>80,
                'total_gw'=>'264','total_nw'=>'240','room'=>'R-03','pallet_no'=>'PAL-0005',
                'palletized_by'=>'Deepak S','palletization_time'=>'09:30',
                'palletization_start'=>'09:30','palletization_end'=>'10:20',
                'put_away_by'=>'Binu Raj','put_away_time'=>'10:20',
                'putaway_start'=>'10:20','putaway_end'=>'11:10'
            ]],

            // BLUE OCEAN MEDIUM – 1 pallet
            'P-3-1' => [[
                'product'=>'BLUE OCEAN MEDIUM','lot'=>'LOT015','package_type'=>'Sack','no_of_packages'=>150,
                'total_gw'=>'180','total_nw'=>'150','room'=>'R-02','pallet_no'=>'PAL-0006',
                'palletized_by'=>'Nikhil Mathew','palletization_time'=>'09:35',
                'palletization_start'=>'09:35','palletization_end'=>'10:25',
                'put_away_by'=>'Sandeep Menon','put_away_time'=>'10:25',
                'putaway_start'=>'10:25','putaway_end'=>'11:15'
            ]],

            // YELLOW SUNBURST XL – 1 pallet
            'P-4-1' => [[
                'product'=>'YELLOW SUNBURST XL','lot'=>'LOT020','package_type'=>'Carton','no_of_packages'=>80,
                'total_gw'=>'400','total_nw'=>'380','room'=>'R-04','pallet_no'=>'PAL-0007',
                'palletized_by'=>'Suresh P','palletization_time'=>'09:40',
                'palletization_start'=>'09:40','palletization_end'=>'10:30',
                'put_away_by'=>'Ravi M','put_away_time'=>'10:30',
                'putaway_start'=>'10:30','putaway_end'=>'11:20'
            ]],

            // ORANGE BLAZE SMALL – 2 pallets
            'P-5-1' => [[
                'product'=>'ORANGE BLAZE SMALL','lot'=>'LOT025','package_type'=>'Crate','no_of_packages'=>60,
                'total_gw'=>'156','total_nw'=>'150','room'=>'R-05','pallet_no'=>'PAL-0008',
                'palletized_by'=>'Manoj Pillai','palletization_time'=>'09:45',
                'palletization_start'=>'09:45','palletization_end'=>'10:35',
                'put_away_by'=>'Saji K','put_away_time'=>'10:35',
                'putaway_start'=>'10:35','putaway_end'=>'11:25'
            ]],
            'P-5-2' => [[
                'product'=>'ORANGE BLAZE SMALL','lot'=>'LOT025','package_type'=>'Crate','no_of_packages'=>40,
                'total_gw'=>'104','total_nw'=>'100','room'=>'R-05','pallet_no'=>'PAL-0009',
                'palletized_by'=>'Manoj Pillai','palletization_time'=>'09:47',
                'palletization_start'=>'09:47','palletization_end'=>'10:37',
                'put_away_by'=>'Saji K','put_away_time'=>'10:37',
                'putaway_start'=>'10:37','putaway_end'=>'11:27'
            ]],

            // PURPLE REGALIA – 1 pallet
            'P-6-1' => [[
                'product'=>'PURPLE REGALIA','lot'=>'LOT030','package_type'=>'Carton','no_of_packages'=>140,
                'total_gw'=>'420','total_nw'=>'400','room'=>'R-01','pallet_no'=>'PAL-0010',
                'palletized_by'=>'Lijo Varghese','palletization_time'=>'09:50',
                'palletization_start'=>'09:50','palletization_end'=>'10:40',
                'put_away_by'=>'Thomas George','put_away_time'=>'10:40',
                'putaway_start'=>'10:40','putaway_end'=>'11:30'
            ]],

            // WHITE CRYSTAL LARGE – 1 pallet
            'P-7-1' => [[
                'product'=>'WHITE CRYSTAL LARGE','lot'=>'LOT035','package_type'=>'Bag','no_of_packages'=>60,
                'total_gw'=>'120','total_nw'=>'115','room'=>'R-06','pallet_no'=>'PAL-0011',
                'palletized_by'=>'George Mathew','palletization_time'=>'09:55',
                'palletization_start'=>'09:55','palletization_end'=>'10:45',
                'put_away_by'=>'Akhil V','put_away_time'=>'10:45',
                'putaway_start'=>'10:45','putaway_end'=>'11:35'
            ]],

            // BLACK DIAMOND MEDIUM – 1 pallet
            'P-8-1' => [[
                'product'=>'BLACK DIAMOND MEDIUM','lot'=>'LOT040','package_type'=>'Crate','no_of_packages'=>90,
                'total_gw'=>'220','total_nw'=>'210','room'=>'R-03','pallet_no'=>'PAL-0012',
                'palletized_by'=>'Arun R','palletization_time'=>'10:00',
                'palletization_start'=>'10:00','palletization_end'=>'10:50',
                'put_away_by'=>'Mathew K','put_away_time'=>'10:50',
                'putaway_start'=>'10:50','putaway_end'=>'11:40'
            ]],

            // SILVER MIST SMALL – 1 pallet
            'P-9-1' => [[
                'product'=>'SILVER MIST SMALL','lot'=>'LOT045','package_type'=>'Carton','no_of_packages'=>110,
                'total_gw'=>'330','total_nw'=>'320','room'=>'R-04','pallet_no'=>'PAL-0013',
                'palletized_by'=>'John Paul','palletization_time'=>'10:05',
                'palletization_start'=>'10:05','palletization_end'=>'10:55',
                'put_away_by'=>'Binu Mathew','put_away_time'=>'10:55',
                'putaway_start'=>'10:55','putaway_end'=>'11:45'
            ]],

            // GOLDEN PEARL XL – 1 pallet
            'P-10-1' => [[
                'product'=>'GOLDEN PEARL XL','lot'=>'LOT050','package_type'=>'Crate','no_of_packages'=>130,
                'total_gw'=>'390','total_nw'=>'375','room'=>'R-02','pallet_no'=>'PAL-0014',
                'palletized_by'=>'Naveen C','palletization_time'=>'10:10',
                'palletization_start'=>'10:10','palletization_end'=>'11:00',
                'put_away_by'=>'Praveen Lal','put_away_time'=>'11:00',
                'putaway_start'=>'11:00','putaway_end'=>'11:50'
            ]],
        ];
        @endphp
        <div class="card">
            <div class="card-header">
                <h5>Pallet Wise GRN Detail</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped page-list-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Lot</th>
                            <th>Qty</th>
                            <th>UOM</th>
                            <th>Room</th>
                            <th>Pallet No</th>
                            <th>Palletized By</th>
                            <th>Palletization Time</th>
                            <th>Put Away By</th>
                            <th>Put Away Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pallets as $palletNo => $items)
                        @php $first = $items[0]; @endphp
                            <tr>
                                <td>{{ $first['product'] }}</td>
                                <td>{{ $first['lot'] }}</td>
                                <td>{{ $first['no_of_packages'] }}</td>
                                <td>{{ $first['package_type'] }}</td>
                                <td>{{ $first['room'] }}</td>
                                <td>{{ $first['pallet_no'] }}</td>
                                <td>{{ $first['palletized_by'] }}</td>
                                <td>{{ formatRange($first['palletization_start'], $first['palletization_end']) }}</td>
                                <td>{{ $first['put_away_by'] }}</td>
                                <td>{{ formatRange($first['putaway_start'], $first['putaway_end']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Status Tab -->
    <div class="tab-pane fade" id="grnStatus" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5>Status History</h5>
        </div>
        <div class="card-body">

            <!-- Entry 1 -->
            <div class="status-log-entry">
                <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="John Smith">
                <div class="status-details">
                    <strong>John Smith</strong>
                    <span class="status">Created</span>
                    <span class="description">GRN record created</span>
                    <span class="date">25 Aug 2025 10:15</span>
                </div>
            </div>

            <!-- Entry 2 -->
            <div class="status-log-entry">
                <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Jane Doe">
                <div class="status-details">
                    <strong>Jane Doe</strong>
                    <span class="status">Approved</span>
                    <span class="description">Verified by supervisor</span>
                    <span class="date">25 Aug 2025 11:00</span>
                </div>
            </div>

            <!-- Entry 3 (dummy extra) -->
            <div class="status-log-entry">
                <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Amit Verma">
                <div class="status-details">
                    <strong>Amit Verma</strong>
                    <span class="status">Put Away Complete</span>
                    <span class="description">All pallets stored in designated racks</span>
                    <span class="date">25 Aug 2025 11:45</span>
                </div>
            </div>

        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.tab-pane -->

@endsection

@section('css')
<style>
    #grnTabs { border-bottom: 1px solid #000; }
    #grnTabs li.nav-item a { color:#000; }
    #grnTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
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

</script>
@endsection
