@extends('adminlte::page')

@section('title', 'View GRN')

@section('content_header')
    <h1>Inward</h1>
@endsection

@section('content')

@include('admin.purchase.grn.modal')

<!-- Toggle between Views -->
<div class="page-sub-header">
    <h3>View Details</h3>
    <div class="action-btns" >
        <a href="{{ route('admin.purchase.grn.index') }}" class="btn btn-back" ><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card page-list-panel" >
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Supplier:</strong> {{ $grn->supplier->supplier_name??'' }}</p>
                <p><strong>Address:</strong> {{ $grn->supplier->supplier_address }}</p>
            </div>
            <div class="col-md-6 text-right">
                <p><strong>Ref. #:</strong> {{ $grn->grn_no }}</p>
                <p><strong>Date:</strong> {{ $grn->GRNDate }}</p>
            </div>
        </div>

        <table class="table table-striped page-list-table" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Lot No.</th>
                    <th class="text-center" >Quantity</th>
                    <th>Pallet No</th>
                    <!-- <th>Tray No</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grn->productmasters as $index => $productmaster)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $productmaster->product_description }}</td>
                    <td>{{ $productmaster->detail->BatchNo }}</td>
                    <td class="text-center" >{{ $productmaster->detail->ReceivedQuantity }}</td>
                    <td>
                        <input type="text" class="form-control pallet-input" 
                            data-product-id="{{ $productmaster->product_id }}" 
                            value="{{ $productmaster->detail->assigned_pallets }}" 
                            readonly>
                    </td>
                    <td>
                        <a href="{{ route('admin.purchase.grn.assign',['grn'=>$grn->GRNBatchID, 'id'=>$productmaster->detail->GRNProductID]) }}" class="btn btn-info btn-sm assign-btn @if($productmaster->detail->is_fully_assigned_to_cold_storage) disabled @endif " ><i class="fas fa-box"></i>&nbsp;&nbsp;Assign</a>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('css')
    <style>
    /* Storage Room Cards */
    .storage-room-card {
        width: 22%;
        min-height: 184px;
        padding: 15px;
        margin: 10px;
        /* border: 2px solid #d2cf46; */
        /* border-radius: 8px; */
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        background: url('{{ asset("images/room.png") }}') no-repeat center;
        background-size: contain;
        background-position-y: 34px;
        /* box-shadow: -3px 3px 6px #81938f69, inset -7px 14px 30px #d9d8a5;*/
    }
    
    .storage-room-card:hover {
        border-color: #6c757d;
    }
    
    .storage-room-card.selected {
        border-color: #007bff;
        background-color: #f8f9fa;
    }
    
    .room-name {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 5px;
    }
    
    .rack {
            width: 300px;
            height: 150px;
            background: steelblue;
            padding: 10px;
            text-align: center;
            transform: rotateX(15deg);
        }


    .rack-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .metal-rack {
        width: 120px;
        margin: 10px;
        background: url('{{ asset("images/rack.png") }}') no-repeat center;
        background-size: contain;
        background-position-y: 25px;
        min-height: 174px;
    }

    .rack-label {
        text-align: center;
        font-weight: normal;
        font-size: 13px;
        background: #897f3a;
        color: #fff;
        padding: 4px;
        border-radius: 4px;
        margin-bottom: 5px;
    }

    .metal-shelf {
        margin-bottom: 5px;
        position: relative;
        height: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .metal-beam {
        height: 4px;
        background: #888;
        width: 100%;
        margin: 2px 0;
    }

    .metal-pallet {
        background: #eee;
        width: 90px;
        height: 80px;
        position: relative;
        border: 1px solid #999;
        border-radius: 4px;
        display: flex;
        flex-direction: column-reverse;
        align-items: center;
        justify-content: flex-end;
        padding: 5px;
    }

    /* .pallet-label {
        font-size: 10px;
        font-weight: bold;
        color: #333;
        margin-top: 4px;
    } */

    .pallet-label {
        background: #333;
        color: #fff;
        position: absolute;
        bottom: 2px;
        width: 100%;
        font-size: 10px;
        text-align: center;
        color: white;
        font-weight: bold;
        padding: 4px;
        border-radius: 4px;
    }

    .product-stack {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Adjust based on how many per row */
        gap: 4px;
        padding: 4px;
    }

    .product-image {
        width: 40px;
        height: 40px;
    }
    .product-image svg {
        width: 100%;
        height: 100%;
    }

    .empty-space {
        width: 90px;
        height: 80px;
        background: #f9f9f9;
        border: 1px dashed #ccc;
        border-radius: 4px;
    }

    #rackDetailModal .modal-dialog { width:250px; }
    #rackDetailModal .metal-rack { width:85%; }

    .rack-pallet-list { list-style-type:none; margin:0; padding:0; }
    .rack-pallet-list li { width:100%; margin:10px 0 0 0; padding:0; }
    .rack-pallet-list li label { width:100%; margin:29px 0 0 22px; }
    .rack-pallet-list li label span { display: inline-block; margin:-3px 0 0 2px; font-size: 13px; float: left; color:#555; } 
    .rack-pallet-list li input { float:left; }

    #assignStorageForm strong { width:124px; display:inline-block; float:left; }
    #assignStorageForm div.frm-v { float:left; }
    #assignStorageForm div.frm-v::before { content:': '; margin-right: 5px; }
    #assignStorageForm input[type="number"] { width:100px; border:1px solid #CCC; border-radius:3px; }

    #step-title { font-size:16px; text-decoration:underline; }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Configuration
        const PALLET_ORDER = 'bottom-up'; // or 'top-down'
        let currentStep = 1;
        const selectedData = {};
        let grnId = null;

        // Update step title and clear selection
        function updateStepTitle(title) {
            $('#step-title').text(title);
            $('#visual-selector').html('');
            $('#confirmAssign').prop('disabled', true);
            $("#backBtn").toggleClass("d-none", currentStep === 1);
        }

        function createRackWithPallets(rack) {
            let shelvesHtml = '';
            const totalShelves = 1;

            for (let i = 0; i < totalShelves; i++) {
                const pallet = rack.pallets[i];

                shelvesHtml += `
                    <div class="metal-shelf">
                        <div class="metal-beam"></div>
                        ${pallet ? `
                            <div class="metal-pallet" data-id="${pallet.pallet_id}" data-type="pallet">
                                <div class="pallet-label">${pallet.name}</div>
                                <div class="product-stack">
                                    ${pallet.products?.map(product => `
                                        <div class="product-image" title="${product.product_description} (${product.ReceivedQuantity})">
                                            ${product.cat_svg_icon.svg_icon}
                                        </div>
                                    `).join('') || ''}
                                </div>
                            </div>` : `
                            <div class="empty-space"></div>`
                        }
                        <div class="metal-beam"></div>
                    </div>`;
            }

            return `
                <div class="metal-rack" data-id="${rack.rack_id}" data-type="rack" data-name="${rack.name}">
                    <div class="rack-label">${rack.name}</div>
                    ${shelvesHtml}
                </div>`;
        }

        // Modified createRacks function
        function createRacks(rack) {
            let palletsHtml = '';

            if (rack.pallets && rack.pallets.length > 0) {
                rack.pallets.forEach(pallet => {
                    palletsHtml += `
                        <li data-id="${pallet.pallet_id}" data-type="pallet" >
                            <label for="frm-pallet-${pallet.pallet_id}" >
                                <input type="hidden" id="assigned-box-count-per-pallet" name="quantity[]">
                                <input type="checkbox" name="pallet_ids[]" id="frm-pallet-${pallet.pallet_id}" value="${pallet.pallet_id}" 
                                ${pallet.status === 'partial' ? `data-current-assigned-boxes="${pallet.current_pallet_capacity}"` : ''} />
                                <span>${pallet.name}</span>                                
                            <label>
                        </li>
                    `;
                });
            }

            return `
                <div class="metal-rack">
                    <div class="rack-label" >
                        ${rack.name} - ${rack.rack_no}
                        <a class="rack-view-pallet text-white ml-2" href="#" data-id="${rack.rack_id}" data-type="rack" data-name="${rack.name}">
                            <i class="fa fa-eye"></i>
                            <input type="hidden" name="rack_id" value="${rack.rack_id}" >
                        </a>
                    </div>
                    <ul class="rack-pallet-list" >
                        ${palletsHtml}
                    </ul>
                </div>
            `;
        }

        // Render storage rooms with rack counts
        function renderRooms() {
            currentStep = 1;
            updateStepTitle("Step 1: Select a Storage Room");
            selectedData.roomId = null;
            selectedData.palletId = null;

            $.get('/admin/purchase/grn/get-storage-rooms', function(response) {
                response.rooms.forEach(room => {
                    $('#visual-selector').append(`
                        <div class="storage-room-card" data-id="${room.room_id}" data-type="room">
                            <div class="room-name">${room.name} | ${room.rack_count || 0}</div>
                        </div>
                    `);
                });
            });
        }

        // Render racks for selected room
        function renderRacks(roomId) {
            currentStep = 2;
            updateStepTitle("Step 2: Select a Rack/Pallet");
            selectedData.palletId = null;

            $.post("/admin/purchase/grn/get-racks", { 
                room_id: roomId, 
                box_capacity : parseInt($('#assign-box-per-pallet').val()) || 40,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function(response) {
                response.racks.forEach(rack => {
                    $('#visual-selector').append(createRacks(rack));
                });
            });
        }

        function getSelectedPalletCount() {
            var cnt = 0;
            $(".rack-pallet-list li input:checked").each(function(){
                cnt++;
            });
            $("#assign-pallet-selected-qty").text(cnt);
        }

        function calculateBoxCount()
        {
            const weightPerUnit = parseInt($("#assign-grn-weight-per-unit").text()) || 0;
            const weightPerBox = parseInt($("#assign-weight-per-box").val()) || 0;
            const grnQuantity = parseInt($("#assign-grn-qty").text()) || 0;
            const grnUnit = $('#assign-grn-unit').text();

            // Declare boxCount in the outer scope
            let boxCount;

            if (grnUnit === 'Kg') {
                // Calculate boxCount for weight-based units
                boxCount = Math.ceil((grnQuantity * weightPerUnit) / weightPerBox);
            } else {
                // Retrieve boxCount for other units
                boxCount = parseInt($('#selected-prod-box-count').val()) || 0;
            }

            return boxCount;
        }

        function calculateRequiredPallets(boxCount, boxCapacity, availablePallets = []) {
            let remainingBoxes = boxCount;
            let assignments = [];

            // Try to fill existing pallets
            availablePallets.forEach(pallet => {
                const remainingCapacity = boxCapacity - (pallet.current || 0);
                if (remainingCapacity <= 0) return;

                const assign = Math.min(remainingBoxes, remainingCapacity);

                assignments.push({
                    pallet_id: pallet.pallet_id,
                    assigned: assign,
                    after_assign: (pallet.current || 0) + assign,
                });

                remainingBoxes -= assign;
            });

            const newPalletsRequired = Math.ceil(remainingBoxes / boxCapacity);

            return {
                totalPallets: assignments.length + newPalletsRequired,
                assignments,
                newPalletsRequired,
                remainingBoxes
            };
        }

        // Add this with your other event handlers
        $(document).on("click", ".metal-rack .rack-view-pallet", function() {
            const rackId = $(this).data("id");

            // Show loading indicator in modal
            $("#rack-detail-content").html('<p class="text-muted text-center">Loading...</p>');
            $("#rackDetailModal").modal('show');

            // Fetch rack details and show
            $.post("/admin/master/inventory/racks/get-rack-details", {
                rack_id: rackId,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function(response) {
                const rackHtml = createRackWithPallets(response.rack);
                $("#rack-detail-content").html(rackHtml);
            }).fail(function(xhr) {
                $("#rack-detail-content").html(`<div class="alert alert-danger">Failed to load rack details.</div>`);
            });
        });

        // Event Handlers
        /*
        $(document).on("click", ".assign-btn", function() {
            grnId = $(this).data("id");
            const productName = $(this).data("product-name");
            const requiredPallets = $(this).data("required-pallets") || 1;
            const boxPerPallet = $(this).data("box-per-pallet") || 1;  
            const weightPerBox = $(this).data("weight-per-box") || 1;            
            const grnDetailId = $(this).data("grn-detail-id");
            const prodMasterId = $(this).data("product-id");
            const grnQuantity = $(this).data("grn-quantity");
            const grnWeightPerUnit = $(this).data("grn-weight-per-unit");
            const grnUnit = $(this).data("grn-unit");
            const prodBoxCount = $(this).data("product-box-count");

            $('#selected-prod-box-count').val(prodBoxCount);
            $('#grn-detail-id').val(grnDetailId);
            $('#product-master-id').val(prodMasterId);

            if (grnUnit === 'Kg') {
                $('#weightPerBoxDiv').show(); // Show the div
                $('#assign-weight-per-box').val(weightPerBox); // Set the input value
            } else {
                $('#weightPerBoxDiv').hide(); // Hide the div
            }
            
            $("#assign-product-name").text(productName);
            $("#assign-grn-qty").text(grnQuantity);
            $("#assign-grn-weight-per-unit").text(grnWeightPerUnit);
            $("#assign-grn-unit").text(grnUnit);

            $("#assign-box-per-pallet").val(boxPerPallet);
            $("#assign-pallet-required-qty").text(requiredPallets);
            $("#assign-pallet-selected-qty").text('0');

            renderRooms();
            $('#assignColdStorageModal').modal('show');
        });*/

        $(document).on("input", "#assign-box-per-pallet, #assign-weight-per-box", function() {
            // var grnQuantity = $("#assign-grn-qty").text();
            // // var boxCount = $("#assign-grn-qty").text();
            // // var weightPerUnit = $("#assign-grn-weight-per-unit").text();
            // var boxPerPallet = $("#assign-box-per-pallet").val();
            // var requiredPallets = Math.ceil(parseFloat(grnQuantity / boxPerPallet));
            // $("#assign-pallet-required-qty").text(requiredPallets);

            // Retrieve and parse input values
            const boxCount = calculateBoxCount(); // Your existing logic
            const boxCapacity = parseInt($('#assign-box-per-pallet').val()) || 40;

            $('li[data-type="pallet"]').each(function () {
                const currentCapacity = parseInt($(this).find('input[name="pallet_ids[]"]').data('current-assigned-boxes')) || 0;
                
                if (currentCapacity >= boxCapacity) {
                    $(this).closest('.metal-rack').hide();
                } else {
                    $(this).closest('.metal-rack').show();
                }
            });

            const availablePallets = @json($availablePallets);

            const result = calculateRequiredPallets(boxCount, boxCapacity, availablePallets);

            $('#assign-pallet-required-qty').text(result.totalPallets);
        });

        $('#backBtn').click(function() {
            if (currentStep === 2) {
                renderRooms();
            }
        });

        $(document).on("click", ".storage-room-card", function() {
            const id = $(this).data("id");
            $(".storage-room-card").removeClass("selected");
            $(this).addClass("selected");
            selectedData.roomId = id;
            renderRacks(id);
        });

        // $(document).on("click", ".metal-pallet, .empty-space", function() {
        //     $(".metal-pallet, .empty-space").removeClass("selected");
        //     $(this).addClass("selected");
            
        //     if ($(this).hasClass("metal-pallet")) {
        //         selectedData.palletId = $(this).data("id");
        //     } else {
        //         selectedData.emptyPosition = $(this).data("position");
        //     }
            
        // });

        $('#confirmAssign').click(function () {
            const selectedPallets = $("input[name='pallet_ids[]']:checked")
                .map(function () {
                    return $(this).val();
                }).get();

            const required = parseInt($("#assign-pallet-required-qty").text());

            if (selectedPallets.length !== required) {
                alert(`Please select exactly ${required} pallet${required > 1 ? 's' : ''}.`);
                $('#confirmAssign').prop('disabled', false);
                return;
            }

            const formData = $('#assignStorageForm').serialize();

            // Add additional data that might not be in the form
            const extraData = {
                movement_type: 'in',
                status: 'stored'
            };

            // Combine both
            const requestData = formData + '&' + $.param(extraData);

            $.post("/admin/purchase/grn/assign-to-inventory", requestData, function(response) {
                alert(response.message || 'Assigned successfully!');
                $('#assignColdStorageModal').modal('hide');
                location.reload();
            }).fail(function(xhr) {
                alert(xhr.responseJSON?.message || "Error assigning product");
            });
        });

        $(document).on("change", "input[name='pallet_ids[]']", function () {
            const totalBoxes = calculateBoxCount();
            const boxCapacity = parseFloat($('#assign-box-per-pallet').val()) || 40;
            const required = parseInt($("#assign-pallet-required-qty").text());

            let assignedBoxes = 0;

            // Limit selection to required pallets
            const selectedCount = $("input[name='pallet_ids[]']:checked").length;
            if (selectedCount > required) {
                $(this).prop("checked", false);
                alert(`You can only select ${required} pallet${required > 1 ? 's' : ''}.`);
                return;
            }

            // Loop through selected pallets and assign boxes
            $("input[name='pallet_ids[]']").each(function () {
                const isChecked = $(this).is(":checked");
                const currentAssignedBoxes = parseInt($(this).data('current-assigned-boxes')) || 0;
                const currentBoxCapacity = boxCapacity - currentAssignedBoxes;
                const remainingBoxes = totalBoxes - assignedBoxes;

                const assignBoxes = (isChecked && remainingBoxes > 0)
                    ? Math.min(currentBoxCapacity, remainingBoxes)
                    : '';

                $(this).closest('li').find('input[name="quantity[]"]').val(assignBoxes);
                if (isChecked) assignedBoxes += parseInt(assignBoxes || 0);
            });

            // Enable/disable Assign button
            $('#assign-pallet-selected-qty').text(selectedCount);
            $('#confirmAssign').prop('disabled', selectedCount !== required);
        });


    });
</script>
@stop