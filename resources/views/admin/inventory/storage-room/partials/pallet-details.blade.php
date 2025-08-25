<!-- Modal -->
<div class="modal fade" id="palletDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pallet Detail</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="palletModalBody">
            <div class="metal-pallet">
                <!-- <div class="pallet-label">{{ $pallet->name }}</div> -->
                <div class="pallet-shelf">
                    <div class="pallet-detail">
                        <div class="product-info">Pallet: {{ $pallet->name }}</div>
                    </div>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>

<style>
    .metal-pallet {
        width: 85%;
        height: 150px;
        margin: 10px;
        padding: 5px;
        background-image: url('{{ asset("images/rack.png") }}'); 
        background-size: contain;
        background-repeat: no-repeat;
        position: relative;
        background-position-y: 0;
        min-height: 174px;
        margin: 0 auto;
    }

    .pallet-label {
        text-align: center;
        font-weight: bold;
        background: #b5651d;
        color: #fff;
        padding: 4px;
        border-radius: 4px;
        margin-bottom: 5px;
    }

    /* .rack-detail-view {
        display: flex;
        gap: 20px;
        justify-content: center;
    } */

    .pallet-shelf {
        position: absolute;
        bottom: 60px;
        left: 48%;
        transform: translateX(-50%);
        text-align: center;
    }

    .product-detail {
        display: grid;
        grid-auto-flow: column;
        /* flex-wrap: wrap; */
        justify-content: center;
        grid-template-columns: repeat(4, 1fr);
        gap: 4px;
    }

    .product-detail svg {
        width: 28px;
        height: 28px;
    }

    .product-info {
        background-color: #c4601e;
        color: white;
        font-size: 12px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-top: 4px;
    }

    #palletDetailModal .modal-dialog { width:250px; }
</style>
