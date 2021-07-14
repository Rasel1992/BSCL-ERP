<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\AssignStockRequest;
use App\Http\Requests\StockRequest;
use App\Imports\ImportStock;
use App\Models\Category;
use App\Models\Department;
use App\Models\Stock;
use App\Models\StockCategory;
use App\Models\StockUpdatedData;
use App\Models\StockUser;
use App\User;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!Auth::user()->can('see stock list')) {
                return view('errors.403');
            }

            $categoryData = StockCategory::where('parent_id', 0)->with('nested')->get();
            $sql = Stock::orderBy('stock_date', 'ASC');

            if (isLocationUser(Auth::user())) {
                $sql->where('location', Auth::user()->location);
            }

            if ($request->per_page) {
                $pagination = $request->per_page;
            } else {
                $pagination = 50;
            }

            if ($request->location) {
                $sql->where('location', $request->location);
            }
            if ($request->category_id) {
                $sql->where('category_id', $request->category_id);
            }

            if ($request->from) {
                $sql->whereDate('stock_date', '>=', $request->from);
            }
            if ($request->to) {
                $sql->whereDate('stock_date', '<=', $request->to);
            }
            if ($request->q) {
                $sql->whereHas('category', function($q) use($request) {
                    $q->where('category_name', $request->q);
                });
                $sql->orWhere('stock_code', $request->q);
            }
            $stocks = $sql->paginate($pagination);
            $serial = (!empty($request->page)) ? (($pagination*($request->page - 1)) + 1) : 1;
            return view('admin.stock.index', compact('stocks', 'categoryData', 'serial'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        if (!Auth::user()->can('add stock')) {
            return view('errors.403');
        }

        $categoryData = StockCategory::where('parent_id', 0)->with('nested')->get();
        return view('admin.stock.create-edit', compact('categoryData'));
    }

    public function store(StockRequest $request)
    {
        try {
            if (!Auth::user()->can('add stock')) {
                return view('errors.403');
            }

            $storeData = [
                'stock_code' => $request->stock_code,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'qty' => $request->qty,
                'location' => $request->location,
                'stock_date' => $request->stock_date,
            ];

            $catCheck = Stock::where('category_id', $request->category_id)->where('location', $request->location)->first();
            if($catCheck) {
                $stock = Stock::find($catCheck->id);
                $stock->update(['qty'=> $stock->qty + $request->qty]);
                StockUpdatedData::create($storeData);
            } else {
                Stock::create($storeData);
            }

            return redirect()->route('admin.stocks.index', qArray())->withSuccess('Stock created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        if (!Auth::user()->can('edit stock')) {
            return view('errors.403');
        }

        $sql = Stock::orderBy('stock_date', 'ASC');

        if (isLocationUser(Auth::user())) {
            $sql->where('location', Auth::user()->location);
        }

        $stock = $sql->find($id);

        if (empty($stock)) {
            return redirect()->route('admin.stocks.index');
        }
        $categoryData = StockCategory::where('parent_id', 0)->with('nested')->get();
        return view('admin.stock.create-edit', compact('categoryData', 'stock'))->with('edit', 1);
    }

    public function update(StockRequest $request, $id)
    {
        try {
            if (!Auth::user()->can('edit stock')) {
                return view('errors.403');
            }

            $sql = Stock::orderBy('stock_date', 'ASC');

            if (isLocationUser(Auth::user())) {
                $sql->where('location', Auth::user()->location);
            }

            $stock = $sql->find($id);

            if (empty($stock)) {
                return redirect()->route('admin.stocks.index');
            }
            $storeData = [
                'stock_code' => $request->stock_code,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'qty' => $request->qty,
                'location' => $request->location,
                'stock_date' => $request->stock_date,
            ];
            $stock->update($storeData);
            return redirect()->route('admin.stocks.index', qArray())->withSuccess('Stock updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            if (!Auth::user()->can('delete stock')) {
                return view('errors.403');
            }

            $sql = Stock::orderBy('stock_date', 'ASC');

            if (isLocationUser(Auth::user())) {
                $sql->where('location', Auth::user()->location);
            }

            $stock = $sql->find($id);

            if (empty($stock)) {
                return redirect()->route('admin.stocks.index');
            }
            StockUser::where('stock_id', $id)->delete();

            $stock->delete();
            return redirect()->route('admin.stocks.index', qArray())->withSuccess('Stock deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function assignedStock(Request $request)
    {
        try {

            if (!Auth::user()->can('see assigned stock list')) {
                return view('errors.403');
            }

            $categoryData = StockCategory::where('parent_id', 0)->with('nested')->get();
            $sql = StockUser::with('stock')->orderBy('created_at', 'ASC');

            if (isLocationUser(Auth::user())) {
                $sql->whereHas('stock', function ($q) use ($request) {
                    $q->where('location', Auth::user()->location);
                });
            }
            if ($request->per_page) {
                $pagination = $request->per_page;
            } else {
                $pagination = 50;
            }

            if ($request->location) {
                $sql->whereHas('stock', function ($q) use ($request) {
                    $q->where('location', $request->location);
                });
            }
            if ($request->category_id) {
                $sql->whereHas('stock', function ($q) use ($request) {
                    $q->where('category_id', $request->category_id);
                });
            }
            if ($request->from) {
                $sql->whereDate('assign_date', '>=', $request->from);
            }
            if ($request->to) {
                $sql->whereDate('assign_date', '<=', $request->to);
            }
            $assignedStocks = $sql->paginate($pagination);
            $serial = (!empty($request->page)) ? (($pagination*($request->page - 1)) + 1) : 1;
            return view('admin.stock.assigned-stock', compact('assignedStocks', 'categoryData', 'serial'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function assignStockForm(Request $request, $id)
    {
        if (!Auth::user()->can('assign stock')) {
            return view('errors.403');
        }

        $data = Stock::where('id', $id)->first();
        $users = User::get();
        $departments = Department::get();
        return view('admin.stock.assign-stock', compact('data', 'users', 'departments'));
    }

    public function assignStock(AssignStockRequest $request, $id)
    {
        if (!Auth::user()->can('assign stock')) {
            return view('errors.403');
        }

        $stock_id = $id;
        $data = Stock::where('id', $stock_id)->first();

        if ($data->qty < $request->qty) {
            return redirect()->route('admin.stocks.index')->withErrors(['error' => 'Qty not in stock!']);
        }
        $updateData = [
            'qty' => $data->qty - $request->qty,
        ];
        $data->update($updateData);
        $storeData = [
            'stock_id' => $request->stock_id,
            'qty' => $request->qty,
            'assign_to' => $request->assign_to,
            'user_id' => $request->user_id,
            'dept_id' => $request->dept_id,
            'assign_date' => $request->assign_date,
            'remark' => $request->remark,
            'apply_no' => $request->apply_no,
        ];
        StockUser::create($storeData);
        return redirect()->route('admin.stocks.assigned-stock')->withSuccess('Stock Assigned successfully.');
    }

    public function summary()
    {
        try {

            if (!Auth::user()->can('see stock all summary')) {
                return view('errors.403');
            }

            $categories = StockCategory::with('nested')->where('parent_id', 0)->paginate(50);
            $serial = (!empty($request->page)) ? ((50*($request->page - 1)) + 1) : 1;
            return view('admin.stock.summary', compact('categories', 'serial'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function locationSummary(Request $request)
    {
        try {

            if (!Auth::user()->can('see stock summary')) {
                return view('errors.403');
            }
            $categories = StockCategory::with(['nested', 'stocks'])->where('parent_id', 0)->paginate(50);
            $serial = (!empty($request->page)) ? ((50*($request->page - 1)) + 1) : 1;

            if($request->location) {
                $location = $request->location;
            } else {
                $location = Auth::user()->location;
            }
            return view('admin.stock.location-summary', compact('categories', 'location', 'serial'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function categoryStocks(Request $request, $id)
    {
        $data['category'] = $category = StockCategory::where('id', $id)->find($id);
        $sql = Stock::where('category_id', $category->id);
        if ($request->location) {
            $sql->where('location', $request->location);
        }
        $data['stocks'] = $sql->paginate(50);
        $serial = (!empty($request->page)) ? ((50*($request->page - 1)) + 1) : 1;
        return view('admin.stock.summary-show', compact('data', 'category', 'serial'));
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
            Excel::import(new ImportStock(), $file); //IMPORT FILE
            return redirect()->back()->withSuccess('Upload file data Stock !');
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }

    public function updatedList(Request $request)
    {
        try {
            if (!Auth::user()->can('see updated stock list')) {
                return view('errors.403');
            }

            $categoryData = StockCategory::where('parent_id', 0)->with('nested')->get();
            $sql = StockUpdatedData::orderBy('stock_date', 'ASC');

            if (isLocationUser(Auth::user())) {
                $sql->where('location', Auth::user()->location);
            }
            if ($request->per_page) {
                $pagination = $request->per_page;
            } else {
                $pagination = 50;
            }

            if ($request->location) {
                $sql->where('location', $request->location);
            }
            if ($request->category_id) {
                $sql->where('category_id', $request->category_id);
            }
            if ($request->from) {
                $sql->whereDate('stock_date', '>=', $request->from);
            }
            if ($request->to) {
                $sql->whereDate('stock_date', '<=', $request->to);
            }
            if ($request->q) {
                $sql->whereHas('category', function($q) use($request) {
                    $q->where('category_name', $request->q);
                });
                $sql->orWhere('stock_code', $request->q);
            }
            $stocks = $sql->paginate($pagination);
            $serial = (!empty($request->page)) ? (($pagination*($request->page - 1)) + 1) : 1;
            return view('admin.stock.updated-stock', compact('stocks', 'categoryData', 'serial'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
