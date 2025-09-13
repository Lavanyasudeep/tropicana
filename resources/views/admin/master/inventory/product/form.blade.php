@extends('adminlte::page')

@section('title', 'Create Product Master')

@section('content_header')
    <h1>Product Master</h1>
@endsection

@section('content')
@php
   if(isset($product)) {
        $page_title = 'Edit';
        $action = route('admin.master.inventory.product.update', $product->id);
        $method = 'PUT';
        $product_name = $product->product_name;
        $product_code = $product->product_code;
        $product_category_id = $product->product_category_id;
        $brand_id = $product->brand_id;
        $product_description = $product->product_description;
        $short_name = $product->short_name;
        $hsn_code = $product->hsn_code;
        $image = $product->image;
    } else {
        $page_title = 'Create';
        $action = route('admin.master.inventory.product.store');
        $method = 'POST';
        $product_name = '';
        $product_code = '';
        $product_category_id = '';
        $brand_id = '';
        $product_description = '';
        $short_name = '';
        $hsn_code = '';
        $image = '';
    }
@endphp
<div class="page-sub-header">
    <h3>{{ $page_title }} Form</h3>
    <div class="action-btns">
        <a href="{{ route('admin.master.inventory.product.index') }}" class="btn btn-success">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="pageTabs">
    <ul class="nav nav-tabs" id="productTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="tab-basic" data-toggle="tab" href="#basic" role="tab"><i class="fas fa-info-circle"></i> Basic Info</a></li>
        <li class="nav-item"><a class="nav-link" id="tab-specs" data-toggle="tab" href="#specs" role="tab"><i class="fas fa-cogs"></i> Specifications</a></li>
        <!-- <li class="nav-item"><a class="nav-link" id="tab-variants" data-toggle="tab" href="#variants" role="tab"><i class="fas fa-receipt"></i> Variants</a></li> -->
        <li class="nav-item"><a class="nav-link" id="tab-inventory" data-toggle="tab" href="#inventory" role="tab"><i class="fas fa-warehouse"></i> Inventory</a></li>
        <li class="nav-item"><a class="nav-link" id="tab-tax" data-toggle="tab" href="#tax" role="tab"><i class="fas fa-receipt"></i> Tax & Pricing</a></li>
        <li class="nav-item"><a class="nav-link" id="tab-others" data-toggle="tab" href="#others" role="tab"><i class="fas fa-ellipsis-h"></i> Others</a></li>
    </ul>

    <div class="card page-form page-form-add">
        <div class="card-body">
            <form action="{{ route('admin.master.inventory.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method($method)

                <div class="tab-content" id="productTabContent">
                    <!-- BASIC INFO -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:158px;">

                                    <!-- Identification -->
                                    <div class="pform-section-title">Identification</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Product Name <span class="text-danger">*</span></div>
                                        <div class="pform-value">
                                            <input type="text" name="product_name" value="{{ old('product_name') }}" placeholder="Enter full product name" required>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Product Code</div>
                                        <div class="pform-value">
                                            <input type="text" name="product_code" value="{{ old('product_code') }}" placeholder="Internal code or SKU">
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Short Name</div>
                                        <div class="pform-value">
                                            <input type="text" name="short_name" value="{{ old('short_name') }}" placeholder="Abbreviated name for labels">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:158px;">
                                    <!-- Classification -->
                                    <div class="pform-section-title">Classification</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Category</div>
                                        <div class="pform-value">
                                            <select name="product_category_id">
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->product_category_id  }}">{{ $cat->product_category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Brand</div>
                                        <div class="pform-value">
                                            <select name="brand_id">
                                                <option value="">-- Select Brand --</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Product Type</div>
                                        <div class="pform-value">
                                            <select name="product_type">
                                                <option value="">-- Select Type --</option>
                                                <option value="Dry">Dry</option>
                                                <option value="Frozen">Frozen</option>
                                                <option value="Chilled">Chilled</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="pform-panel" style="min-height:158px;">
                                        <!-- Description -->
                                        <div class="pform-section-title">Description</div>
                                        <div class="pform-row">
                                            <div class="pform-label">Description</div>
                                            <div class="pform-value">
                                                <textarea name="product_description" placeholder="Detailed description">{{ old('product_description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="pform-panel" style="min-height:158px;">
                                        <!-- Codes & Compliance -->
                                        <div class="pform-section-title">Codes & Compliance</div>
                                        <div class="pform-row">
                                            <div class="pform-label">HSN Code</div>
                                            <div class="pform-value">
                                                <input type="text" name="hsn_code" value="{{ old('hsn_code') }}" placeholder="e.g. 21069099">
                                            </div>
                                        </div>
                                        <div class="pform-row">
                                            <div class="pform-label">Country of Origin</div>
                                            <div class="pform-value">
                                                <select name="country_of_origin">
                                                    <option value="">-- Select Country --</option>
                                                    <option value="IN">India</option>
                                                    <option value="US">United States</option>
                                                    <option value="CN">China</option>
                                                    <!-- Add more -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pform-row">
                                            <div class="pform-label">Regulatory Approval No.</div>
                                            <div class="pform-value">
                                                <input type="text" name="regulatory_no" placeholder="e.g. FSSAI / FDA / CE">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="pform-panel" style="min-height:158px;">
                                        <!-- Image -->
                                        <div class="pform-section-title">Media</div>
                                        <div class="pform-row">
                                            <div class="pform-label">Product Image</div>
                                            <div class="pform-value">
                                                <input type="file" name="image" id="product_image">
                                                <img id="preview" class="mt-2 rounded shadow-sm border" style="max-width:150px; display:none;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pform-panel" style="min-height:158px;">

                                        <!-- Procurement -->
                                        <div class="pform-section-title">Procurement</div>
                                        <div class="pform-row d-none">
                                            <div class="pform-label">Arrival Date</div>
                                            <div class="pform-value">
                                                <input type="date" name="arrival_date">
                                            </div>
                                        </div>
                                        <div class="pform-row">
                                            <div class="pform-label">Supplier</div>
                                            <div class="pform-value">
                                                <select name="supplier_id">
                                                    <option value="">-- Select Supplier --</option>
                                                    @foreach($suppliers as $sup)
                                                        <option value="{{ $sup->supplier_id }}">{{ $sup->supplier_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pform-row">
                                            <div class="pform-label">Customer</div>
                                            <div class="pform-value">
                                                <select name="customer_id">
                                                    <option value="">-- Select Customer --</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- SPECIFICATIONS -->
                    <div class="tab-pane fade" id="specs" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:150px;">
                                    <!-- Dimensions -->
                                    <div class="pform-section-title">Dimensions</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Length (cm)</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="length_cm" placeholder="e.g. 30.5"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Width (cm)</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="width_cm" placeholder="e.g. 20.0"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Height (cm)</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="height_cm" placeholder="e.g. 15.0"></div>
                                    </div>
                                </div>

                                <div class="pform-panel" style="min-height:158px;">
                                    <!-- Storage & Compliance -->
                                    <div class="pform-section-title">Storage & Compliance</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Storage Temp (°C)</div>
                                        <div class="pform-value"><input type="text" name="storage_temp" placeholder="e.g. -18 to -20"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Shelf Life (Days)</div>
                                        <div class="pform-value"><input type="number" name="shelf_life_days" placeholder="e.g. 365"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Hazardous Material</div>
                                        <div class="pform-value">
                                            <select name="hazardous_flag">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="pform-panel" style="min-height:100px;">
                                    <!-- Specifications -->
                                    <div class="pform-section-title">Specifications</div>
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
                                    <br /><br />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:260px;">
                                    
                                    <!-- Weight & Capacity -->
                                    <div class="pform-section-title">Weight & Capacity</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Net Weight (kg)</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="product_weight" placeholder="e.g. 1.25"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Gross Weight (kg)</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="gross_weight" placeholder="e.g. 1.35"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Weight Per Box (kg)</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="weight_per_box" placeholder="e.g. 10.00"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Box Capacity (Full Pallet)</div>
                                        <div class="pform-value"><input type="number" name="box_capacity_per_full_pallet" placeholder="e.g. 50"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Box Capacity (Half Pallet)</div>
                                        <div class="pform-value"><input type="number" name="box_capacity_per_half_pallet" placeholder="e.g. 25"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Items per Box</div>
                                        <div class="pform-value"><input type="number" name="no_of_items_in_box" placeholder="e.g. 12"></div>
                                    </div>
                                </div>
                                
                                <div class="pform-panel" style="min-height:158px;">
                                    <!-- Material & Packaging -->
                                    <div class="pform-section-title">Material & Packaging</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Material / Composition</div>
                                        <div class="pform-value"><input type="text" name="material" placeholder="e.g. Polypropylene"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Packaging Type</div>
                                        <div class="pform-value">
                                            <select name="packaging_type">
                                                <option value="">-- Select --</option>
                                                <option value="Box">Box</option>
                                                <option value="Carton">Carton</option>
                                                <option value="Bag">Bag</option>
                                                <option value="Drum">Drum</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PRODUCT VARIANTS -->
                    <div class="tab-pane fade" id="variants" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pform-panel" style="min-height:300px;">

                                    <!-- Add Variant Form -->
                                    <div class="pform-section-title">Add Variant</div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Variant Name <span class="text-danger">*</span></label>
                                            <input type="text" name="variant_name" id="variant_name" class="form-control" placeholder="e.g. 500g Pack">
                                        </div>
                                        <div class="col-md-4">
                                            <label>SKU / Code</label>
                                            <input type="text" name="variant_code" id="variant_code" class="form-control" placeholder="Optional">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Status</label>
                                            <select name="variant_status" id="variant_status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Variant Specifications -->
                                    <div class="pform-section-title">Variant Specifications</div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label>Weight (kg)</label>
                                            <input type="number" step="0.01" name="variant_weight" id="variant_weight" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Dimensions (L × W × H cm)</label>
                                            <input type="text" name="variant_dimensions" id="variant_dimensions" class="form-control" placeholder="e.g. 20×15×10">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Packaging Type</label>
                                            <select name="variant_packaging" id="variant_packaging" class="form-control">
                                                <option value="">-- Select --</option>
                                                <option value="Carton">Carton</option>
                                                <option value="Bag">Bag</option>
                                                <option value="Bottle">Bottle</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Items per Box</label>
                                            <input type="number" name="variant_items_per_box" id="variant_items_per_box" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Add Button -->
                                    <div class="text-right mb-3">
                                        <button type="button" class="btn btn-success" id="addVariantBtn">
                                            <i class="fas fa-plus"></i> Add Variant
                                        </button>
                                    </div>

                                    <!-- Variants Table -->
                                    <div class="pform-section-title">Variants List</div>
                                    <table class="table table-bordered page-list-table" id="variantsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Variant Name</th>
                                                <th>Code</th>
                                                <th>Weight</th>
                                                <th>Dimensions</th>
                                                <th>Packaging</th>
                                                <th>Items/Box</th>
                                                <th>Status</th>
                                                <th width="10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic rows will be appended here -->
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- INVENTORY -->
                    <div class="tab-pane fade" id="inventory" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:190px;">

                                    <!-- Stock Levels -->
                                    <div class="pform-section-title">Stock Levels</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Min Stock Qty</div>
                                        <div class="pform-value"><input type="number" name="min_stock_qty" placeholder="e.g. 50"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Max Stock Qty</div>
                                        <div class="pform-value"><input type="number" name="max_stock_qty" placeholder="e.g. 500"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Re-order Level</div>
                                        <div class="pform-value"><input type="number" name="re_order_level" placeholder="e.g. 100"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Re-order Qty</div>
                                        <div class="pform-value"><input type="number" name="re_order_qty" placeholder="e.g. 200"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:190px;">
                                    <!-- Units -->
                                    <div class="pform-section-title">Units</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Purchase Unit</div>
                                        <div class="pform-value">
                                            <select name="purchase_unit_id">
                                                <option value="">-- Select Unit --</option>
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Selling Unit</div>
                                        <div class="pform-value">
                                            <select name="selling_unit_id">
                                                <option value="">-- Select Unit --</option>
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:300px;">
                                    <!-- Additional Inventory Controls -->
                                    <div class="pform-section-title">Inventory Controls</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Default Warehouse</div>
                                        <div class="pform-value">
                                            <select name="default_warehouse_id">
                                                <option value="">-- Select Warehouse --</option>
                                                <!-- Populate from warehouses -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Rack / Bin Location</div>
                                        <div class="pform-value"><input type="text" name="rack_location" placeholder="e.g. Room A - Rack 3 - Bin 5"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Lead Time (Days)</div>
                                        <div class="pform-value"><input type="number" name="lead_time_days" placeholder="e.g. 7"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Minimum Order Qty (MOQ)</div>
                                        <div class="pform-value"><input type="number" name="moq" placeholder="e.g. 100"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Allow Negative Stock</div>
                                        <div class="pform-value">
                                            <select name="allow_negative">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Batch Tracking</div>
                                        <div class="pform-value">
                                            <select name="batch_tracking">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Serial Number Tracking</div>
                                        <div class="pform-value">
                                            <select name="serial_tracking">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                   <!-- TAX & PRICING -->
                    <div class="tab-pane fade" id="tax" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:222px;">

                                    <!-- Tax Details -->
                                    <div class="pform-section-title">Tax Details</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Tax</div>
                                        <div class="pform-value">
                                            <select name="tax_id">
                                                <option value="">-- Select Tax --</option>
                                                @foreach($taxes as $tax)
                                                    <option value="{{ $tax->id }}">{{ $tax->name }} ({{ $tax->rate }}%)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Additional Tax (%)</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="tax" placeholder="e.g. 2.50"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:222px;">
                                    <!-- Pricing -->
                                    <div class="pform-section-title">Pricing</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Purchase Price</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="purchase_price" placeholder="e.g. 150.00"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Selling Price</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="selling_price" placeholder="e.g. 200.00"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">MRP / List Price</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="mrp" placeholder="e.g. 220.00"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Default Discount (%)</div>
                                        <div class="pform-value"><input type="number" step="0.01" name="default_discount" placeholder="e.g. 5"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Currency</div>
                                        <div class="pform-value">
                                            <select name="currency">
                                                <option value="INR">INR</option>
                                                <option value="USD">USD</option>
                                                <option value="EUR">EUR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:158px;">
                                    <!-- Barcodes & Supplier Codes -->
                                    <div class="pform-section-title">Barcodes & Supplier Codes</div>
                                    <div class="pform-row">
                                        <div class="pform-label">In-house Barcode</div>
                                        <div class="pform-value"><input type="text" name="barcode_in_house" placeholder="Scan or enter code"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Supplier Barcode</div>
                                        <div class="pform-value"><input type="text" name="barcode_supplier" placeholder="Scan or enter code"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Supplier Product Code</div>
                                        <div class="pform-value"><input type="text" name="product_code_supplier" placeholder="e.g. SUP-12345"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OTHERS -->
                    <div class="tab-pane fade" id="others" role="tabpanel">
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:158px;">
                                    <!-- Product Settings -->
                                    <div class="pform-section-title">Settings</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Active</div>
                                        <div class="pform-value">
                                            <label><input type="checkbox" name="active" checked> Yes</label><br>
                                            <!-- <label><input type="checkbox" name="allow_negative"> Allow Negative Stock</label><br>
                                            <label><input type="checkbox" name="single_batch"> Single Batch</label><br> -->
                                            <!-- <label><input type="checkbox" name="new_product"> Mark as New Product</label> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="pform-panel" style="min-height:158px;">
                                    <!-- Notes -->
                                    <div class="pform-section-title">Notes</div>
                                    <div class="pform-row">
                                        <div class="pform-label">Internal Notes</div>
                                        <div class="pform-value">
                                            <textarea name="internal_notes" placeholder="For internal use only"></textarea>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Attachments</div>
                                        <div class="pform-value">
                                            <input type="file" name="attachments[]" multiple>
                                            <small class="form-text text-muted">Upload certificates, manuals, or other documents</small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUBMIT -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-save float-right">Save</button>
                        <a href="{{ route('admin.master.inventory.product.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
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

<script>

let lastOpenedSelect = null;

window.openAttributeModal = function(button) {
    lastOpenedSelect = $(button).closest('td').find('select');
    $('#createAttributeModal').modal('show');
};

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
    //$('.select2').select2({ theme: 'bootstrap4' });
};

$(document).ready(function(){
    let variantCount = 0;

    $('#addVariantBtn').on('click', function(){
        const name = $('#variant_name').val();
        if(!name) {
            alert('Variant Name is required');
            return;
        }

        variantCount++;
        const code = $('#variant_code').val();
        const weight = $('#variant_weight').val();
        const dims = $('#variant_dimensions').val();
        const packaging = $('#variant_packaging').val();
        const items = $('#variant_items_per_box').val();
        const status = $('#variant_status').val() == '1' ? 'Active' : 'Inactive';

        const row = `
            <tr>
                <td>${variantCount}</td>
                <td>${name}</td>
                <td>${code || '-'}</td>
                <td>${weight || '-'}</td>
                <td>${dims || '-'}</td>
                <td>${packaging || '-'}</td>
                <td>${items || '-'}</td>
                <td>${status}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning edit-variant">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger delete-variant">Delete</button>
                </td>
            </tr>
        `;

        $('#variantsTable tbody').append(row);

        // Clear form
        $('#variant_name, #variant_code, #variant_weight, #variant_dimensions, #variant_packaging, #variant_items_per_box').val('');
        $('#variant_status').val('1');
    });

    // Delete variant row
    $(document).on('click', '.delete-variant', function(){
        $(this).closest('tr').remove();
    });

    // Edit variant row (basic example)
    $(document).on('click', '.edit-variant', function(){
        alert('Edit functionality can be implemented here.');
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

    $(document).on('change', 'select[name^="specifications"]', function () {
        let val = $(this).val();
        let input = $(this).closest('.form-group').find('input[name^="new_specifications"]');
        if (val === '_new') {
            input.removeClass('d-none').attr('required', true);
        } else {
            input.addClass('d-none').val('').removeAttr('required');
        }
    });

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

</script>

@endsection
