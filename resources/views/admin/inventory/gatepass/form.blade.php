@extends('adminlte::page')

@section('title', 'Create Gatepass-Out')

@section('content_header')
    <h1>Gate Pass-out</h1>
@endsection

@section('content')

@php
   if(isset($gatepass)) {
        $page_title = 'Edit';
        $action = route('admin.inventory.gatepass.update', $gatepass->gate_pass_id);
        $method = 'PUT';

        $doc_no = $gatepass->doc_no;
        $doc_date = $gatepass->doc_date;
        $status = $gatepass->status;
        $client_id = $gatepass->client_id;
        $contact_name = $gatepass->contact_name;
        $contact_address = $gatepass->contact_address;
        $vehicle_no = $gatepass->vehicle_no;
        $movement_type = $gatepass->movement_type;
        $driver_name = $gatepass->driver_name;
        $transport_mode = $gatepass->transport_mode;
        $remarks = $gatepass->remarks;
    } else {
        $page_title = 'Create';
        $action = route('admin.inventory.gatepass.store');
        $method = 'POST';

        $doc_no = '';
        $doc_date = date('Y-m-d');
        $status = '';
        $client_id = '';
        $contact_name = '';
        $contact_address = '';
        $vehicle_no = '';
        $movement_type = '';
        $driver_name = '';
        $transport_mode = '';
        $remarks = '';
    }
@endphp

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>{{ $page_title }}</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.inventory.gatepass.index') }}" class="btn btn-success" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-form page-form-add" >
    <div class="card-body">
        <form method="POST" action="{{ $action }}" id="outwardForm">
            @csrf
            @method($method)
            <div class="row" >
                <!-- Panel 1 -->
                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height: 150px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. #</div>
                            <div class="pform-value" >
                                <input type="text" id="doc_no" value="{{ old('doc_no', $doc_no) }}" readonly>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Doc. Date</div>
                            <div class="pform-value" >
                                <input type="date" id="doc_date" name="doc_date" value="{{ old('doc_date', $doc_date) }}" >
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Status</div>
                            <div class="pform-value">
                                <select name="status" id="status">
                                    <option value="created" @selected(old('status', $status) == 'created')>Created</option>
                                    <option value="approved" @selected(old('status', $status) == 'approved')>Approved</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Customer</div>
                            <div class="pform-value" >
                                <select name="client_id" id="client_id">
                                    <option value="">- Select -</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->client_id }}"
                                            @selected(old('client_id', $client_id) == $client->client_id)
                                        >
                                            {{ $client->client_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 2 -->
                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height: 150px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Name</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name', $contact_name ?? '') }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Contact Address</div>
                            <div class="pform-value" >
                                <input type="text" id="contact_address" name="contact_address" value="{{ old('contact_address', $contact_address ?? '') }}" >
                            </div>
                        </div>
                        <div class="pform-row">
                            <div class="pform-label">Remarks</div>
                            <div class="pform-value">
                                <textarea name="remarks" rows="3" >{{ old('remarks', $remarks) }}</textarea>
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>

                <!-- Panel 3 -->
                <div class="col-md-4" >
                    <div class="pform-panel" style="min-height: 150px;" >
                        <div class="pform-row" >
                            <div class="pform-label" >Movement Type</div>
                            <div class="pform-value" >
                                <select name="movement_type" id="movement_type">
                                    <option value="">- Select -</option>
                                    <option value="inward" @selected($movement_type == 'Inward')>Inward</option>
                                    <option value="outward" @selected($movement_type == 'Outward')>Outward</option>
                                    <option value="returnable" @selected($movement_type == 'Returnable')>Returnable</option>
                                    <option value="non_returnable" @selected($movement_type == 'Non-Returnable')>Non Returnable</option>
                                </select>
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Vehicle No</div>
                            <div class="pform-value" >
                                <input type="text" id="vehicle_no" name="vehicle_no" value="{{ old('vehicle_no', $vehicle_no ?? '') }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Driver Name</div>
                            <div class="pform-value" >
                                <input type="text" id="driver_name" name="driver_name" value="{{ old('driver_name', $driver_name ?? '') }}" >
                            </div>
                        </div>
                        <div class="pform-row" >
                            <div class="pform-label" >Transport Mode</div>
                            <div class="pform-value" >
                                <input type="text" id="transport_mode" name="transport_mode" value="{{ old('transport_mode', $transport_mode) }}">
                            </div>
                        </div>
                        <div class="pform-clear" ></div>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-md-12" >
                    <div class="page-list-panel" >
                        <table class="page-list-table" id="gatepassCreateTable" >
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>UOM</th>
                                    <th>Qty</th>
                                    <th>Returnable?</th>
                                    <th>Expected Return Date</th>
                                    <th><button type="button" onclick="addRow()" class="btn btn-sm btn-success">+</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($gatepass) && $gatepass->gatePassDetails)
                                    @foreach($gatepass->gatePassDetails as $idx => $item)
                                        <tr>
                                            <td><input name="items[$idx][item_name]" class="form-control" value="{{ $item->item_name }}" ></td>
                                            <td><input name="items[$idx][uom]" class="form-control" value="{{ $item->uom }}" ></td>
                                            <td><input name="items[$idx][quantity]" type="number" class="form-control" value="{{ $item->quantity }}" ></td>
                                            <td><input name="items[$idx][is_returnable]" type="checkbox" value="{{ $item->is_returnable }}"></td>
                                            <td><input name="items[$idx][expected_return_date]" type="date" class="form-control" value="{{ $item->expected_return_date }}"></td>
                                            <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">-</button></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><input name="items[0][item_name]" class="form-control"></td>
                                        <td><input name="items[0][uom]" class="form-control"></td>
                                        <td><input name="items[0][quantity]" type="number" class="form-control"></td>
                                        <td><input name="items[0][is_returnable]" type="checkbox" value="1"></td>
                                        <td><input name="items[0][expected_return_date]" type="date" class="form-control"></td>
                                        <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">-</button></td>
                                    </tr>
                                @endif
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
</style>
@stop

@section('js')
<script>
let rowIdx = 1;
function addRow() {
    let table = document.querySelector("#gatepassCreateTable tbody");
    let newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td><input name="items[${rowIdx}][item_name]" class="form-control"></td>
        <td><input name="items[${rowIdx}][uom]" class="form-control"></td>
        <td><input name="items[${rowIdx}][quantity]" type="number" class="form-control"></td>
        <td><input name="items[${rowIdx}][is_returnable]" type="checkbox" value="1"></td>
        <td><input name="items[${rowIdx}][expected_return_date]" type="date" class="form-control"></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">-</button></td>
    `;
    table.appendChild(newRow);
    rowIdx++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>
@stop