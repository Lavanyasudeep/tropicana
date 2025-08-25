<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Models\Inventory\GatePass;
use App\Models\Master\General\Status;
use App\Models\Client;

use App\Http\Requests\Inventory\GatePassRequest;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use DataTables;
use Carbon\Carbon;

class GatePassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::all();
        $statuses = Status::select('status_name')->where('doc_type', 'inward')->get();

        $data = GatePass::with(['client'])->orderBy('created_at', 'desc');

        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') != '') {
                        $instance->where('status', $request->get('status'));
                    }

                    if ($request->get('client_flt') != '') {
                        $instance->whereHas('client', function ($q) use ($request) {
                            $q->where('client_name', 'like', "%{$request->get('client_flt')}%");
                        });
                    }

                    if ($request->from_date && $request->to_date) {
                        $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                        $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();

                        $instance->whereBetween('created_at', [
                                    $from_date,
                                    $to_date
                                ]);
                    }

                    if ($request->get('quick_search')) {
                        $search = $request->get('quick_search');

                        $instance->where(function($w) use($search){
                            $w->orWhere('movement_type', 'LIKE', "%$search%")
                                ->orWhere('driver_name', 'LIKE', "%$search%")
                                ->orWhere('vehicle_no', 'LIKE', "%$search%")
                                ->orWhere('transport_mode', 'LIKE', "%$search%"); 
                        });
                    }
                })
                ->editColumn('doc_date', function ($res) {
                    return date('j F, Y', strtotime($res->doc_date));
                })
                ->addColumn('no_of_items', function ($res) {
                    return $res->gatePassDetails->count();
                })
                ->addColumn('status', function ($res) {
                    return ucfirst($res->status);
                })
                ->addColumn('actions', function($res) {
                    $act = '';
                    $act .= '<a href="'.route('admin.inventory.gatepass.edit', $res->gate_pass_id).'" class="btn btn-warning btn-sm" ><i class="fas fa-edit" ></i></a>';
                    $act .= '<a href="' . route('admin.inventory.gatepass.print', $res->gate_pass_id) . '" target="_blank" class="btn btn-sm btn-print"><i class="fas fa-print"></i></a>';
                    $act .= '<a href="'.route('admin.inventory.gatepass.view', $res->gate_pass_id).'" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>';
                    return $act;
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.inventory.gatepass.index', compact('clients', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::select('client_id', 'client_name')->get();
        return view('admin.inventory.gatepass.form', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GatePassRequest $request)
    {
        $validated = $request->validated();
        
        DB::beginTransaction();
        try {
            $gatePass = GatePass::create([
                'movement_type' => $validated['movement_type'],
                'doc_date' => $validated['doc_date'],
                'client_id' => $validated['client_id'],
                'vehicle_no' => $validated['vehicle_no'],
                'driver_name' => $validated['driver_name']??null,
                'transport_mode' => $validated['transport_mode']??null,
                'remarks' => $validated['remarks']??null,
                'requested_by' => auth()->user()->id,
            ]);

            foreach ($validated['items'] as $item) {
                $gatePass->gatePassDetails()->create([
                    'item_name' => $item['item_name'],
                    'uom' => $item['uom'],
                    'quantity' => $item['quantity'],
                    'is_returnable' => $item['is_returnable'] ?? false,
                    'expected_return_date' => $item['expected_return_date'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.inventory.gatepass.index')->with('success', 'Gate Pass created.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gatepass = GatePass::with('gatePassDetails')->findOrFail($id);

        return view('admin.inventory.gatepass.view', compact('gatepass'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gatepass = GatePass::with('gatePassDetails')->findOrFail($id);
        $clients = Client::select('client_id', 'client_name')->get();

        return view('admin.inventory.gatepass.form', compact('gatepass', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function print(string $id)
    {
        $gatepass = GatePass::with('gatePassDetails')->findOrFail($id);

        return view('admin.inventory.gatepass.print', compact('gatepass'));
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        
        $gatepass_id = $request->input('gatepass_id');
        $newStatus = $request->input('status');

        $gatepass = GatePass::findOrFail($gatepass_id);
        $gatepass->status = $newStatus;
        $gatepass->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
