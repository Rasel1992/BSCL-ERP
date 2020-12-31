<?php

namespace App\Http\Controllers\Admin;
use App\Exports\InventoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Imports\InventoriesImport;
use App\Models\Category;
use App\Models\Department;
use App\Models\Inventory;
use App\User;
use Illuminate\Http\Request;
use Excel;
class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['categoryData'] = Category::where('parent_id', 0)->with('nested')->get();
            $sql = Category::orderBy('categories.id', 'DESC');
            $sql->select('categories.*', 'B.category_name AS parent_name', 'C.category_name AS parent_mother', \DB::raw('IFNULL(D.subCount,0) AS subCount'));
            $sql->leftJoin('categories AS B', 'B.id','=','categories.parent_id');
            $sql->leftJoin('categories AS C', 'C.id','=','B.parent_id');
            $sql->leftJoin(\DB::raw('(SELECT parent_id, COUNT(id) AS subCount FROM categories GROUP BY parent_id) AS D'), 'categories.id','=','D.parent_id');
            $data['categories'] = $sql->get();
            $inventories = Inventory::paginate(10);
//            dd($inventories);
            return view('admin.inventory.index', compact('data', 'inventories'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::get();
        $departments = Department::get();
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.inventory.create-edit', compact('categoryData', 'users', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InventoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InventoryRequest $request)
    {
        try {
            $data = $request->except('_token');
            Inventory::create($data);
            return redirect()->back()->withSuccess('Inventory created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Inventory $inventory)
    {
        $users = User::get();
        $departments = Department::get();
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.inventory.create-edit', compact('inventory','categoryData', 'users', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InventoryRequest $request
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InventoryRequest $request, Inventory $inventory)
    {
        try {
            $data = $request->except('_token');
            $inventory->update($data);
            return redirect()->back()->withSuccess('Inventory updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        try {
            $inventory->delete();
            return redirect()->back()->withSuccess('Inventory trashed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function ImportExcel(Request $request) {
        //Validation
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        if ($request->hasFile('file')) {
            //UPLOAD FILE
            $file = $request->file('file'); //GET FILE
            Excel::import(new InventoriesImport(), $file); //IMPORT FILE
            return redirect()->back()->withSuccess('Upload file data Inventory !');
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileExport()
    {
        return Excel::download(new InventoryExport, 'inventory-collection.xlsx');
    }
}
