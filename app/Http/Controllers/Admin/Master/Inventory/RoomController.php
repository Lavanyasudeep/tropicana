<?php

namespace App\Http\Controllers\Admin\Master\Inventory;

use App\Http\Controllers\Controller;

use App\Models\Master\Inventory\StorageRoom;

use Illuminate\Http\Request;

use DataTables;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $storageRooms= StorageRoom::active()->get();

        $data = StorageRoom::select(['room_id', 'name', 'description', 'total_capacity', 'temperature_range', 'is_active as Status']);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('ApprovalStatus') != '') {
                    //     $instance->where('ApprovalStatus', $request->get('ApprovalStatus'));
                    // }
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        $search = $search['value'];
                        $instance->where(function($w) use($search){
                            $w->where('name', 'LIKE', "%$search%")
                              ->orWhere('description', 'LIKE', "%$search%"); 
                        });
                    }
                })
                ->editColumn('Status', function ($res) {
                    $statusToggle = "<button class='btn btn-sm toggle-status active-inactive-btn " . ($res->is_active ? 'btn-success' : 'btn-secondary') . "'
                        data-id='{$res->room_id}'>" . ($res->is_active ? 'Active' : 'Inactive') . "</button>";

                    return $statusToggle;
                })
                ->addColumn('actions', function ($room) {
                    $editBtn = "<button class='btn btn-warning btn-sm edit-btn ' 
                        data-id='{$room->room_id}'
                        data-name='{$room->name}'
                        data-description='{$room->description}'
                        data-capacity='{$room->total_capacity}'
                        data-temperature='{$room->temperature_range}'
                        title='Edit'
                    ><i class='fas fa-edit' ></i></button>";
        
                    $deleteForm = "<form action='" . route('admin.master.inventory.rooms.destroy', $room->room_id) . "' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>
                        " . csrf_field() . method_field('DELETE') . "
                        <button class='btn btn-danger btn-sm' title='Delete' ><i class='fas fa-trash' ></i></button>
                    </form>";
        
                    return $editBtn . ' ' . $deleteForm;
                })
                ->rawColumns(['Status', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.inventory.rooms.index', compact('storageRooms'));
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            // 'total_capacity' => 'required|numeric',
            // 'temperature_range' => 'required|string',
        ]);

        StorageRoom::create($validated);

        return redirect()->route('admin.master.inventory.rooms.index')->with('success', 'Storage Room Created Successfully!');
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
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            // 'total_capacity' => 'required|numeric',
            // 'temperature_range' => 'required|string',
        ]);
    
        $room = StorageRoom::findOrFail($id);
        $room->fill($validated);
        $room->save();
    
        return redirect()->route('admin.master.inventory.rooms.index')->with('success', 'Storage Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = StorageRoom::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.room.index')->with('success', 'Storage room deleted successfully!');
    }

    public function toggleStatus(Request $request)
    {
        $room = StorageRoom::findOrFail($request->id);
        $room->is_active = !$room->is_active;
        $room->save();

        return response()->json(['success' => true, 'status' => $room->is_active]);
    }

}
