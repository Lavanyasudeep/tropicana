@extends('adminlte::page')

@section('title', 'Stock Adjustment')

@section('content_header')
    <h1>Stock Adjustment</h1>
@stop

@section('content')

@php
$dynamicCss = '';
foreach ($palletTypes as $palletType) {
    $className = \Illuminate\Support\Str::slug($palletType->type_name, '-');
    $color = $palletType->color_code;
    $dynamicCss .= ".slotRows > li.{$className} { border-bottom: 4px solid {$color} !important; }\n";
}
@endphp

<div class="page-sub-header">
    <h3>Form - Out</h3>
    <div class="action-btns" >
        <a href="#" id="confirmReAssign" class="btn btn-save" disabled >Save</a>
        <a href="{{ route('admin.inventory.stock-adjustment.create') }}" class="btn btn-back" style="float:right;"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-list-panel" >   
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.stock-adjustment.assign.back') }}" id="assignStockAdjustmentForm" >
            @csrf
            <input type="hidden" name="packing_list_id" value="{{ $packingListDetail->packing_list_id }}">
            <input type="hidden" name="packing_list_detail_id" value="{{ $packingListDetail->packing_list_detail_id }}">
            <input type="hidden" name="product_id" value="{{ $productId }}">
            <input type="hidden" name="selected_slots" id="selected_slots" value="" />

            <div class="page-form page-form-add" >
                <div class="row">
                    <div class="col-md-4" >
                        <div class="pform-panel">
                            <div class="pform-row" >
                                <div class="pform-label" >Product Name</div>
                                <div class="pform-value" >: <span id="product-name" >{{ $packingListDetail->product?->product_description }}</span></div>
                                <div class="pform-clear" ></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Lot No.</div>
                                <div class="pform-value" >: <span id="product-name" >{{ $packingListDetail->lot_no }}</span></div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="pform-panel">
                            <div class="pform-row" >
                                <div class="pform-label" >Qty per Full Pallet <i class="pform-required" ></i></div>
                                <div class="pform-value" ><input type="number" id="packageQtyPerFullPallet" name="package_qty_per_full_pallet" value="{{ old('package_qty_per_full_pallet', $packageQtyPerFullPallet ?? '') }}" class="pform-required" /></div>
                                <div class="pform-clear" ></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Qty per Half Pallet <i class="pform-required" ></i></div>
                                <div class="pform-value" ><input type="number" id="packageQtyPerHalfPallet" name="package_qty_per_half_pallet" value="{{ old('package_qty_per_half_pallet', $packageQtyPerHalfPallet ?? '') }}" class="pform-required" /></div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="pform-panel">
                            <div class="pform-row" >
                                <div class="pform-label" >Adjustment Qty (Out)</div>
                                <div class="pform-value" ><input type="number" id="package_qty" name="package_qty" value="{{ old('package_qty', $packageQty ?? '') }}" class="pform-required" /></div>
                                <div class="pform-clear" ></div>
                            </div>
                            <div class="pform-row" >
                                <div class="pform-label" >Pallet Type <i class="pform-required" ></i></div>
                                <div class="pform-value" >
                                    <select name="pallet_type_id[]" id="pallet-type-id" class="select2 pform-required" multiple>
                                        <option value="">- Select -</option>
                                        @foreach($palletTypes as $palletType)
                                            <option value="{{ $palletType->pallet_type_id }}" {{ isset($grnDetail->inwardDetail->pallet->pallet_type_id) && $grnDetail->inwardDetail->pallet->pallet_type_id == $palletType->pallet_type_id ? 'selected' : 'selected' }}>
                                                {{ $palletType->type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="pform-clear" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-12">

                    <div class="color-section" >
                        <div class="pallets-color" >
                            <label>Pallet Color : </label>
                            @foreach($palletTypes as $palletType)
                                <span style="background-color:{{ $palletType->color_code }}" >{{ $palletType->type_name }}</span>
                            @endforeach
                            <div class="clear-both" ></div>
                        </div>
                        <div class="slots-color" >
                            <label>Slot Color : </label>
                            <span class="empty" >Empty</span>
                            <span class="partial" >Partial</span>
                            <span class="booked" >Booked</span>
                            <span class="selected" >Selected</span>
                            <span class="disabled" >Disabled</span>
                            <div class="clear-both" ></div>
                        </div>
                    </div>
                    
                    <!-- Tabs -->
                    <ul id="roomTabs" class="nav nav-tabs">
                        <label>Rooms : </label>
                        @foreach($rooms as $room)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                data-room-id="{{ $room->room_id }}" 
                                href="#">
                                    {{ $room->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                
                    <div id="roomTabContent">
                        @foreach($racks as $rack)
                            @php
                                $slots = $rack['slots'] ?? [];
                                $rack_no = $rack['rack_no'];
                                $rack_id = $rack['rack_id'];
                                $room_id = $rack['room']['room_id'];
                                $no_of_levels = (int) $rack['no_of_levels'];
                                $no_of_depth = (int) $rack['no_of_depth'];

                                // Width calculation
                                if($no_of_depth === 5) {
                                    $width = (100 / ($no_of_depth + 1) - 0.4) . '%';
                                } else {
                                    $width = round(100 / ($no_of_depth + 1), 2) . '%';
                                }

                                // Preprocess slots: add int level/depth numbers
                                foreach ($slots as &$slot) {
                                    $slot['depth_no_int'] = (int) str_replace('D', '', $slot['depth_no']);
                                    $slot['level_no_int'] = (int) str_replace('L', '', $slot['level_no']);
                                }
                                unset($slot);
                            @endphp
                            
                            <div class="rackGroup" data-room-id="{{ $room_id }}">
                                <div class="rackColumn">
                                    <div class="rackColumnName">
                                        Rack: {{ $rack_no }}
                                        <input type="hidden" name="rack_id" value="{{ $rack_id }}">
                                        <a href="#" class="view-rack-details" 
                                        data-rack-id="{{ $rack_id }}" 
                                        data-room-id="{{ $room_id }}">
                                            <i class="fas fa-eye text-white ml-3"></i>
                                        </a>
                                    </div>

                                    <ul class="slotRows" data-rack-id="{{ $rack_id }}" data-room-id="{{ $room_id }}">
                                        <li>
                                            <label>
                                                <input type="checkbox" id="select-all-slots-{{ $rack_id }}" 
                                                    class="select-all-slots" 
                                                    data-rack-id="{{ $rack_id }}" />
                                                <span>Select all Slots</span>
                                            </label>
                                        </li>

                                        {{-- Loop levels from top to bottom --}}
                                        @for ($l = $no_of_levels; $l > 0; $l--)
                                            <li class="rack-depth" style="width:{{ $width }} !important;">
                                                <div class="rack-level-no">L{{ $l }}</div>
                                            </li>

                                            @for ($d = 1; $d <= $no_of_depth; $d++)
                                                @php
                                                    $slot = collect($slots)->firstWhere(function ($s) use ($l, $d) {
                                                        return $s['level_no_int'] === $l && $s['depth_no_int'] === $d;
                                                    });

                                                    $palletType = 'half'; // default
                                                    if ($slot && !empty($slot['palletType']['type_name'])) {
                                                        $palletType = strtolower($slot['palletType']['type_name']);
                                                    }
                                                @endphp

                                                <li class="empty-slot {{ $palletType }}"
                                                    @if($slot)
                                                        id="stock_adjustment_slot_{{ $slot['slot_id'] }}"
                                                        data-id="{{ $slot['slot_id'] }}"
                                                        data-slot-status="{{ $slot['status'] }}"
                                                        data-pallet-type-id="{{ $slot['pallet_type_id'] }}"
                                                    @endif
                                                    style="width:{{ $width }} !important;">
                                                    @if($slot)
                                                        <label title="Empty Slot ({{ $slot['room']['name'] }}-{{ $slot['rack']['rack_no'] }}-L{{ $l }}-D{{ $d }})" for="frm-slot-{{ $slot['slot_id'] }}">
                                                            <input type="hidden" class="pallet-capacity" id="assigned-pallet-capacity-{{ $slot['slot_id'] }}" name="capacity[]">
                                                            <input type="hidden" class="box-count" id="assigned-box-count-{{ $slot['slot_id'] }}" name="quantity[]">
                                                            <input type="checkbox" name="slot_ids[]" id="frm-slot-{{ $slot['slot_id'] }}" value="{{ $slot['slot_id'] }}">
                                                            <span class="empty-slot-label"></span>
                                                        </label>
                                                    @endif
                                                </li>
                                            @endfor
                                        @endfor

                                        {{-- Depth Footer --}}
                                        <li class="rack-depth" style="width:{{ $width }} !important;"></li>
                                        @for ($d = 1; $d <= $no_of_depth; $d++)
                                            <li class="rack-depth" style="width:{{ $width }} !important;">
                                                <div class="rack-depth-no">D{{ $d }}</div>
                                            </li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
                                                  
        </form>
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
@stop

@section('css')
<style>
    #roomTabs { border-bottom: 1px solid #000; }
    #roomTabs>label { padding:7px 15px 0 0; font-size:14px; }
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
    .rackColumn .slotRows li label input.box-count, input[type="checkbox"] { float:left; }
    .rackColumn .slotRows li label input.box-count { position: absolute; bottom: 2px; width: 95%; padding: 0; margin:0 auto; left:0; right:0; border:0px; text-align: center !important; font-weight: bold; font-size: 10px; }

    .rackColumn .slotRows li label input[type="checkbox"] { display:none; }
    .rackColumn .slotRows li label span { float:left; display:inline-block; margin:-2px 0 0 5px; }
    .rackColumn .slotRows li.out-of-stock { background-color:#ef7676; }
    .rackColumn .slotRows li.out-of-stock label { color:#FFF; }
    .rackColumn .slotRows li.out-of-stock input { display:none; }
    .rackColumn .slotRows li:first-child label input[type="checkbox"] { display:block; }
    .rackColumn .slotRows li.out-of-stock label span { margin-left:18px; }

    .rackColumn .slotRows li.disabled { opacity: 0.5; cursor:none; background-color: #a9a7a7; }

    .rackColumn .slotRows li.available { background-color: #FFF; }
    .rackColumn .slotRows li.selected { background-color: #32a616; }
    .rackColumn .slotRows li.picked { background-color: #36abe3; }
    .rackColumn .slotRows li.partial-stock { background-color:#f0b36b; }

    .rackColumn .slotRows li.partial-stock label { color:#FFF; }
    .rackColumn .slotRows li .rack-level-no { width: 100%; height: 94%; border-radius: 2px; margin: 0px 0px 0 0px; text-align: center; font-size: 14px; padding-top: 6px; }
    .rackColumn .slotRows li .rack-depth-no { width: 100%; height: 94%; border-radius: 2px; margin: 0px 0px 0 0px; text-align: center; font-size: 14px; padding-top: 6px; }

    .color-section { position: absolute; right: 20px; }
    
    .pallets-color { float:left; border-right:1px solid #BBB; padding:0 10px; }
    .pallets-color label { font-size:12px; font-weight:bold; display:inline-block; text-align:right; margin:0; }
    .pallets-color span { color: #FFF; font-size: 11px; padding: 3px 6px; display: inline-block; margin-left: 0px; text-transform: uppercase; border-radius: 2px; }

    .slots-color { float:left; padding:0 10px; }
    .slots-color label { font-size:12px; font-weight:bold; display:inline-block; text-align:right; margin:0; }
    .slots-color span { color: #FFF; font-size: 11px; padding: 3px 6px; display: inline-block; margin-left: 0px; text-transform: uppercase; border-radius: 2px; }
    .slots-color span.empty { background-color:#FFF; border:1px solid #CCC; color:#444; } 
    .slots-color span.partial { background-color:#f0b36b; border:1px solid #f0b36b; } 
    .slots-color span.booked { background-color:#ef7676; border:1px solid #ef7676; } 
    .slots-color span.selected { background-color:#32a616; border:1px solid #32a616; } 
    .slots-color span.disabled { background-color:#a9a7a7; border:1px solid #a9a7a7; } 

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

    .product-icon i {
        font-size: 14px;
        margin: -1px 15px;
    }

    .product-images.empty {
        width: 100%;
        height: 25px;
        border-radius: 2px;
    }

    .product-count {
        background-color: #0e0f0f;
        color: #fff;
        font-size: 9px;
        font-weight: bold;
        padding: 1px 3px;
        border-radius: 10px;
        z-index: 2;
    }

    .empty-slot {
        background-color: #FFF;
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

    .view-slot-detail-btn { position:absolute; top:0; left:0; padding:4px 6px; color:#555; font-size:12px; z-index: 1; cursor:pointer; }
    .view-slot-detail-btn:hover { color:#000; }

    {!! $dynamicCss !!}
</style>
@stop

@section('js')
<script>
$(document).ready(function () {
    const adjustmentProducts = @json($adjustmentProducts) ?? {};
    const availableSlots = @json($availableSlots);
    const packingListDetailId = '{{ $packingListDetail->packing_list_detail_id }}';
    
    let outQuantities = {}; // { slotId: qty }
    var selectedSlots = new Set();
    var selectedProducts = {};
    var slotMetadata = {};
    let maxPackages = parseInt($('#package_qty').val()) || 0;
    
    initRoomTabs();

    function initRoomTabs() {
        $('#roomTabs .nav-link').on('click', function (e) {
            e.preventDefault();

            $('#roomTabs .nav-link').removeClass('active');
            $(this).addClass('active');

            const selectedRoomId = $(this).data('room-id');
            $('.rackGroup').hide();
            $(`.rackGroup[data-room-id="${selectedRoomId}"]`).show();
        });

        $('#roomTabs .nav-link.active').trigger('click');
    }

    function restoreSlotProducts() {
        var racks = {!! json_encode($racks_array) !!};
        var slotsArray = [];
        
        // All Slots
        Object.values(racks).forEach(function(rack) {
            var slots = rack.slots || [];
            // console.log(slots);
            slots.forEach(function(slot) {
                slotsArray.push({
                    slot_id: slot.slot_id,
                    qty: slot.has_pallet? slot.pallet.current_pallet_capacity : 0,
                    stocks: slot.has_pallet? slot.stocks : 0,
                    pallet_no: slot.has_pallet? slot.pallet.pallet_no : '',
                    pallet_type: slot.has_pallet? (slot.pallet.pallet_type? slot.pallet.pallet_type.type_name : 'half'): '',
                    inward_detail_id: 0,
                    pallet_capacity: slot.has_pallet? slot.pallet.pallet_capacity : 0,
                    status: slot.status,
                    has_pallet: slot.has_pallet,
                    is_picked: slot.has_pallet? slot.pallet.is_picked : false
                });
            });
        });

        // Selected Slots only
        var selectedSlots2 = {};

        Object.values(adjustmentProducts).forEach(product => {
            let slots = product.selected_slots;

            if (typeof slots === 'string') {
                slots = JSON.parse(slots);
            }

            if (product.packing_list_detail_id == packingListDetailId) {
                selectedProducts[product.packing_list_detail_id] = { ...product };
                delete selectedProducts[product.packing_list_detail_id].selected_slots;

                if (slots && typeof slots === 'object') {
                    Object.entries(slots).forEach(([slotId, slotData]) => {
                        selectedSlots2[slotId] = slotData;
                        selectedSlots2[slotId]['quantity'] = parseInt($('#packageQtyPerPallet').val()) || 0;
                    });
                }
            }
            
        });

        var productHTML = '';
        slotsArray.forEach(function(slot) {
            const slotId = slot.slot_id;
            const slotEl = $('#stock_adjustment_slot_' + slotId);
           
            if (!slotEl.length) return; // Skip if not found

            // Update checkbox and quantity

            // Determine slot class
            let className = '';
            if (['full', 'partial'].includes(slot.status) && slot.is_picked) {
                className = 'picked';
            } else if (slot.status === 'full') {
                className = 'out-of-stock';
            } else if (slot.status === 'partial') {
                className = 'partial-stock';
            } else {
                className = 'available';
            }

            const productImages = ``;

            const slotTitle = slot.has_pallet ? ` | Qty : ${slot.qty ?? 0}/${slot.pallet_capacity ?? 0}` : [];

            const viewDetail = `<i class="fa fa-xl fa-eye text-black view-slot-detail-btn" title="View Slot Details"></i>`;

            $dataPartial = '';
            if (slot.status === 'partial') {
                slotEl.find('input[type="checkbox"]')
                                .attr('data-current-assigned-boxes', slot?.qty ?? 0)
                                .attr('data-pallet-capacity', slot?.pallet_capacity ?? 0);
            }

            // Add pallet and product display
            productHTML = ``;
            if(slot.has_pallet || selectedSlots2[slot.slot_id]) 
            {
                if(selectedSlots2[slot.slot_id] && adjustmentProducts[packingListDetailId]['packing_list_detail_id'] == packingListDetailId) {
                    if(selectedSlots2[slot.slot_id]['inward_detail_id']) {
                        productHTML = `
                        <div class="product-images">
                            <div class="product-icon" data-slot-id="${slot.slot_id}" >
                                <a class="remove-product-btn" data-slot-id="${slot.slot_id}" href='#' >×</a>
                            </div>
                        </div>`;
                    } 

                } else if (slot.has_pallet) {
                    productHTML = `
                    <div class="product-images">
                        <div class="product-icon" data-slot-id="${slot.slot_id}" >
                            <div class="product-count">${slot.qty}/${slot.pallet_capacity}</div>
                        </div>
                    </div>`;
                } 
                
                slotEl.find('input[type="checkbox"]').prop('checked', true);
                if (slot.status !== 'partial') {
                    slotEl.find('input[type="checkbox"]').prop('disabled', true);
                }
                slotEl.find('input[name="quantity[]"]').val(slot.qty);
                slotEl.find('label').prepend(viewDetail);
            }

            if(selectedSlots2[slot.slot_id] && adjustmentProducts[packingListDetailId]['packing_list_detail_id'] == packingListDetailId) {
                slotEl.find('input[type="checkbox"]').prop('disabled', false);
                
                selectedSlots.add(slot.slot_id);
                slotMetadata[slot.slot_id] = selectedSlots2[slot.slot_id];
            }

            var a = 0;
            if (slot.has_pallet || selectedSlots2[slot.slot_id]) {
                (slot.stocks || []).forEach(stock => {
                    if (stock.packing_list_detail_id == packingListDetailId) {
                        a++;
                        console.log(packingListDetailId);
                        console.log(slotEl.find('input[type="checkbox"]'));
                        className = 'selected';
                        // productHTML = `
                        // <div class="product-images">
                        //     <div class="product-icon" data-slot-id="${slot.slot_id}">
                        //         <div class="product-count">${stock.available_qty}/${slot.pallet_capacity}</div>
                        //     </div>
                        // </div>`;
                        productHTML = '';

                        slotEl.find('input[type="checkbox"]').prop('checked', true);
                        
                        slotEl.find('input[name="quantity[]"]')
                            .attr('type', 'number')
                            .attr('min', 0)
                            .attr('max', stock.available_qty) // allocated qty for this slot
                            .attr('data-slot-id', slot.slot_id)
                            .attr('data-allocated-qty', stock.available_qty) // store for validation
                            .val(''); // default to current allocated qty
                        
                        slotEl.find('label').prepend(productHTML + viewDetail);
                    } else {
                        //slotEl.addClass('disabled');
                    }
                    
                });
            }

            // Inject visual details
            if (slot.status === 'full') {
                slotEl.removeClass('empty-slot');
            }

            slotEl.addClass(className).addClass('slot').attr('data-type', 'slot');
            

            let currentTitle = slotEl.find('label').attr('title') || '';
            slotEl.find('label').attr('title', currentTitle + ' ' + slotTitle);

        });

        $('#assign-pallet-selected-qty').text(selectedSlots.size);

        restorePreviouslySelectedSlots();
    }

    function restoreSelectedSlots() {
        $("input[name='slot_ids[]']").each(function () {
            const $checkbox = $(this);
            const slotId = parseInt($checkbox.val());

            if (selectedSlots.has(slotId)) {
                // Get values from stored data
                const assignPackages = (outQuantities && outQuantities[slotId] != null) 
                    ? parseInt(outQuantities[slotId]) || 0 
                    : parseInt(slotMetadata[slotId]?.quantity) || 0;

                const palletCapacity = parseInt(slotMetadata[slotId]?.capacity) || 0;

                // Check the box
                $checkbox.prop("checked", true);
                const $li = $checkbox.closest('li');

                console.log('restoreSelectedSlots', slotId, {
                    assignPackages,
                    palletCapacity,
                    slotMeta: slotMetadata[slotId]
                });

                // Restore capacity
                $li.find('input[name="capacity[]"]').val(palletCapacity);

                // Restore quantity input from outQuantities
                $li.find('input[name="quantity[]"]').val(assignPackages);

                if (assignPackages === 0) {
                    // Unselect if qty is zero
                    $checkbox.prop("checked", false);
                    $li.removeClass('selected');
                    $li.find('input[name="quantity[]"]').attr('type', 'hidden');
                    selectedSlots.delete(slotId);
                    delete slotMetadata[slotId];
                    if (outQuantities) delete outQuantities[slotId];
                } else {
                    $li.find('input[name="quantity[]"]').attr('type', 'number');
                    $li.addClass('selected');
                }
            }
        });
    }

    restoreSlotProducts();
    
    function restorePreviouslySelectedSlots() {
        Object.values(adjustmentProducts).forEach(product => {
            let selectedSlotsData = product.selected_slots;
            if (!selectedSlotsData) return;
            if (typeof selectedSlotsData === 'string') {
            selectedSlotsData = JSON.parse(selectedSlotsData);
            }

            Object.entries(selectedSlotsData).forEach(([slotIdStr, slot]) => {
            const slotId = parseInt(slotIdStr);
            const $checkbox = $(`#frm-slot-${slotId}`);
            const $li = $checkbox.closest('li');

            if (product.packing_list_detail_id == packingListDetailId) {
                $checkbox.prop("checked", true);
                $li.addClass("selected");

                const allocatedQty = slot.quantity || 0;
                const $qtyInput = $('<input>', {
                type: 'number',
                min: 0,
                max: allocatedQty,
                value: 0,
                class: 'slot-out-qty',
                'data-slot-id': slotId,
                'data-allocated-qty': allocatedQty
                });

                $li.find('.product-images').remove();
                $li.find('label').append($qtyInput);

                selectedSlots.add(slotId);
                slotMetadata[slotId] = {
                ...slot,
                slot_id: slotId,
                quantity: allocatedQty,
                capacity: slot.capacity || 0
                };
            } else {
                $checkbox.prop("checked", true).prop("disabled", true);
                $li.addClass("selected locked");
            }
            });
        });

        restoreSelectedSlots();
    }

    function calculateRequiredSlots(packageCount, fullPackageCapacity, halfPackageCapacity, palletTypes = []) {
        let remaining = packageCount;
        const assignments = [];

        availableSlots.forEach(slot => {
            const current = slot.current || 0;
            let packageCapacity = 0;

            // Decide capacity by pallet type
            if (slot.pallet_type === 'half') {
                packageCapacity = halfPackageCapacity;
            } else if (slot.pallet_type === 'full') {
                packageCapacity = fullPackageCapacity;
            } else {
                packageCapacity = halfPackageCapacity; // default
            }

            // Calculate empty space
            let capacity = 0;
            if (slot.status === 'empty') {
                capacity = packageCapacity - current;
            } else if (slot.status === 'partial') {
                capacity = slot.total - current;
            }

            // If slot has space, assign up to remaining
            if (capacity > 0 && remaining > 0) {
                const assignQty = Math.min(remaining, capacity);

                assignments.push({
                    slot_id: slot.slot_id,
                    assigned: assignQty,
                    max_capacity: capacity
                });

                // Optionally auto-fill outQuantities for UI sync
                if (typeof outQuantities !== "undefined") {
                    outQuantities[slot.slot_id] = assignQty;
                }

                remaining -= assignQty;
            }
        });

        let newSlotsRequired = 0;
        let requiredFull = 0;
        let requiredHalf = 0;

        // Slot requirement calculations
        if (palletTypes.includes("full") && !palletTypes.includes("half")) {
            newSlotsRequired = Math.ceil(remaining / fullPackageCapacity);
            requiredFull = assignments.length + newSlotsRequired;
        } else if (!palletTypes.includes("full") && palletTypes.includes("half")) {
            newSlotsRequired = Math.ceil(remaining / halfPackageCapacity);
            requiredHalf = assignments.length + newSlotsRequired;
        } else if (palletTypes.includes("full") && palletTypes.includes("half")) {
            requiredFull = Math.floor(packageCount / fullPackageCapacity);
            const remainingPackages = packageCount - (requiredFull * fullPackageCapacity);
            requiredHalf = Math.ceil(remainingPackages / halfPackageCapacity);
        }

        return {
            totalSlots: assignments.length + newSlotsRequired,
            assignments,
            newSlotsRequired,
            remainingPackages: remaining,
            requiredFull,
            requiredHalf
        };
    }

    function getAssignedPackageCount() {
        return Array.from(selectedSlots).reduce((sum, id) => {
            return sum + parseInt(slotMetadata[id]?.quantity || 0);
        }, 0);
    }

    function updateSlotVisibility(palletTypes) {
        // Enable all slots first
        $("li[data-type='slot']").removeClass("disabled");
        $("li[data-type='slot']").find("input[type='checkbox']").prop("disabled", false);

        // Hide based on type
        $("li[data-type='slot']").each(function () {
            const $li = $(this);

            if ($li.hasClass("full") && !palletTypes.includes("full")) {
                $li.addClass("disabled").find("input[name='slot_ids[]']").prop("disabled", true);
            }

            if ($li.hasClass("half") && !palletTypes.includes("half")) {
                $li.addClass("disabled").find("input[name='slot_ids[]']").prop("disabled", true);
            }

            if ($li.find("input[name='slot_ids[]']").is(":checked")) {
                $li.find("input[name='slot_ids[]']").prop("checked", false).trigger("change");
            }
            
        });

        restorePreviouslySelectedSlots();
    }

    $(document).on("change", ".select-all-slots", function () {
        const $ul = $(this).closest('ul');
        const isChecked = $(this).is(':checked');

        const packageCount = parseInt($('#package_qty').val()) || 0;
        const halfPalletCapacity = parseInt($('#packageQtyPerHalfPallet').val()) || 0;
        const fullPalletCapacity = parseInt($('#packageQtyPerFullPallet').val()) || 0;

        let assignedCount = selectedSlots.size;

        // Use outQuantities instead of slotMetadata.quantity
        const currentlySelectedQuantity = Object.values(outQuantities).reduce((sum, qty) => {
            return sum + (parseFloat(qty) || 0);
        }, 0);

        const selectedTypes = $('#pallet-type-id').val() || [];
        const palletTypes = [];

        selectedTypes.forEach(id => {
            const option = $('#pallet-type-id').find(`option[value="${id}"]`);
            if (option.length && id !== "") {
                palletTypes.push(option.text().trim().toLowerCase());
            }
        });

        const result = calculateRequiredSlots(packageCount, halfPalletCapacity, fullPalletCapacity, palletTypes);
        const validSlotIds = result.assignments.map(s => s.slot_id);

        $ul.find("input[name='slot_ids[]']").each(function () {
            const $checkbox = $(this);
            const slotId = parseInt($checkbox.val());

            if ($checkbox.prop('disabled')) return;

            if (validSlotIds.includes(slotId)) {
                if (isChecked) {
                    if (!selectedSlots.has(slotId) && currentlySelectedQuantity < packageCount) {
                        $checkbox.prop('checked', true).trigger('change');
                        assignedCount++;

                        // Optional: auto-fill max available qty for this slot
                        const availableQty = parseInt(slotMetadata[slotId]?.quantity) || 0;
                        const remainingNeeded = packageCount - currentlySelectedQuantity;
                        outQuantities[slotId] = Math.min(availableQty, remainingNeeded);

                    } else {
                        $checkbox.prop('checked', false);
                    }
                } else {
                    if (selectedSlots.has(slotId)) {
                        $checkbox.prop('checked', false).trigger('change');
                        assignedCount--;
                        delete outQuantities[slotId];
                    }
                }
            }
        });
    });

    $(document).on('input', 'input[name="quantity[]"][type="number"]', function() {
        const $input = $(this);
        const $li = $input.closest('li');
        const $rack = $input.closest('[data-rack-id]');
        const slotId = $(this).data('slot-id');
        const allocatedQty = parseInt($(this).data('allocated-qty')) || 0;
        let val = parseInt($(this).val()) || 0;

        if (val > allocatedQty) {
            toastr.error(`Cannot exceed allocated quantity (${allocatedQty}) for this slot.`);
            val = allocatedQty;
            $(this).val(val);
        }

        outQuantities[slotId] = val;
        const totalOut = Object.values(outQuantities).reduce((a, b) => a + b, 0);


        console.log(totalOut+' > '+maxPackages);
        if (totalOut > maxPackages) {
            toastr.error(`Total out quantity cannot exceed ${maxPackages}.`);
            val = Math.max(0, val - (totalOut - maxPackages));
            $(this).val(val);
            outQuantities[slotId] = val;
        }

        const slot = availableSlots.find(s => s.slot_id === slotId);
        if (slot) {
            slotMetadata[slotId] = {
                slot_id: slotId,
                room_id: parseInt($rack.data('room-id')),
                rack_id: parseInt($rack.data('rack-id')),
                pallet_type_id: isNaN(parseInt($li.data('pallet-type-id')))? null : parseInt($li.data('pallet-type-id')),
                location: `${slot.room_name}-${slot.rack_no}-${slot.level_no}-${slot.depth_no}`,
                quantity: val,
                capacity: allocatedQty,
                status: $li.data('slot-status'),
                is_assigned_deleted : false
            };
        }

        $('#totalOutQty').text(Object.values(outQuantities).reduce((a, b) => a + b, 0));
    });

    $(document).on("change", "#pallet-type-id", function () {
        const selectedTypes = $(this).val() || [];
        const palletTypes = [];

        selectedTypes.forEach(id => {
            const option = $(this).find(`option[value="${id}"]`);
            if (option.length && id !== "") {
                palletTypes.push(option.text().trim().toLowerCase());
            }
        });

        updateSlotVisibility(palletTypes);
        
        $('#packageQtyPerHalfPallet, #packageQtyPerFullPallet').trigger('input');
    });

    $(document).on('click', '.view-slot-detail-btn', function (e) {
        e.stopPropagation();

        const slotId = $(this).closest('li').data('id');

        // Show loading modal
        const loadingModal = `
            <div id="slotDetailsModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Slot Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Loading slot details...</p>
                </div>
                </div>
            </div>
            </div>`;
        
        $('#slotDetailsModal').remove();
        $('body').append(loadingModal);
        $('#slotDetailsModal').modal('show');

        // Call your backend endpoint
        $.ajax({
            url: '/admin/master/inventory/slots/get-slot-detail', 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { slot_id: slotId },
            success: function (response) {
                const products = response.slot.pallet.stocks ?? [];
                let productsHtml = '';
                
                if (products.length > 0) {
                    products.forEach(p => {
                        productsHtml += `
                            <tr>
                                <td>${p.product.product_description}</td>
                                <td>${p.batch_no}</td>
                                <td>${p.available_qty}</td>
                            </tr>`;
                    });
                } else {
                    productsHtml = `<tr><td colspan="2">No products assigned</td></tr>`;
                }

                // Replace modal content
                $('#slotDetailsModal .modal-body').html(`
                    <p><strong>Pallet Location : </strong> ${response.slot.pallet.pallet_position}</p>
                    <p><strong>Pallet Type : </strong> ${response.slot.pallet.pallet_type? response.slot.pallet.pallet_type.type_name : 'half'}</p>
                    <p><strong>Pallet No. : </strong> ${response.slot.pallet.pallet_no}</p>
                    <p><strong>Pallet Capacity : </strong> ${response.slot.pallet.capacity}</p>
                    <table class="table table-bordered">
                        <thead><tr><th>Product</th><th>Batch No.</th><th>Qty</th></tr></thead>
                        <tbody>${productsHtml}</tbody>
                    </table>
                `);
            },
            error: function () {
                $('#slotDetailsModal .modal-body').html(`<p class="text-danger">Failed to load slot details.</p>`);
            }
        });
    });

    $(document).on('click', '.view-rack-details', function (e) {
        e.preventDefault();
        const rackId = $(this).data('rack-id');

        $.post("/admin/master/inventory/racks/get-rack-details", {
            rack_id: rackId,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function (res) {
            showRackDetail(res.rack);
        });
    });

   $('#confirmReAssign').on('click', function (e) {
        e.preventDefault();

        let isValid = checkPageFormValidate('assignStockAdjustmentForm');
        if (!isValid) return;

        const required = parseInt($("#package_qty").val()) || 0;

        // Sum user-entered quantities instead of allocated qty
        const totalOutQty = Object.values(outQuantities).reduce((sum, qty) => {
            return sum + (parseInt(qty) || 0);
        }, 0);

        if (totalOutQty !== required) {
            toastr.error(`Total "Qty to Out" must be exactly ${required}.`);
            $('#confirmReAssign').prop('disabled', false);
            return;
        }

        const $form = $('#assignStockAdjustmentForm');
        const packingListDetailId = $form.find('input[name="packing_list_detail_id"]').val();

        if (!selectedProducts[packingListDetailId]) {
            selectedProducts[packingListDetailId] = {};
        }

        console.log(slotMetadata);

        // Save both slotMetadata and outQuantities
        $form.find('input[name="selected_slots"]').val(JSON.stringify(slotMetadata));
        // $('<input>', {
        //     type: 'hidden',
        //     name: 'out_quantities',
        //     value: JSON.stringify(outQuantities)
        // }).appendTo($form);

        $form.submit();
    });

    //restorePreviouslySelectedSlots();
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
