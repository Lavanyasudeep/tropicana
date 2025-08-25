@extends('adminlte::page')

@section('title', 'Assign Products')

@section('content_header')
    <h1>Inward</h1>
@stop

@section('content')

<div class="page-sub-header">
    <h3>Assign Products</h3>
    <div class="action-btns" >
        <a href="#" id="confirmAssign" class="btn btn-save" disabled >Assign Product</a>
        <a href="{{ route('admin.inventory.inward.create', $packingListDetail->packing_list_id) }}" class="btn btn-back" style="float:right;"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-list-panel" >   
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.inward.assign.back') }}" id="assignInwardForm" >
            @csrf
            <input type="hidden" name="packing_list_id" value="{{ $packingListDetail->packing_list_id }}">
            <input type="hidden" name="packing_list_detail_id" value="{{ $packingListDetail->packing_list_detail_id }}">
            <input type="hidden" name="product_id" value="{{ $productId }}">
            <input type="hidden" name="package_qty" id="packageQty" value="{{ $packageQty }}">
            <input type="hidden" name="package_qty_per_pallet" id="packageQtyPerPallet" value="{{ $packageQtyPerPallet }}">
            <input type="hidden" name="pallet_qty" value="{{ $palletQty }}">
            <input type="hidden" name="selected_slots" id="selected_slots" value="" />

            <div class="page-form page-form-add" >
                <div class="row">
                    <div class="col-md-6" >
                        <div class="pform-panel">
                            <div class="pform-row" >
                                <div class="pform-label" >Pallets Required</div>
                                <div class="pform-value" >: <span id="assign-pallet-required-qty" >{{ $palletQty??0 }}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="pform-panel">
                            <div class="pform-row" >
                                <div class="pform-label" >Pallets Selected</div>
                                <div class="pform-value" >: <span id="assign-pallet-selected-qty" >0</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
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
                        @foreach($racks as $rack)
                            @php
                                $slots = $rack['slots'] ?? [];
                                $rack_no = $rack['rack_no'];
                                $rack_id = $rack['rack_id'];
                                $room_id = $rack['room']['room_id'];
                                $no_of_levels = $rack['no_of_levels'];
                                $no_of_depth = $rack['no_of_depth'];
                                
                                if($no_of_depth == '5')
                                    $width = (number_format(100 / ($no_of_depth + 1), 0)-0.4) . '%';
                                else
                                    $width = number_format(100 / ($no_of_depth + 1), 2) . '%';

                                // Preprocess slots
                                foreach ($slots as &$slot) {
                                    $slot['depth_no_int'] = (int) str_replace('D', '', $slot['depth_no']);
                                    $slot['level_no_int'] = (int) str_replace('L', '', $slot['level_no']);
                                }
                                unset($slot);
                            @endphp
                            <div class="rackGroup" data-room-id="{{ $room_id }}" >
                                <div class="rackColumn">
                                    <div class="rackColumnName">
                                        Rack: {{ $rack_no }}
                                        <input type="hidden" name="rack_id" value="{{ $rack_id }}">
                                        <a href="#" class="view-rack-details" data-rack-id="{{ $rack_id }}" data-room-id="{{ $room_id }}">
                                            <i class="fas fa-eye text-white ml-3"></i>
                                        </a>
                                    </div>

                                    <ul class="slotRows" data-rack-id="{{ $rack_id }}" data-room-id="{{ $room_id }}">
                                        <li>
                                            <label>
                                                <input type="checkbox" id="select-all-slots-{{ $rack_id }}" class="select-all-slots" data-rack-id="{{ $rack_id }}" />
                                                <span>Select all Slots</span>
                                            </label>
                                        </li>

                                        {{-- Loop levels from top to bottom --}}
                                        @for ($l = $no_of_levels; $l > 0; $l--)
                                            <li class="rack-depth" data-type="depth" style="width:{{ $width }} !important;">
                                                <div class="rack-level-no">L{{ $l }}</div>
                                            </li>

                                            @for ($d = 1; $d <= $no_of_depth; $d++)
                                                @php
                                                    $slot = collect($slots)->firstWhere(function ($s) use ($l, $d) {
                                                        return $s['level_no_int'] === $l && $s['depth_no_int'] === $d;
                                                    });
                                                @endphp

                                                @if ($slot)
                                                    @php
                                                        $pallet = $slot['pallet'] ?? null;
                                                        $hasPallet = $slot['has_pallet'];
                                                        $dataPartial = '';

                                                        if ($hasPallet) {
                                                            $products = $pallet['available_products'] ?? [];
                                                            
                                                            $className = in_array($slot['status'], ['full', 'partial']) && $pallet['is_picked']
                                                                ? 'picked'
                                                                : ($slot['status'] === 'full' ? 'out-of-stock' : ($slot['status'] === 'partial' ? 'partial-stock' : 'available'));
                                                            
                                                            if ($slot['status'] === 'partial') {
                                                                $dataPartial = 'data-current-assigned-boxes="' . ($pallet['current_pallet_capacity'] ?? 0) . '" ';
                                                                $dataPartial .= 'data-pallet-capacity="' . ($pallet['pallet_capacity'] ?? 0) . '"';
                                                            }
                                                        }
                                                    @endphp

                                                    @if ($hasPallet)
                                                        <li class="{{ $className }}" data-id="{{ $slot['slot_id'] }}" data-type="slot" style="width:{{ $width }} !important;">
                                                            <label title="Slot {{ $slot['slot_no'] }} - L{{ $l }}-D{{ $d }}" style="position: relative; display: block;">
                                                                <div class="pallet-wrapper">
                                                                    <img src="{{ asset('images/pallet.png') }}" class="pallet-img">
                                                                    <div class="pallet-label">Pallet: {{ $pallet['pallet_no'] }}</div>
                                                                </div>
                                                                <div class="product-images">
                                                                    @foreach($products as $product)
                                                                        <div class="product-icon" title="{{ $product['product_description'] ?? '' }}">
                                                                            {!! $product['product']['CatSvgIcon']['svg_icon'] ?? '' !!}
                                                                            <div class="product-count">{{ $product['net_quantity'] ?? 0 }}/{{ $pallet['pallet_capacity'] ?? 0 }}</div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </label>
                                                        </li>
                                                    @else
                                                        <li class="empty-slot" data-id="{{ $slot['slot_id'] }}" data-type="slot" style="width:{{ $width }} !important;">
                                                            <label title="Empty Slot {{ $slot['slot_no'] }}-L{{ $l }}-D{{ $d }}">
                                                                <input type="hidden" id="assigned-box-count-{{ $slot['slot_id'] }}" name="quantity[]">
                                                                <input type="checkbox" name="slot_ids[]" id="frm-slot-{{ $slot['slot_id'] }}" value="{{ $slot['slot_id'] }}" {!! $dataPartial !!}/>
                                                                <span class="empty-slot-label">{{ $slot['slot_no'] }}</span>
                                                            </label>
                                                        </li>
                                                    @endif
                                                @else
                                                    <li class="rack-block" data-type="block" style="width:{{ $width }} !important;">
                                                        <div class="rack-block-no">--</div>
                                                    </li>
                                                @endif
                                            @endfor
                                        @endfor

                                        {{-- Depth Footer --}}
                                        <li class="rack-depth" data-type="depth" style="width:{{ $width }} !important;">
                                            <div class="rack-depth-no"></div>
                                        </li>
                                        @for ($d = 1; $d <= $no_of_depth; $d++)
                                            <li class="rack-depth" data-type="depth" style="width:{{ $width }} !important;">
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
    #roomTabs li.nav-item {  }
    #roomTabs li.nav-item a { color:#000; }
    #roomTabs li.nav-item a.active { color:#000; border-color:#000; border-bottom: 1px solid #FFF !important; }
    #roomTabs .nav-link:hover { border:1px solid #FFF !important; border-bottom:5px solid #000 !important; margin-bottom:-6px; }
    #roomTabContent { padding:15px 0; background-color:#FFF; width: 100%; }

    .rackColumn { width:19.8%; height:auto; float:left; border:1px solid #555; padding:5px 5px 5px 5px; margin:0 0 10px 2px; overflow: auto; min-height: 318px;}
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
    const assignedProduct = @json($assignedProduct) ?? {};
    const availableSlots = @json($availableSlots);
    const packingListDetailId = '{{ $packingListDetail->packing_list_detail_id }}';

    let assignedSlots = [];
    const selectedSlots = new Set();
    const slotMetadata = {};

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

    function calculateRequiredSlots(packageCount, packageCapacity) {
        let remaining = packageCount;
        const assignments = [];

        availableSlots.forEach(slot => {
            const current = slot.current || 0;
            let capacity = 0;

            if (slot.status === 'empty') {
                capacity = packageCapacity - current;
            } else if (slot.status === 'partial' && slot.total === packageCapacity) {
                capacity = slot.total - current;
            }

            if (capacity > 0) {
                const assign = Math.min(remaining, capacity);
                assignments.push({ slot_id: slot.slot_id, assigned: assign });
                remaining -= assign;
            }
        });

        assignedSlots = [assignments];

        return {
            totalSlots: assignments.length + Math.ceil(remaining / packageCapacity),
            assignments,
            newSlotsRequired: Math.ceil(remaining / packageCapacity),
            remainingPackages: remaining
        };
    }

    function restorePreviouslySelectedSlots() {
        Object.values(assignedProduct).forEach(product => {
            const selectedSlotsData = product.selected_slots;
            if (!selectedSlotsData) return;

            const parsedSlots = JSON.parse(selectedSlotsData);
            const slotIds = Object.keys(parsedSlots).map(Number);

            $("input[name='slot_ids[]']").each(function () {
                const $checkbox = $(this);
                const slotId = parseInt($checkbox.val());

                if (slotIds.includes(slotId)) {
                    $checkbox.prop("checked", true);
                    
                    if (product.packing_list_detail_id != packingListDetailId) {
                        $checkbox.prop("disabled", true);
                    }
                    $checkbox.trigger("change");
                }
            });
        });
    }

    function getAssignedPackageCount() {
        return Array.from(selectedSlots).reduce((sum, id) => {
            return sum + parseInt(slotMetadata[id]?.quantity || 0);
        }, 0);
    }

    $(document).on("change", ".select-all-slots", function () {
        const $ul = $(this).closest('ul');
        const isChecked = $(this).is(':checked');

        const packageCount = parseInt($('#packageQty').val()) || 0;
        const packageCapacity = parseInt($('#packageQtyPerPallet').val()) || 0;
        const required = parseInt($("#assign-pallet-required-qty").text()) || 0;
        let assignedCount = selectedSlots.size;

        const result = calculateRequiredSlots(packageCount, packageCapacity);
        const validSlotIds = result.assignments.map(s => s.slot_id);

        $ul.find("input[name='slot_ids[]']").each(function () {
            const $checkbox = $(this);
            const slotId = parseInt($checkbox.val());

            if ($checkbox.prop('disabled')) return;

            if (validSlotIds.includes(slotId)) {
                if (isChecked) {
                    if (!selectedSlots.has(slotId) && assignedCount < required) {
                        $checkbox.prop('checked', true);
                        $checkbox.trigger('change');
                        assignedCount++;
                    } else {
                        $checkbox.prop('checked', false);
                    }
                } else {
                    if (selectedSlots.has(slotId)) {
                        $checkbox.prop('checked', false);
                        $checkbox.trigger('change');
                        assignedCount--;
                    }
                }
            }
        });
    });

    $(document).on("change", "input[name='slot_ids[]']", function () {
        const $input = $(this);
        const slotId = parseInt($input.val());
        const isChecked = $input.is(":checked");
        const isEnabled = !$input.prop("disabled");
        const $li = $input.closest('li');
        const $rack = $input.closest('[data-rack-id]');

        const currentAssigned = parseInt($input.data('current-assigned-boxes')) || 0;
        const palletCapacity = parseInt($input.data('pallet-capacity')) || parseInt($('#packageQtyPerPallet').val()) || 0;

        const totalPackages = parseInt($('#packageQty').val()) || 0;
        const required = parseInt($("#assign-pallet-required-qty").text()) || 0;

        if (isChecked && isEnabled) {
            
            if (selectedSlots.size >= required) {
                toastr.error(`You can only select ${required} slot${required > 1 ? 's' : ''}.`);
                $input.prop('checked', false);
                return;
            }

            const remaining = totalPackages - getAssignedPackageCount();
            const assignQty = Math.min(palletCapacity - currentAssigned, remaining);

            $li.find('input[name="quantity[]"]').val(assignQty).end().addClass('selected');
            selectedSlots.add(slotId);

            const slot = availableSlots.find(s => s.slot_id === slotId);
            if (slot) {
                slotMetadata[slotId] = {
                    slot_id: slotId,
                    room_id: parseInt($rack.data('room-id')),
                    rack_id: parseInt($rack.data('rack-id')),
                    location: `${slot.room_name}-${slot.rack_no}-${slot.level_no}-${slot.depth_no}`,
                    quantity: assignQty
                };
            }
        } else if (isChecked && !isEnabled) {
            $li.addClass('selected'); // Preserve style for pre-assigned
        } else {
            $li.removeClass('selected').find('input[name="quantity[]"]').val('');
            selectedSlots.delete(slotId);
            delete slotMetadata[slotId];
        }

        $('#assign-pallet-selected-qty').text(selectedSlots.size);
        $('#confirmAssign').prop('disabled', selectedSlots.size !== required);
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

    $('#confirmAssign').on('click', function (e) {
        e.preventDefault();
        let isValid = checkPageFormValidate('assignInwardForm');
        if(isValid) {
            const required = parseInt($("#assign-pallet-required-qty").text());
            const selectedSlotCount = Object.keys(slotMetadata).length;

            if (selectedSlotCount !== required) {
                alert(`Please select exactly ${required} slot${required > 1 ? 's' : ''}.`);
                $('#confirmAssign').prop('disabled', false);
                return;
            }
            
            const selectedSlotsData = JSON.stringify(slotMetadata);
            $('#assignInwardForm input[name="selected_slots"]').val(selectedSlotsData);
            $('#assignInwardForm').submit();
        }
    });

    restorePreviouslySelectedSlots();
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
