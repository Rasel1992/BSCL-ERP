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
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!Auth::user()->can('see inventory list')) {
                return view('errors.403');
            }

            $categoryData = Category::where('type', '!=', 'Stock')->where('parent_id', 0)->with('nested')->get();
            $sql = Inventory::orderBy('created_at', 'ASC');
            if ($request->q) {
                $sql->where('asset_code', 'LIKE', $request->q . '%');
                $sql->orWhere('voucher_no', $request->q );
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
        if (!Auth::user()->can('add inventory')) {
            return view('errors.403');
        }

        $users = User::get();
        $departments = Department::get();
        $categoryData = Category::where('type', '!=', 'Stock')->where('parent_id', 0)->with('nested')->get();
        return view('admin.inventory.create-edit', compact('categoryData', 'users', 'departments'));
    }

    public function store(InventoryRequest $request)
    {
        if (!Auth::user()->can('add inventory')) {
            return view('errors.403');
        }

        $data = $request->all();
        Inventory::create($data);
        return redirect()->route('admin.inventories.index', qArray())->withSuccess('Inventory created successfully.');

    }

    public function show(Inventory $inventory)
    {
        if (!Auth::user()->can('see inventory details')) {
            return view('errors.403');
        }

        if (empty($inventory)) {
            return redirect()->route('admin.inventories.index');
        }
        return view('admin.inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        if (!Auth::user()->can('edit inventory')) {
            return view('errors.403');
        }

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
            if (!Auth::user()->can('edit inventory')) {
                return view('errors.403');
            }

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
            if (!Auth::user()->can('delete inventory')) {
                return view('errors.403');
            }

            if (empty($inventory)) {
                return redirect()->route('admin.inventories.index');
            }
            $inventory->delete();
            return redirect()->route('admin.inventories.index', qArray())->withSuccess('Inventory trashed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function qrCodeList(Request $request)
    {
        try {
            if (!Auth::user()->can('see inventory QR code list')) {
                return view('errors.403');
            }

            $sql = Inventory::orderBy('created_at', 'ASC');
            if ($request->q) {
                $sql->where('asset_code', 'LIKE', $request->q . '%');
            }
            $inventories = $sql->latest()->paginate(10);
            return view('admin.inventory.qr-code-list', compact('inventories'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function summary()
    {
        try {
            if (!Auth::user()->can('see inventory summary')) {
                return view('errors.403');
            }

            $categories = Category::with('nested')->where('parent_id', 0)->where('type', '!=', 'Stock')->paginate(50);
            return view('admin.inventory.summary', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function locationSummary(Request $request)
    {
        try {
            if (!Auth::user()->can('see inventory summary')) {
                return view('errors.403');
            }

            $categories = Category::with('nested', 'inventories')->where('parent_id', 0)->where('type', '!=', 'Stock')->paginate(50);
            $location = $request->location;
            return view('admin.inventory.location-summary', compact('categories', 'location'));
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

    public function categoryInventory(Request $request, $id)
    {
        $data['category'] = $category = Category::where('id', $id)->find($id);
        $sql = Inventory::where('category_id', $category->id);
        if ($request->location) {
            $sql->where('location', $request->location);
        }
        $data['inventories'] = $sql->paginate(15);
        return view('admin.inventory.summary-show', compact('data', 'category'));
    }
}
