
@if($logs->isEmpty())
    <p class="text-muted">No status history found.</p>
@else
    <div class="d-flex justify-content-between align-items-center mb-4">
        @foreach ($logs as $log)
            @php
                $status = strtolower($log->column_value ?? 'created');
                $colorMap = [
                    'created'   => 'secondary',
                    'approved'  => 'primary',
                    'finalized' => 'success',
                    'out'       => 'danger',
                    'picked'    => 'warning',
                ];
                $iconMap = [
                    'created'   => 'fa-circle',
                    'approved'  => 'fa-check',
                    'finalized' => 'fa-flag-checkered',
                    'out'       => 'fa-sign-out-alt',
                    'picked'    => 'fa-box',
                ];
                $color = $colorMap[$status] ?? 'info';
                $icon = $iconMap[$status] ?? 'fa-info-circle';
            @endphp

             <div class="text-center flex-fill position-relative">
                <i class="fas {{ $icon }} bg-{{ $color }}"></i>
                <div class="timeline-item">
                    <span class="time"><i class="far fa-clock"></i> {{ $log->created_at->format('d M Y H:i') }}</span>
                    <h3 class="timeline-header">
                        <strong>{{ $log->creator?->name ?? 'System' }}</strong>
                        <span class="badge bg-{{ $color }}">{{ ucfirst($status) }}</span>
                    </h3>
                    <div class="timeline-body">
                        {{ $log->description }}
                    </div>
                </div>

                @if (!$loop->last)
                    <div class="progress-line"></div>
                @endif
            </div>
        @endforeach
        <!-- <li>
            <i class="fas fa-clock bg-gray"></i>
        </li> -->
    </div>
@endif

<style>
     .active-step {
        font-weight: bold;
        box-shadow: 0 0 5px rgba(0,0,0,0.3);
    }

    .progress-line {
        height: 2px;
        background-color: #ccc;
        position: absolute;
        top: 50%;
        right: -50%;
        left: 50%;
        z-index: -1;
    }
</style>