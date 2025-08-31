<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Models\Inventory\GatePass;
use App\Models\Master\General\Status;
use App\Models\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use DataTables;
use Carbon\Carbon;

class CustomerContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::all();
        $statuses = Status::select('status_name')->where('doc_type', 'inward')->get();

        return view('admin.sales.customer-contract.index', compact('clients', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sales.customer-contract.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GatePassRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.sales.customer-contract.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.sales.customer-contract.form');
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
        return view('admin.sales.customer-contract.print');
    }

}
