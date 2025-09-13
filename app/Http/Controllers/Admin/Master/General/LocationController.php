<?php

namespace App\Http\Controllers\Admin\Master\General;

use App\Http\Requests\Master\General\TaxRequest;
use App\Models\Master\General\Tax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locations = [
            ['location_id' => 1, 'location_code' => 'TVM',  'location_name' => 'Thiruvananthapuram',  'is_active' => true],
            ['location_id' => 2, 'location_code' => 'CLT',  'location_name' => 'Calicut (Kozhikode)',  'is_active' => true],
            ['location_id' => 3, 'location_code' => 'EKM',  'location_name' => 'Ernakulam',            'is_active' => true],
            ['location_id' => 4, 'location_code' => 'TSR',  'location_name' => 'Thrissur',              'is_active' => true],
            ['location_id' => 5, 'location_code' => 'KTM',  'location_name' => 'Kottayam',              'is_active' => false],
            ['location_id' => 6, 'location_code' => 'ALP',  'location_name' => 'Alappuzha',             'is_active' => true],
            ['location_id' => 7, 'location_code' => 'IDK',  'location_name' => 'Idukki',                'is_active' => false],
            ['location_id' => 8, 'location_code' => 'PTA',  'location_name' => 'Pathanamthitta',        'is_active' => true],
            ['location_id' => 9, 'location_code' => 'KNR',  'location_name' => 'Kannur',                'is_active' => true],
            ['location_id' => 10,'location_code' => 'KSD',  'location_name' => 'Kasaragod',             'is_active' => false],
            ['location_id' => 11,'location_code' => 'PLKD', 'location_name' => 'Palakkad',              'is_active' => true],
            ['location_id' => 12,'location_code' => 'KLM',  'location_name' => 'Kollam',                'is_active' => true],
        ];

        if ($request->ajax()) {
            return DataTables::of($locations)
                ->editColumn('is_active', function ($location) {
                    return '<button class="btn btn-sm toggle-status ' . ($location['is_active'] ? 'btn-success' : 'btn-secondary') . '" data-id="' . $location['location_id'] . '">' . ($location['is_active'] ? 'Active' : 'Inactive') . '</button>';
                })
                ->addColumn('actions', function ($location) {
                    return '
                        <button class="btn btn-sm btn-warning edit-btn" 
                                data-id="' . $location['location_id'] . '" 
                                data-code="' . $location['location_code'] . '" 
                                data-name="' . $location['location_name'] . '" 
                                title="Edit"
                        ><i class="fas fa-edit"></i></button>
                        <form method="POST" action="' . route('admin.master.general.location.destroy', $location['location_id']) . '" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['is_active', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.general.location.index');
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
    public function store(TaxRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = auth()->user()->company_id;

        Tax::create($data);
        return redirect()->back()->with('success', 'Tax created successfully.');
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
    public function update(TaxRequest $request, $id)
    {
        $tax = Tax::findOrFail($id);
        $data = $request->validated();
        $tax->update($data);

        return redirect()->back()->with('success', 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tax = Tax::findOrFail($id);
        $tax->delete();

        return redirect()->back()->with('success', 'Tax deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $tax = Tax::findOrFail($request->id);
        $tax->active = !$tax->active;
        $tax->save();

        return response()->json(['success' => true, 'status' => $tax->active]);
    }
}
