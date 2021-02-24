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
    public function index(Request $request)
    {
        try {
            $categoryData = Category::where('type', '!=', 'Stock')->where('parent_id', 0)->with('nested')->get();
            $sql = Inventory::orderBy('created_at', 'ASC');
            if ($request->q) {
                $sql->where(function ($q) use ($request) {
                    $q->orWhere('asset_code', 'LIKE', $request->q . '%');
                    $q->orWhere('voucher_no', 'LIKE', $request->q . '%');
                });
            }
            if ($request->location) {
                $sql->where('location', $request->location);
            }
            if ($request->category_id) {
                $sql->where('category_id', $request->category_id);
            }
            if ($request->from) {
                $sql->whereDate('purchase_date', '>=', $request->from);
            }
            if ($request->to) {
                $sql->whereDate('purchase_date', '<=', $request->to);
            }
            $inventories = $sql->paginate(50);
            return view('admin.inventory.index', compact('categoryData', 'inventories'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $users = User::get();
        $departments = Department::get();
        $categoryData = Category::where('type', '!=', 'Stock')->where('parent_id', 0)->with('nested')->get();
        return view('admin.inventory.create-edit', compact('categoryData', 'users', 'departments'));
    }

    public function store(InventoryRequest $request)
    {
        $data = $request->all();
        Inventory::create($data);
        return redirect()->route('admin.inventories.index', qArray())->withSuccess('Inventory created successfully.');

    }

    public function show(Inventory $inventory)
    {
        if (empty($inventory)) {
            return redirect()->route('admin.inventories.index');
        }
        return view('admin.inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        if (empty($inventory)) {
            return redirect()->route('admin.inventories.index');
        }
        $users = User::get();
        $departments = Department::get();
        $categoryData = Category::where('type', '!=', 'Stock')->where('parent_id', 0)->with('nested')->get();
        return view('admin.inventory.create-edit', compact('inventory', 'categoryData', 'users', 'departments'));
    }

    public function update(InventoryRequest $request, Inventory $inventory)
    {
        try {
            if (empty($inventory)) {
                return redirect()->route('admin.inventories.index');
            }
            $data = $request->all();
            $inventory->update($data);
            return redirect()->route('admin.inventories.index', qArray())->withSuccess('Inventory updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Inventory $inventory)
    {
        try {
            if (empty($inventory)) {
                return redirect()->route('admin.inventories.index');
            }
            $inventory->delete();
            return redirect()->route('admin.inventories.index', qArray())->withSuccess('Inventory trashed successfully.');
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

            $data['categories_head'] = Category::where('type', '!=', 'Stock')->with(['inventories' => function ($q) {
                $q->where('location', 'hq');
            }])
                ->get();
            $data['categories_gs1'] = Category::where('type', '!=', 'Stock')->with(['inventories' => function ($q) {
                $q->where('location', 'gs1');
            }])
                ->get();
            $data['categories_gs2'] = Category::where('type', '!=', 'Stock')->with(['inventories' => function ($q) {
                $q->where('location', 'gs2');
            }])
                ->get();
            return view('admin.inventory.summary', $data);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function code()
    {
        return view('admin.inventory.qr');
    }

    public function showQrDetails(Inventory $inventory)
    {
        return view('admin.inventory.qr-code-details', compact('inventory'));
    }

    public function ImportExcel(Request $request)
    {
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

    public function categoryInventory($id)
    {
        $data['category'] = $category = Category::where('id', $id)->find($id);
        $data['inventories'] = Inventory::where('category_id', $category->id)->paginate(15);
        return view('admin.inventory.summary-show', compact('data', 'category'));
    }
}
