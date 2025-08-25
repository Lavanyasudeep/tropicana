<?php

namespace App\Services\Inventory;

use App\Enums\MovementType;

use App\Models\Master\Inventory\{ Pallet, PalletType, ProdCatSvgImg, Product, ProductCategory, ProductMaster, ProductSpecification, ProductVariantSpecification, ProductVariant, Rack, Slot, StorageRoom};
use App\Models\Inventory\{PackingList, PackingListDetail, Inward, InwardDetail, Stock};
use App\Models\Purchase\{GRNDetail};

use Illuminate\Support\Facades\DB;

class InwardService
{
    public function assignProduct(array $data, $user)
    {
        DB::beginTransaction();
        try {
            $product = $this->updateProductMaster($data, $user);

            $grnDetail = GRNDetail::with('grn', 'productMaster')->findOrFail($data['grn_detail_id']);
            $grnDetail->ExpiryDate = $data['expiry_date'];
            $grnDetail->save();

            $packingListDetail = $this->createOrGetPackingListDetail($grnDetail, $data, $user);
            $inward = $this->createOrGetInward($packingListDetail, $user, $data);
            $productVariantId = $this->createOrGetProductVariant($data, $user);
            $this->processAssignments($data, $grnDetail, $packingListDetail, $inward, $user);

            DB::commit();
            return [
                'status' => true,
                'message' => 'Product assigned to cold storage successfully.',
                'inward_id' => $inward->inward_id
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('InwardService Error:', ['error' => $e]);
            return ['status' => false, 'message' => 'Failed to assign product.', 'error' => $e->getMessage()];
        }
    }

    protected function updateProductMaster(array $data, $user)
    {
        return tap(ProductMaster::find($data['product_master_id']), function ($product) use ($data) {
            $product->update([
                'box_capacity_per_full_pallet' => $data['package_qty_per_full_pallet'],
                'box_capacity_per_half_pallet' => $data['package_qty_per_half_pallet'],
                'weight_per_box'         => $data['nw_per_package'],
                'no_of_items_in_box'       => $data['item_size_per_package'],
            ]);
        });
    }

    protected function createOrGetPackingListDetail($grnDetail, $data, $user)
    {
        $grn = $grnDetail->grn;

        // if (PackingList::where('grn_id', $grnDetail->GRNBatchID)->exists()) {
        //     throw new \Exception('Cannot assign products. Packing List already exists.');
        // }

        $packingList = PackingList::firstOrCreate(
            ['grn_id' => $grnDetail->GRNBatchID],
            [
                'company_id' => $user->company_id,
                'warehouse_id' => $user->warehouse_id,
                'client_id' => $data['client_id'],
                'doc_date' => now(),
                'invoice_no' => $grn->InvoiceNumber,
                'invoice_date' => $grn->InvoiceDate,
                'supplier_id' => $grn->SupplierID,
                'weight_per_pallet' => $data['weight_per_pallet'],
                'ref_no' => $grn->PurchaseOrderID,
                'ref_doc_type' => 'Purchase Order',
                'movement_type' => MovementType::In,
                'created_by' => $user->id
            ]
        );

        return PackingListDetail::firstOrCreate(
            [
                'packing_list_id' => $packingList->packing_list_id,
                'grn_detail_id' => $grnDetail->GRNProductID
            ],
            [
                'product_id' => $grnDetail->ProductMasterID,
                'cargo_description' => $grnDetail->product_description,
                'lot_no' => $grnDetail->BatchNo,
                'variety_id' => $grnDetail->productMaster->ProductCategoryID,
                'brand_id' => $grnDetail->productMaster->brand_id,
                'expiry_date' => $data['expiry_date'],
                'package_type_id' => $grnDetail->productMaster->PurchaseUnitID,
                'package_qty' => $grnDetail->ReceivedQuantity,
                'item_size_per_package' => $data['item_size_per_package'],
                'package_qty_per_half_pallet' => $data['package_qty_per_half_pallet'],
                'package_qty_per_full_pallet' => $data['package_qty_per_full_pallet'],
                'pallet_qty' => $data['pallet_qty'],
                'gw_per_package' => $data['gw_per_package'],
                'nw_per_package' => $data['nw_per_package'],
            ]
        );
    }

    protected function createOrGetInward($packingListDetail, $user, $data)
    {
        if($packingListDetail?->grnDetail?->is_fully_assigned_to_cold_storage) {
            throw new \Exception("Cannot assign products. Products already assigned to slots.");
        }

        return Inward::firstOrCreate(
            ['packing_list_id' => $packingListDetail->packing_list_id, 'packing_list_detail_id' => $packingListDetail->packing_list_detail_id],
            ['doc_date' => $data['doc_date'], 'client_id' => $data['client_id'], 'pallet_qty' => 0]
        );
    }

    protected function processAssignments($data, $grnDetail, $packingListDetail, $inward, $user)
    {
        $totalQty = 0;
        $palletQty = 0;

        foreach ($data['assignments'] as $assign) {
            $slot = Slot::findOrFail($assign['slot_id']);
            
            if($assign['pallet_type_id']) {
                $palletType = PalletType::findOrFail($assign['pallet_type_id']);
            }

            if ($slot->has_pallet && $slot->status == 'partial') {
                $pallet = Pallet::findOrFail($slot->pallet->pallet_id);
                // $pallet->capacity += $data['package_qty_per_pallet'];
                // $pallet->save();
            } else {
                if ($slot->has_pallet) {
                    throw new \Exception("Slot {$assign['slot_id']} already has a pallet.");
                }

                $pallet = Pallet::create([
                    'room_id' => $assign['room_id'],
                    'block_id' => $slot->rack->block_id,
                    'rack_id' => $assign['rack_id'],
                    'slot_id' => $assign['slot_id'],
                    'capacity_unit_id' => $grnDetail->productMaster->ProductPackingID,
                    'pallet_type_id' => $assign['pallet_type_id'],
                    'capacity' => $assign['capacity'],
                    'weight' => $data['weight_per_pallet'],
                    'client_id' => $packingListDetail->packingList->client_id,
                    'is_active' => 1
                ]);
            }
            
            InwardDetail::create([
                'inward_id' => $inward->inward_id,
                'packing_list_detail_id' => $packingListDetail->packing_list_detail_id,
                'room_id' => $assign['room_id'],
                'rack_id' => $assign['rack_id'],
                'slot_id' => $assign['slot_id'],
                'pallet_id' => $pallet->pallet_id,
                'quantity' => $assign['quantity']
            ]);

            $totalQty += $assign['quantity'];
            $palletQty++;
        }

        $inward->fill(['pallet_qty' => $palletQty, 'tot_package_qty' => $totalQty]);
        $inward->save();
    }

    protected function createOrGetProductVariant(array $data, $user)
    {
        $specifications = $data['specifications'] ?? [];
        $newSpecifications = $data['new_specifications'] ?? [];

        $productMasterId = $data['product_master_id'];

        $specIds = [];
        $variantParts = [];

        foreach ($specifications as $attributeId => $value) {
            // Handle new value
            if ($value === '_new') {
                $value = $newSpecifications[$attributeId] ?? null;
                if (!$value) {
                    throw new \Exception("Missing value for new specification (attribute ID: $attributeId).");
                }
            }

            $spec = ProductSpecification::firstOrCreate([
                'prod_attribute_id' => $attributeId,
                'prod_attribute_value' => $value,
            ]);

            $specIds[] = $spec->prod_spec_id;
            $variantParts[] = $value;
        }

        // 2. Construct variant name
        $variantName = implode(' ', $variantParts);

        // 3. Check if variant with same specs exists
        $existingVariant = ProductVariant::where('product_master_id', $productMasterId)
            ->where('variant_name', $variantName)
            ->first();

        if (!$existingVariant) {
            // Create new variant
            $existingVariant = ProductVariant::create([
                'product_master_id' => $productMasterId,
                'variant_name' => $variantName
            ]);

            // Attach specifications
            foreach ($specIds as $specId) {
                ProductVariantSpecification::create([
                    'product_variant_id' => $existingVariant->product_variant_id,
                    'prod_spec_id' => $specId,
                ]);
            }
        }

        GRNDetail::where('GRNProductID', $data['grn_detail_id'])->update(['ProductVariantID' => $existingVariant->product_variant_id]);

        return $existingVariant->product_variant_id;
    }

}
