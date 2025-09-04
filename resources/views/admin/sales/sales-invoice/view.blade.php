@extends('adminlte::page')

@section('title', 'View Sales Invoice')

@section('content_header')
    <h1>Sales Invoice</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.sales.sales-invoice.edit', 1) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.sales.sales-invoice.print', 1) }}" target="_blank" class="btn btn-print" ><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.sales.sales-invoice.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status" >
        <label>Change Status</label>
        <select id="change_status_select" >
            <option value="created" >Created</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" id="salesInvoiceTabs" >
    <li class="nav-item">
        <a class="nav-link active" id="sales-invoice-tab" data-toggle="tab" href="#salesInvoice" role="tab">Sales Invoice</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="annexure-tab" data-toggle="tab" href="#annexure" role="tab">Annexure</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="sales-invoice-status-tab" data-toggle="tab" href="#invoiceStatus" role="tab">Status</a>
    </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="salesInvoice" role="tabpanel">
            <div class="card page-form">
                <div class="card-body">
                    <div class="row">
                        <!-- Document Details -->
                        <div class="col-md-4">
                            <div class="pform-panel" style="min-height:150px;">
                                <div class="pform-row"><div class="pform-label">Doc. No.</div><div class="pform-value">INV-2025-001</div></div>
                                <div class="pform-row"><div class="pform-label">Doc. Date</div><div class="pform-value">02/09/2025</div></div>
                                <div class="pform-row"><div class="pform-label">Billing Type</div><div class="pform-value">Monthly</div></div>
                                <div class="pform-row"><div class="pform-label">Status</div><div class="pform-value">Created</div></div>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="col-md-4">
                            <div class="pform-panel" style="min-height:150px;">
                                <div class="pform-row"><div class="pform-label">Customer</div><div class="pform-value">Chelur Foods Pvt Ltd</div></div>
                                <div class="pform-row"><div class="pform-label">Contact No.</div><div class="pform-value">+91 98765 43210</div></div>
                                <div class="pform-row"><div class="pform-label">Credit Limit</div><div class="pform-value">₹ 1,00,000</div></div>
                                <div class="pform-row"><div class="pform-label">Cur. Balance</div><div class="pform-value">₹ 45,000</div></div>
                                <div class="pform-row"><div class="pform-label">GSTIN</div><div class="pform-value">29ABCDE1234F1Z5</div></div>
                            </div>
                        </div>

                        <!-- Vehicle Info -->
                        <div class="col-md-4">
                            <div class="pform-panel" style="min-height:150px;">
                                <div class="pform-row"><div class="pform-label">Vehicle Type</div><div class="pform-value">Refrigerated Truck</div></div>
                                <div class="pform-row"><div class="pform-label">Vehicle No.</div><div class="pform-value">KL-07-BT-9988</div></div>
                                <div class="pform-row"><div class="pform-label">Driver Name</div><div class="pform-value">Ramesh Kumar</div></div>
                                <div class="pform-row"><div class="pform-label">Delivery Address</div><div class="pform-value">Plot 42, Industrial Zone, Navi Mumbai</div></div>
                            </div>
                        </div>
                    </div>

                    <!-- Item Table -->
                    <table class="table table-bordered mt-3 page-list-table">
                        <thead>
                        <tr>
                            <th>Item Type</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th class="text-right">Qty (pallets)</th>
                            <th class="text-right">Rate</th>
                            <th class="text-right">Tax %</th>
                            <th class="text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Frozen</td>
                            <td>Frozen Prawns 5kg</td>
                            <td>Box</td>
                            <td class="text-right">50</td>
                            <td class="text-right">250.00</td>
                            <td class="text-right">18%</td>
                            <td class="text-right">14750.00</td>
                        </tr>
                        <tr>
                            <td>Chilled</td>
                            <td>Paneer Blocks 10kg</td>
                            <td>Crate</td>
                            <td class="text-right">30</td>
                            <td class="text-right">180.00</td>
                            <td class="text-right">12%</td>
                            <td class="text-right">6048.00</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="6" class="text-right">Net Total</td>
                            <td class="text-right">20798.00</td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Billing Scenario -->
                    <div class="row mt-4">
                        <!-- Remarks -->
                        <div class="col-md-6"><br /><br />
                            <div class="remarks" >
                                <label>Remarks</label>
                                <div style="height:100px; width:100%; border:1px solid #CCC; padding:15px;" >Includes generator backup and VAS documentation. No temperature violations recorded.</div>
                            </div>
                        </div>
                        <div class="col-md-6"><br /><br />
                            <div class="pform-panel" style="min-height:250px;">
                                <div class="pform-row"><div class="pform-label">Billing Scenario</div><div class="pform-value">Cold Storage + VAS</div></div>
                                <div class="pform-row"><div class="pform-label">Fixed Charges</div><div class="pform-value">₹ 5000 / month</div></div>
                                <div class="pform-row"><div class="pform-label">Variable Charges</div><div class="pform-value">₹ 20 / pallet/day</div></div>
                                <div class="pform-row"><div class="pform-label">WAS Charges</div><div class="pform-value">₹ 1200</div></div>
                                <div class="pform-row"><div class="pform-label">Power Tariff Hike</div><div class="pform-value">₹ 3.50 / kWh</div></div>
                                <div class="pform-row"><div class="pform-label">Power Cut Backup</div><div class="pform-value">₹ 4.00 / kWh</div></div>
                                <div class="pform-row"><div class="pform-label">Temperature Penalty</div><div class="pform-value">₹ 1000 / incident</div></div>
                                <div class="pform-row"><div class="pform-label">Discount</div><div class="pform-value">₹ 500</div></div>
                                <div class="pform-row"><div class="pform-label"><b>Net Total</b></div><div class="pform-value"><b>₹ 20798.00</b></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="invoiceStatus" role="tabpanel">
            <div class="card">
                <div class="card-header"><h5>Status History</h5></div>
                <div class="card-body">
                    <div class="status-log-entry">
                        <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Admin">
                        <div class="status-details">
                        <strong>Admin</strong>
                        <span class="status">Created</span>
                        <span class="description">Invoice initiated for Chelur Foods</span>
                        <span class="date">02 Sep 2025 10:15</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="annexure" role="tabpanel">
            <div class="card page-form mt-4">
                <div class="card-body">
                    <h6 class="mt-4">Annexure – Daily Pallet Movement & Billing</h6>
                    <div class="page-list-panel">
                        <table class="page-input-table" id="annexure-table">
                            <thead class="thead-light">
                                <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>OP</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>CL</th>
                                <th>OP in UOM</th>
                                <th>In in UOM</th>
                                <th>Out in UOM</th>
                                <th>CL in UOM</th>
                                <th>Chargeable Billing UOM</th>
                                <th>Billed Qty</th>
                                <th>Amount</th>
                                <th>Exceed Qty in UOM</th>
                                <th>Exceed Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 21; $i++)
                                @php
                                    $date = \Carbon\Carbon::create(2025, 8, $i)->format('d/m/Y');
                                    $op = rand(72, 230);
                                    $in = rand(0, 45);
                                    $out = rand(0, 60);
                                    $cl = $op + $in - $out;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $date }}</td>
                                    <td>{{ $op }}</td>
                                    <td>{{ $in }}</td>
                                    <td>{{ $out }}</td>
                                    <td>{{ $cl }}</td>
                                    <td>{{ $op }}</td>
                                    <td>{{ $in }}</td>
                                    <td>{{ $out }}</td>
                                    <td>{{ $cl }}</td>
                                    <td>Fixed 5</td>
                                    <td>5</td>
                                    <td>₹475</td>
                                    <td>0</td>
                                    <td>₹0</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    #invoiceTabs { border-bottom: 1px solid #000; }
    #invoiceTabs li.nav-item {  }
    #invoiceTabs li.nav-item a { color:#000; }
    #invoiceTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #invoiceTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }

    .status-log-entry {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .status-log-entry .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .status-details {
        font-size: 14px;
    }

</style>
@stop

@section('js')
<script>
    document.getElementById('change_status_select').addEventListener('change', function(){
        const statusText = this.options[this.selectedIndex].text;
        if(confirm("Do you want to change the status to '" + statusText + "'?")) {
            alert("Status changed to: " + statusText + " (demo)");
        } else {
            this.value = 'created';
        }
    });
</script>
@stop