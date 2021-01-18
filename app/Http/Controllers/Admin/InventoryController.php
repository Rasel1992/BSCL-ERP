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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class InventoryController extends Controller
{
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
            $inventories = Inventory::latest()->paginate(10);
            return view('admin.inventory.index', compact('data', 'inventories'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function qrCodeList()
    {
        try {
            $inventories = Inventory::latest()->paginate(10);
            return view('admin.inventory.qr-code-list', compact('inventories'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function summary()
    {
        try {
            $categories_head = Category::with(['inventories' => function($q) {
                $q->where('location','hq');
            }])
                ->get();
            $categories_gs1 = Category::with(['inventories' => function($q) {
                $q->where('location','gs1');
            }])
                ->get();
            $categories_gs2 = Category::with(['inventories' => function($q) {
                $q->where('location','gs2');
            }])
                ->get();
            return view('admin.inventory.summary', compact( 'categories_head', 'categories_gs1', 'categories_gs2'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

//    public function summaryShow(Request $request)
//    {
//        try {
//            $data['categoryData'] = Category::where('parent_id', 0)->with('nested')->get();
//            $sql = Category::orderBy('categories.id', 'DESC');
//            $sql->select('categories.*', 'B.category_name AS parent_name', 'C.category_name AS parent_mother', \DB::raw('IFNULL(D.subCount,0) AS subCount'));
//            $sql->leftJoin('categories AS B', 'B.id','=','categories.parent_id');
//            $sql->leftJoin('categories AS C', 'C.id','=','B.parent_id');
//            $sql->leftJoin(\DB::raw('(SELECT parent_id, COUNT(id) AS subCount FROM categories GROUP BY parent_id) AS D'), 'categories.id','=','D.parent_id');
//            $data['categories'] = $sql->get();
//            $inventories = Inventory::latest()->paginate(10);
//            return view('admin.inventory.index', compact('data', 'inventories'));
//        } catch (\Exception $e) {
//            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
//        }
//    }

    public function create()
    {
        $users = User::get();
        $departments = Department::get();
        $categoryData = Category::where('type','!=', 'Stock')->where('parent_id', 0)->with('nested')->get();
        return view('admin.inventory.create-edit', compact('categoryData', 'users', 'departments'));
    }
    public function code()
    {
        return view('admin.inventory.qr');
    }

    public function store(InventoryRequest $request)
    {
            $data = $request->except('_token');
            Inventory::create($data);
            return redirect()->back()->withSuccess('Inventory created successfully.');

    }

    public function show(Inventory $inventory)
    {
        return view('admin.inventory.show', compact('inventory'));
    }
    public function showQrDetails(Inventory $inventory)
    {
        return view('admin.inventory.qr-code-details', compact('inventory'));
    }


    public function edit(Inventory $inventory)
    {
        $users = User::get();
        $departments = Department::get();
        $categoryData = Category::where('type','!=', 'Stock')->where('parent_id', 0)->with('nested')->get();
        return view('admin.inventory.create-edit', compact('inventory','categoryData', 'users', 'departments'));
    }

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

    public function fileExport()
    {
        return Excel::download(new InventoryExport, 'inventory-collection.xlsx');
    }
}
