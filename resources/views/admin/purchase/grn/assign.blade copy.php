@extends('adminlte::page')

@section('title', 'Assign Products')

@section('content_header')
    <h1>Inward</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>Assign Products</h3>
    <div class="action-btns" >
        <a href="#" id="prodSpecBtn" class="btn btn-create" >Product Specification</a>
        <a href="#" id="confirmAssign" class="btn btn-save" disabled >Assign Product</a>
        <a href="{{ route('admin.purchase.grn.view', $grnBatchID) }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-list-panel" >   
    <div class="card-body">
        <form id="assignStorageForm" >
            @csrf
            <div class="page-form page-form-add" >
                <div class="row">
                    <div class="col-md-4">
                        <div class="pform-panel" style="min-height:195px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. # </div>
                                <div class="pform-value" ><input type="text" name="doc_no" id="doc-no" value="{{ old('doc_no', $grnDetail->packingListDetail->inward->doc_no ?? '') }}" readonly /></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Doc. Date <i class="pform-required" ></i></div>
                                <div class="pform-value" ><input type="date" name="doc_date" id="doc-date" value="{{ old('doc_date', $grnDetail->packingListDetail->inward->doc_date ?? $defaultDate) }}" class="pform-required" /></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Client <i class="pform-required" ></i></div>
                                <div class="pform-value" >
                                    <select name="client_id" id="client-id" class="select2 pform-required" >
                                        <option value="">- Select -</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->client_id }}" {{ isset($grnDetail->grn->packingList->client_id) && $grnDetail->grn->packingList->client_id == $client->client_id ? 'selected' : 'selected' }}>
                                                {{ $client->client_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Product</div>
                                <div class="pform-value" >: <span id="assign-product-name" >{{ $grnDetail->productMaster->product_description }}</span></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Package Type</div>
                                <div class="pform-value" >: <span id="assign-package-unit" >{{ $grnDetail->productMaster->purchaseunit->conversion_unit??'' }}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:195px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Qty per Pallet <i class="pform-required" ></i></div>
                                <div class="pform-value" ><input type="number" id="package-qty-per-pallet" name="package_qty_per_pallet" value="{{ old('package_qty_per_pallet', $grnDetail->packingListDetail->package_qty_per_pallet ?? '') }}" class="pform-required" /></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Item Numbers per Package <i class="pform-required" ></i></div>
                                <div class="pform-value" ><input type="number" id="item-size-per-package" name="item_size_per_package" value="{{  old('item_size_per_package', $grnDetail->packingListDetail->item_size_per_package?? '') }}" class="pform-required" /></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Weight per Pallet <i class="pform-required" ></i></div>
                                <div class="pform-value" ><input type="number" id="weight-per-pallet" name="weight_per_pallet" value="{{ old('weight_per_pallet', $grnDetail->packingListDetail->weight_per_pallet?? '') }}" class="pform-required" /></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >N.W. per Package <i class="pform-required" ></i></div>
                                <div class="pform-value" ><input type="number" id="assign-nw-per-package" name="nw_per_package" value="{{ old('nw_per_package', $grnDetail->packingListDetail->nw_per_package?? '') }}" class="pform-required" /></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >G.W. per Package <i class="pform-required" ></i></div>
                                <div class="pform-value" ><input type="number" id="assign-gw-per-package" name="gw_per_package" value="{{ old('gw_per_package', $grnDetail->pickingListDetail->gw_per_package?? '') }}" class="pform-required" /></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="pform-panel" style="min-height:195px;" >
                            <div class="pform-row" >
                                <div class="pform-label" >Pallet Type <i class="pform-required" ></i></div>
                                <div class="pform-value" >
                                    <select name="pallet_type_id" id="pallet-type-id" class="select2 pform-required" >
                                        <option value="">- Select -</option>
                                        @foreach($palletTypes as $palletType)
                                            <option value="{{ $palletType->pallet_type_id }}" {{ isset($grnDetail->inwardDetail->pallet->pallet_type_id) && $grnDetail->inwardDetail->pallet->pallet_type_id == $palletType->pallet_type_id ? 'selected' : 'selected' }}>
                                                {{ $palletType->type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >No of Packages</div>
                                <div class="pform-value" >: <span id="assign-package-qty" >{{ $grnDetail->ReceivedQuantity??0 }}</span></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Weight Per Unit</div>
                                <div class="pform-value" >: <span id="assign-grn-weight-per-unit" >{{ $grnDetail->WeightPerUnit??0 }}</span></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Pallets Required</div>
                                <div class="pform-value" >: <span id="assign-pallet-required-qty" >{{ $grnDetail->required_pallets??0 }}</span></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Pallets Selected</div>
                                <div class="pform-value" >: <span id="assign-pallet-selected-qty" >0</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div>
                <input type="hidden" id="selected-prod-box-count" name="selected_prod_box_count" value="{{ $grnDetail->box_count }}">
                <input type="hidden" id="product-master-id" name="product_master_id" value="{{ $grnDetail->ProductMasterID  }}">
                <input type="hidden" id="grn-detail-id" name="grn_detail_id" value="{{ $grnDetail->GRNProductID }}" >
                <input type="hidden" id="grn-supplier-id" name="grn_supplier_id" value="{{ $grnDetail->grn->SupplierID }}" >
                <!-- Tabs -->
                <ul id="roomTabs" class="nav nav-tabs" >
                    @foreach($rooms as $room)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-room-id="{{ $room->room_id }}" href="#">
                                {{ $room->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div id="roomTabContent" >
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Product Specification Modal -->
<div class="modal fade" id="prodSpecModal" tabindex="-1" aria-hidden="true" >
  <div class="modal-dialog" style="width:600px; max-width: 1000px !important;">
    <div class="modal-content" >
      <div class="modal-header" >
        <h5 class="modal-title" >Product Specifications</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <table class="table page-input-table" id="specificationTable1" >
            <thead>
                <tr>
                    <th style="width: 45%" >Attribute</th>
                    <th style="width: 45%" >Value</th>
                    <th style="width: 10%" ></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success" onclick="addSpecRow(1)" >
            <i class="fas fa-plus"></i> Add More
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Rack Detail Modal -->
<div class="modal fade" id="rackDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-l modal-dialog-centered">
    <div class="modal-content text-white">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-white">Rack Detail View</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body text-center">
        <div id="rackDisplayArea" class="position-relative d-inline-block">
          <img id="rackImage" src="{{ asset('/images/5rowrack.png') }}" class="img-fluid" />
          <!-- Pallets will be appended here -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Product Attribute Modal -->
<div class="modal fade" id="createAttributeModal" tabindex="-1" aria-labelledby="attributeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="createAttributeForm">
    @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Product Attribute</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Attribute Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Input Type</label>
                    <select name="data_type" class="form-control" required >
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="date">Date</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Required?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_required" value="1" checked> Yes
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_required" value="0"> No
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Attribute</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>

@stop

@section('css')
<style>
    #roomTabs { border-bottom: 1px solid #000; }
    #roomTabs li.nav-item {  }
    #roomTabs li.nav-item a { color:#000; }
    #roomTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #roomTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }
    #roomTabContent { padding:15px 0; background-color:#FFF; width: 100%; }

    .rackColumn { width:19.6%; height:auto; float:left; border:1px solid #555; padding:5px 5px 5px 5px; margin:0 0 10px 2px; overflow: auto; min-height: 318px;}
    .rackColumn .rackColumnName { font-size:14px; margin-bottom:5px; background-color: #9d0f0f; color: white; padding: 5px; text-align: center; }
    .rackColumn .slotRows { margin:0; padding:0; list-style-type: none; }
    .rackColumn .slotRows li { margin:0 0 -1px 0; padding:0; border:1px solid #CCC; float:left; width:20%; height:50px; position:relative; }
    .rackColumn .slotRows li:first-child { width:100%; height:25px; padding:5px; }
    .rackColumn .slotRows li:first-child span { font-size:12px; }
    .rackColumn .slotRows li label { font-weight:normal; font-size:9px; margin:0; width:100%; display: block; cursor:pointer; height: 100%;}
    .rackColumn .slotRows li label input { float:left; }
    .rackColumn .slotRows li label input[type="checkbox"] { display:none; }
    .rackColumn .slotRows li label span { float:left; display:inline-block; margin:-2px 0 0 5px; }
    .rackColumn .slotRows li.out-of-stock { background-color:#ef7676; }
    .rackColumn .slotRows li.out-of-stock label { color:#FFF; }
    .rackColumn .slotRows li.out-of-stock input { display:none; }
    .rackColumn .slotRows li:first-child label input[type="checkbox"] { display:block; }
    .rackColumn .slotRows li.out-of-stock label span { margin-left:18px; }

    .rackColumn .slotRows li.available { background-color: #EEE; }
    .rackColumn .slotRows li.selected { background-color: #32a616; }
    .rackColumn .slotRows li.picked { background-color: #36abe3; }
    .rackColumn .slotRows li.partial-stock { background-color:#f0b36b; }

    .rackColumn .slotRows li.partial-stock label { color:#FFF; }
    .rackColumn .slotRows li .rack-level-no { width: 100%; height: 94%; border-radius: 2px; margin: 0px 0px 0 0px; text-align: center; font-size: 14px; padding-top: 6px; }
    .rackColumn .slotRows li .rack-depth-no { width: 100%; height: 94%; border-radius: 2px; margin: 0px 0px 0 0px; text-align: center; font-size: 14px; padding-top: 6px; }
/* 
    #assignStorageForm strong { width:124px; display:inline-block; float:left; font-size:14px; }
    #assignStorageForm div.frm-v { float:left; font-size:14px; }
    #assignStorageForm div.frm-v::before { content:': '; margin-right: 5px; }
    #assignStorageForm input[type="text"], input[type="number"], input[type="date"], select { width:100px; border:1px solid #CCC; border-radius:3px; }
    #assignStorageForm input[readonly] { background-color: #f5f5f5 !important; cursor: not-allowed; } */
    
    .product-images {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-bottom: 6px;
        flex-wrap: wrap;
    }
    .product-icon{
        position: relative;
    }

    .product-icon svg {
        width: 40px;
        height: 34px;
    }

    .product-images.empty {
        width: 100%;
        height: 25px;
        border-radius: 2px;
    }
    .product-count {
        position: absolute;
        top: -4px;
        right: -7px;
        background-color: #0e0f0f;
        color: #fff;
        font-size: 9px;
        font-weight: bold;
        padding: 1px 3px;
        border-radius: 10px;
        z-index: 2;
    }

    .empty-slot {
        background-color: #f7f7f7;
    }

    .pallet-label {
        font-size: 11px;
        font-weight: bold;
        color: #555;
        margin-bottom: 4px;
        text-align: center;
        display: none;
    }

    .empty-slot-label {
        font-size: 11px;
        color: #aaa;
        display: block;
        text-align: center;
        padding-top: 8px;
    }

    .pallet-wrapper {
        position: absolute;
        display: inline-block;
        width:100%;
        height:100%;
        bottom:0;
    }

    .pallet-wrapper .pallet-label {
        position: absolute;
        bottom: 2px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(255, 255, 255, 0.85);
        padding: 2px 4px;
        font-size: 12px;
        font-weight: bold;
        color: #000;
        border-radius: 4px;
    }
    .pallet-wrapper .pallet-img { width:100%; height:100%; }
</style>
@stop

@section('js')
<script>
$(document).ready(function () {
    const firstRoomId = $('#roomTabs .nav-link.active').data('room-id');
    let assignedSlots= [];
    let selectedSlots = new Set();
    const slotMetadata = {}; 

    renderRacks(firstRoomId);
    
    $('#prodSpecBtn').on('click', function (e) {
        e.preventDefault();
        $('#prodSpecModal').modal();
    });

    $('#roomTabs .nav-link').on('click', function (e) {
        e.preventDefault();

        // saveSelectedPallets();

        $('#roomTabs .nav-link').removeClass('active');
        $(this).addClass('active');

        const roomId = $(this).data('room-id');
        renderRacks(roomId);
    });

    function renderRacks(roomId) {
        $('#roomTabContent').html('');
        $.post("/admin/purchase/grn/get-racks", { 
            room_id: roomId, 
            box_capacity : parseInt($('#package-qty-per-pallet').val()) || 0,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(response) {
            
            response.racks.forEach(rack => {
                $('#roomTabContent').append(createRacks(rack));
            });

            restoreSelectedSlots();
        });
    }

    function createRacks(rack) {
        const { slots = [], rack_no, rack_id, no_of_levels, no_of_depth, name, room=[] } = rack;
        let slotsHtml = '';
        var width = 0;
        if(no_of_depth == '5')
            width = (parseFloat(100 / (no_of_depth + 1)).toFixed(0)-0.4) + '%';
        else
            width = parseFloat(100 / (no_of_depth + 1)).toFixed(2) + '%';

        // Convert depth and level strings to numbers for sorting/matching
        const parsedSlots = slots.map(slot => ({
            ...slot,
            depth_no_int: parseInt(slot.depth_no.replace("D", "")),
            level_no_int: parseInt(slot.level_no.replace("L", ""))
        }));

        // Loop levels from top to bottom
        for (let l = no_of_levels; l > 0; l--) {
            slotsHtml += `<li class="rack-depth" data-type="depth" style="width:${width} !important;"><div class="rack-level-no">L${l}</div></li>`;

            for (let d = 1; d <= no_of_depth; d++) {
                const slot = parsedSlots.find(s => s.level_no_int === l && s.depth_no_int === d);

                if (slot) {
                    const pallet = slot.pallet;
                    // const hasPallet = !!pallet;
                    const hasPallet = slot.has_pallet;
                  
                    if (hasPallet) {
                        const productImages = (pallet.available_products ?? []).map(stock => `
                            <div class="product-icon" title="${stock?.product?.product_description ?? ''}">
                                ${stock?.product?.cat_svg_icon?.svg_icon ?? ''}
                                <div class="product-count">${stock.total_available_qty ?? 0}/${pallet.pallet_capacity ?? 0}</div>
                            </div>`).join('');

                        const className = (['full', 'partial'].includes(slot.status) && pallet.is_picked)
                            ? 'picked'
                            : slot.status === 'full'
                            ? 'out-of-stock'
                            : slot.status === 'partial'
                            ? 'partial-stock'
                            : 'available';

                        const dataPartial = slot.status === 'partial'
                            ? `data-current-assigned-boxes="${pallet.current_pallet_capacity}" data-pallet-capacity="${pallet.pallet_capacity}"`
                            : '';

                        slotsHtml += `
                            <li class="${className}" data-id="${slot.slot_id}" data-type="slot" style="width:${width} !important;">
                                <label title="Slot ${room.name}-${name}-L${l}-D${d}" style="position: relative; display: block;">
                                    <div class="pallet-wrapper">
                                        <img src="{{ asset('images/pallet.png') }}" class="pallet-img" >
                                        <div class="pallet-label">Pallet: ${pallet.pallet_no}</div>
                                    </div>
                                    <div class="product-images">${productImages}</div>`;
                                    if(dataPartial) {
                                    slotsHtml += `<input type="hidden" id="assigned-box-count-${slot.slot_id}" name="quantity[]">
                                        <input type="checkbox" name="slot_ids[]" id="frm-slot-${slot.slot_id}" value="${slot.slot_id}" ${dataPartial} />
                                        <span class="empty-slot-label" ></span>`;
                                    }
                        slotsHtml += `</label>
                            </li>`;
                    } else {
                        // Slot exists but no pallet assigned
                        slotsHtml += `
                            <li class="empty-slot" data-id="${slot.slot_id}" data-type="slot" style="width:${width} !important;">
                                <label title="Empty Slot ${room.name}-${name}- L${l}-D${d}">
                                    <input type="hidden" id="assigned-box-count-${slot.slot_id}" name="quantity[]">
                                    <input type="checkbox" name="slot_ids[]" id="frm-slot-${slot.slot_id}" value="${slot.slot_id}" />
                                    <span class="empty-slot-label"></span>
                                </label>
                            </li>`;
                    }
                } else {
                    // Slot doesn't exist for this position
                    slotsHtml += `<li class="rack-block" data-type="block" style="width:${width} !important;"><div class="rack-block-no">--</div></li>`;
                }
            }
        }

        // Depth footer
        slotsHtml += `<li class="rack-depth" data-type="depth" style="width:${width} !important;"><div class="rack-depth-no"></div></li>`;
        for (let d = 1; d <= no_of_depth; d++) {
            slotsHtml += `<li class="rack-depth" data-type="depth" style="width:${width} !important;"><div class="rack-depth-no">D${d}</div></li>`;
        }

        // Final wrapper
        return `
            <div class="rackColumn">
                <div class="rackColumnName">
                    Rack: ${rack_no}
                    <input type="hidden" name="rack_id" value="${rack_id}">
                    <a href="#" class="view-rack-details" data-rack-id="${rack_id}">
                        <i class="fas fa-eye text-white ml-3"></i>
                    </a>
                </div>
                <ul class="slotRows" data-rack-id="${rack_id}" data-room-id="${room.room_id}">
                    <li>
                        <label>
                            <input type="checkbox" id="select-all-slots-${rack_id}" class="select-all-slots" data-rack-id="${rack_id}" />
                            <span>Select all Slots</span>
                        </label>
                    </li>
                    ${slotsHtml}
                </ul>
            </div>`;
    }

    function calculatePackageCount()
    {
        const weightPerUnit = parseInt($("#assign-grn-weight-per-unit").text()) || 0;
        const weightPerPackage = parseInt($("#assign-gw-per-package").val()) || 0;
        const packageQuantity = parseFloat($("#assign-package-qty").text()) || 0;
        const packageUnit = $('#assign-package-unit').text();

        // Declare packageCount in the outer scope
        let packageCount;

        if (packageUnit === 'Kg') {
            // Calculate packageCount for weight-based units
            packageCount = Math.ceil((packageQuantity * weightPerUnit) / weightPerPackage);
        } else {
            // Retrieve packageCount for other units
            //packageCount = parseInt($('#selected-prod-box-count').val()) || 0;
            packageCount = parseInt(packageQuantity) || 0;
        }

        return packageCount;
    }

    function calculateRequiredSlots(packageCount, packageCapacity, availableSlots = []) {
        let remainingPackages = packageCount;
        let assignments = [];
        
        // Try to fill existing slots
        availableSlots.forEach(slot => {
            let remainingCapacity = 0;

            if (slot.status === 'empty') {
                remainingCapacity = packageCapacity - (slot.current || 0);
            } 
            else if (slot.status === 'partial' && slot.total == packageCapacity) {
                remainingCapacity = slot.total - (slot.current || 0);
            }

            if (remainingCapacity <= 0) return;

            const assign = Math.min(remainingPackages, remainingCapacity);

            if (assign !== 0) {
                assignments.push({
                    slot_id: slot.slot_id,
                    assigned: assign,
                    remaining: remainingPackages,
                });
            }

            remainingPackages -= assign;
        });

        assignedSlots = [assignments];
        
        const newSlotsRequired = Math.ceil(remainingPackages / packageCapacity);
        
        return {
            totalSlots: assignments.length + newSlotsRequired,
            assignments,
            newSlotsRequired,
            remainingPackages
        };
    }

    function getSelectedSlotCount() {
        var cnt = 0;
        $(".slotRows li input:checked").each(function(){
            cnt++;
        });
        $("#assign-pallet-selected-qty").text(cnt);
    }

    // function saveSelectedPallets() {
    //     selectedPallets.clear();
    //     $("input[name='pallet_ids[]']:checked").each(function () {
    //         selectedPallets.add(parseInt($(this).val(), 10));
    //     });
    // }

    function restoreSelectedSlots() {
        $("input[name='slot_ids[]']").each(function () {
            const $checkbox = $(this);
            const slotId = parseInt($checkbox.val());
            
            if (selectedSlots.has(slotId)) {
                var assignPackages = slotMetadata[slotId]['quantity'];
                $checkbox.prop("checked", true);
                var $li = $checkbox.closest('li');
                $li.find('input[name="quantity[]"]').val(assignPackages);
                $li.addClass('selected');
            }
        });

        // $("input[name='slot_ids[]']:checked").each(function () {
        //     const $checkbox = $(this);
        //     $checkbox.trigger("change");
        // });
    }

    $(document).on("input", "#package-qty-per-pallet, #assign-nw-per-package", function() {
        // Retrieve and parse input values
        const packageCount = calculatePackageCount(); // Your existing logic
        const packageCapacity = parseInt($('#package-qty-per-pallet').val()) || 0;
        
        $('li[data-type="slot"]').each(function () {
            const currentCapacity = parseInt($(this).find('input[name="slot_ids[]"]').data('current-assigned-boxes')) || 0;
            
            if (currentCapacity >= packageCapacity) {
                $(this).closest('.metal-rack').hide();
            } else {
                $(this).closest('.metal-rack').show();
            }
        });
        
        const availableSlots = @json($availableSlots);
        
        const result = calculateRequiredSlots(packageCount, packageCapacity, availableSlots);

        $('#assign-pallet-required-qty').text(result.totalSlots);
    });

    $(document).on('change', '.select-all-slots', function () {
        const $ul = $(this).closest('ul');
        const isChecked = $(this).is(':checked');

        const required = parseInt($("#assign-pallet-required-qty").text()) || 0;
        let currentlySelectedCount = selectedSlots.size;

        console.log(`Currently selected: ${currentlySelectedCount}, Required: ${required}`);

        if (isChecked) {
            if (currentlySelectedCount >= required) {
                toastr.error(`You already selected the required ${required} slots.`);
                $(this).prop('checked', false);
                return;
            }

            let remaining = required - currentlySelectedCount;

            console.log(`Remaining slots needed: ${remaining}`);

            // Only check up to the number of remaining needed
            $ul.find("input[name='slot_ids[]']").each(function () {
                if (!$(this).is(":checked") && remaining > 0) {
                    $(this).prop("checked", true).trigger("change");
                    remaining--;
                }
            });

        } else {
            // Uncheck all in this rack
            $ul.find("input[name='slot_ids[]']").each(function () {
                if ($(this).is(":checked")) {
                    $(this).prop("checked", false).trigger("change");
                }
            });
        }
    });

    // $(document).on("change", "input[name='slot_ids[]']", function () {
    //     const totalPackages = calculatePackageCount();
    //     const packageCapacity = parseFloat($('#package-qty-per-pallet').val()) || 0;
    //     const required = parseInt($("#assign-pallet-required-qty").text()) || 0;
    //     const selected = parseInt($("#assign-pallet-selected-qty").text())|| 0;

    //     let assignedPackages = 0;
    //     let selectedCount = 0;
    //     // let selectedCount = selected;

    //     // Limit selection to required slots
    //     // const selectedCount = $(document).find("input[name='slot_ids[]']:checked").length;
    //     // // const selectedCount = $(this).is(':checked') ? selected + 1 : selected - 1;
    //     // if (selectedCount > required) {
    //     //     $(this).prop("checked", false);
    //     //     alert(`You can only select ${required} slot${required > 1 ? 's' : ''}.`);
    //     //     return;
    //     // }

        

    //     // Loop through selected slots and assign packages
    //     $("input[name='slot_ids[]']").each(function () {
    //         const isChecked = $(this).is(":checked");
    //         const currentAssignedPackages = parseInt($(this).data('current-assigned-boxes')) || 0;
    //         const palletCapacity = parseInt($(this).data('pallet-capacity')) || packageCapacity;
    //         const currentPackageCapacity = palletCapacity - currentAssignedPackages;
    //         const remainingPackages = totalPackages - assignedPackages;
    //         const slotId = parseInt($(this).val(), 10);
    //         const roomId = parseInt($(this).closest('[data-rack-id]').data('room-id'), 10); 
    //         const rackId = parseInt($(this).closest('[data-rack-id]').data('rack-id'), 10);
    //         // const quantity = parseInt($(this).closest('li').find("input[name='quantity[]']").val(), 10);

    //         const assignPackages = (isChecked && remainingPackages > 0)
    //             ? Math.min(currentPackageCapacity, remainingPackages)
    //             : '';

    //         $(this).closest('li').find('input[name="quantity[]"]').val(assignPackages);
    //         if (isChecked) {
    //             $(this).closest('li').addClass('selected');
    //             assignedPackages += parseInt(assignPackages || 0);
    //             selectedSlots.add(slotId);
    //             slotMetadata[slotId] = {
    //                 room_id: roomId,
    //                 rack_id: rackId,
    //                 slot_id: slotId,
    //                 quantity: parseInt($(this).closest('li').find("input[name='quantity[]']").val(), 10)
    //             };
    //         } else {
    //             selectedSlots.delete(slotId);
    //             delete slotMetadata[slotId];
    //             $(this).closest('li').removeClass('selected');
    //             $(this).closest('li').find('input[name="quantity[]"]').val(''); // optional: clear value on uncheck
    //         }

    //         selectedCount = selectedSlots.size

    //         if (selectedCount > required) {
    //             $(this).prop('checked', false);
    //             selectedSlots.delete(slotId);
    //             $(this).closest('li').removeClass('selected');
    //             alert(`You can only select ${required} slot${required > 1 ? 's' : ''}.`);
    //             return;
    //         }

    //     });

        

    //     // Enable/disable Assign button
    //     $('#assign-pallet-selected-qty').text(selectedCount);
    //     $('#confirmAssign').prop('disabled', selectedCount !== required);
    // });

    $(document).on("change", "input[name='slot_ids[]']", function () {
        const totalPackages = calculatePackageCount();
        const packageCapacity = parseFloat($('#package-qty-per-pallet').val()) || 0;
        const required = parseInt($("#assign-pallet-required-qty").text()) || 0;

        let assignedPackages = 0;
        let selectedCount = 0;

        const $input = $(this);
        const slotId = parseInt($input.val(), 10);
        const isChecked = $input.is(":checked");
        const $li = $input.closest('li');
        const $rack = $input.closest('[data-rack-id]');
        const currentAssignedPackages = parseInt($input.data('current-assigned-boxes')) || 0;
        const palletCapacity = parseInt($input.data('pallet-capacity')) || packageCapacity;
        const currentPackageCapacity = palletCapacity - currentAssignedPackages;

        if (isChecked) {

            if (selectedSlots.size >= required) {
                toastr.error(`You can only select ${required} slot${required > 1 ? 's' : ''}.`);
                $input.prop('checked', false);
                return;
            }

            const remainingPackages = totalPackages - calculateAssignedPackages();
            const assignPackages = Math.min(currentPackageCapacity, remainingPackages);

            $li.find('input[name="quantity[]"]').val(assignPackages);
            if($li.hasClass('partial-stock')) {
                $li.removeClass('partial-stock');
            }

            $li.addClass('selected');

            selectedSlots.add(slotId);
            slotMetadata[slotId] = {
                slot_id: slotId,
                room_id: parseInt($rack.data('room-id')),
                rack_id: parseInt($rack.data('rack-id')),
                quantity: assignPackages
            };
        } else {
            $li.removeClass('selected');
            $li.find('input[name="quantity[]"]').val('');
            selectedSlots.delete(slotId);
            delete slotMetadata[slotId];
        }

        selectedCount = selectedSlots.size;
        $('#assign-pallet-selected-qty').text(selectedCount);
        $('#confirmAssign').prop('disabled', selectedCount !== required);
    });

    // Helper to recalculate how many packages are already assigned
    function calculateAssignedPackages() {
        let sum = 0;
        selectedSlots.forEach(id => {
            const qty = parseInt(slotMetadata[id]?.quantity || 0);
            sum += qty;
        });
        return sum;
    }

    $('#confirmAssign').click(function (e) {
        e.preventDefault();

        let isValid = checkPageFormValidate('assignStorageForm');
        if(isValid) {
            const required = parseInt($("#assign-pallet-required-qty").text());

            // const selectedSlots = $("input[name='slot_ids[]']:checked");
            // const selectedSlots = $(document).find("input[name='slot_ids[]']:checked");
            
            // if (selectedSlots.length !== required) {
            if (selectedSlots.size !== required) {
                toastr.error(`Please select exactly ${required} slot${required > 1 ? 's' : ''}.`);
                $('#confirmAssign').prop('disabled', false);
                return;
            }

            const assignments = [];
            // selectedSlots.each(function (i) {
            //     const slotId = $(this).val();
            //     const roomId = $(this).closest('[data-rack-id]').data('room-id');
            //     const rackId = $(this).closest('[data-rack-id]').data('rack-id');
            //     const quantity = $(this).closest('li').find("input[name='quantity[]']").val();

            //     assignments.push({
            //         room_id: roomId,
            //         rack_id: rackId,
            //         slot_id: slotId,
            //         quantity: quantity
            //     });
            // });
            selectedSlots.forEach(slotId => {
                if (slotMetadata[slotId]) {
                    assignments.push(slotMetadata[slotId]);
                }
            });

            const requestData = {
                doc_date: $("#doc-date").val(),
                client_id: $("#client-id").val(),
                product_master_id: $("#product-master-id").val(),
                grn_detail_id: $("#grn-detail-id").val(),
                movement_type: 'in',
                pallet_type_id: $('#pallet-type-id').val(),
                package_qty_per_pallet: $('#package-qty-per-pallet').val(),
                item_size_per_package: $('#item-size-per-package').val(),
                nw_per_package: $('#assign-nw-per-package').val(),
                gw_per_package: $('#assign-gw-per-package').val(),
                weight_per_pallet: $('#weight-per-pallet').val(),
                pallet_qty: $('#assign-pallet-required-qty').text(),
                pallet_qty: required,
                assignments: assignments
            };

            if($('#confirmAssign').text() == 'Assign Product') {
                $('#confirmAssign').text('Please Wait...');

                requestData.specifications = {};
                requestData.new_specifications = {};

                $("select.attribute-select").each(function () {
                    const attrId = $(this).val(); // this is attribute_id
                    const valueField = $(this).closest('tr').find('.spec-value-input');
                    const val = valueField.val();

                    if (attrId) {
                        requestData.specifications[attrId] = val;

                        if (val === '_new') {
                            const newVal = $(this).closest('tr').find('input[name^="new_specifications"]').val();
                            requestData.new_specifications[attrId] = newVal;
                        }
                    }
                });

                $.ajax({
                    url: "/admin/purchase/grn/assign-to-inventory",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: requestData,
                    success: function (response) {
                        $('#confirmAssign').text('Assign Product');
                        toastr.success(response.message || 'Product Assigned Successfully!');
                        $('#assignColdStorageModal').modal('hide');
                        document.location = "{{ route('admin.purchase.grn.view', $grnBatchID) }}";
                        //location.reload();
                    },
                    error: function (xhr) {
                        $('#confirmAssign').text('Assign Product');
                        toastr.error(xhr.responseJSON?.message || "Error in Product Assigning");
                    }
                });
            }
        }
    });

    $(document).on('click', '.view-rack-details', function (e) {
        e.preventDefault();

        const rack_id = $(this).data('rack-id');
        $.post("/admin/master/inventory/racks/get-rack-details", { 
            rack_id: rack_id, 
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(response) {
            showRackDetail(response.rack);
        });
    });

    let specRowCount = 0;
    const attributeDataTypes = @json($attributes->pluck('data_type', 'product_attribute_id'));

    $(document).on('change', '.attribute-select', function () {
        const $trObj = $(this).closest('tr');
        const $select = $(this);
        const productIndex = $select.data('product-index');
        const rowIndex = $select.data('row-index');
        const attributeId = $select.val();

        if (!attributeId) return;

        // Optional: use data-type from option directly
        const dataType = $select.find('option:selected').data('data-type');

        // Otherwise, use AJAX to fetch input HTML
        $.ajax({
            url: `/admin/master/inventory/product-attributes/${attributeId}/input-field`, // Create this route
            type: 'GET',
            data: {
                product_index: productIndex,
                row_index: rowIndex
            },
            success: function (res) {
                $trObj.find('td.spec-value-td').html(res.input);
                // const $td = $(`td.spec-value-td[data-product-index="${productIndex}"][data-row-index="${rowIndex}"]`);
                // console.log(`td.spec-value-td[data-product-index="${productIndex}"][data-row-index="${rowIndex}"]`);
                // $td.html(res.input); // Replace input dynamically
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    window.addSpecRow = function(productIndex) {
        const tableBody = $(`#specificationTable${productIndex} tbody`);
        const rowIndex = Date.now(); // safer than global counter

        const row = `
            <tr>
                <td class="d-flex align-items-center gap-1" >
                    <select name="products[${productIndex}][specifications][${rowIndex}][attribute_id]" class="form-control form-control-sm select2 attribute-select" 
                        data-product-index="${productIndex}" data-row-index="${rowIndex} required>
                        <option value="">-- Select Attribute --</option>
                        @foreach($attributes as $attr)
                            <option value="{{ $attr->product_attribute_id }}" data-data-type="{{ $attr->data_type }}">{{ $attr->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-sm btn-success" onclick="openAttributeModal(this)">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
                <td class="spec-value-td" data-product-index="${productIndex}" data-row-index="${rowIndex}">
                    <input type="text" name="products[${productIndex}][specifications][${rowIndex}][value]" class="form-control form-control-sm spec-value-input" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('tr').remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        tableBody.append(row);
        $('.select2').select2({ theme: 'bootstrap4' });
    };

    $(document).on('change', 'select[name^="specifications"]', function () {
        let val = $(this).val();
        let input = $(this).closest('.form-group').find('input[name^="new_specifications"]');
        if (val === '_new') {
            input.removeClass('d-none').attr('required', true);
        } else {
            input.addClass('d-none').val('').removeAttr('required');
        }
    });

    let lastOpenedSelect = null;

    window.openAttributeModal = function(button) {
        lastOpenedSelect = $(button).closest('td').find('select');
        $('#createAttributeModal').modal('show');
    };

    $('#createAttributeForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const data = form.serialize();

        $.ajax({
            url: '{{ route("admin.master.inventory.product-attributes.store") }}', // Make sure this matches your route
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function(res) {
                const newId = res.data.product_attribute_id;
                const newName = res.data.name;

                // Append new attribute to all select2 dropdowns
                $('select[name$="[attribute_id]"]').each(function () {
                    if ($(this).find(`option[value="${newId}"]`).length === 0) {
                        $(this).append(`<option value="${newId}" selected>${newName}</option>`).trigger('change');
                    }
                });

                $('#createAttributeModal').modal('hide');
                $('#createAttributeForm')[0].reset();
            },
            error: function(xhr) {
                alert('Failed to create attribute. Check inputs.');
            }
        });
    });


});

function showRackDetail(rackSlotsData) {
    const rackLevels = rackSlotsData.no_of_levels;
    const palletsPerLevel = rackSlotsData.no_of_depth;

    const rackArea = document.getElementById('rackDisplayArea');
    const rackImg = document.getElementById('rackImage');

    // Clear previous display
    document.querySelectorAll('.pallet-container').forEach(p => p.remove());

    rackImg.onload = function () {
        const rackWidth = rackImg.offsetWidth;
        const rackHeight = rackImg.offsetHeight;
        const levelHeight = rackHeight / rackLevels;

        const palletWidth = 120;
        const palletHeight = 64;
        const palletFixedBottom = 71;
        const palletFixedLeft = 30;
        const verticalGap = 40;
        const horizontalGap = 98;
       
        rackSlotsData.slots.forEach(slot => {
            const pallet = slot.pallet;
            // const hasPallet = !!pallet;
            const hasPallet = slot.has_pallet;

            if (hasPallet) {
                const match = slot.pallet.pallet_position.match(/L(\d+)-D(\d+)/);
                if (!match) return;

                const level = parseInt(match[1]); // L4 → 4
                const depth = parseInt(match[2]); // D3 → 3

                const container = document.createElement('div');
                container.className = 'pallet-container position-absolute';
                container.style.width = palletWidth + 'px';
                container.style.height = palletHeight + 'px';

                // Position based on level (vertical) and depth (horizontal)
                container.style.bottom = (palletFixedBottom + (level - 1) * verticalGap) + "px";
                container.style.left = (palletFixedLeft + (depth - 1) * horizontalGap) + "px";
                container.style.zIndex = 20;

                const palletLabel = document.createElement('div');
                palletLabel.className = 'pallet-label position-absolute text-dark fw-bold text-center';
                palletLabel.innerText = pallet.pallet_no;
                palletLabel.style.top = '50px';
                palletLabel.style.left = '0';
                palletLabel.style.width = '100%';
                palletLabel.style.fontSize = '14px';
                palletLabel.style.zIndex = 30;

                const palletImg = document.createElement('img');
                palletImg.src = "{{ asset('/images/pallet.png') }}";
                palletImg.className = 'pallet-img';
                palletImg.style.width = '70%';
                palletImg.style.height = '85%';

                // const productWrapper = document.createElement('div');
                // productWrapper.className = 'product-images position-absolute w-100 h-100 top-0 start-0';
                // productWrapper.style.pointerEvents = 'none';
                
                const productIconWrapper = document.createElement('div');
                productIconWrapper.className = 'product-icon-wrapper position-absolute';
                productIconWrapper.style.bottom = '38%'; 
                productIconWrapper.style.left = '50%';
                productIconWrapper.style.transform = 'translateX(-50%)';
                productIconWrapper.style.zIndex = 50;

                if (slot.pallet.available_products?.length > 0) {
                    slot.pallet.available_products.forEach(stock => {
                        const iconDiv = document.createElement('div');
                        iconDiv.className = 'product-icon';
                        iconDiv.innerHTML = `
                            ${stock.product.cat_svg_icon.svg_icon}
                            <div class="product-count">${stock.total_available_qty ?? 0}</div>
                        `;
                        iconDiv.title = stock.product.product_description;
                        productIconWrapper.appendChild(iconDiv);
                    });
                }

                container.appendChild(palletLabel);  
                container.appendChild(productIconWrapper);
                container.appendChild(palletImg);
                rackArea.appendChild(container);
            }
        });

        const modal = new bootstrap.Modal(document.getElementById('rackDetailModal'));
        modal.show();
    };

    rackImg.src = "{{ asset('/images/5rowrack.png') }}" + '?v=' + new Date().getTime();
}

</script>
@stop
