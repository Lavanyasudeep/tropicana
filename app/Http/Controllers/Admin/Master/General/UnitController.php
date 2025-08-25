<?php

namespace App\Http\Controllers\Admin\Master\General;

use App\Http\Requests\Master\General\UnitRequest;
use App\Models\Master\General\Unit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $units = Unit::get();

        if ($request->ajax()) {
            return DataTables::of($units)
                ->editColumn('is_active', function ($unit) {
                    return '<button class="btn btn-sm toggle-status ' . ($unit->is_active ? 'btn-success' : 'btn-secondary') . '" data-id="' . $unit->unit_id . '">' . ($unit->is_active ? 'Active' : 'Inactive') . '</button>';
                })
                ->addColumn('actions', function ($unit) {
                    return '
                        <button class="btn btn-sm btn-warning edit-btn"
                            data-id="' . $unit->unit_id . '"
                            data-unit="' . $unit->unit . '"
                            data-short-name="' . $unit->short_name . '"
                            data-description="' . $unit->description . '"
                            data-conversion-unit="' . $unit->conversion_unit . '"
                            data-conversion-quantity="' . $unit->conversion_quantity . '"
                            data-sign="' . $unit->sign . '"
                            title="Edit"><i class="fas fa-edit"></i></button>
                        <form method="POST" action="' . route('admin.master.general.unit.destroy', $unit->unit_id) . '" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['is_active', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.general.unit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = auth()->user()->company_id;

        Unit::create($data);
        return redirect()->back()->with('success', 'Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $data = $request->validated();

        $unit->update($data);
        return redirect()->back()->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->back()->with('success', 'Unit deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $unit = Unit::findOrFail($request->id);
        $unit->active = !$unit->active;
        $unit->save();

        return response()->json(['success' => true, 'status' => $unit->active]);
    }
}
