@extends('adminlte::page')

@section('title', 'Order/Packing List')

@section('content_header')
    <h1>Order/Packing List</h1>
@endsection

@section('content')
<div class="page-sub-header">
    <h3>Create Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.inventory.packing-list.index') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" role="tablist" >
        <li class="nav-item">
            <a class="nav-link active" id="packing-list-tab" data-toggle="tab" href="#packingList" role="tab">Basic Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="packinglist-attachment-tab" data-toggle="tab" href="#packingListAttachment" role="tab">Attachment</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="packingList" role="tabpanel">
            <div class="card page-form page-form-add">
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf
                        <div class="row">
                            <!-- Panel 1: Document Info -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 183px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Doc No.</div>
                                        <div class="pform-value"><input type="text" name="pl_no" value="PL-25-00012" readonly></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Doc Date</div>
                                        <div class="pform-value"><input type="date" name="pl_date" value="2025-08-26"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Date of Arrived</div>
                                        <div class="pform-value">
                                            <input type="date" value="" >
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Gate Pass No.</div>
                                        <div class="pform-value">
                                            <select name="gate_pass_id" id="gate_pass_id" class="form-control">
                                                <option value="">- Select -</option>
                                                <option value="GP-25-0045" selected>GP-25-0045</option>
                                                <option value="GP-25-0046">GP-25-0046</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Invoice No.</div>
                                        <div class="pform-value"><input type="text" name="invoice_no" placeholder="Eg: INV-25-0010" ></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel 2: Customer Info -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 183px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Customer Name</div>
                                        <div class="pform-value"><input type="text" name="customer_name" placeholder="" readonly></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Number</div>
                                        <div class="pform-value"><input type="text" name="customer_contact" placeholder="" readonly></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Contact Email</div>
                                        <div class="pform-value"><input type="text" value="" readonly></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Address</div>
                                        <div class="pform-value"><textarea name="customer_address" rows="3" readonly></textarea></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel 3: Shipment Info -->
                            <div class="col-md-4">
                                <div class="pform-panel" style="min-height: 183px;">
                                    <div class="pform-row">
                                        <div class="pform-label">Transport Mode</div>
                                        <div class="pform-value">
                                            <input type="text" placeholder="Eg: Refrigerated Truck, VAN, etc">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Vehicle No.</div>
                                        <div class="pform-value"><input type="text" name="vehicle_no" placeholder="Eg: KL-07-CD-4521" ></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Container No.</div>
                                        <div class="pform-value"><input type="text" name="container_no" placeholder="Eg: CONT-SEA-00987"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Driver Name</div>
                                        <div class="pform-value"><input type="text" name="driver_name" value="" ></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Driver Mobile No.</div>
                                        <div class="pform-value"><input type="text" name="driver_mobile_no" value="" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="page-list-panel">
                                    <table class="page-input-table" id="packingListItemsTable">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>UOM</th>
                                                <th>Batch No.</th>
                                                <th>Gross Weight (KG)</th>
                                                <th>Net Weight (KG)</th>
                                                <th><button type="button" onclick="addRow()" class="btn btn-sm btn-success"><i class="fa fa-plus" ></i></button></th>   
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><input class="form-control" value=""></td>
                                                <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash" ></i></button></td>
                                            </tr>
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
        </div>

        <!-- Attachment Tab -->
        <div class="tab-pane fade" id="packingListAttachment" role="tabpanel">
            <x-attachment-uploader 
                :tableName="'packing_list'" 
                :rowId="'PL-25-00012'" 
            />
        </div>
    </div>
</div>
@endsection
