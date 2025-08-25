<?php

namespace App\Http\Controllers\Admin\Common;

use App\Models\Common\Attachment;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'table_name' => 'required|string|max:50',
            'row_id' => 'required|integer',
        ]);

        return Attachment::where('table_name', $request->table_name)
                         ->where('row_id', $request->row_id)
                         ->get();
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
        $request->validate([
            'attachments.*' => 'required|file|max:5120', // 5MB
            'table_name' => 'required|string|max:50',
            'row_id' => 'required|integer',
        ]);

        foreach ($request->file('attachments') as $file) {
            $path = $file->store('attachments', 'public');

            Attachment::create([
                'company_id' => auth()->user()->company_id ?? null,
                'branch_id' => auth()->user()->branch_id ?? null,
                'table_name' => $request->table_name,
                'row_id' => $request->row_id,
                'file_name' => $path,
                'created_by' => auth()->id(),
                'created_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attachment = Attachment::findOrFail($id);

        \Storage::disk('public')->delete($attachment->file_name);
        $attachment->delete();

        return response()->json(['success' => true]);
    }
}
