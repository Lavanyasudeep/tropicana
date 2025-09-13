@extends('adminlte::page')

@section('title', 'View Packing List')

@section('content_header')
    <h1>Packing List</h1>
@endsection

@section('content')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.packing-list.edit', 1) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('admin.inventory.packing-list.print', 1) }}" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
        <a href="{{ route('admin.inventory.packing-list.index') }}" class="btn btn-back"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="action-status">
        <label>Change Status</label>
        <select id="change_status_select">
            <option value="created" selected>Created</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<div class="card page-form">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="pform-panel" style="min-height:150px;">
                    <div class="pform-row">
                        <div class="pform-label">Doc. #</div>
                        <div class="pform-value">PL‑25‑00012</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label">Doc. Date</div>
                        <div class="pform-value">26/08/2025</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label">Gate Pass No.</div>
                        <div class="pform-value">GP-25-0045</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label">Invoice No.</div>
                        <div class="pform-value">INV-25-0010</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label">Status</div>
                        <div class="pform-value">Created</div>
                    </div>
                    <div class="pform-clear"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="pform-panel" style="min-height:150px;">
                    <div class="pform-row">
                        <div class="pform-label">Customer Name</div>
                        <div class="pform-value">Chelur Foods</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label">Contact Number</div>
                        <div class="pform-value">+91 98470 12345</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label">Address</div>
                        <div class="pform-value">Plot No. 45, Food Industrial Estate, Aroor, Kerala, India</div>
                    </div>
                    <div class="pform-clear"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="pform-panel" style="min-height:150px;">
                    <div class="pform-row">
                        <div class="pform-label">Vehicle No.</div>
                        <div class="pform-value">KL-07-CD-4521</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label">Container No.</div>
                        <div class="pform-value">CONT-SEA-00987</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label">Port of Loading</div>
                        <div class="pform-value">Cochin Port</div>
                    </div>
                    <div class="pform-row">
                        <div class="pform-label">Port of Discharge</div>
                        <div class="pform-value">Port of Rotterdam</div>
                    </div>
                    <div class="pform-clear"></div>
                </div>
            </div>
        </div>

        <table class="table table-striped page-list-table mt-3">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>UOM</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Net Weight (KG)</th>
                    <th class="text-right">Gross Weight (KG)</th>
                    <th>Manufacturing Date</th>
                    <th>Expiry Date</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Frozen Peas 5kg</td>
                    <td>Box</td>
                    <td class="text-right">500</td>
                    <td class="text-right">500.00</td>
                    <td class="text-right">520.00</td>
                    <td>10/12/2010</td>
                    <td>01/04/2030</td>
                    <td>Packed in 20kg Boxes</td>
                </tr>
                <tr>
                    <td>Mixed Veg 1kg</td>
                    <td>Box</td>
                    <td class="text-right">300</td>
                    <td class="text-right">300.00</td>
                    <td class="text-right">315.00</td>
                    <td>12/08/2015</td>
                    <td>10/12/2030</td>
                    <td>Packed in 15kg Boxes</td>
                </tr>
                <tr>
                    <td>Paneer Blocks 5kg</td>
                    <td>Box</td>
                    <td class="text-right">200</td>
                    <td class="text-right">200.00</td>
                    <td class="text-right">210.00</td>
                    <td>05/01/2010</td>
                    <td>01/11/2015</td>
                    <td>Packed in 10kg Boxes</td>
                </tr>
            </tbody>
            <tfoot>
            <tr class="total-row">
                <th colspan="2" class="text-right">Total</th>
                <th class="text-right">1000</th>
                <th class="text-right">{{ number_format(1000, 2) }}</th>
                <th class="text-right">{{ number_format(1045, 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
        </table>
    </div>
</div>
@endsection

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
@endsection
