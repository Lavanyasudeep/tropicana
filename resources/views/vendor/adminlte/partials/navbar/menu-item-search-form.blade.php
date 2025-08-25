<!-- Quick Menu -->
<li class="nav-item dropdown quick-menu">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" title="Quick Menu" >
        <i class="fas fa-bars"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right " style="left: inherit; right: 0px;">
        <span class="dropdown-item dropdown-header">Quick Menu</span>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.purchase.grn.index') }}" class="dropdown-item" >
            <i class="fas fa-arrow-right mr-2"></i> {{ __('GRN') }}
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.inventory.inward.index') }}" class="dropdown-item" >
            <i class="fas fa-arrow-right mr-2"></i> {{ __('Inward') }}
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.inventory.pick-list.index') }}" class="dropdown-item" >
            <i class="fas fa-arrow-right mr-2"></i> {{ __('Pick List') }}
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.inventory.outward.index') }}" class="dropdown-item" >
            <i class="fas fa-arrow-right mr-2"></i> {{ __('Outward') }}
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.inventory.storage-room.index') }}" class="dropdown-item" >
            <i class="fas fa-arrow-right mr-2"></i> {{ __('Storage Room') }}
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.report.stock-summary.index') }}" class="dropdown-item" >
            <i class="fas fa-arrow-right mr-2"></i> {{ __('Stock Summary Report') }}
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.report.stock-detail.index') }}" class="dropdown-item" >
            <i class="fas fa-arrow-right mr-2"></i> {{ __('Stock Detail Report') }}
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.accounting.payment.index') }}" class="dropdown-item" >
            <i class="fas fa-arrow-right mr-2"></i> {{ __('Payment Voucher') }}
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer btn btn-create">Add Menu</a>
    </div>
</li>

<!-- Search -->
<li class="nav-item">

    {{-- Search toggle button --}}
    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
    </a>

    {{-- Search bar --}}
    <div class="navbar-search-block">
        <form class="form-inline" action="{{ $item['href'] }}" method="{{ $item['method'] }}">
            {{ csrf_field() }}

            <div class="input-group">

                {{-- Search input --}}
                <input class="form-control form-control-navbar" type="search"
                    @isset($item['id']) id="{{ $item['id'] }}" @endisset
                    name="{{ $item['input_name'] }}"
                    placeholder="{{ $item['text'] }}"
                    aria-label="{{ $item['text'] }}">

                {{-- Search buttons --}}
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>

</li>
