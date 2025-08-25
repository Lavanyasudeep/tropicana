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

    <div class="rackColumn">
        <div class="rackColumnName">
            Rack: {{ $rack_no }}
            <input type="hidden" name="rack_id" value="{{ $rack_id }}">
            <a href="#" class="view-rack-details" data-rack-id="{{ $rack_id }}" data-room-id="{{ $room_id }}">
                <i class="fas fa-eye text-white ml-3"></i>
            </a>
        </div>

        <ul class="slotRows" data-rack-id="{{ $rack_id }}" data-room-id="{{ $room_id }}">
            <li class="d-none" >
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

                            if ($hasPallet) {
                                $products = $pallet['available_products'] ?? [];
                                
                                $className = in_array($slot['status'], ['full', 'partial']) && $pallet['is_picked']
                                    ? 'picked'
                                    : ($slot['status'] === 'full' ? 'out-of-stock' : ($slot['status'] === 'partial' ? 'partial-stock' : 'available'));
                            }
                        @endphp

                        @if ($hasPallet)
                            <li class="{{ $className }}" data-id="{{ $slot['slot_id'] }}" data-type="slot" style="width:{{ $width }} !important;">
                                <label title="Slot : {{ $slot['room']['name'].'-'.$slot['rack']['name'] }}-L{{ $l }}-D{{ $d }}" style="position: relative; display: block;">
                                    <div class="pallet-wrapper">
                                        <img src="{{ asset('images/pallet.png') }}" class="pallet-img">
                                        <div class="pallet-label">Pallet: {{ $pallet['pallet_no'] }}</div>
                                    </div>
                                    <div class="product-images">
                                        @foreach($products as $product)
                                            <div class="product-icon" title="{{ $product['product_description'] ?? '' }}">
                                                {!! $product['product']['CatSvgIcon']['svg_icon'] ?? '' !!}
                                                <div class="product-count">{{ $product['total_available_qty'] ?? 0 }}/{{ $pallet['pallet_capacity'] ?? 0 }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </label>
                            </li>
                        @else
                            <li class="empty-slot" data-id="{{ $slot['slot_id'] }}" data-type="slot" style="width:{{ $width }} !important;">
                                <label title="Empty Slot : {{ $slot['room']['name'].'-'.$slot['rack']['name'] }}-L{{ $l }}-D{{ $d }}">
                                    <input type="hidden" id="assigned-box-count-{{ $slot['slot_id'] }}" name="quantity[]">
                                    <input type="checkbox" name="slot_ids[]" id="frm-slot-{{ $slot['slot_id'] }}" value="{{ $slot['slot_id'] }}" />
                                    <span class="empty-slot-label"></span>
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
@endforeach




