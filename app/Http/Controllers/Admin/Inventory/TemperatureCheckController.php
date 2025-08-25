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

class TemperatureCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin.inventory.temperature-check.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory.temperature-check.form');
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
        return view('admin.inventory.temperature-check.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.inventory.temperature-check.form');
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
        return view('admin.inventory.temperature-check.print');
    }

}
