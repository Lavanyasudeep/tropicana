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
    <h3>{{ $page_title }}</h3>
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
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:300px;" >
                                    <div class="pform-row">
                                        <div class="pform-label">Product Name *</div>
                                        <div class="pform-value"><input type="text" name="product_name" value="{{ old('product_name') }}" required></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Product Code</div>
                                        <div class="pform-value"><input type="text" name="product_code" value="{{ old('product_code') }}"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Category</div>
                                        <div class="pform-value">
                                            <select name="product_category_id">
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
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
                                                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Description</div>
                                        <div class="pform-value"><textarea name="product_description">{{ old('product_description') }}</textarea></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Short Name</div>
                                        <div class="pform-value"><input type="text" name="short_name" value="{{ old('short_name') }}"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">HSN Code</div>
                                        <div class="pform-value"><input type="text" name="hsn_code" value="{{ old('hsn_code') }}"></div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Product Image</div>
                                        <div class="pform-value">
                                            <input type="file" name="image" id="product_image">
                                            <img id="preview" class="mt-2 rounded shadow-sm border" style="max-width:150px; display:none;" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SPECIFICATIONS -->
                    <div class="tab-pane fade" id="specs" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:300px;" >
                                    <div class="pform-row"><div class="pform-label">Weight (kg)</div><div class="pform-value"><input type="number" step="0.01" name="product_weight"></div></div>
                                    <div class="pform-row"><div class="pform-label">Weight Per Box (kg)</div><div class="pform-value"><input type="number" step="0.01" name="weight_per_box"></div></div>
                                    <div class="pform-row"><div class="pform-label">Box Capacity (Full Pallet)</div><div class="pform-value"><input type="number" name="box_capacity_per_full_pallet"></div></div>
                                    <div class="pform-row"><div class="pform-label">Box Capacity (Half Pallet)</div><div class="pform-value"><input type="number" name="box_capacity_per_half_pallet"></div></div>
                                    <div class="pform-row"><div class="pform-label">Items per Box</div><div class="pform-value"><input type="number" name="no_of_items_in_box"></div></div>
                                    <div class="pform-row"><div class="pform-label">Material / Composition</div><div class="pform-value"><input type="text" name="material"></div></div>
                                </div>
                             </div>
                        </div>
                    </div>

                    <!-- INVENTORY -->
                    <div class="tab-pane fade" id="inventory" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:300px;" >
                                    <div class="pform-row"><div class="pform-label">Min Stock Qty</div><div class="pform-value"><input type="number" name="min_stock_qty"></div></div>
                                    <div class="pform-row"><div class="pform-label">Max Stock Qty</div><div class="pform-value"><input type="number" name="max_stock_qty"></div></div>
                                    <div class="pform-row"><div class="pform-label">Re-order Level</div><div class="pform-value"><input type="number" name="re_order_level"></div></div>
                                    <div class="pform-row"><div class="pform-label">Re-order Qty</div><div class="pform-value"><input type="number" name="re_order_qty"></div></div>
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
                    </div>

                    <!-- TAX -->
                    <div class="tab-pane fade" id="tax" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:300px;">
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
                                    <div class="pform-row"><div class="pform-label">Additional Tax (%)</div><div class="pform-value"><input type="number" step="0.01" name="tax"></div></div>
                                    <div class="pform-row"><div class="pform-label">In-house Barcode</div><div class="pform-value"><input type="text" name="barcode_in_house"></div></div>
                                    <div class="pform-row"><div class="pform-label">Supplier Barcode</div><div class="pform-value"><input type="text" name="barcode_supplier"></div></div>
                                    <div class="pform-row"><div class="pform-label">Supplier Product Code</div><div class="pform-value"><input type="text" name="product_code_supplier"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OTHERS -->
                    <div class="tab-pane fade" id="others" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6" >
                                <div class="pform-panel" style="min-height:300px;">
                                    <div class="pform-row"><div class="pform-label">Arrival Date</div><div class="pform-value"><input type="date" name="arrival_date"></div></div>
                                    <div class="pform-row">
                                        <div class="pform-label">Supplier</div>
                                        <div class="pform-value">
                                            <select name="supplier_id">
                                                <option value="">-- Select Supplier --</option>
                                                @foreach($suppliers as $sup)
                                                    <option value="{{ $sup->id }}">{{ $sup->supplier_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-label">Product Settings</div>
                                        <div class="pform-value">
                                            <label><input type="checkbox" name="active" checked> Active</label><br>
                                            <label><input type="checkbox" name="allow_negative"> Allow Negative Stock</label><br>
                                            <label><input type="checkbox" name="single_batch"> Single Batch</label>
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
@endsection
