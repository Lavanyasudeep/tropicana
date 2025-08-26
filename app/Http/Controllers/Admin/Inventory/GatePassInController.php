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

class GatePassInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::all();
        $statuses = Status::select('status_name')->where('doc_type', 'inward')->get();
        
        return view('admin.inventory.gatepass-in.index', compact('clients', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory.gatepass-in.form');
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
        return view('admin.inventory.gatepass-in.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.inventory.gatepass-in.form');
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
        return view('admin.inventory.gatepass-in.print');
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
