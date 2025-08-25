@php
    $rackLevels = $rack->no_of_levels;
    $palletsPerLevel = $rack->no_of_depth;

    $palletWidth = 120;
    $palletHeight = 64;
    $palletFixedBottom = 190;
    $palletFixedLeft = 102;
    $verticalGap = 63;
    $horizontalGap = 155;
@endphp

<div id="rackDisplayArea" class="position-relative" style="min-height: 400px;">
    <img id="rackImage" src="{{ asset('/images/5rowrack.png') }}" alt="Rack Image" style="width: 100%; max-height: 100%;" />
    @foreach($rack['slots'] as $slot)
        @php
            $pallet = $slot['pallet'] ?? null;
            if (!$pallet || !preg_match('/L(\d+)-D(\d+)/', $pallet['pallet_position'], $match)) continue;

            $level = (int) $match[1];
            $depth = (int) $match[2];

            $bottom = $palletFixedBottom + ($level - 1) * $verticalGap;
            $left = $palletFixedLeft + ($depth - 1) * $horizontalGap;
        @endphp

        @if ($slot['has_pallet'])
            <div class="pallet-container position-absolute" style="bottom: {{ $bottom }}px; left: {{ $left }}px; width: {{ $palletWidth }}px; height: {{ $palletHeight }}px; z-index: 20;">
                <div class="pallet-label position-absolute text-dark fw-bold text-center" style="top: 50px; left: 0; width: 100%; font-size: 14px; z-index: 30;">
                    {{ $pallet['pallet_no'] }}
                </div>

                <div class="product-icon-wrapper position-absolute" style="bottom: 38%; left: 50%; transform: translateX(-50%); z-index: 50;">
                    @foreach($pallet['available_products'] ?? [] as $stock)
                        <div class="product-icon" title="{{ $stock['product']['product_description'] ?? '' }}">
                            {!! $stock['product']['CatSvgIcon']['svg_icon'] ?? '' !!}
                            <div class="product-count">{{ $stock['total_available_qty'] ?? 0 }}</div>
                        </div>
                    @endforeach
                </div>

                <img src="{{ asset('/images/pallet.png') }}" class="pallet-img" style="width: 70%; height: 85%;" />
            </div>
        @endif
    @endforeach
</div>
