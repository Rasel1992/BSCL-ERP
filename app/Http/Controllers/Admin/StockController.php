<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\AssignStockRequest;
use App\Http\Requests\StockRequest;
use App\Imports\ImportStock;
use App\Models\Category;
use App\Models\Department;
use App\Models\Stock;
use App\Models\StockUser;
use App\User;
use Illuminate\Http\Request;
use Excel;
class StockController extends Controller
{
    public function index(Request $request)
    {
        try {
            $categoryData = Category::where('type', 'Stock')->with('nested')->get();
            $sql = Stock::orderBy('created_at', 'ASC');
            if ($request->location) {
                $sql->where('location', $request->location);
            }
            if ($request->category_id) {
                $sql->where('category_id', $request->category_id);
            }
            $stocks = $sql->paginate(10);
            return view('admin.stock.index', compact('stocks', 'categoryData'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function assignedStock(Request $request)
    {
        try {
            $categoryData = Category::where('parent_id', 0)->with('nested')->where('type', 'Stock')->get();
            $sql = StockUser::with('stock')->orderBy('created_at', 'ASC');

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
            $assignedStocks = $sql->paginate(10);
            return view('admin.stock.assigned-stock', compact('assignedStocks', 'categoryData'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $categoryData = Category::where('type', 'Stock')->with('nested')->get();
        return view('admin.stock.create-edit', compact('categoryData'))->with('create', 1);
    }

    public function store(StockRequest $request)
    {
        try {
            $data = $request->except('_token');
            Stock::create($data);
            return redirect()->route('admin.stocks.index', qArray())->withSuccess('Stock created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Stock $stock)
    {
        $categoryData = Category::where('type', 'Stock')->where('parent_id', 0)->with('nested')->get();
        return view('admin.stock.create-edit', compact('categoryData', 'stock'))->with('edit', 1);
    }

    public function update(StockRequest $request, Stock $stock)
    {
        try {
            $data = $request->except('_token');
            $stock->update($data);
            return redirect()->route('admin.stocks.index', qArray())->withSuccess('Stock updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Stock $stock)
    {
        try {
            $stock->delete();
            return redirect()->route('admin.stocks.index', qArray())->withSuccess('Stock deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function assignStockForm(Request $request, $id){
        $data = Stock::where('id', $id)->first();
        $users = User::get();
        $departments = Department::get();
        return view('admin.stock.assign-stock', compact('data', 'users', 'departments'));
    }

    public function assignStock(AssignStockRequest $request, $id){
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
            'qty' => $request->qty,
            'stock_id' => $request->stock_id,
            'assign_to' => $request->assign_to,
            'user_id' => $request->user_id,
            'dept_id' => $request->dept_id,
            'assign_date' => $request->assign_date,
        ];
        StockUser::create($storeData);
        return redirect()->route('admin.stocks.assigned-stock')->withSuccess('Stock Assigned successfully.');
    }

    public function summary()
    {
        try {

            $categories_head = Category::where('type', 'Stock')->with(['stocks' => function($q) {
                $q->where('location','hq');
            }])
                ->get();

            $categories_gs1 = Category::where('type', 'Stock')->with(['stocks' => function($q) {
                $q->where('location','gs1');
            }])
                ->get();
            $categories_gs2 = Category::where('type', 'Stock')->with(['stocks' => function($q) {
                $q->where('location','gs2');
            }])
                ->get();
            return view('admin.stock.summary', compact( 'categories_head', 'categories_gs1', 'categories_gs2'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function categoryStocks($id) {
        $data['category'] = $category = Category::where('id', $id)->find($id);
        $data['stocks'] = Stock::where('category_id', $category->id)->paginate(15);

        return view('admin.stock.summary-show', compact('data', 'category'));
    }

    public function ImportExcel(Request $request) {
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
}
