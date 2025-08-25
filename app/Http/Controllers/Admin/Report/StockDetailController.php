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

class StockDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Stock::with(['rack.room', 'slot', 'pallet.products', 'product', 'product.category', 'grnDetail.grn', 'grnDetail.unit', 'packingListDetail.packageType', 'packingListDetail.packingList'])->select('cs_stock.*');
        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        $search = $search['value'];

                        $instance->where(function ($w) use ($search) {
                            $w->whereHas('rack.room', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            })->orWhereHas('rack', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            });
                    
                            $w->orWhereHas('pallet', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            });
                    
                            $w->orWhereHas('product', function ($q) use ($search) {
                                $q->where('product_description', 'LIKE', "%$search%");
                            });
                    
                            $w->orWhereHas('grnDetail.grn', function ($q) use ($search) {
                                $q->where(DB::raw('CONCAT(Prefix, Suffix)'), 'LIKE', "%$search%");
                            });

                            $w->orWhereHas('grnDetail.grn.supplier', function ($q) use ($search) {
                                $q->where('supplier_name', 'LIKE', "%$search%");
                            });

                            $w->orWhereHas('grnDetail', function ($q) use ($search) {
                                $q->where(DB::raw('BatchNo'), 'LIKE', "%$search%");
                            });
                        });
                    }

                    // if ($request->date_range) {
                    //     [$start, $end] = explode(' - ', $request->date_range);
                    //     $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
                    //     $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $end)->endOfDay();
                    //     $instance->whereBetween('GRNate', [$startDate, $endDate]);
                    // }
                    // If date filter applied
                    // if ($request->from_date && $request->to_date) {
                    //     $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                    //     $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();

                    //     $instance->whereBetween('GRNDate', [$from_date, $to_date]);
                    // }

                    if ($request->search_term) {
                        $search = $request->search_term;
                        $instance->where(function ($w) use ($search) {
                            $w->whereHas('rack.room', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            })->orWhereHas('rack', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            });
                    
                            $w->orWhereHas('pallet', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            });
                    
                            $w->orWhereHas('product', function ($q) use ($search) {
                                $q->where('product_description', 'LIKE', "%$search%");
                            });
                    
                            $w->orWhereHas('grnDetail.grn', function ($q) use ($search) {
                                $q->where(DB::raw('CONCAT(Prefix, Suffix)'), 'LIKE', "%$search%");
                            });
                            
                            $w->orWhereHas('grnDetail.grn.supplier', function ($q) use ($search) {
                                $q->where('supplier_name', 'LIKE', "%$search%");
                            });

                            $w->orWhereHas('grnDetail', function ($q) use ($search) {
                                $q->where(DB::raw('BatchNo'), 'LIKE', "%$search%");
                            });
                        });
                    }
                })
                 ->addColumn('UOM', function ($row) {
                    return $row->packingListDetail->packageType ? $row->packingListDetail->packageType?->description : '';
                })
                ->addColumn('SubUOM', function ($row) {
                    return $row->packingListDetail? $row->packingListDetail->item_size_per_package : '';
                })
                ->addColumn('slot_position', function($row) { 
                    $slot_no = $row->room->name; 
                    $slot_no .= '-'.$row->rack->name; 
                    $slot_no .= '-'.$row->slot->level_no;
                    $slot_no .= '-'.$row->slot->depth_no;
                    return $slot_no;
                })
                ->addColumn('ClosingQty', function ($row) {
                    return $row->available_qty ?? '';
                })
                ->addColumn('client_name', function ($row) {
                    return $row->packingListDetail ? $row->packingListDetail->packingList->client->client_name : '';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->product->category ? $row->product->category->ProductCategoryName : '';
                })
                ->addColumn('storage_room_name', function ($row) {
                    return $row->rack->room ? $row->rack->room->name : 'No Room';
                })
                ->addIndexColumn()
                ->make(true);
        }

        $defaultDate = Carbon::now()->format('Y-m-d');

        return view('admin.report.stock-detail.index', compact('defaultDate'));
    }

    public function printView()
    {
        $stockData = Stock::with(['rack.room', 'slot', 'pallet.products', 'product', 'product.category', 'grnDetail.grn', 'grnDetail.unit', 'packingListDetail.packageType', 'packingListDetail.packingList'])->get();

        $groupedData = [];

        $totalInQty = 0;
        $totalOutQty = 0;
        $totalQty = 0;

        foreach ($stockData as $item) {
            $grnKey = $item->packingListDetail->packingList->grn->grn_no;

            if (!isset($groupedData[$grnKey])) {
                $groupedData[$grnKey] = [
                    'date' => $item->created_at->format('Y-m-d'),
                    'items' => [],
                    'subintotal' => 0,
                    'subouttotal' => 0,
                    'subtotal' => 0
                ];
            }

            $groupedData[$grnKey]['items'][] = $item;
            $groupedData[$grnKey]['subintotal'] += $item->in_qty;
            $groupedData[$grnKey]['subouttotal'] += $item->out_qty;
            $groupedData[$grnKey]['subtotal'] += $item->available_qty;
            $totalInQty += $item->in_qty;
            $totalOutQty += $item->out_qty;
            $totalQty += $item->available_qty;
        }

        return view('admin.report.stock-detail.print', [
            'party_name' => $item->packingListDetail->packingList->client->client_name,
            'report_date' => now()->toDateString(),
            'stock_groups' => $groupedData,
            'total_in_qty' => $totalInQty,
            'total_out_qty' => $totalOutQty,
            'total_qty' => $totalQty,
        ]);
    }

}
