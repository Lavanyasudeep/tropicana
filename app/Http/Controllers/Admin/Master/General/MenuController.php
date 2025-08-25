<?php

namespace App\Http\Controllers\Admin\Master\General;

use App\Models\Master\General\Menu;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::whereNull('parent_id')->with('children')->orderBy('sort_order')->get();
        return view('admin.master.general.menu.index', compact('menus'));
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
        Menu::create($request->all());
        return back()->with('success', 'Menu created');
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
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->except('menu_id'); // 🚀 avoid re-setting PK
        $menu->update($data);

        return back()->with('success', 'Menu updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $menu = Menu::select('cs_menu.*')
            ->where('menu_name', 'like', '%' . $query . '%')
            ->first();

        if ($menu) {
            return response()->json([
                'found' => true,
                'menu_id' => $menu->menu_id,
                'menu_name' => $menu->menu_name
            ]);
        }

        return response()->json(['found' => false]);
    }

    public function getSubMenu(Request $request)
    { 
        $menu_id = $request->menu_id;
        $parent = Menu::findOrFail($menu_id);
        $children = Menu::where('parent_id', $menu_id)->orderBy('sort_order')->get();

        return view('admin.master.general.menu.partials.submenu', compact('parent','children'));
    }

    public function getMenu(Request $request)
    { 
        $menu_id = $request->menu_id;
        $parent = Menu::findOrFail($menu_id);
        $children = Menu::where('parent_id', $menu_id)->orderBy('sort_order')->get();

        return view('admin.master.general.menu.partials.menu', compact('parent','children'));
    }

    public function updateSortOrder(Request $request)
    {
        foreach ($request->order as $item) {
            Menu::where('menu_id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

}
