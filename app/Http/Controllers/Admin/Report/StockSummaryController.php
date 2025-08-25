<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;

use App\Models\Purchase\GRN;
use App\Models\Master\Inventory\StorageRoom;
use App\Models\Master\Inventory\Rack;
use App\Models\Master\Inventory\Pallet;
use App\Models\Tray;
use App\Models\Master\Inventory\ProductMaster;
use App\Models\Inventory\Stock;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Carbon\Carbon;
use DataTables;

class StockSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $query = Stock::with([
                'room',
                'rack',
                'slot',
                'pallet.products',
                'product',
                'product.category',
                'grnDetail.grn',
                'grnDetail.unit',
                'packingListDetail.packageType',
                'packingListDetail.packingList'
            ]);

        if (!empty($request->get('search')) || !empty($request->get('search'))) {
            $search = $request->input('search.value') ?? $request->search_term;

            $query->where(function ($w) use ($search) {
                $w->whereHas('room', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                })->orWhereHas('rack', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                })->orWhereHas('slot', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                })->orWhereHas('pallet', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                })->orWhereHas('product', function ($q) use ($search) {
                    $q->where('product_description', 'LIKE', "%$search%");
                })->orWhereHas('packingListDetail.variety', function ($q) use ($search) {
                    $q->where('product_category_name', 'LIKE', "%$search%");
                })->orWhereHas('packingListDetail.packageType', function ($q) use ($search) {
                    $q->where('description', 'LIKE', "%$search%");
                })->orWhereHas('grnDetail.grn', function ($q) use ($search) {
                    $q->where(DB::raw('CONCAT(Prefix, Suffix)'), 'LIKE', "%$search%");
                })->orWhereHas('grnDetail.grn.supplier', function ($q) use ($search) {
                    $q->where('supplier_name', 'LIKE', "%$search%");
                })->orWhereHas('grnDetail', function ($q) use ($search) {
                    $q->where(DB::raw('BatchNo'), 'LIKE', "%$search%");
                });
            });
        }
        
        $data = $query->get()
                    ->groupBy(function ($item) {
                            return $item->product_id . '_' . $item->batch_no . '_' . $item->expiry_date;
                        })
                    ->map(function ($group) {
                        return [
                            'product_name' => $group->first()->product->product_description,
                            'batch_no' => $group->first()->batch_no,
                            'expiry_date' => $group->first()->expiry_date,
                            // 'rooms' => $group->pluck('rack.room.name')->unique()->implode(', '),
                            // 'racks' => $group->pluck('rack.name')->unique()->implode(', '),
                            'slot_positions' => $group->pluck('pallet.pallet_position')->unique()->implode(', '),
                            'pallets' => $group->pluck('pallet.name')->unique()->implode(', '),
                            'pallet_count' => $group->pluck('pallet_id')->unique()->count(),
                            'in_quantity' => $group->sum('in_qty'),
                            'out_quantity' => $group->sum('out_qty'),
                            'total_quantity' => $group->sum('available_qty'),
                            'UOM' => $group->map(function ($item) {
                                return optional(optional($item->packingListDetail)->packageType)->description;
                            })->filter()->unique()->implode(', '),
                            'SubUOM' => $group->map(function ($item) {
                                return optional($item->packingListDetail)->item_size_per_package;
                            })->filter()->unique()->implode(', '),
                            'client_name' => optional(optional($group->first()->packingListDetail)->packingList->client)->client_name,
                            'category_name' => optional($group->first()->product->category)->ProductCategoryName,
                        ];
                    });

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('product_name', function ($row) {
                    return $row['product_name'];
                })
                ->addColumn('UOM', function ($row) {
                    return $row['UOM'];
                })
                ->addColumn('SubUOM', function ($row) {
                    return $row['SubUOM'];
                })
                // ->addColumn('rooms', function ($row) {
                //     return $row['rooms'];
                // })
                // ->addColumn('racks', function ($row) {
                //     return $row['racks'];
                // })
                ->addColumn('slot_positions', function ($row) {
                    return $row['slot_positions'];
                })
                ->addColumn('pallets', function ($row) {
                    return $row['pallets'];
                })
                ->addColumn('pallet_count', function ($row) {
                    return $row['pallet_count'];
                })
                ->addColumn('in_quantity', function ($row) {
                    return $row['in_quantity'];
                })
                ->addColumn('out_quantity', function ($row) {
                    return $row['out_quantity'];
                })
                ->addColumn('total_quantity', function ($row) {
                    return $row['total_quantity'];
                })
                ->addColumn('client_name', function ($row) {
                    return $row['client_name'];
                })
                ->addColumn('category_name', function ($row) {
                    return $row['category_name'];
                })
                ->addIndexColumn()
                ->make(true);
        }

        $defaultDate = Carbon::now()->format('Y-m-d');

        return view('admin.report.stock-summary.index', compact('defaultDate'));
    }

    public function printView()
    {
        $stockData = Stock::with([
                'rack.room',
                'slot',
                'pallet.products',
                'product',
                'product.category',
                'grnDetail.grn',
                'grnDetail.unit',
                'packingListDetail.packageType',
                'packingListDetail.packingList.client'
            ])
            ->get()
            ->groupBy(function ($item) {
                return $item->product_id . '_' . $item->batch_no . '_' . $item->expiry_date;
            })
            ->map(function ($group) {
                return [
                    'product_name'   => $group->first()->product->product_description,
                    'batch_no'       => $group->first()->batch_no,
                    'expiry_date'    => $group->first()->expiry_date,
                    // 'rooms'          => $group->pluck('rack.room.name')->unique()->implode(', '),
                    // 'racks'          => $group->pluck('rack.name')->unique()->implode(', '),
                    // 'slots'          => $group->pluck('slot.name')->unique()->implode(', '),
                    'slot_positions' => $group->pluck('pallet.pallet_position')->unique()->implode(', '),
                    'pallets'        => $group->pluck('pallet.name')->unique()->implode(', '),
                    'pallet_count'   => $group->pluck('pallet_id')->unique()->count(),
                    'in_quantity' => $group->sum('in_qty'),
                    'out_quantity' => $group->sum('out_qty'),
                    'total_quantity' => $group->sum('available_qty'),
                    'UOM'            => $group->map(function ($item) {
                        return optional(optional($item->packingListDetail)->packageType)->description;
                    })->filter()->unique()->implode(', '),
                    'SubUOM'         => $group->map(function ($item) {
                        return optional($item->packingListDetail)->item_size_per_package;
                    })->filter()->unique()->implode(', '),
                    'client_name'    => optional(optional($group->first()->packingListDetail)->packingList->client)->client_name,
                    'category_name'  => optional($group->first()->product->category)->ProductCategoryName,

                    // Add GRN No and Created Date so you can use in grouping below
                    'grn_no'         => optional(optional($group->first()->packingListDetail)->packingList)->grn->grn_no,
                    'created_at'     => $group->first()->created_at,
                ];
            });

        // Now group by GRN No
        $groupedData = [];
        $totalPalletQty = 0;
        $totalInQty = 0;
        $totalOutQty = 0;
        $totalQty = 0;

        foreach ($stockData as $item) {
            $grnKey = $item['grn_no'] ?? 'Unknown GRN';

            if (!isset($groupedData[$grnKey])) {
                $groupedData[$grnKey] = [
                    'date'      => optional($item['created_at'])->format('Y-m-d'),
                    'items'     => [],
                    'subpallettotal'  => 0,
                    'subintotal'  => 0,
                    'subouttotal'  => 0,
                    'subtotal'  => 0
                ];
            }

            $groupedData[$grnKey]['items'][] = $item;
            $groupedData[$grnKey]['subpallettotal'] += $item['pallet_count'];
            $groupedData[$grnKey]['subintotal'] += $item['in_quantity'];
            $groupedData[$grnKey]['subouttotal'] += $item['out_quantity'];
            $groupedData[$grnKey]['subtotal'] += $item['total_quantity'];
            $totalPalletQty += $item['pallet_count'];
            $totalInQty += $item['in_quantity'];
            $totalOutQty += $item['out_quantity'];
            $totalQty += $item['total_quantity'];
        }

        // Use first item to get client name
        $firstItem = $stockData->first();

        return view('admin.report.stock-summary.print', [
            'party_name'    => $firstItem['client_name'] ?? 'Unknown',
            'report_date'   => now()->toDateString(),
            'stock_groups'  => $groupedData,
            'total_pallet'     => $totalPalletQty,
            'total_in_qty'     => $totalInQty,
            'total_out_qty'     => $totalOutQty,
            'total_qty'     => $totalQty,
        ]);
    }


}
