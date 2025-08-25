<div class="modal fade" id="assignColdStorageModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Assign Product to Cold Storage</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="assignStorageForm" >
            @csrf
              <div class="justify-content-between mb-4 assStorageFrm" >
                <div class="row" >
                  <div class="col-md-6" >
                    <strong>Product</strong> <div class="frm-v" ><span id="assign-product-name" ></span></div>
                  </div>
                  <div class="col-md-6" >
                    <strong>Box per Pallet</strong> <div class="frm-v" ><input type="number" id="assign-box-per-pallet" name="box_capacity_per_pallet" /></div>
                  </div>
                </div>
                <div class="row" >
                  <div class="col-md-6" >
                    <strong>GRN Qty</strong> <div class="frm-v" ><span id="assign-grn-qty" >0</span></div>
                  </div>
                  <div class="col-md-6" >
                    <strong>Pallets Required</strong> <div class="frm-v" ><span id="assign-pallet-required-qty" >0</span></div>
                  </div>
                </div>
                <div class="row" >
                  <div class="col-md-6" >
                    <strong>GRN Weight</strong> <div class="frm-v" ><span id="assign-grn-weight-per-unit" >0</span>&nbsp;</span><span id="assign-grn-unit"></span></div>
                  </div>
                  <div class="col-md-6" >
                    <strong>Pallets Selected</strong> <div class="frm-v" ><span id="assign-pallet-selected-qty" >0</span></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6" id="weightPerBoxDiv">
                    <strong>Weight per Box</strong> <div class="frm-v" ><input type="number" id="assign-weight-per-box" name="weight_per_box" /></div>
                  </div>
                </div>
              </div>
              <hr />
              <input type="hidden" id="selected-prod-box-count" name="selected_prod_box_count">
              <input type="hidden" id="product-master-id" name="product_master_id">
              <input type="hidden" id="grn-detail-id" name="grn_detail_id">
              <div id="step-title" class="mb-3 h6" >Step 1: Select a Room</div>
                  <div id="visual-selector" class="d-flex flex-wrap justify-content-start gap-3">
                      <!-- Blocks will be injected dynamically -->
                  </div>
              
                  <input type="hidden" id="selected-unit">
                  <input type="hidden" id="selected-rack">
              </div>
              <div class="modal-footer">
                  <button id="backBtn" class="btn btn-secondary mb-2 d-none">
                      ← Back
                  </button>
                  <button type="submit" id="confirmAssign" class="btn btn-primary" disabled>Assign Product</button>
              </div>
          </form>
      </div>
    </div>
</div>

<!-- Rack Detail Modal -->
<div class="modal fade" id="rackDetailModal" tabindex="-1" role="dialog" aria-labelledby="rackDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rack Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="rack-detail-content">
        <!-- Detailed rack view will be injected here -->
      </div>
    </div>
  </div>
</div>
